<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('units')->insert([
            ['kodeunit' => '3R00', 'namaunit' => 'Kantor Region', 'nama_distrik' => null, 'jenis' => 'Kantor Direksi', 'singkatan' => null],
            ['kodeunit' => '3E01', 'namaunit' => 'Kebun Inti/KKPA Sei Galuh', 'nama_distrik' => 'Distrik Timur', 'jenis' => 'Kebun Inti', 'singkatan' => 'SGH'],
            ['kodeunit' => '3E02', 'namaunit' => 'Kebun Inti/KKPA Sei Garo', 'nama_distrik' => 'Distrik Timur', 'jenis' => 'Kebun Inti', 'singkatan' => 'SGO'],
            ['kodeunit' => '3E03', 'namaunit' => 'Kebun Inti/KKPA Sei Pagar', 'nama_distrik' => 'Distrik Timur', 'jenis' => 'Kebun Inti', 'singkatan' => 'SPA'],
            ['kodeunit' => '3E04', 'namaunit' => 'Kebun Tanjung Medan', 'nama_distrik' => 'Distrik Timur', 'jenis' => 'Kebun Inti', 'singkatan' => 'TME'],
            ['kodeunit' => '3E05', 'namaunit' => 'Kebun Inti Tanah Putih', 'nama_distrik' => 'Distrik Timur', 'jenis' => 'Kebun Inti', 'singkatan' => 'TPU'],
            ['kodeunit' => '3E06', 'namaunit' => 'Kebun Plasma/Pembelian SGO/SPA/SGH', 'nama_distrik' => null, 'jenis' => 'Kebun Inti', 'singkatan' => null],
            ['kodeunit' => '3E07', 'namaunit' => 'Kebun Plasma/Pembelian TPU/TME', 'nama_distrik' => null, 'jenis' => 'Kebun Inti', 'singkatan' => null],
            ['kodeunit' => '3E08', 'namaunit' => 'Kebun Inti Lubuk Dalam', 'nama_distrik' => 'Distrik Timur', 'jenis' => 'Kebun Inti', 'singkatan' => 'LDA'],
            ['kodeunit' => '3E09', 'namaunit' => 'Kebun Inti Sei Buatan', 'nama_distrik' => 'Distrik Timur', 'jenis' => 'Kebun Inti', 'singkatan' => 'SBT'],
            ['kodeunit' => '3E10', 'namaunit' => 'Kebun Inti/KKPA Air Molek I', 'nama_distrik' => 'Distrik Timur', 'jenis' => 'Kebun Inti', 'singkatan' => 'AMO1'],
            ['kodeunit' => '3E11', 'namaunit' => 'Kebun Inti/KKPA Air Molek II', 'nama_distrik' => 'Distrik Timur', 'jenis' => 'Kebun Inti', 'singkatan' => 'AMO2'],
            ['kodeunit' => '3E12', 'namaunit' => 'Kebun Plasma/Pembelian SBT/LDA', 'nama_distrik' => null, 'jenis' => 'Kebun Inti', 'singkatan' => null],
            ['kodeunit' => '3E13', 'namaunit' => 'Kebun Tandun', 'nama_distrik' => 'Distrik Barat', 'jenis' => 'Kebun Inti', 'singkatan' => 'TAN'],
            ['kodeunit' => '3E14', 'namaunit' => 'Kebun Terantam', 'nama_distrik' => 'Distrik Barat', 'jenis' => 'Kebun Inti', 'singkatan' => 'TER'],
            ['kodeunit' => '3E15', 'namaunit' => 'Kebun Sei Kencana', 'nama_distrik' => 'Distrik Barat', 'jenis' => 'Kebun Inti', 'singkatan' => 'SKE'],
            ['kodeunit' => '3E16', 'namaunit' => 'Kebun Sei Lindai', 'nama_distrik' => 'Distrik Barat', 'jenis' => 'Kebun Inti', 'singkatan' => 'SLI'],
            ['kodeunit' => '3E17', 'namaunit' => 'Kebun Tamora', 'nama_distrik' => 'Distrik Barat', 'jenis' => 'Kebun Inti', 'singkatan' => 'TAM'],
            ['kodeunit' => '3E18', 'namaunit' => 'Kebun Inti/KKPA Sei Batu Langkah', 'nama_distrik' => 'Distrik Barat', 'jenis' => 'Kebun Inti', 'singkatan' => 'SBL'],
            ['kodeunit' => '3E19', 'namaunit' => 'Kebun Pembelian TAN', 'nama_distrik' => null, 'jenis' => 'Kebun Inti', 'singkatan' => null],
            ['kodeunit' => '3E20', 'namaunit' => 'Kebun Sei Rokan', 'nama_distrik' => 'Distrik Barat', 'jenis' => 'Kebun Inti', 'singkatan' => 'SRO'],
            ['kodeunit' => '3E21', 'namaunit' => 'Kebun Inti Sei Intan', 'nama_distrik' => 'Distrik Barat', 'jenis' => 'Kebun Inti', 'singkatan' => 'SIN'],
            ['kodeunit' => '3E22', 'namaunit' => 'Kebun Sei Siasam', 'nama_distrik' => 'Distrik Barat', 'jenis' => 'Kebun Inti', 'singkatan' => 'SSI'],
            ['kodeunit' => '3E23', 'namaunit' => 'Kebun Inti / KKPA Sei Tapung', 'nama_distrik' => 'Distrik Barat', 'jenis' => 'Kebun Inti', 'singkatan' => 'STA'],
            ['kodeunit' => '3E24', 'namaunit' => 'Kebun Sei Berlian', 'nama_distrik' => 'Distrik Barat', 'jenis' => 'Kebun Inti', 'singkatan' => 'SBE'],
        ]);
    }
}
