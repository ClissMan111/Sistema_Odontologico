@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')

{{-- ── SALUDO ── --}}
<div style="margin-bottom: 28px;">
    <h2 style="font-size:1.4rem; font-weight:800; color:var(--navy); margin-bottom:4px;">
        Hola, {{ Auth::guard('administrador')->user()->nombre }}
    </h2>
    <p style="color:var(--gray-500); font-size:.9rem;">
        {{ now()->isoFormat('dddd, D [de] MMMM [de] YYYY') }} &nbsp;·&nbsp;
        @if($stats['citas_hoy'] > 0)
            <span style="color:var(--blue); font-weight:600;">
                {{ $stats['citas_hoy'] }} cita(s) programadas para hoy
            </span>
        @else
            Sin citas programadas para hoy
        @endif
    </p>
</div>

{{-- ── TARJETAS ESTADÍSTICAS ── --}}
<div class="stats-grid" style="margin-bottom:32px;">

    <div class="stat-card">
        <div class="stat-icon blue"><i class="fa-solid fa-user-doctor"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['odontologos'] }}</div>
            <div class="stat-label">Odontólogos</div>
        </div>
        <a href="{{ route('odontologos.index') }}" style="color:var(--gray-300); font-size:.85rem; align-self:flex-start;">
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <div class="stat-card">
        <div class="stat-icon navy"><i class="fa-solid fa-users"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['pacientes'] }}</div>
            <div class="stat-label">Pacientes</div>
        </div>
        <a href="{{ route('pacientes.index') }}" style="color:var(--gray-300); font-size:.85rem; align-self:flex-start;">
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <div class="stat-card">
        <div class="stat-icon green"><i class="fa-solid fa-calendar-check"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['citas_total'] }}</div>
            <div class="stat-label">Citas totales</div>
        </div>
        <a href="{{ route('citas.index') }}" style="color:var(--gray-300); font-size:.85rem; align-self:flex-start;">
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <div class="stat-card">
        <div class="stat-icon orange"><i class="fa-solid fa-money-bill-wave"></i></div>
        <div class="stat-info">
            <div class="stat-value">Bs {{ number_format($stats['pagos_mes'], 0) }}</div>
            <div class="stat-label">Ingresos este mes</div>
        </div>
        <a href="{{ route('pagos.index') }}" style="color:var(--gray-300); font-size:.85rem; align-self:flex-start;">
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

</div>

{{-- ── FILA: Citas recientes + Panel derecho ── --}}
<div style="display:grid; grid-template-columns:1fr 320px; gap:24px; margin-bottom:24px;">

    {{-- Últimas citas --}}
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Últimas Citas</div>
                <div class="card-subtitle">Las 5 citas más recientes</div>
            </div>
            <a href="{{ route('citas.index') }}" class="btn btn-outline btn-sm">Ver todas</a>
        </div>
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Paciente</th>
                        <th>Odontólogo</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ultimasCitas as $cita)
                    <tr>
                        <td style="font-weight:600;">
                            {{ $cita->paciente->nombre ?? '—' }}
                            {{ $cita->paciente->apellido ?? '' }}
                        </td>
                        <td style="color:var(--gray-500);">
                            Dr. {{ $cita->odontologo->nombre ?? '—' }}
                        </td>
                        <td>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</td>
                        <td style="color:var(--gray-500);">{{ $cita->hora }}</td>
                        <td>
                            @php
                                $map = [
                                    'pendiente'  => 'badge-orange',
                                    'confirmada' => 'badge-blue',
                                    'completada' => 'badge-green',
                                    'cancelada'  => 'badge-red',
                                ];
                            @endphp
                            <span class="badge {{ $map[$cita->estado] ?? 'badge-gray' }}">
                                {{ ucfirst($cita->estado) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:30px; color:var(--gray-500);">
                            <i class="fa-solid fa-calendar-xmark" style="font-size:1.5rem;opacity:.3;display:block;margin-bottom:8px;"></i>
                            No hay citas registradas aún
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Panel derecho --}}
    <div style="display:flex; flex-direction:column; gap:20px;">

        {{-- Barra de estados --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">Estado de Citas</div>
            </div>
            <div class="card-body">
                @php
                    $total  = max($stats['citas_total'], 1);
                    $items  = [
                        ['Pendientes',  $stats['pendientes'],  '#f59e0b', 'badge-orange'],
                        ['Confirmadas', $stats['confirmadas'], '#3b82f6', 'badge-blue'],
                        ['Completadas', $stats['completadas'], '#22c55e', 'badge-green'],
                        ['Canceladas',  $stats['canceladas'],  '#ef4444', 'badge-red'],
                    ];
                @endphp

                @foreach($items as [$label, $val, $color, $badge])
                <div style="margin-bottom:14px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:5px;">
                        <span style="font-size:.82rem;font-weight:600;color:var(--gray-700);">{{ $label }}</span>
                        <span class="badge {{ $badge }}">{{ $val }}</span>
                    </div>
                    <div style="height:6px;background:var(--gray-100);border-radius:99px;overflow:hidden;">
                        <div style="height:100%;width:{{ round(($val/$total)*100) }}%;background:{{ $color }};border-radius:99px;"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Accesos rápidos --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">Accesos Rápidos</div>
            </div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:8px;">
                <a href="{{ route('odontologos.create') }}" class="btn btn-outline" style="justify-content:flex-start;">
                    <i class="fa-solid fa-user-plus"></i> Nuevo Odontólogo
                </a>
                <a href="{{ route('pacientes.create') }}" class="btn btn-outline" style="justify-content:flex-start;">
                    <i class="fa-solid fa-user-plus"></i> Nuevo Paciente
                </a>
                <a href="{{ route('citas.create') }}" class="btn btn-primary" style="justify-content:flex-start;">
                    <i class="fa-solid fa-calendar-plus"></i> Nueva Cita
                </a>
            </div>
        </div>

    </div>
</div>

{{-- ── ÚLTIMOS PACIENTES ── --}}
<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">Pacientes Recientes</div>
            <div class="card-subtitle">Últimos 5 pacientes registrados</div>
        </div>
        <a href="{{ route('pacientes.index') }}" class="btn btn-outline btn-sm">Ver todos</a>
    </div>
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>C.I.</th>
                    <th>Teléfono</th>
                    <th>Registrado</th>
                    <th style="text-align:center;">Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ultimosPacientes as $paciente)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div class="user-avatar" style="width:32px;height:32px;font-size:.75rem;flex-shrink:0;">
                                {{ strtoupper(substr($paciente->nombre, 0, 1)) }}
                            </div>
                            <span style="font-weight:600;">{{ $paciente->nombre }} {{ $paciente->apellido }}</span>
                        </div>
                    </td>
                    <td style="color:var(--gray-500);">{{ $paciente->ci ?? '—' }}</td>
                    <td style="color:var(--gray-500);">{{ $paciente->telefono ?? '—' }}</td>
                    <td>
                        <span class="badge badge-gray">
                            {{ $paciente->created_at ? $paciente->created_at->format('d/m/Y') : '—' }}
                        </span>
                    </td>
                    <td style="text-align:center;">
                        <a href="{{ route('pacientes.edit', $paciente->id) }}"
                           class="btn btn-outline btn-sm btn-icon" title="Editar">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:30px;color:var(--gray-500);">
                        <i class="fa-solid fa-users-slash" style="font-size:1.5rem;opacity:.3;display:block;margin-bottom:8px;"></i>
                        No hay pacientes registrados aún
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection