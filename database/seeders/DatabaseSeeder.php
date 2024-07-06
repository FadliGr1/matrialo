<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vendor;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(100)->create();

        // User::factory()->create(
        //     [
        //         'name' => 'Admin',
        //         'email' => 'admin@gmail.com',
        //         'role' => 'admin',
        //         'username' => 'admin',
        //         'password' => bcrypt('password'),
        //     ]
        // );

        Vendor::factory()->count(10)->create();
    }
}
