<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Odontologo extends Model
{
    protected $fillable = [
        'nombre',
        'especialidad',
        'telefono',
        'administrador_id'
    ];

    public function administrador()
    {
        return $this->belongsTo(Administrador::class);
    }

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
}

