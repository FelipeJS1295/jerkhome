<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores'; // Nombre correcto de la tabla

    protected $fillable = [
        'rut', 'nombre', 'contacto'
    ];
    
    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }

    // Relación con pagos
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}
