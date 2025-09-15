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
                'sumber'         => 'Afdeling A',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'material_id'    => 2,
                'user_id'      => 3,
                'tanggal_keluar' => '2025-09-08',
                'saldo_keluar'   => 10,
                'sumber'         => 'Afdeling B',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'material_id'    => 3,
                'user_id'      => 3,
                'tanggal_keluar' => '2025-09-04',
                'saldo_keluar'   => 2,
                'sumber'         => 'Afdeling C',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'material_id'    => 4,
                'user_id'      => 3,
                'tanggal_keluar' => '2025-09-09',
                'saldo_keluar'   => 6,
                'sumber'         => 'Afdeling A',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'material_id'    => 5,
                'user_id'      => 3,
                'tanggal_keluar' => '2025-09-10',
                'saldo_keluar'   => 3,
                'sumber'         => 'Afdeling B',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'material_id'    => 2,
                'user_id'      => 3,
                'tanggal_keluar' => '2025-09-11',
                'saldo_keluar'   => 8,
                'sumber'         => 'Afdeling C',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'material_id'    => 1,
                'user_id'      => 3,
                'tanggal_keluar' => '2025-09-12',
                'saldo_keluar'   => 7,
                'sumber'         => 'Afdeling A',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'material_id'    => 2,
                'user_id'      => 3,
                'tanggal_keluar' => '2025-09-13',
                'saldo_keluar'   => 4,
                'sumber'         => 'Afdeling B',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'material_id'    => 3,
                'user_id'      => 3,
                'tanggal_keluar' => '2025-09-14',
                'saldo_keluar'   => 5,
                'sumber'         => 'Afdeling C',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'material_id'    => 4,
                'user_id'      => 3,
                'tanggal_keluar' => '2025-09-15',
                'saldo_keluar'   => 9,
                'sumber'         => 'Afdeling A',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'material_id'    => 6,
                'user_id'      => 3,
                'tanggal_keluar' => '2025-09-16',
                'saldo_keluar'   => 6,
                'sumber'         => 'Afdeling B',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'material_id'    => 4,
                'user_id'      => 3,
                'tanggal_keluar' => '2025-09-17',
                'saldo_keluar'   => 3,
                'sumber'         => 'Afdeling C',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'material_id'    => 2,
                'user_id'      => 3,
                'tanggal_keluar' => '2025-09-18',
                'saldo_keluar'   => 8,
                'sumber'         => 'Afdeling A',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}
