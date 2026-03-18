<?php

namespace App\Http\Controllers;

use App\Models\Tratamiento;
use App\Models\HistoriaClinica;
use Illuminate\Http\Request;

class TratamientoController extends Controller
{
    public function index()
    {
        $tratamientos = Tratamiento::with('historiaClinica.paciente')->latest()->get();
        return view('tratamientos.index', compact('tratamientos'));
    }

    public function create()
    {
        $historias = HistoriaClinica::with('paciente')->get();
        return view('tratamientos.create', compact('historias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'              => 'required|string|max:255',
            'descripcion'         => 'required|string',
            'costo'               => 'required|numeric|min:0',
            'historia_clinica_id' => 'required|exists:historia_clinicas,id',
        ]);

        Tratamiento::create($request->all());

        return redirect()->route('tratamientos.index')
            ->with('success', 'Tratamiento registrado correctamente.');
    }

    public function edit(Tratamiento $tratamiento)
    {
        $historias = HistoriaClinica::with('paciente')->get();
        return view('tratamientos.edit', compact('tratamiento', 'historias'));
    }

    public function update(Request $request, Tratamiento $tratamiento)
    {
        $request->validate([
            'nombre'              => 'required|string|max:255',
            'descripcion'         => 'required|string',
            'costo'               => 'required|numeric|min:0',
            'historia_clinica_id' => 'required|exists:historia_clinicas,id',
        ]);

        $tratamiento->update($request->all());

        return redirect()->route('tratamientos.index')
            ->with('success', 'Tratamiento actualizado correctamente.');
    }

    public function destroy(Tratamiento $tratamiento)
    {
        $tratamiento->delete();
        return redirect()->route('tratamientos.index')
            ->with('success', 'Tratamiento eliminado correctamente.');
    }
}