<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenerimaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('penerimaans')->insert([
            [
                'material_id'   => 1,
                'tanggal_terima'=> '2025-09-01',
                'saldo_masuk'   => 100,
                'sumber'        => 'Supplier A',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'material_id'   => 2,
                'tanggal_terima'=> '2025-09-02',
                'saldo_masuk'   => 250,
                'sumber'        => 'Supplier B',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'material_id'   => 3,
                'tanggal_terima'=> '2025-09-03',
                'saldo_masuk'   => 150,
                'sumber'        => 'Supplier A',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'material_id'   => 4,
                'tanggal_terima'=> '2025-09-04',
                'saldo_masuk'   => 200,
                'sumber'        => 'Supplier B',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'material_id'   => 5,
                'tanggal_terima'=> '2025-09-05',
                'saldo_masuk'   => 300,
                'sumber'        => 'Supplier A',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'material_id'   => 3,
                'tanggal_terima'=> '2025-09-06',
                'saldo_masuk'   => 120,
                'sumber'        => 'Supplier B',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'material_id'   => 1,
                'tanggal_terima'=> '2025-09-07',
                'saldo_masuk'   => 180,
                'sumber'        => 'Supplier C',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'material_id'   => 2,
                'tanggal_terima'=> '2025-09-08',
                'saldo_masuk'   => 220,
                'sumber'        => 'Supplier A',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'material_id'   => 3,
                'tanggal_terima'=> '2025-09-09',
                'saldo_masuk'   => 140,
                'sumber'        => 'Supplier B',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'material_id'   => 4,
                'tanggal_terima'=> '2025-09-10',
                'saldo_masuk'   => 260,
                'sumber'        => 'Supplier C',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'material_id'   => 3,
                'tanggal_terima'=> '2025-09-11',
                'saldo_masuk'   => 310,
                'sumber'        => 'Supplier A',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'material_id'   => 2,
                'tanggal_terima'=> '2025-09-12',
                'saldo_masuk'   => 170,
                'sumber'        => 'Supplier B',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'material_id'   => 6,
                'tanggal_terima'=> '2025-09-13',
                'saldo_masuk'   => 280,
                'sumber'        => 'Supplier C',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);
    }
}
