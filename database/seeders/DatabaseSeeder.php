<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Booking;
use App\Models\ProductBooking;

use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    private static function generateBookId()
    {
            $prefix = 'BOOK-';
            $timestamp = now()->format('YmdHis');
            $randomNumber = mt_rand(1000, 9999);
            return $prefix . $timestamp . '-' . $randomNumber;
    }
    /**
     * Seed the application's database.
     */
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
            'name' => 'Basic Self Photoshoot',
            'price' => 47000,
        ]);

        Product::Create([
            'name' => 'Projector Self Photoshoot',
            'price' => 70000,
        ]);

        Product::Create([
            'name' => 'Printed Photo 4R',
            'price' => 10000,
        ]);

        Product::Create([
            'name' => '2 Printed Strip',
            'price' => 10000,
        ]);

        Product::Create([
            'name' => '1 Printed Holographic',
            'price' => 10000,
        ]);

        Product::Create([
            'name' => 'Digital Soft Copy',
            'price' => 25000,
        ]);

        $bookId = $this->generateBookId();
        $totalPrice = 0;

        $dataDetails['booking_date'] = '07-21-2024';
        $dataDetails['booking_time'] = "06:45";

        $dataDetails['items'] = [
            [
                'product_name' => 'Basic Self Photoshoot',
                'quantity'  => '1'
            ],
            [
                'product_name' => 'Printed Photo 4R',
                'quantity'  => '2'
            ],
            [
                'product_name' => '2 Printed Strip',
                'quantity'  => '2'
            ],
            [
                'product_name' => '1 Printed Holographic',
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

        $bookId = $this->generateBookId();
        $totalPrice = 0;

        $dataDetails['booking_date'] = '07-24-2024';
        $dataDetails['booking_time'] = "06:45";

        $dataDetails['items'] = [
            [
                'product_name' => 'Projector Self Photoshoot',
                'quantity'  => '1'
            ],
            [
                'product_name' => 'Printed Photo 4R',
                'quantity'  => '2'
            ],
            [
                'product_name' => '2 Printed Strip',
                'quantity'  => '2'
            ],
            [
                'product_name' => '1 Printed Holographic',
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

        $bookId = $this->generateBookId();
        $totalPrice = 0;

        $dataDetails['booking_date'] = '07-24-2024';
        $dataDetails['booking_time'] = "06:45";

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
                'product_name' => 'Printed Photo 4R',
                'quantity'  => '2'
            ],
            [
                'product_name' => '2 Printed Strip',
                'quantity'  => '2'
            ],
            [
                'product_name' => '1 Printed Holographic',
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



        // Seed 1000 users with the Client role
        // User::factory()->count(1000)->create(['role_id' => $idClient]);
    }
}
