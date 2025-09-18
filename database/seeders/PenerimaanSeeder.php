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
        $suppliers = ['CV A', 'CV B', 'CV C'];

        $records = [
            ['material_id' => 1, 'tanggal_terima' => Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'), 'saldo_masuk' => 950],
            ['material_id' => 2, 'tanggal_terima' => Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'), 'saldo_masuk' => 950],
            ['material_id' => 3, 'tanggal_terima' => Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'), 'saldo_masuk' => 200],
            ['material_id' => 4, 'tanggal_terima' => Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'), 'saldo_masuk' => 700],
            ['material_id' => 5, 'tanggal_terima' => Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'), 'saldo_masuk' => 900],
            ['material_id' => 6, 'tanggal_terima' => Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'), 'saldo_masuk' => 850],
            ['material_id' => 1, 'tanggal_terima' => Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'), 'saldo_masuk' => 800],
            ['material_id' => 2, 'tanggal_terima' => Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'), 'saldo_masuk' => 700],
            ['material_id' => 3, 'tanggal_terima' => Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'), 'saldo_masuk' => 700],
            ['material_id' => 4, 'tanggal_terima' => Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'), 'saldo_masuk' => 950],
            ['material_id' => 5, 'tanggal_terima' => Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'), 'saldo_masuk' => 800],
            ['material_id' => 6, 'tanggal_terima' => Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'), 'saldo_masuk' => 550],
            ['material_id' => 1, 'tanggal_terima' => Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'), 'saldo_masuk' => 750],
            ['material_id' => 2, 'tanggal_terima' => Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'), 'saldo_masuk' => 850],
            ['material_id' => 3, 'tanggal_terima' => Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'), 'saldo_masuk' => 950],
            ['material_id' => 4, 'tanggal_terima' => Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'), 'saldo_masuk' => 650],
            ['material_id' => 5, 'tanggal_terima' => Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'), 'saldo_masuk' => 750],
            ['material_id' => 6, 'tanggal_terima' => Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'), 'saldo_masuk' => 950],
            ['material_id' => 1, 'tanggal_terima' => Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'), 'saldo_masuk' => 550],
            ['material_id' => 2, 'tanggal_terima' => Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'), 'saldo_masuk' => 950],
        ];

        foreach ($records as $record) {
            DB::table('penerimaans')->insert([
                'material_id'    => $record['material_id'],
                'tanggal_terima' => $record['tanggal_terima'],
                'saldo_masuk'    => $record['saldo_masuk'],
                'sumber'         => $suppliers[array_rand($suppliers)],
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }
    }
}
