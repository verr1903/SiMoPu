<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Material;
use Carbon\Carbon;

class StokMaterialExport implements FromView
{
    protected $year;
    protected $month;

    public function __construct($year, $month = null)
    {
        $this->year = $year;
        $this->month = $month;
    }

    /**
     * Hitung saldo awal pada bulan tertentu.
     */
    protected function getSaldoAwal($item, $year, $month)
    {
        $cutoff = Carbon::createFromDate($year, $month, 1)->startOfMonth();

        // saldo akhir (total_saldo) saat ini
        $saldoAkhirSekarang = $item->total_saldo;

        // hitung semua transaksi setelah bulan yang diminta
        $totalMasukSetelah = $item->penerimaans()
            ->where('tanggal_terima', '>=', $cutoff)
            ->sum('saldo_masuk');

        $totalKeluarSetelah = $item->pengeluarans()
            ->where('tanggal_keluar', '>=', $cutoff)
            ->sum('saldo_keluar');

        // rumus mundur saldo awal
        return $saldoAkhirSekarang + $totalKeluarSetelah - $totalMasukSetelah;
    }

    /**
     * Hitung saldo akhir pada bulan tertentu.
     */
    protected function getSaldoAkhir($item, $year, $month)
    {
        // ambil saldo awal bulan tersebut
        $saldoAwal = $this->getSaldoAwal($item, $year, $month);

        // total transaksi bulan tersebut
        $masuk = $item->penerimaans()
            ->whereYear('tanggal_terima', $year)
            ->whereMonth('tanggal_terima', $month)
            ->sum('saldo_masuk');

        $keluar = $item->pengeluarans()
            ->whereYear('tanggal_keluar', $year)
            ->whereMonth('tanggal_keluar', $month)
            ->sum('saldo_keluar');

        // saldo akhir bulan itu
        return $saldoAwal + $masuk - $keluar;
    }

    /**
     * View export ke Excel.
     */
    public function view(): View
    {
        $year = $this->year;
        $month = $this->month;

        $materials = Material::with(['penerimaans', 'pengeluarans'])->get()->map(function ($item) use ($year, $month) {

            // saldo awal
            $saldo_awal = $this->getSaldoAwal($item, $year, $month);

            // transaksi bulan dipilih
            $masuk = $item->penerimaans()
                ->whereYear('tanggal_terima', $year)
                ->whereMonth('tanggal_terima', $month)
                ->sum('saldo_masuk');

            $keluar = $item->pengeluarans()
                ->whereYear('tanggal_keluar', $year)
                ->whereMonth('tanggal_keluar', $month)
                ->sum('saldo_keluar');

            // saldo akhir bulan dipilih (pakai helper juga boleh)
            $saldo_akhir = $this->getSaldoAkhir($item, $year, $month);

            return [
                'plant' => $item->plant,
                'kode_material' => $item->kode_material,
                'satuan' => $item->satuan,
                'nama' => $item->uraian_material,
                'saldo_awal' => $saldo_awal,
                'masuk' => $masuk,
                'keluar' => $keluar,
                'saldo_akhir' => $saldo_akhir,
            ];
        });

        return view('exports.stok_material', [
            'materials' => $materials,
            'year' => $year,
            'month' => $month,
        ]);
    }
}
