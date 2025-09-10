<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerimaan extends Model
{
    protected $fillable = ['material_id', 'tanggal_terima', 'saldo_masuk', 'sumber'];

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
}
