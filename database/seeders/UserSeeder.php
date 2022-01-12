<?php

namespace Database\Seeders;

use App\Models\Statistic;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'leduyviet2612@gmail.com',
            'first_name' => 'Viet',
            'last_name' => 'Le',
            'password' => bcrypt('0123456789'),
            'phone_number' => '0123456789',
            'address' => 'Phu Binh, Thai Nguyen',
            'role' => 0,
        ]);
        User::create([
            'email' => 'admin@gmail.com',
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'password' => bcrypt('0123456789'),
            'phone_number' => '01234567891',
            'address' => 'Phu Binh, Thai Nguyen',
            'role' => 0,
        ]);
        User::create([
            'email' => 'employee@gmail.com',
            'first_name' => 'Nhan',
            'last_name' => 'Vien',
            'password' => bcrypt('0123456789'),
            'phone_number' => '0124567891',
            'address' => 'Phu Binh, Thai Nguyen',
            'role' => 1,
        ]);
    }
}
