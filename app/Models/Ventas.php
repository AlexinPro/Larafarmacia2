<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ventas extends Model
{
    /** @use HasFactory<\Database\Factories\VentasFactory> */
    use HasFactory;
    protected $fillable = ['cliente_id', 'medicamento_id','cantidad'];
    public function cliente() : BelongsToMany{
        return $this->belongsToMany(Clientes::class);
    }
    public function medicamento() : BelongsToMany{
        return $this->belongsToMany(Medicamento::class);
    }
}
