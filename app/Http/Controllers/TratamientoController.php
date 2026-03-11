<?php

namespace App\Http\Controllers;

use App\Models\Tratamiento;
use App\Models\HistoriaClinica;
use Illuminate\Http\Request;

class TratamientoController extends Controller
{
    public function create()
    {
        $historias = HistoriaClinica::all();
        return view('tratamientos.create', compact('historias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'costo' => 'required|numeric',
            'historia_clinica_id' => 'required|exists:historia_clinicas,id',
        ]);

        Tratamiento::create($request->all());

        return redirect()->route('tratamientos.create')
            ->with('success', 'Tratamiento registrado correctamente');
    }
}
