<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    use HasFactory;

    protected $table = 'evaluaciones';  // Especifica el nombre de la tabla

    protected $fillable = [
        'trabajador_id', 'fecha', 'desempeño', 'asistencia', 'habilidades_tecnicas', 'comunicacion', 'comentarios', 'recomendaciones'
    ];

    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class);
    }
}
