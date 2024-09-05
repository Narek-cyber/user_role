<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'John',
                'lastname' => 'Doe',
                'phone' => '(011)155615',
                'date_of_birth' => '2001-09-05',
                'role' => 'admin',
                'email' => 'john@doe.com',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Jenna',
                'lastname' => 'Doe',
                'phone' => '(011)123615',
                'date_of_birth' => '2002-06-13',
                'role' => 'admin',
                'email' => 'jenna@doe.com',
                'password' => Hash::make('12345678'),
            ],
        ];

        foreach ($admins as $admin) {
            User::query()->firstOrCreate(['email' => $admin['email']], $admin);
        }
    }
}
