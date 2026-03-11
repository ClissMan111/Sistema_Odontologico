<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Odontologo;
use App\Models\Pago;
use App\Models\Tratamiento;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index()
    {
        // Citas por estado
        $citasPorEstado = [
            'pendiente'  => Cita::where('estado', 'pendiente')->count(),
            'confirmada' => Cita::where('estado', 'confirmada')->count(),
            'completada' => Cita::where('estado', 'completada')->count(),
            'cancelada'  => Cita::where('estado', 'cancelada')->count(),
        ];

        // Citas por mes (últimos 6 meses)
        $citasPorMes = [];
        for ($i = 5; $i >= 0; $i--) {
            $mes = now()->subMonths($i);
            $citasPorMes[] = [
                'mes'      => $mes->isoFormat('MMM'),
                'total'    => Cita::whereMonth('fecha', $mes->month)
                                   ->whereYear('fecha', $mes->year)
                                   ->count(),
                'completadas' => Cita::whereMonth('fecha', $mes->month)
                                      ->whereYear('fecha', $mes->year)
                                      ->where('estado', 'completada')
                                      ->count(),
            ];
        }

        // Top odontólogos por citas atendidas
        $topOdontologos = Odontologo::withCount(['citas' => function ($q) {
            $q->where('estado', 'completada');
        }])->orderByDesc('citas_count')->take(5)->get();

        // Ingresos por mes (últimos 6 meses)
        $ingresosPorMes = [];
        for ($i = 5; $i >= 0; $i--) {
            $mes = now()->subMonths($i);
            $ingresosPorMes[] = [
                'mes'   => $mes->isoFormat('MMM'),
                'total' => Pago::whereMonth('fecha', $mes->month)
                                ->whereYear('fecha', $mes->year)
                                ->sum('monto'),
            ];
        }

        // Resumen general
        $resumen = [
            'total_pacientes'    => Paciente::count(),
            'total_odontologos'  => Odontologo::count(),
            'total_citas'        => Cita::count(),
            'ingresos_totales'   => Pago::sum('monto'),
            'ingresos_mes'       => Pago::whereMonth('fecha', now()->month)
                                         ->whereYear('fecha', now()->year)
                                         ->sum('monto'),
            'citas_mes'          => Cita::whereMonth('fecha', now()->month)
                                         ->whereYear('fecha', now()->year)
                                         ->count(),
        ];

        return view('reportes.index', compact(
            'citasPorEstado',
            'citasPorMes',
            'topOdontologos',
            'ingresosPorMes',
            'resumen'
        ));
    }
}