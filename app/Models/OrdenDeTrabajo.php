<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenDeTrabajo extends Model
{
    use HasFactory;

    protected $table = 'ordenes_de_trabajo'; // Apuntar a la tabla correcta

    protected $fillable = [
        'numero_ot', 'fecha', 'seccion', 'trabajador_id', 'producto_id'
    ];

    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
