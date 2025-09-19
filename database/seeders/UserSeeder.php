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
                'username'   => 'Satria',
                'sap'        => '5015031',
                'password'   => Hash::make('12345678'), 
                'level_user' => 'administrator',
                'kodeunit'   => '3R00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username'   => 'Farid Mudzaky',
                'sap'        => '500196',
                'password'   => Hash::make('12345678'),
                'level_user' => 'manager', 
                'kodeunit'   => '3E02', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username'   => 'Pratama Lubis',
                'sap'        => '19003788',
                'password'   => Hash::make('12345678'),
                'level_user' => 'administrasi', 
                'kodeunit'   => '3E02', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username'   => 'Pawit Udiono',
                'sap'        => '5009319',
                'password'   => Hash::make('12345678'),
                'level_user' => 'administrasi', 
                'kodeunit'   => '3E02', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username'   => 'Fantri Dwi Saputra Sinaga',
                'sap'        => '5018660',
                'password'   => Hash::make('12345678'),
                'level_user' => 'afdeling 01',
                'kodeunit'   => '3E02',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username'   => 'Suwardi',
                'sap'        => '5005058',
                'password'   => Hash::make('12345678'),
                'level_user' => 'afdeling 03',
                'kodeunit'   => '3E02',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username'   => 'Ivan Fauzi',
                'sap'        => '5009221',
                'password'   => Hash::make('12345678'),
                'level_user' => 'afdeling 02',
                'kodeunit'   => '3E02',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username'   => 'Kasiadi',
                'sap'        => '5005076',
                'password'   => Hash::make('12345678'),
                'level_user' => 'afdeling 04',
                'kodeunit'   => '3E02',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username'   => 'Mustika Biran',
                'sap'        => '5000543',
                'password'   => Hash::make('12345678'),
                'level_user' => 'atu',
                'kodeunit'   => '3E02',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username'   => 'Hariswan',
                'sap'        => '5006550',
                'password'   => Hash::make('12345678'),
                'level_user' => 'atu',
                'kodeunit'   => '3E02',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
