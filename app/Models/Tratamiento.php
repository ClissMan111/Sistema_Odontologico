<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tratamiento extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'costo',
        'historia_clinica_id'
    ];

    public function historiaClinica()
    {
        return $this->belongsTo(HistoriaClinica::class);
    }
}
