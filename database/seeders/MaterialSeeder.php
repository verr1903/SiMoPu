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
                'uraian_material' => 'BORATE',
                'satuan'          => 'Kg',
                'total_saldo'     => 80,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'plant'           => '3E02',
                'kode_material'   => '40005945',
                'uraian_material' => 'DOLOMITE',
                'satuan'          => 'Kg',
                'total_saldo'     => 247792,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'plant'           => '3E02',
                'kode_material'   => '40005947',
                'uraian_material' => 'KCL (MOP)',
                'satuan'          => 'Kg',
                'total_saldo'     => 216729,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'plant'           => '3E02',
                'kode_material'   => '40005918',
                'uraian_material' => 'NPK 12-12-17-2',
                'satuan'          => 'Kg',
                'total_saldo'     => 564600,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'plant'           => '3E02',
                'kode_material'   => '40005914',
                'uraian_material' => 'TSP',
                'satuan'          => 'Kg',
                'total_saldo'     => 9040,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'plant'           => '3E02',
                'kode_material'   => '40505922',
                'uraian_material' => 'UREA',
                'satuan'          => 'Kg',
                'total_saldo'     => 231085,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
        ]);
    }
}
