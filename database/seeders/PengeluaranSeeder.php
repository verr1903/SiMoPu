<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengeluaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records = [];
        $letters = range('A', 'Z');

        for ($i = 0; $i < 100; $i++) {
            $randomDate = Carbon::now()
                ->subYears(2)
                ->addDays(rand(0, 730)); // 2 tahun = 730 hari
            $saldoKeluar = rand(50, 200);

            $sumberArray = [];
            $count = rand(1, 5);
            for ($j = 0; $j < $count; $j++) {
                $sumberArray[] = rand(10, 99) . $letters[array_rand($letters)];
            }

            $records[] = [
                'material_id'    => rand(1, 6),
                'user_id'        => 3,
                'tanggal_keluar' => $randomDate->format('Y-m-d'),
                'saldo_keluar'   => $saldoKeluar,
                'saldo_sisa'     => $saldoKeluar,
                'sumber'         => json_encode($sumberArray), 
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
        }

        DB::table('pengeluarans')->insert($records);
    }
}
