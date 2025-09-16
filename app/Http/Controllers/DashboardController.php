<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Penerimaan;
use App\Models\Pengeluaran;
use App\Models\RealisasiPengeluaran; // sesuaikan dengan nama model kamu

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total dari tiap tabel
        $totalMaterial    = Material::count();
        $totalPenerimaan  = Penerimaan::count();
        $totalPengeluaran = Pengeluaran::count();
        $totalRealisasi   = RealisasiPengeluaran::count();

        return view('admin.index', [
            'title'           => 'Dashboard',
            'totalMaterial'   => $totalMaterial,
            'totalPenerimaan' => $totalPenerimaan,
            'totalPengeluaran'=> $totalPengeluaran,
            'totalRealisasi'  => $totalRealisasi,
        ]);
    }
}
