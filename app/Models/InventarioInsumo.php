<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarioInsumo extends Model
{
    use HasFactory;

    protected $table = 'inventario_insumos';

    protected $fillable = [
        'insumo_id',
        'cantidad',
    ];

    public function insumo()
    {
        return $this->belongsTo(Insumo::class);
    }
}
