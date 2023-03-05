<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo_producto'
    ];

    public function entradas(): HasMany
    {
        return $this->hasMany(Entrada::class, 'producto_id', 'id');
    }
}
