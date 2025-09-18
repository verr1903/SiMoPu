<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'kodeunit',
        'namaunit',
        'nama_distrik',
        'jenis',
        'singkatan',
    ];

    public function materials()
    {
        return $this->hasMany(Material::class, 'plant', 'kodeunit');
    }
     public function users()
    {
        return $this->hasMany(User::class, 'kodeunit', 'kodeunit');
    }
}
