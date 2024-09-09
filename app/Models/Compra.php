<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha', 'fecha_vencimiento', 'factura_o_boleta', 'proveedor_id', 'estado'
    ];

    public function insumos()
    {
        return $this->belongsToMany(Insumo::class, 'compra_insumo')
                    ->withPivot('precio_unitario', 'cantidad', 'total')
                    ->withTimestamps();
    }
}