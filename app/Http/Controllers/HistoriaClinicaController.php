<?php

namespace App\Http\Controllers;

use App\Models\HistoriaClinica;
use App\Models\Paciente;
use Illuminate\Http\Request;

class HistoriaClinicaController extends Controller
{
    public function create()
    {
        $pacientes = Paciente::all();
        return view('historias.create', compact('pacientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'diagnostico' => 'required|string|max:255',
            'observaciones' => 'required|string',
            'paciente_id' => 'required|exists:pacientes,id',
        ]);

        HistoriaClinica::create($request->all());

        return redirect()->route('historias.create')
            ->with('success', 'Historia clínica registrada correctamente');
    }
}
