<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class OrdenDeCompra extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha', 'orden_de_compra', 'cliente_id', 'producto_id', 'monto', 'fecha_envio', 'unidades', 'rut', 'nombre_cliente_final'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function getFechaEnvioAttribute($value)
    {
        return Carbon::parse($value);
    }
}

