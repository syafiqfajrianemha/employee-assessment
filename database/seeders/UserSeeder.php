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
                'role' => 'admin',
                'password' => Hash::make('12345678')
            ],
            [
                'name' => 'Manager',
                'email' => 'manager@gmail.com',
                'role' => 'manager',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Program',
                'email' => 'program@gmail.com',
                'role' => 'program',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Fundraising A',
                'email' => 'fundraisinga@gmail.com',
                'role' => 'fundraising',
                'salary' => '2100000',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Fundraising B',
                'email' => 'fundraisingb@gmail.com',
                'role' => 'fundraising',
                'salary' => '2100000',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'Fundraising C',
                'email' => 'fundraisingc@gmail.com',
                'role' => 'fundraising',
                'salary' => '2100000',
                'password' => Hash::make('12345678'),
            ],
        ]);
    }
}
