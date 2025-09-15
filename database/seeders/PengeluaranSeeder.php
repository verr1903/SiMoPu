<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengeluaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pengeluarans')->insert([
            [
                'material_id'    => 1,
                'user_id'      => 3,
                'tanggal_keluar' => '2025-09-07',
                'saldo_keluar'   => 5,
                'saldo_sisa'   => 5,
                'sumber'         => '11J',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'material_id'    => 2,
                'user_id'      => 3,
                'tanggal_keluar' => '2025-09-08',
                'saldo_keluar'   => 10,
                'saldo_sisa'   => 10,
                'sumber'         => '14H',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'material_id'    => 3,
                'user_id'      => 3,
                'tanggal_keluar' => '2025-09-04',
                'saldo_keluar'   => 2,
                'saldo_sisa'   => 2,
                'sumber'         => '17M',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'material_id'    => 4,
                'user_id'      => 3,
                'tanggal_keluar' => '2025-09-09',
                'saldo_keluar'   => 6,
                'saldo_sisa'   => 6,
                'sumber'         => '11D',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'material_id'    => 5,
                'user_id'      => 3,
                'tanggal_keluar' => '2025-09-10',
                'saldo_keluar'   => 3,
                'saldo_sisa'   => 3,
                'sumber'         => '12L',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'material_id'    => 2,
                'user_id'      => 3,
                'tanggal_keluar' => '2025-09-11',
                'saldo_keluar'   => 8,
                'saldo_sisa'   => 8,
                'sumber'         => '12G',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'material_id'    => 1,
                'user_id'      => 3,
                'tanggal_keluar' => '2025-09-12',
                'saldo_keluar'   => 7,
                'saldo_sisa'   => 7,
                'sumber'         => '31M',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'material_id'    => 2,
                'user_id'      => 3,
                'tanggal_keluar' => '2025-09-13',
                'saldo_keluar'   => 4,
                'saldo_sisa'   => 4,
                'sumber'         => '21K',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'material_id'    => 3,
                'user_id'      => 3,
                'tanggal_keluar' => '2025-09-14',
                'saldo_keluar'   => 5,
                'saldo_sisa'   => 5,
                'sumber'         => '31F',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'material_id'    => 4,
                'user_id'      => 3,
                'tanggal_keluar' => '2025-09-15',
                'saldo_keluar'   => 9,
                'saldo_sisa'   => 9,
                'sumber'         => '13A',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'material_id'    => 6,
                'user_id'      => 3,
                'tanggal_keluar' => '2025-09-16',
                'saldo_keluar'   => 6,
                'saldo_sisa'   => 6,
                'sumber'         => '23B',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'material_id'    => 4,
                'user_id'      => 3,
                'tanggal_keluar' => '2025-09-17',
                'saldo_keluar'   => 3,
                'saldo_sisa'   => 3,
                'sumber'         => '31C',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'material_id'    => 2,
                'user_id'      => 3,
                'tanggal_keluar' => '2025-09-18',
                'saldo_keluar'   => 8,
                'saldo_sisa'   => 8,
                'sumber'         => '21H',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}
