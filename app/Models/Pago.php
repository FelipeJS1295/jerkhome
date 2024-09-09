<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_pago', 'fecha_pago', 'numero_pago', 'monto', 'documento_id'
    ];

    public function documento()
    {
        return $this->belongsTo(Documento::class);
    }
}