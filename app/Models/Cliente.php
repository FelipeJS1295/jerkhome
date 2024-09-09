<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'rut', 'nombre'
    ];

    public function ordenesDeCompra()
    {
        return $this->hasMany(OrdenDeCompra::class, 'cliente_id');
    }
}