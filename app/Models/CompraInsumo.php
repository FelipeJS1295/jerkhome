<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompraInsumo extends Model
{
    use HasFactory;

    protected $fillable = [
        'compra_id', 'insumo_id', 'precio_unitario', 'cantidad', 'total'
    ];
}

