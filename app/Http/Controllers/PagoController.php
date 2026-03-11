<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Cita;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function create()
    {
        $citas = Cita::all();
        return view('pagos.create', compact('citas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'monto' => 'required|numeric',
            'fecha' => 'required|date',
            'metodo' => 'required|string|max:255',
            'cita_id' => 'required|exists:citas,id|unique:pagos,cita_id',
        ]);

        Pago::create($request->all());

        return redirect()->route('pagos.create')
            ->with('success', 'Pago registrado correctamente');
    }
}
