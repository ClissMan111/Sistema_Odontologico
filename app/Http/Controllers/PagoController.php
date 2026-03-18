<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Cita;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index()
    {
        $pagos = Pago::with('cita.paciente')->latest()->get();
        return view('pagos.index', compact('pagos'));
    }

    public function create()
    {
        // Solo citas sin pago registrado
        $citas = Cita::with('paciente')
            ->whereDoesntHave('pago')
            ->get();
        return view('pagos.create', compact('citas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'monto'   => 'required|numeric|min:0',
            'fecha'   => 'required|date',
            'metodo'  => 'required|string|max:255',
            'cita_id' => 'required|exists:citas,id|unique:pagos,cita_id',
        ]);

        Pago::create($request->all());

        return redirect()->route('pagos.index')
            ->with('success', 'Pago registrado correctamente.');
    }

    public function edit(Pago $pago)
    {
        $citas = Cita::with('paciente')->get();
        return view('pagos.edit', compact('pago', 'citas'));
    }

    public function update(Request $request, Pago $pago)
    {
        $request->validate([
            'monto'   => 'required|numeric|min:0',
            'fecha'   => 'required|date',
            'metodo'  => 'required|string|max:255',
            'cita_id' => 'required|exists:citas,id|unique:pagos,cita_id,' . $pago->id,
        ]);

        $pago->update($request->all());

        return redirect()->route('pagos.index')
            ->with('success', 'Pago actualizado correctamente.');
    }

    public function destroy(Pago $pago)
    {
        $pago->delete();
        return redirect()->route('pagos.index')
            ->with('success', 'Pago eliminado correctamente.');
    }
}