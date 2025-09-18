<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenerimaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records = [];
        $suppliers = ['Supplier A', 'Supplier B', 'Supplier C'];

        for ($i = 0; $i < 100; $i++) {
            $randomDate = Carbon::now()
                ->subYears(2)
                ->addDays(rand(0, 730)); // 2 tahun ke belakang

            // saldo masuk minimal lebih banyak dari keluar
            $saldoKeluar = rand(1, 20); // perkiraan keluar
            $saldoMasuk  = $saldoKeluar + rand(70, 250); // lebih besar dari keluar

            $records[] = [
                'material_id'    => rand(1, 6),
                'tanggal_terima' => $randomDate->format('Y-m-d'),
                'saldo_masuk'    => $saldoMasuk,
                'sumber'         => $suppliers[array_rand($suppliers)],
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
        }

        DB::table('penerimaans')->insert($records);
    }
}
