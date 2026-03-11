@extends('layouts.admin')

@section('title', 'Reportes')
@section('page_title', 'Ver Reportes')
@section('breadcrumb', 'Reportes')

@section('content')

{{-- ── RESUMEN GENERAL ── --}}
<div class="stats-grid" style="margin-bottom:28px;">

    <div class="stat-card">
        <div class="stat-icon blue"><i class="fa-solid fa-users"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ $resumen['total_pacientes'] }}</div>
            <div class="stat-label">Pacientes registrados</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon navy"><i class="fa-solid fa-user-doctor"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ $resumen['total_odontologos'] }}</div>
            <div class="stat-label">Odontólogos activos</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon green"><i class="fa-solid fa-calendar-check"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ $resumen['citas_mes'] }}</div>
            <div class="stat-label">Citas este mes</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon orange"><i class="fa-solid fa-money-bill-wave"></i></div>
        <div class="stat-info">
            <div class="stat-value">Bs {{ number_format($resumen['ingresos_mes'], 0) }}</div>
            <div class="stat-label">Ingresos este mes</div>
        </div>
    </div>

</div>

{{-- ── FILA 1: Citas por mes + Estado de citas ── --}}
<div style="display:grid;grid-template-columns:1fr 300px;gap:24px;margin-bottom:24px;">

    {{-- Gráfico de barras — Citas últimos 6 meses --}}
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Citas — Últimos 6 meses</div>
                <div class="card-subtitle">Total vs completadas por mes</div>
            </div>
            <span class="badge badge-blue">{{ now()->isoFormat('YYYY') }}</span>
        </div>
        <div class="card-body">

            @php
                $maxCitas = collect($citasPorMes)->max('total');
                $maxCitas = max($maxCitas, 1);
            @endphp

            <div style="display:flex;align-items:flex-end;gap:12px;height:180px;padding-bottom:30px;position:relative;">

                {{-- Líneas de referencia --}}
                <div style="position:absolute;top:0;left:0;right:0;bottom:30px;display:flex;flex-direction:column;justify-content:space-between;pointer-events:none;">
                    @for($l = 4; $l >= 0; $l--)
                        <div style="border-top:1px dashed var(--gray-100);width:100%;position:relative;">
                            <span style="position:absolute;left:-28px;top:-8px;font-size:.65rem;color:var(--gray-300);">
                                {{ round(($maxCitas / 4) * $l) }}
                            </span>
                        </div>
                    @endfor
                </div>

                @foreach($citasPorMes as $dato)
                @php
                    $alturaTotal      = $maxCitas > 0 ? round(($dato['total'] / $maxCitas) * 150) : 0;
                    $alturaCompletada = $maxCitas > 0 ? round(($dato['completadas'] / $maxCitas) * 150) : 0;
                @endphp
                <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:4px;position:relative;">
                    {{-- Barra total --}}
                    <div style="width:100%;display:flex;align-items:flex-end;justify-content:center;gap:3px;height:150px;">
                        <div style="width:45%;height:{{ $alturaTotal }}px;background:var(--blue-light);border-radius:5px 5px 0 0;position:relative;" title="Total: {{ $dato['total'] }}">
                            @if($dato['total'] > 0)
                            <span style="position:absolute;top:-18px;left:50%;transform:translateX(-50%);font-size:.65rem;font-weight:700;color:var(--blue);">
                                {{ $dato['total'] }}
                            </span>
                            @endif
                        </div>
                        <div style="width:45%;height:{{ $alturaCompletada }}px;background:var(--blue);border-radius:5px 5px 0 0;" title="Completadas: {{ $dato['completadas'] }}"></div>
                    </div>
                    {{-- Label mes --}}
                    <div style="font-size:.72rem;font-weight:700;color:var(--gray-500);text-transform:capitalize;">
                        {{ $dato['mes'] }}
                    </div>
                </div>
                @endforeach

            </div>

            {{-- Leyenda --}}
            <div style="display:flex;gap:16px;margin-top:8px;justify-content:center;">
                <div style="display:flex;align-items:center;gap:6px;font-size:.75rem;color:var(--gray-500);">
                    <div style="width:12px;height:12px;background:var(--blue-light);border-radius:3px;"></div> Total
                </div>
                <div style="display:flex;align-items:center;gap:6px;font-size:.75rem;color:var(--gray-500);">
                    <div style="width:12px;height:12px;background:var(--blue);border-radius:3px;"></div> Completadas
                </div>
            </div>

        </div>
    </div>

    {{-- Distribución por estado --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">Distribución por Estado</div>
        </div>
        <div class="card-body">

            @php
                $totalCitas = max(array_sum($citasPorEstado), 1);
                $estadosConfig = [
                    'pendiente'  => ['label' => 'Pendientes',  'color' => '#f59e0b', 'badge' => 'badge-orange'],
                    'confirmada' => ['label' => 'Confirmadas', 'color' => '#3b82f6', 'badge' => 'badge-blue'],
                    'completada' => ['label' => 'Completadas', 'color' => '#22c55e', 'badge' => 'badge-green'],
                    'cancelada'  => ['label' => 'Canceladas',  'color' => '#ef4444', 'badge' => 'badge-red'],
                ];
            @endphp

            {{-- Donut visual CSS --}}
            <div style="display:flex;justify-content:center;margin-bottom:20px;">
                @php
                    $gradientParts = [];
                    $acumulado = 0;
                    foreach($citasPorEstado as $estado => $val) {
                        $pct = round(($val / $totalCitas) * 100);
                        $color = $estadosConfig[$estado]['color'];
                        $gradientParts[] = "$color {$acumulado}% " . ($acumulado + $pct) . "%";
                        $acumulado += $pct;
                    }
                    $gradient = implode(', ', $gradientParts);
                @endphp
                <div style="
                    width:120px;height:120px;
                    border-radius:50%;
                    background: conic-gradient({{ $gradient }});
                    box-shadow: 0 4px 16px rgba(0,0,0,.1);
                    position:relative;
                ">
                    <div style="
                        position:absolute;top:50%;left:50%;
                        transform:translate(-50%,-50%);
                        width:70px;height:70px;
                        background:white;border-radius:50%;
                        display:flex;align-items:center;justify-content:center;
                        flex-direction:column;
                    ">
                        <span style="font-size:1.1rem;font-weight:800;color:var(--navy);">{{ $totalCitas }}</span>
                        <span style="font-size:.6rem;color:var(--gray-500);">total</span>
                    </div>
                </div>
            </div>

            {{-- Leyenda con barras --}}
            @foreach($citasPorEstado as $estado => $val)
            <div style="margin-bottom:12px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;">
                    <span style="font-size:.8rem;font-weight:600;color:var(--gray-700);">
                        {{ $estadosConfig[$estado]['label'] }}
                    </span>
                    <span class="badge {{ $estadosConfig[$estado]['badge'] }}">
                        {{ $val }} ({{ round(($val/$totalCitas)*100) }}%)
                    </span>
                </div>
                <div style="height:5px;background:var(--gray-100);border-radius:99px;overflow:hidden;">
                    <div style="height:100%;width:{{ round(($val/$totalCitas)*100) }}%;background:{{ $estadosConfig[$estado]['color'] }};border-radius:99px;"></div>
                </div>
            </div>
            @endforeach

        </div>
    </div>

</div>

{{-- ── FILA 2: Ingresos por mes + Top odontólogos ── --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:24px;">

    {{-- Ingresos por mes --}}
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Ingresos — Últimos 6 meses</div>
                <div class="card-subtitle">Total en bolivianos (Bs)</div>
            </div>
        </div>
        <div class="card-body">

            @php $maxIngreso = max(collect($ingresosPorMes)->max('total'), 1); @endphp

            @foreach($ingresosPorMes as $dato)
            <div style="margin-bottom:14px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:5px;">
                    <span style="font-size:.82rem;font-weight:600;color:var(--gray-700);text-transform:capitalize;">
                        {{ $dato['mes'] }}
                    </span>
                    <span style="font-size:.82rem;font-weight:700;color:var(--navy);">
                        Bs {{ number_format($dato['total'], 0) }}
                    </span>
                </div>
                <div style="height:8px;background:var(--gray-100);border-radius:99px;overflow:hidden;">
                    <div style="height:100%;width:{{ round(($dato['total']/$maxIngreso)*100) }}%;background:linear-gradient(90deg,#3b82f6,#1a2e4a);border-radius:99px;"></div>
                </div>
            </div>
            @endforeach

            <div style="margin-top:20px;padding-top:16px;border-top:1px solid var(--gray-100);display:flex;justify-content:space-between;align-items:center;">
                <span style="font-size:.85rem;color:var(--gray-500);">Total acumulado</span>
                <span style="font-size:1.1rem;font-weight:800;color:var(--navy);">
                    Bs {{ number_format($resumen['ingresos_totales'], 0) }}
                </span>
            </div>

        </div>
    </div>

    {{-- Top odontólogos --}}
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Top Odontólogos</div>
                <div class="card-subtitle">Por citas completadas</div>
            </div>
        </div>
        <div class="card-body">

            @php $maxCitasOdon = max($topOdontologos->max('citas_count'), 1); @endphp

            @forelse($topOdontologos as $i => $odon)
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">

                {{-- Posición --}}
                <div style="
                    width:26px;height:26px;border-radius:50%;
                    background:{{ $i == 0 ? '#f59e0b' : ($i == 1 ? '#94a3b8' : ($i == 2 ? '#cd7c44' : 'var(--gray-100)')) }};
                    color:{{ $i < 3 ? 'white' : 'var(--gray-500)' }};
                    display:flex;align-items:center;justify-content:center;
                    font-size:.72rem;font-weight:800;flex-shrink:0;
                ">{{ $i + 1 }}</div>

                {{-- Avatar --}}
                <div class="user-avatar" style="width:34px;height:34px;font-size:.78rem;flex-shrink:0;background:linear-gradient(135deg,#3b82f6,#1a2e4a);">
                    {{ strtoupper(substr($odon->nombre, 0, 1)) }}
                </div>

                {{-- Info --}}
                <div style="flex:1;min-width:0;">
                    <div style="font-size:.82rem;font-weight:700;color:var(--navy);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        Dr. {{ $odon->nombre }}
                    </div>
                    <div style="height:5px;background:var(--gray-100);border-radius:99px;overflow:hidden;margin-top:4px;">
                        <div style="height:100%;width:{{ round(($odon->citas_count/$maxCitasOdon)*100) }}%;background:var(--blue);border-radius:99px;"></div>
                    </div>
                </div>

                {{-- Contador --}}
                <div style="font-size:.9rem;font-weight:800;color:var(--blue);flex-shrink:0;">
                    {{ $odon->citas_count }}
                </div>

            </div>
            @empty
            <div style="text-align:center;padding:20px;color:var(--gray-500);">
                <i class="fa-solid fa-user-doctor" style="font-size:1.5rem;opacity:.3;display:block;margin-bottom:8px;"></i>
                Sin datos disponibles
            </div>
            @endforelse

        </div>
    </div>

</div>

{{-- ── BOTÓN IMPRIMIR ── --}}
<div style="display:flex;justify-content:flex-end;">
    <button onclick="window.print()" class="btn btn-outline">
        <i class="fa-solid fa-print"></i> Imprimir Reporte
    </button>
</div>

@endsection

@push('styles')
<style>
    @media print {
        .sidebar, .topbar, .btn { display: none !important; }
        .main-content { margin-left: 0 !important; }
        .card { box-shadow: none !important; border: 1px solid #ddd !important; }
    }
    @media (max-width: 900px) {
        .reportes-grid { grid-template-columns: 1fr !important; }
    }
</style>
@endpush