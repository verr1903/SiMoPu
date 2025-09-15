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
                'email'      => 'budi@example.com',
                'password'   => Hash::make('12345678'), 
                'level_user' => 'administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username'   => 'andi',
                'email'      => 'andi@example.com',
                'password'   => Hash::make('12345678'),
                'level_user' => 'administrasi', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username'   => 'sari',
                'email'      => 'sari@example.com',
                'password'   => Hash::make('12345678'),
                'level_user' => 'afdeling 04',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
