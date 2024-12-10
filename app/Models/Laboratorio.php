<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Laboratorio extends Model
{
    use HasFactory;
    protected $fillable = ['laboratorio'];
    public function medicamento() : BelongsToMany{
        return $this->belongsToMany(Medicamento::class);
    }
}
