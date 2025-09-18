<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'username',
        'sap',
        'password',
        'level_user',
        'kodeunit',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'kodeunit', 'kodeunit');
    }
}
