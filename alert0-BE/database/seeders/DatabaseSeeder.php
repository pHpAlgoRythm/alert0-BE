<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            systemPhotoSeeder::class,
        ]);

        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'address' => '123 Admin Street',
                'gender' => 'Male',
                'role' => 'admin',
                'status' => 'active',
                'phone' => '1234567890',
            ],
            [
                'name' => 'Driver User 1',
                'email' => 'driver@example.com',
                'password' => Hash::make('password123'),
                'address' => '123 Driver Street',
                'gender' => 'Male',
                'role' => 'driver',
                'status' => 'active',
                'phone' => '1234567891',
            ],
            [
                'name' => 'Driver User 2',
                'email' => 'driver@example1.com',
                'password' => Hash::make('password123'),
                'address' => '123 Driver Street',
                'gender' => 'Male',
                'role' => 'driver',
                'status' => 'active',
                'phone' => '1234567891',
            ],
            [
                'name' => 'Responder User 1',
                'email' => 'responder1@example.com', // Changed email to avoid duplicate
                'password' => Hash::make('password123'),
                'address' => '123 Responder Street',
                'gender' => 'Male',
                'role' => 'responder',
                'status' => 'active',
                'phone' => '1234567892',
            ],

            [
                'name' => 'Dispatcher User',
                'email' => 'dispatcher@example.com',
                'password' => Hash::make('password123'),
                'address' => '123 Dispatcher Street',
                'gender' => 'Male',
                'role' => 'dispatcher',
                'status' => 'active',
                'phone' => '1234567894',
            ],
        ];

        // Insert each user into the database
        foreach ($users as $user) {
            User::create(array_merge($user, [
                'email_verified_at' => Carbon::now(),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]));
        }
    }
}
