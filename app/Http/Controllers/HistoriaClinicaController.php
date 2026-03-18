<?php

namespace App\Http\Controllers;

use App\Models\HistoriaClinica;
use App\Models\Paciente;
use Illuminate\Http\Request;

class HistoriaClinicaController extends Controller
{
    public function index()
    {
        $historias = HistoriaClinica::with('paciente')->latest()->get();
        return view('historias.index', compact('historias'));
    }

    public function create()
    {
        $pacientes = Paciente::all();
        return view('historias.create', compact('pacientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha'          => 'required|date',
            'diagnostico'    => 'required|string|max:255',
            'observaciones'  => 'required|string',
            'paciente_id'    => 'required|exists:pacientes,id',
        ]);

        HistoriaClinica::create($request->all());

        return redirect()->route('historias.index')
            ->with('success', 'Historia clínica registrada correctamente.');
    }

    public function edit(HistoriaClinica $historia)
    {
        $pacientes = Paciente::all();
        return view('historias.edit', compact('historia', 'pacientes'));
    }

    public function update(Request $request, HistoriaClinica $historia)
    {
        $request->validate([
            'fecha'         => 'required|date',
            'diagnostico'   => 'required|string|max:255',
            'observaciones' => 'required|string',
            'paciente_id'   => 'required|exists:pacientes,id',
        ]);

        $historia->update($request->all());

        return redirect()->route('historias.index')
            ->with('success', 'Historia clínica actualizada correctamente.');
    }

    public function destroy(HistoriaClinica $historia)
    {
        $historia->delete();
        return redirect()->route('historias.index')
            ->with('success', 'Historia clínica eliminada correctamente.');
    }
}
