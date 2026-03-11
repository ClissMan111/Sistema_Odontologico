<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $fillable = [
        'fecha',
        'hora',
        'estado',
        'paciente_id',
        'odontologo_id',
        'administrador_id'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function odontologo()
    {
        return $this->belongsTo(Odontologo::class);
    }

    public function pago()
    {
        return $this->hasOne(Pago::class);
    }
}
