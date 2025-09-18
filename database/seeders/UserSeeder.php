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
                'username'   => 'budi',
                'sap'        => '12345678',
                'password'   => Hash::make('12345678'), 
                'level_user' => 'administrator',
                'kodeunit'   => '3R00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username'   => 'andi',
                'sap'        => '23456789',
                'password'   => Hash::make('12345678'),
                'level_user' => 'administrasi', 
                'kodeunit'   => '3E02', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username'   => 'sari',
                'sap'        => '34567890',
                'password'   => Hash::make('12345678'),
                'level_user' => 'afdeling 04',
                'kodeunit'   => '3E02',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
