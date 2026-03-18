<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = Paciente::latest()->get();
        return view('pacientes.index', compact('pacientes'));
    }

    public function create()
    {
        return view('pacientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'           => 'required|string|max:255',
            'apellido'         => 'required|string|max:255',
            'ci'               => 'required|string|max:255|unique:pacientes,ci',
            'telefono'         => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'direccion'        => 'required|string|max:255',
        ]);

        Paciente::create([
            'nombre'           => $request->nombre,
            'apellido'         => $request->apellido,
            'ci'               => $request->ci,
            'telefono'         => $request->telefono,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'direccion'        => $request->direccion,
        ]);

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente registrado correctamente.');
    }

    public function edit(Paciente $paciente)
    {
        return view('pacientes.edit', compact('paciente'));
    }

    public function update(Request $request, Paciente $paciente)
    {
        $request->validate([
            'nombre'           => 'required|string|max:255',
            'apellido'         => 'required|string|max:255',
            'ci'               => 'required|string|max:255|unique:pacientes,ci,' . $paciente->id,
            'telefono'         => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'direccion'        => 'required|string|max:255',
        ]);

        $paciente->update($request->all());

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente actualizado correctamente.');
    }

    public function destroy(Paciente $paciente)
    {
        $paciente->delete();
        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente eliminado correctamente.');
    }
}