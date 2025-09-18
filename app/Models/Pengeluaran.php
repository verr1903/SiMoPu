<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{

    protected $fillable = [
        'material_id',
        'user_id',
        'penerima',
        'au58',
        'tanggal_keluar',
        'saldo_keluar',
        'saldo_sisa',
        'sumber',
        'status'
    ];

    protected $casts = [
        'sumber' => 'array',
    ];

    /**
     * Scope untuk urutkan data:
     * - Status menunggu → paling atas, urut dari yang lama
     * - Status lain     → di bawah, urut dari yang baru
     */
    public function scopeUrutkanStatus($query)
    {
        return $query->orderByRaw("
                CASE 
                    WHEN status = 'menunggu' THEN 0 
                    ELSE 1 
                END
            ")
            ->orderByRaw("
                CASE 
                    WHEN status = 'menunggu' THEN created_at 
                END ASC
            ")
            ->orderByRaw("
                CASE 
                    WHEN status != 'menunggu' THEN created_at 
                END DESC
            ");
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function realisasiPengeluarans()
    {
        return $this->hasMany(RealisasiPengeluaran::class, 'pengeluaran_id');
    }
}
