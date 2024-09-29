<?php

namespace App\Repositories;

use App\Interfaces\InvoiceRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    protected $relations = [
        'users',
        'bookings',
    ];

    public function getAll($search, $page)
    {
        $model = Invoice::with($this->relations);

        if ($search === null) {
            $query = $model->orderBy('updated_at', 'desc');
            return $query->paginate($page);
        } else {
            $query = $model
                ->whereHas('users', function ($query) use ($search) {
                    $query->where('email', 'like', '%' . $search . '%');
                })
                ->orWhere('invoice_id', 'like', '%' . $search . '%')
                ->orderBy('updated_at', 'desc');
            return $query->paginate($page);
        }
    }

    public function getById($dataId)
    {
        return Invoice::where('invoice_id', $dataId)->get();
    }

    public function getByIdBooking($dataId)
    {
        return Invoice::where('book_id', $dataId)->get();
    }


    public function getClient($search, $perPage)
    {
        $model = Invoice::with($this->relations);

        if ($search === null) {
            $query = $model
                ->where('user_id', 'like', '%' . Auth::user()->id . '%')
                ->orderBy('updated_at', 'desc');
            return $query->paginate($perPage);
        } else {
            $query = $model
                ->where('user_id', 'like', '%' . Auth::user()->id . '%')
                ->where('book_id', 'like', '%' . $search . '%')
                ->orderBy('updated_at', 'desc');
            return $query->paginate($perPage);
        }
    }

    // Use $this->generateInvoiceId() for invoice id
    private static function generateInvoiceId()
    {
        $prefix = 'INV-';
        $timestamp = now()->format('dmYHis');
        $randomNumber = mt_rand(1000, 9999);
        return $prefix . $randomNumber . '-' . $timestamp;
    }

    // Use $this->validatorBook($userId, $bookId) for check booking user
    private static function validatorBook($userId, $bookId)
    {
        // Ambil booking dengan status dan total_price sekaligus
        $booking = Booking::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->select('status', 'total_price')
            ->first();

        // Cek apakah booking ditemukan
        if (!$booking) {
            return [
                'success' => false,
                'message' => 'Booking not found or user does not have access.',
            ];
        }

        // Daftar status yang tidak valid
        $invalidStatuses = ['DONE', 'ON PROCESS', 'PAYMENT PROCESS', 'EXP'];

        // Cek status booking
        if (in_array($booking->status, $invalidStatuses)) {
            return [
                'success' => false,
                'message' => 'Booking is ' . $booking->status,
            ];
        }

        // Jika status PENDING, kembalikan detail booking yang valid
        return [
            'success' => true,
            'message' => 'Book Valid',
            'price_book' => $booking->total_price,
        ];
    }

    // Use $this->canCreatePayment($invId) for check create payment
    private static function canCreatePayment($invId)
    {
        $invoice = Invoice::where('invoice_id', $invId)->first();

        // Memeriksa apakah invoice ditemukan
        if (!$invoice) {
            return [
                'success' => false,
                'message' => "Invoice not found",
            ];
        }

        // Memeriksa status invoice
        if ($invoice->status !== 'PENDING') {
            return [
                'success' => false,
                'message' => "Invoice status is " . $invoice->status,
            ];
        }

        return ['success' => true];
    }

    // Use $this->createPayment($invId) for create payment
    private function createPayment($invId)
    {
        $invoice = Invoice::where('invoice_id', $invId)->first();

        // Siapkan payload untuk API pembayaran
        $payload = [
            "transaction_details" => [
                "order_id" => $invId,
                "gross_amount" => $invoice->amount,
            ],
            "credit_card" => [
                "secure" => true,
            ],
        ];

        // Inisialisasi cURL
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.midtrans.com/snap/v1/transactions',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTPHEADER => [
                'Authorization: Basic ' . 'TWlkLXNlcnZlci1ZS2o4RlRuRjRORl9aeG5PTllPNWUwclc6',
                'Content-Type: application/json',
            ],
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_CUSTOMREQUEST => 'POST',
        ]);

        //DEV Basic U0ItTWlkLXNlcnZlci14a2MtOHpoS193YnUxSW1zSVBJV2JyTUs6
        //DEV https://api.sandbox.midtrans.com

        //PROD Basic TWlkLXNlcnZlci1ZS2o4RlRuRjRORl9aeG5PTllPNWUwclc6
        //PROD https://api.midtrans.com

        // Eksekusi cURL dan ambil respons
        $response = curl_exec($curl);

        // Cek kesalahan eksekusi cURL
        if ($response === false) {
            return [
                'success' => false,
                'message' => curl_error($curl),
            ];
        }

        $responseData = json_decode($response, true);

        // Cek apakah decoding berhasil
        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'success' => false,
                'message' => 'Invalid response format',
            ];
        }

        // Cek apakah ada error_messages dalam respons
        if (isset($responseData['error_messages']) && is_array($responseData['error_messages'])) {
            return [
                'success' => false,
                'message' => implode(', ', $responseData['error_messages']),
            ];
        }

        // Tutup koneksi cURL
        curl_close($curl);

        // Kembalikan respons dari API
        return [
            'success' => true,
            'message' => $responseData
        ];
    }

    public function create($dataDetails)
    {
        $userId = Auth::id();
        $bookId = $dataDetails['book_id'];

        // Validasi booking
        $validatorBook = $this->validatorBook($userId, $bookId);
        if ($validatorBook['success'] === false) {
            return [
                'error_type' => 'apps',
                'success' => false,
                'message' => $validatorBook['message'],
            ];
        }

        DB::beginTransaction();

        try {

            // Buat Invoice
            $invId = $this->generateInvoiceId();
            $invoice = Invoice::create([
                'invoice_id' => $invId,
                'user_id' => $userId,
                'book_id' => $bookId,
                'amount' => $validatorBook['price_book'],
                'payment_due_at' => now()->addMinutes(6),
            ]);

            // Cek apakah bisa membuat pembayaran
            $invCheck = $this->canCreatePayment($invId);
            if ($invCheck['success'] === false) {
                return [
                    'error_type' => 'apps',
                    'success' => false,
                    'message' => $invCheck['message'],
                ];
            }

            // Update expired_at booking
            Booking::where('book_id', $bookId)->update(['expired_at' => now()->addMinutes(5)]);

            // Proses pembayaran
            $paymentResponse = $this->createPayment($invId);
            if ($paymentResponse['success'] === false) {
                return [
                    'error_type' => 'payment_gateway',
                    'success' => false,
                    'message' => $paymentResponse['message'],
                ];
            }

            // Pastikan payment link ada sebelum mengupdate
            $paymentLink = $paymentResponse['message']['redirect_url'] ?? null;

            if ($paymentLink) {

                // Update link pembayaran di invoice
                $invoice->update(['payment_link' => $paymentLink]);

                // Update status booking
                Booking::where('book_id', $bookId)->update(['status' => "PAYMENT PROCESS"]);

                DB::commit();

                return [
                    'success' => true,
                    'invoice_id' => $invId,
                    'user_id' => $userId,
                    'book_id' => $bookId,
                    'amount' => $validatorBook['price_book'],
                    'message' => 'Booking successful, payment link created.',
                    'payment_link' => $paymentLink,
                ];

            } else {
                return [
                    'error_type' => 'payment_gateway',
                    'success' => false,
                    'message' => "Payment link not found.",
                ];
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error_type' => 'apps',
                'success' => false,
                'message' => 'Transaction failed: ' . $e->getMessage(),
            ];
        }
    }
}
