<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
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
        User::Create([
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



        // Seed 1000 users with the Client role
        // User::factory()->count(1000)->create(['role_id' => $idClient]);
    }
}
