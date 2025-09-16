<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('materials')->insert([
            [
                'plant'           => '3E02',
                'kode_material'   => '40005944',
                'uraian_material' => 'FERTILIZER:BORATE;45% B2O3;CRYTL',
                'satuan'          => 'Kg',
                'total_saldo'     => 268,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'plant'           => '3E02',
                'kode_material'   => '40005945',
                'uraian_material' => 'FERTILIZER:DOLOMITE;18% MGO;POWDER',
                'satuan'          => 'Kg',
                'total_saldo'     => 890,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'plant'           => '3E02',
                'kode_material'   => '40005947',
                'uraian_material' => 'FERTILIZER:KCL (MOP);60% K2O;CRYTL',
                'satuan'          => 'Kg',
                'total_saldo'     => 713,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'plant'           => '3E02',
                'kode_material'   => '40005918',
                'uraian_material' => 'FERTILIZER:NPK 12-12-17-2;GRANUL',
                'satuan'          => 'Kg',
                'total_saldo'     => 442,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'plant'           => '3E02',
                'kode_material'   => '40005914',
                'uraian_material' => 'FERTILIZER:TSP;45% P2O5 MIN;GRANUL',
                'satuan'          => 'Kg',
                'total_saldo'     => 291,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'plant'           => '3E02',
                'kode_material'   => '40505922',
                'uraian_material' => 'FERTILIZER:UREA;46% N;GRANUL',
                'satuan'          => 'Kg',
                'total_saldo'     => 276,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'plant'           => '3E02',
                'kode_material'   => '400059142',
                'uraian_material' => 'FERTILIZER:UREA;46% N;GRANUL',
                'satuan'          => 'Kg',
                'total_saldo'     => 276,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'plant'           => '3E02',
                'kode_material'   => '40006942',
                'uraian_material' => 'FERTILIZER:UREA;46% N;GRANUL',
                'satuan'          => 'Kg',
                'total_saldo'     => 276,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'plant'           => '3E02',
                'kode_material'   => '40008942',
                'uraian_material' => 'FERTILIZER:UREA;46% N;GRANUL',
                'satuan'          => 'Kg',
                'total_saldo'     => 276,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'plant'           => '3E02',
                'kode_material'   => '40001922',
                'uraian_material' => 'FERTILIZER:UREA;46% N;GRANUL',
                'satuan'          => 'Kg',
                'total_saldo'     => 276,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'plant'           => '3E02',
                'kode_material'   => '40005922',
                'uraian_material' => 'FERTILIZER:UREA;46% N;GRANUL',
                'satuan'          => 'Kg',
                'total_saldo'     => 276,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'plant'           => '3E02',
                'kode_material'   => '40005992',
                'uraian_material' => 'FERTILIZER:UREA;46% N;GRANUL',
                'satuan'          => 'Kg',
                'total_saldo'     => 276,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
        ]);
    }
}
