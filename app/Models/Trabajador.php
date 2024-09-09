<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    use HasFactory;

    protected $table = 'personal'; // Indicamos que la tabla asociada es 'personal'

    protected $fillable = [
        'nombre',
        'apellido',
        'rut',
        'fecha_nacimiento',
        'direccion',
        'telefono',
        'email',
        'afp',
        'isapre_fonasa',
        'cargo',
        'sueldo',
        'fecha_ingreso',
    ];
    
    public function tiemposPersonales()
    {
        return $this->hasMany(TiempoPersonal::class, 'trabajador_id');
    }

    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class, 'trabajador_id');
    }

    public function producciones()
    {
        return $this->hasMany(OrdenDeTrabajo::class, 'trabajador_id');
    }
}