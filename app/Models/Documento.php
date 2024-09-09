<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $fillable = [
        'numero_documento', 'proveedor_id', 'fecha_documento', 'vencimiento', 'monto_neto', 'iva', 'total', 'total_restante', 'pagado', 'estado'
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}
