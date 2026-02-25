<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@admin.com'], // unique key
            [
                'name'    => 'Admin',
                'phone'   => '01234567890',
                'address' => 'Admin Address',
                'role'    => 1,
                'image'   => 'default.jpg',
                // this will RESET the password on every seed
                'password'=> Hash::make('password'),
            ]
        );
    }
}
