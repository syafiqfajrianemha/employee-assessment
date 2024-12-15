<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'salary' => 0,
                'role' => 'admin',
                'password' => Hash::make('12345678')
            ],
            [
                'name' => 'Manager',
                'email' => 'manager@gmail.com',
                'salary' => 0,
                'role' => 'manager',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Program',
                'email' => 'program@gmail.com',
                'salary' => 0,
                'role' => 'program',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Fundraising A',
                'email' => 'fundraisinga@gmail.com',
                'salary' => 2100000,
                'role' => 'fundraising',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Fundraising B',
                'email' => 'fundraisingb@gmail.com',
                'salary' => 2100000,
                'role' => 'fundraising',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Fundraising C',
                'email' => 'fundraisingc@gmail.com',
                'salary' => 2100000,
                'role' => 'fundraising',
                'password' => Hash::make('12345678'),
            ],
        ]);
    }
}
