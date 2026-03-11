<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = [
        'monto',
        'fecha',
        'metodo',
        'cita_id'
    ];

    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }
}
