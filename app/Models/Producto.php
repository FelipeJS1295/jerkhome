<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku', 
        'nombre',
        'esqueletoc',
        'esqueletoa',
        'esqueleto',
        'ccostura',
        'ctapiceria',
        'ccorte',
        'carmado',
        'ccompleto'
    ];

    public function ordenesDeCompra()
    {
        return $this->hasMany(OrdenDeCompra::class, 'producto_id');
    }
}
