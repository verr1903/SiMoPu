<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Penerimaan;
use App\Models\Pengeluaran;
use App\Models\Unit;
use App\Models\RealisasiPengeluaran; // sesuaikan dengan nama model kamu

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $kodeUnit = session('kodeunit'); // Ambil kodeunit dari session

        // 🔹 Total Material
        $materialQuery = Material::query();
        if ($kodeUnit !== '3R00') {
            $materialQuery->where('plant', $kodeUnit);
        }
        $totalMaterial = $materialQuery->count();

        // 🔹 Total Penerimaan
        $penerimaanQuery = Penerimaan::query();
        if ($kodeUnit !== '3R00') {
            $penerimaanQuery->whereHas('material', function ($q) use ($kodeUnit) {
                $q->where('plant', $kodeUnit);
            });
        }
        $totalPenerimaan = $penerimaanQuery->count();

        // 🔹 Total Pengeluaran
        $pengeluaranQuery = Pengeluaran::query();
        if ($kodeUnit !== '3R00') {
            $pengeluaranQuery->whereHas('material', function ($q) use ($kodeUnit) {
                $q->where('plant', $kodeUnit);
            });
        }
        $totalPengeluaran = $pengeluaranQuery->count();

        // 🔹 Total Realisasi
        $realisasiQuery = RealisasiPengeluaran::query();
        if ($kodeUnit !== '3R00') {
            $realisasiQuery->whereHas('pengeluaran.material', function ($q) use ($kodeUnit) {
                $q->where('plant', $kodeUnit);
            });
        }
        $totalRealisasi = $realisasiQuery->count();

        // Tahun untuk filter
        $years = Pengeluaran::selectRaw('YEAR(tanggal_keluar) as year')
            ->union(Penerimaan::selectRaw('YEAR(tanggal_terima) as year'))
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        $selectedYear = $request->get('year', now()->year);

        // --- Data Pengeluaran & Penerimaan per bulan ---
        $pengeluaranPerBulan = Pengeluaran::selectRaw('MONTH(tanggal_keluar) as month, SUM(saldo_keluar) as total')
            ->when($kodeUnit !== '3R00', fn($q) => $q->whereHas('material', fn($q2) => $q2->where('plant', $kodeUnit)))
            ->whereYear('tanggal_keluar', $selectedYear)
            ->groupBy('month')
            ->pluck('total', 'month');

        $penerimaanPerBulan = Penerimaan::selectRaw('MONTH(tanggal_terima) as month, SUM(saldo_masuk) as total')
            ->when($kodeUnit !== '3R00', fn($q) => $q->whereHas('material', fn($q2) => $q2->where('plant', $kodeUnit)))
            ->whereYear('tanggal_terima', $selectedYear)
            ->groupBy('month')
            ->pluck('total', 'month');

        $pengeluaranData = [];
        $penerimaanData  = [];

        for ($i = 1; $i <= 12; $i++) {
            $pengeluaranData[] = $pengeluaranPerBulan[$i] ?? 0;
            $penerimaanData[]  = $penerimaanPerBulan[$i] ?? 0;
        }

        // --- Grafik Stok Material ---
        $stokMaterial = Material::when($kodeUnit !== '3R00', fn($q) => $q->where('plant', $kodeUnit))
            ->select('uraian_material', 'total_saldo')
            ->get();

        $stokLabels = $stokMaterial->pluck('uraian_material');
        $stokData   = $stokMaterial->pluck('total_saldo');

        // --- Grafik Kecepatan Realisasi ---
        $realisasi = RealisasiPengeluaran::with('pengeluaran.material')
            ->when($kodeUnit !== '3R00', fn($q) => $q->whereHas('pengeluaran.material', fn($q2) => $q2->where('plant', $kodeUnit)))
            ->selectRaw('DATE(scan_keluar) as tgl, AVG(TIMESTAMPDIFF(MINUTE, scan_keluar, scan_akhir)) as rata_waktu')
            ->whereNotNull('scan_keluar')
            ->whereNotNull('scan_akhir')
            ->groupBy('tgl')
            ->orderBy('tgl')
            ->get();

        $realisasiLabels = $realisasi->pluck('tgl');
        $realisasiData   = $realisasi->pluck('rata_waktu');

        $units = Unit::all();

        return view('admin.index', [
            'title'            => 'Dashboard',
            'totalMaterial'    => $totalMaterial,
            'totalPenerimaan'  => $totalPenerimaan,
            'totalPengeluaran' => $totalPengeluaran,
            'totalRealisasi'   => $totalRealisasi,
            'years'            => $years,
            'selectedYear'     => $selectedYear,
            'pengeluaranData'  => $pengeluaranData,
            'penerimaanData'   => $penerimaanData,
            'stokLabels'       => $stokLabels,
            'stokData'         => $stokData,
            'realisasiLabels'  => $realisasiLabels,
            'realisasiData'    => $realisasiData,
            'units'            => $units,
        ]);
    }



    // API untuk chart AJAX
    public function getChartData($year)
    {
        $pengeluaranPerBulan = Pengeluaran::selectRaw('MONTH(tanggal_keluar) as month, SUM(saldo_keluar) as total')
            ->whereYear('tanggal_keluar', $year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $penerimaanPerBulan = Penerimaan::selectRaw('MONTH(tanggal_terima) as month, SUM(saldo_masuk) as total')
            ->whereYear('tanggal_terima', $year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $pengeluaranData = [];
        $penerimaanData  = [];

        for ($i = 1; $i <= 12; $i++) {
            $pengeluaranData[] = $pengeluaranPerBulan[$i] ?? 0;
            $penerimaanData[]  = $penerimaanPerBulan[$i] ?? 0;
        }

        return response()->json([
            'pengeluaran' => $pengeluaranData,
            'penerimaan'  => $penerimaanData,
        ]);
    }
}
