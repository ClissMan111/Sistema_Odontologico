<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Odontologo;
use App\Models\Administrador;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    // LISTAR
    public function index()
    {
        $citas = Cita::with(['paciente', 'odontologo'])->latest()->get();
        return view('citas.index', compact('citas'));
    }

    // FORM CREAR
    public function create()
    {
        $pacientes       = Paciente::all();
        $odontologos     = Odontologo::all();
        $administradores = Administrador::all();
        return view('citas.create', compact('pacientes', 'odontologos', 'administradores'));
    }

    // GUARDAR
public function store(Request $request)
{
    $request->validate([
        'fecha'         => 'required|date',
        'hora'          => 'required|string|max:255',
        'estado'        => 'required|string|max:255',
        'paciente_id'   => 'required|exists:pacientes,id',
        'odontologo_id' => 'required|exists:odontologos,id',
    ]);

    Cita::create($request->only(['fecha', 'hora', 'estado', 'paciente_id', 'odontologo_id']));

    return redirect()->route('citas.index')
        ->with('success', 'Cita registrada correctamente.');
}

    // FORM EDITAR
    public function edit(Cita $cita)
    {
        $pacientes       = Paciente::all();
        $odontologos     = Odontologo::all();
        $administradores = Administrador::all();
        return view('citas.edit', compact('cita', 'pacientes', 'odontologos', 'administradores'));
    }

    // ACTUALIZAR
    public function update(Request $request, Cita $cita)
{
    $request->validate([
        'fecha'         => 'required|date',
        'hora'          => 'required|string|max:255',
        'estado'        => 'required|string|max:255',
        'paciente_id'   => 'required|exists:pacientes,id',
        'odontologo_id' => 'required|exists:odontologos,id',
    ]);

    $cita->update($request->only(['fecha', 'hora', 'estado', 'paciente_id', 'odontologo_id']));

    return redirect()->route('citas.index')
        ->with('success', 'Cita actualizada correctamente.');
}

    // ELIMINAR
    public function destroy(Cita $cita)
    {
        $cita->delete();
        return redirect()->route('citas.index')
            ->with('success', 'Cita eliminada correctamente.');
    }
}