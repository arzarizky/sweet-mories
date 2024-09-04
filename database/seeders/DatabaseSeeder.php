<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\ProductBooking;
use Carbon\Carbon;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    private static function generateBookId()
    {
            $prefix = 'BOOK-';
            $timestamp = now()->format('dmYHis');
            $randomNumber = mt_rand(1000, 9999);
            return $prefix . $randomNumber . '-' . $timestamp;
    }

    private static function generateInvoiceId()
    {
        $prefix = 'INV-';
        $timestamp = now()->format('dmYHis');
        $randomNumber = mt_rand(1000, 9999);
        return $prefix . $randomNumber . '-' . $timestamp;
    }

    private static function validatorBook($userId, $bookId)
    {
        $bookQuery = Booking::where('user_id', $userId)->where('book_id',  $bookId);
        $statusBook = $bookQuery->first('status');
        $priceBook = $bookQuery->first('total_price');

         if (!$statusBook) {
            return [
                'success' => false,
                'message' => 'Booking not found or user does not have access.',
            ];
         }

         if ($statusBook->status === 'DONE') {
             return[
                'success' => false,
                'message' => 'Booking is already DONE.',
             ];

         } elseif ($statusBook->status === 'ON PROCESS') {
             return[
                'success' => false,
                'message' => 'Booking is ON PROCESS.',
             ];

         } elseif ($statusBook->status === 'PENDING') {
            return[
                'success' => true,
                'message' => 'Book Valid',
                'price_book' => $priceBook->total_price
            ];

        } else {
            return[
                'success' => false,
                'message' => 'Booking status not definition or user does not have access.',
            ];
        }
    }

    public function createInv($dataDetails)
    {
        $userId = $dataDetails['user_id'];
        $bookId = $dataDetails['book_id'];
        $bookAmnt = $dataDetails['total_price'];
        $validatorBook = $this->validatorBook($userId, $bookId);

        if ($validatorBook['success'] === false) {
            return [
                'success' => $validatorBook['success'],
                'message' => $validatorBook['message'],
            ];
        } else {
            $invId = $this->generateInvoiceId();
            $Invc = Invoice::create([
                'invoice_id' => $invId,
                'user_id' => $userId,
                'book_id' => $bookId,
                'amount' => $validatorBook['price_book'],
            ]);
            return [
                'success' => $validatorBook['success'],
                'invoice_id' => $invId,
                'user_id' => $userId,
                'book_id' => $bookId,
                'amount'  => $validatorBook['price_book'],
                'message' => $validatorBook['message'],
            ];
        }
    }

    public function run(): void
    {
        // seed role admin
        $roleAdmin = Role::create([
            'name'	=> 'Admin',
        ]);

        // get id role admin
        $idAdmin = $roleAdmin->id;

        // seed role client
        $rolesClient = Role::create([
            'name'	=> 'Client',
        ]);

        // get id role Client
        $idClient =  $rolesClient->id;

        //seed admin
        User::Create([
            'name' => 'Arza Rizky Nova Ramadhani',
            'role_id' => $idAdmin,
            'email' => 'arzarizky@arzarizky.com',
            'no_tlp' => '0822448622721',
            'password' => bcrypt('secret'),
        ]);

        //seed user client
        $idClientUser = User::Create([
            'name' => 'Riyan Fauzi',
            'role_id' => $idClient,
            'email' => 'riyan@arzarizky.com',
            'no_tlp' => '0822448622921',
            'password' => bcrypt('secret'),
        ]);

        Product::Create([
            'name' => 'Basic Self Photoshoot T&C',
            'price' => 37000,
        ]);

        Product::Create([
            'name' => 'Basic Self Photoshoot',
            'price' => 67000,
        ]);

        Product::Create([
            'name' => 'Projector Self Photoshoot T&C',
            'price' => 49000,
        ]);

        Product::Create([
            'name' => 'Projector Self Photoshoot',
            'price' => 90000,
        ]);

        Product::Create([
            'name' => '1 Printed Photo 4R',
            'price' => 10000,
        ]);

        Product::Create([
            'name' => '2 Printed Strip',
            'price' => 15000,
        ]);

        Product::Create([
            'name' => '1 Printed Holoflip 4R',
            'price' => 25000,
        ]);

        Product::Create([
            'name' => 'Digital Soft Copy',
            'price' => 25000,
        ]);

        $bookId = $this->generateBookId();
        $totalPrice = 0;

        $dataDetails['booking_date'] = Carbon::createFromFormat('d-m-Y', '27-08-2024')->format('Y-m-d');
        $dataDetails['booking_time'] = Carbon::createFromTime(10, 15)->format('H:i');

        $dataDetails['items'] = [
            [
                'product_name' => 'Basic Self Photoshoot',
                'quantity'  => '1'
            ],
            [
                'product_name' => '1 Printed Photo 4R',
                'quantity'  => '2'
            ],
            [
                'product_name' => '2 Printed Strip',
                'quantity'  => '2'
            ],
            [
                'product_name' => '1 Printed Holoflip 4R',
                'quantity'  => '2'
            ],
            [
                'product_name' => 'Digital Soft Copy',
                'quantity'  => '2'
            ]
        ];

        $booking = Booking::create([
            'user_id' => $idClientUser->id,
            'book_id' => $bookId,
            'total_price' => $totalPrice,
            'booking_date' => $dataDetails['booking_date'],
            'booking_time' => $dataDetails['booking_time'],
        ]);


        foreach ($dataDetails['items'] as $item) {
            $product = Product::where('name', $item['product_name'])->firstOrFail();
            $totalPrice += $product->price * $item['quantity'];
            ProductBooking::create([
                'book_id' => $bookId,
                'product_id' => $product->id,
                'quantity_product' => $item['quantity'],
            ]);
        }

        Booking::where('book_id', $booking->book_id)->update(['total_price' => $totalPrice]);

        $this->createInv(Booking::where('book_id', $booking->book_id)->first());

        $bookId = $this->generateBookId();
        $totalPrice = 0;

        $dataDetails['booking_date'] = Carbon::createFromFormat('d-m-Y', '27-08-2024')->format('Y-m-d');
        $dataDetails['booking_time'] = Carbon::createFromTime(10, 30)->format('H:i');

        $dataDetails['items'] = [
            [
                'product_name' => 'Projector Self Photoshoot',
                'quantity'  => '1'
            ],
            [
                'product_name' => '1 Printed Photo 4R',
                'quantity'  => '2'
            ],
            [
                'product_name' => '2 Printed Strip',
                'quantity'  => '2'
            ],
            [
                'product_name' => '1 Printed Holoflip 4R',
                'quantity'  => '2'
            ],
            [
                'product_name' => 'Digital Soft Copy',
                'quantity'  => '2'
            ]
        ];

        $booking = Booking::create([
            'user_id' => $idClientUser->id,
            'book_id' => $bookId,
            'total_price' => $totalPrice,
            'booking_date' => $dataDetails['booking_date'],
            'booking_time' => $dataDetails['booking_time'],
        ]);

        foreach ($dataDetails['items'] as $item) {
            $product = Product::where('name', $item['product_name'])->firstOrFail();
            $totalPrice += $product->price * $item['quantity'];
            ProductBooking::create([
                'book_id' => $bookId,
                'product_id' => $product->id,
                'quantity_product' => $item['quantity'],
            ]);
        }

        Booking::where('book_id', $booking->book_id)->update(['total_price' => $totalPrice]);

        $this->createInv(Booking::where('book_id', $booking->book_id)->first());


        $bookId = $this->generateBookId();
        $totalPrice = 0;

        $dataDetails['booking_date'] = Carbon::createFromFormat('d-m-Y', '27-08-2024')->format('Y-m-d');
        $dataDetails['booking_time'] = Carbon::createFromTime(11, 15)->format('H:i');

        $dataDetails['items'] = [
            [
                'product_name' => 'Projector Self Photoshoot',
                'quantity'  => '1'
            ],
            [
                'product_name' => 'Basic Self Photoshoot',
                'quantity'  => '1'
            ],
            [
                'product_name' => '1 Printed Photo 4R',
                'quantity'  => '2'
            ],
            [
                'product_name' => '2 Printed Strip',
                'quantity'  => '2'
            ],
            [
                'product_name' => '1 Printed Holoflip 4R',
                'quantity'  => '2'
            ],
            [
                'product_name' => 'Digital Soft Copy',
                'quantity'  => '2'
            ]
        ];

        $booking = Booking::create([
            'user_id' => $idClientUser->id,
            'book_id' => $bookId,
            'total_price' => $totalPrice,
            'booking_date' => $dataDetails['booking_date'],
            'booking_time' => $dataDetails['booking_time'],
        ]);

        foreach ($dataDetails['items'] as $item) {
            $product = Product::where('name', $item['product_name'])->firstOrFail();
            $totalPrice += $product->price * $item['quantity'];
            ProductBooking::create([
                'book_id' => $bookId,
                'product_id' => $product->id,
                'quantity_product' => $item['quantity'],
            ]);
        }

        Booking::where('book_id', $booking->book_id)->update(['total_price' => $totalPrice]);

        $this->createInv(Booking::where('book_id', $booking->book_id)->first());


        // $date = Carbon::createFromFormat('d-m-Y', '10-09-2024');
        // $startTime = Carbon::createFromTime(9, 0); // Start at 09:00
        // $endTime = Carbon::createFromTime(21, 0); // End at 21:00

        // while ($startTime->lessThan($endTime)) {
        //     $bookId = $this->generateBookId();
        //     $totalPrice = 0;

        //     $bookingDate = $date->format('Y-m-d');
        //     $bookingTime = $startTime->format('H:i');

        //     $dataDetails['items'] = [
        //         [
        //             'product_name' => 'Projector Self Photoshoot',
        //             'quantity'  => 1
        //         ],
        //         [
        //             'product_name' => 'Basic Self Photoshoot',
        //             'quantity'  => 1
        //         ],
        //         [
        //             'product_name' => '1 Printed Photo 4R',
        //             'quantity'  => 2
        //         ],
        //         [
        //             'product_name' => '2 Printed Strip',
        //             'quantity'  => 2
        //         ],
        //         [
        //             'product_name' => '1 Printed Holoflip 4R',
        //             'quantity'  => 2
        //         ],
        //         [
        //             'product_name' => 'Digital Soft Copy',
        //             'quantity'  => 2
        //         ]
        //     ];

        //     $booking = Booking::create([
        //         'user_id' => $idClientUser->id,
        //         'book_id' => $bookId,
        //         'total_price' => $totalPrice,
        //         'booking_date' => $bookingDate,
        //         'booking_time' => $bookingTime,
        //     ]);

        //     foreach ($dataDetails['items'] as $item) {
        //         $product = Product::where('name', $item['product_name'])->firstOrFail();
        //         $totalPrice += $product->price * $item['quantity'];
        //         ProductBooking::create([
        //             'book_id' => $bookId,
        //             'product_id' => $product->id,
        //             'quantity_product' => $item['quantity'],
        //         ]);
        //     }

        //     Booking::where('book_id', $booking->book_id)->update(['total_price' => $totalPrice]);

        //     $this->createInv(Booking::where('book_id', $booking->book_id)->first());

        //     $startTime->addMinutes(15); // Move to the next 15-minute interval

        // }

        // Seed 1000 users with the Client role
        // User::factory()->count(1000)->create(['role_id' => $idClient]);
    }
}
