<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriaClinica extends Model
{
    protected $fillable = [
        'fecha',
        'diagnostico',
        'observaciones',
        'paciente_id'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function tratamientos()
    {
        return $this->hasMany(Tratamiento::class);
    }
}
