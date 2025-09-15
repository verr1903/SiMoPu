<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealisasiPengeluaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengeluaran_id',
        'cicilan_pengeluaran',
    ];

    /**
     * Relasi ke tabel pengeluaran
     */
    public function pengeluaran()
    {
        return $this->belongsTo(Pengeluaran::class, 'pengeluaran_id');
    }
}
