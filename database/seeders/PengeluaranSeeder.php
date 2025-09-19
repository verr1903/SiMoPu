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
        $pengeluaranData = [
            ['material_id'=>1,'user_id'=>5,'tanggal_keluar'=>Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'),'saldo_keluar'=>50,'sumber'=>json_encode(['10A','11B']),'au58'=>'INV/2025/09/001'],
            ['material_id'=>2,'user_id'=>5,'tanggal_keluar'=>Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'),'saldo_keluar'=>150,'sumber'=>json_encode(['12C']),'au58'=>'INV/2025/09/002'],
            ['material_id'=>3,'user_id'=>5,'tanggal_keluar'=>Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'),'saldo_keluar'=>700,'sumber'=>json_encode(['15D','16E','17F']),'au58'=>'INV/2025/09/003'],
            ['material_id'=>1,'user_id'=>5,'tanggal_keluar'=>Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'),'saldo_keluar'=>400,'sumber'=>json_encode(['18G']),'au58'=>'INV/2025/09/004'],
            ['material_id'=>2,'user_id'=>5,'tanggal_keluar'=>Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'),'saldo_keluar'=>250,'sumber'=>json_encode(['19H','20I']),'au58'=>'INV/2025/09/005'],
            ['material_id'=>3,'user_id'=>5,'tanggal_keluar'=>Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'),'saldo_keluar'=>600,'sumber'=>json_encode(['21J']),'au58'=>'INV/2025/09/006'],
            ['material_id'=>4,'user_id'=>5,'tanggal_keluar'=>Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'),'saldo_keluar'=>580,'sumber'=>json_encode(['22K','23L']),'au58'=>'INV/2025/09/007'],
            ['material_id'=>5,'user_id'=>6,'tanggal_keluar'=>Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'),'saldo_keluar'=>550,'sumber'=>json_encode(['24M']),'au58'=>'INV/2025/09/008'],
            ['material_id'=>6,'user_id'=>6,'tanggal_keluar'=>Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'),'saldo_keluar'=>900,'sumber'=>json_encode(['25N','26O']),'au58'=>'INV/2025/09/009'],
            ['material_id'=>1,'user_id'=>6,'tanggal_keluar'=>Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'),'saldo_keluar'=>350,'sumber'=>json_encode(['27P']),'au58'=>'INV/2025/09/010'],
            ['material_id'=>2,'user_id'=>6,'tanggal_keluar'=>Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'),'saldo_keluar'=>450,'sumber'=>json_encode(['28Q','29R']),'au58'=>'INV/2025/09/011'],
            ['material_id'=>3,'user_id'=>6,'tanggal_keluar'=>Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'),'saldo_keluar'=>650,'sumber'=>json_encode(['30S']),'au58'=>'INV/2025/09/012'],
            ['material_id'=>4,'user_id'=>7,'tanggal_keluar'=>Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'),'saldo_keluar'=>500,'sumber'=>json_encode(['31T','32U']),'au58'=>'INV/2025/09/013'],
            ['material_id'=>5,'user_id'=>7,'tanggal_keluar'=>Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'),'saldo_keluar'=>400,'sumber'=>json_encode(['33V']),'au58'=>'INV/2025/09/014'],
            ['material_id'=>6,'user_id'=>7,'tanggal_keluar'=>Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'),'saldo_keluar'=>50,'sumber'=>json_encode(['34W','35X']),'au58'=>'INV/2025/09/015'],
            ['material_id'=>1,'user_id'=>7,'tanggal_keluar'=>Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'),'saldo_keluar'=>120,'sumber'=>json_encode(['36Y']),'au58'=>'INV/2025/09/016'],
            ['material_id'=>2,'user_id'=>7,'tanggal_keluar'=>Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'),'saldo_keluar'=>550,'sumber'=>json_encode(['37Z']),'au58'=>'INV/2025/09/017'],
            ['material_id'=>3,'user_id'=>7,'tanggal_keluar'=>Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'),'saldo_keluar'=>420,'sumber'=>json_encode(['38A','39B']),'au58'=>'INV/2025/09/018'],
            ['material_id'=>4,'user_id'=>8,'tanggal_keluar'=>Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'),'saldo_keluar'=>520,'sumber'=>json_encode(['40C']),'au58'=>'INV/2025/09/019'],
            ['material_id'=>5,'user_id'=>8,'tanggal_keluar'=>Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'),'saldo_keluar'=>350,'sumber'=>json_encode(['41D','42E']),'au58'=>'INV/2025/09/020'],
            ['material_id'=>5,'user_id'=>8,'tanggal_keluar'=>Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'),'saldo_keluar'=>150,'sumber'=>json_encode(['41D','37Z']),'au58'=>'INV/2025/09/021'],
            ['material_id'=>6,'user_id'=>8,'tanggal_keluar'=>Carbon::create(rand(2024,2025), rand(1,12), rand(1,28))->format('Y-m-d'),'saldo_keluar'=>350,'sumber'=>json_encode(['15D','42E']),'au58'=>'INV/2025/09/029'],
        ];

        foreach ($pengeluaranData as $data) {
            $data['saldo_sisa'] = $data['saldo_keluar'];
            $data['created_at'] = now();
            $data['updated_at'] = now();

            DB::table('pengeluarans')->insert($data);
        }
    }
}
