<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_material',
        'uraian_material',
        'satuan',
        'total_saldo',
    ];

    public function penerimaans()
    {
        return $this->hasMany(Penerimaan::class, 'material_id');
    }
    public function pengeluarans()
    {
        return $this->hasMany(Pengeluaran::class, 'material_id');
    }
}
