<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    use HasFactory;

    protected $fillable = [
        'proveedor_id', 'sku_padre', 'sku_jerk', 'nombre', 'unidad_de_medida', 'precio_unitario'
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
}
