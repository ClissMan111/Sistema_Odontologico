<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use Illuminate\Http\Request;

class AdminGestionController extends Controller
{
    public function index()
    {
        $administradores = Administrador::latest()->get();
        return view('admin-gestion.index', compact('administradores'));
    }

    public function create()
    {
        return view('admin-gestion.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'email'    => 'required|email|unique:administradores,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        Administrador::create([
            'nombre'   => $request->nombre,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin-gestion.index')
            ->with('success', 'Administrador creado correctamente.');
    }

    public function edit(Administrador $administrador)
    {
        return view('admin-gestion.edit', compact('administrador'));
    }

    public function update(Request $request, Administrador $administrador)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email'  => 'required|email|unique:administradores,email,' . $administrador->id,
        ]);

        $data = ['nombre' => $request->nombre, 'email' => $request->email];

        // Solo actualiza password si se envió uno nuevo
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:6|confirmed',
            ]);
            $data['password'] = bcrypt($request->password);
        }

        $administrador->update($data);

        return redirect()->route('admin-gestion.index')
            ->with('success', 'Administrador actualizado correctamente.');
    }

    public function destroy(Administrador $administrador)
    {
        // Evitar que se elimine a sí mismo
        if ($administrador->id === auth()->guard('administrador')->id()) {
            return redirect()->route('admin-gestion.index')
                ->with('error', 'No puedes eliminarte a ti mismo.');
        }

        $administrador->delete();
        return redirect()->route('admin-gestion.index')
            ->with('success', 'Administrador eliminado correctamente.');
    }
}