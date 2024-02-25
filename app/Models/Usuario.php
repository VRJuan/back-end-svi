<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $fillable = ['nombre', 'correo', 'cedula', 'fecha_nacimiento', 'cargo_id'];
    use HasFactory;
    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }
}
