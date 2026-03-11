<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    // Mostrar formulario
    public function create()
    {
        return view('pacientes.create');
    }

    // Guardar paciente
    public function store(Request $request)
    {
        // VALIDACIÓN
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'ci' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'direccion' => 'required|string|max:255',
        ]);

        Paciente::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'ci' => $request->ci,
            'telefono' => $request->telefono,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'direccion' => $request->direccion,
        ]);

        return redirect()->route('pacientes.create')
            ->with('success', 'Paciente registrado correctamente');
    }
}
