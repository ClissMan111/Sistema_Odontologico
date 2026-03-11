<?php

namespace App\Http\Controllers;

use App\Models\Odontologo;
use App\Models\Administrador;
use Illuminate\Http\Request;

class OdontologoController extends Controller
{
    // LISTAR
    public function index()
    {
        $odontologos = Odontologo::all();
        return view('odontologos.index', compact('odontologos'));
    }

    // FORM CREAR
    public function create()
    {
        $administradores = Administrador::all();
        return view('odontologos.create', compact('administradores'));
    }

    // GUARDAR
    public function store(Request $request)
    {
        $request->validate([
            'nombre'           => 'required|string|max:255',
            'especialidad'     => 'required|string|max:255',
            'telefono'         => 'required|string|max:255',
            'administrador_id' => 'required|exists:administradores,id',
        ]);

        Odontologo::create([
            'nombre'           => $request->nombre,
            'especialidad'     => $request->especialidad,
            'telefono'         => $request->telefono,
            'administrador_id' => $request->administrador_id,
        ]);

        return redirect()->route('odontologos.index')
            ->with('success', 'Odontólogo registrado correctamente.');
    }

    // FORM EDITAR
    public function edit(Odontologo $odontologo)
    {
        $administradores = Administrador::all();
        return view('odontologos.edit', compact('odontologo', 'administradores'));
    }

    // ACTUALIZAR
    public function update(Request $request, Odontologo $odontologo)
    {
        $request->validate([
            'nombre'           => 'required|string|max:255',
            'especialidad'     => 'required|string|max:255',
            'telefono'         => 'required|string|max:255',
            'administrador_id' => 'required|exists:administradores,id',
        ]);

        $odontologo->update([
            'nombre'           => $request->nombre,
            'especialidad'     => $request->especialidad,
            'telefono'         => $request->telefono,
            'administrador_id' => $request->administrador_id,
        ]);

        return redirect()->route('odontologos.index')
            ->with('success', 'Odontólogo actualizado correctamente.');
    }

    // ELIMINAR
    public function destroy(Odontologo $odontologo)
    {
        $odontologo->delete();

        return redirect()->route('odontologos.index')
            ->with('success', 'Odontólogo eliminado correctamente.');
    }
}