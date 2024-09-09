<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiempoPersonal extends Model
{
    use HasFactory;

    protected $table = 'tiempo_personal';

    protected $fillable = [
        'trabajador_id',
        'tipo',
        'fecha_inicio',
        'fecha_fin',
        'descripcion',
    ];

    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class, 'trabajador_id');
    }
}
