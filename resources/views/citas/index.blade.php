@extends('layouts.admin')

@section('title', 'Citas')
@section('page_title', 'Supervisar Citas')
@section('breadcrumb', 'Citas')

@section('content')

{{-- ── TARJETAS RESUMEN ── --}}
<div class="stats-grid" style="margin-bottom:28px;">

    <div class="stat-card">
        <div class="stat-icon blue"><i class="fa-solid fa-calendar-days"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ $citas->count() }}</div>
            <div class="stat-label">Total citas</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon orange"><i class="fa-solid fa-clock"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ $citas->where('estado', 'pendiente')->count() }}</div>
            <div class="stat-label">Pendientes</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon green"><i class="fa-solid fa-circle-check"></i></div>
        <div class="stat-info">
            <div class="stat-value">{{ $citas->where('estado', 'completada')->count() }}</div>
            <div class="stat-label">Completadas</div>
        </div>
    </div>

    <div class="stat-card" style="border-left:3px solid var(--danger);">
        <div class="stat-icon" style="background:#fee2e2;color:var(--danger);">
            <i class="fa-solid fa-calendar-xmark"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ $citas->where('estado', 'cancelada')->count() }}</div>
            <div class="stat-label">Canceladas</div>
        </div>
    </div>

</div>

{{-- ── TABLA ── --}}
<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">Listado de Citas</div>
            <div class="card-subtitle">Gestiona y supervisa todas las citas del sistema</div>
        </div>
        <a href="{{ route('citas.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Nueva Cita
        </a>
    </div>

    <div class="card-body">

        {{-- Filtros --}}
        <div style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap;">
            <div class="search-bar">
                <span class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" id="searchInput" placeholder="Buscar paciente u odontólogo...">
            </div>

            <select id="filtroEstado" class="form-control" style="width:auto;min-width:160px;">
                <option value="">Todos los estados</option>
                <option value="pendiente">Pendiente</option>
                <option value="confirmada">Confirmada</option>
                <option value="completada">Completada</option>
                <option value="cancelada">Cancelada</option>
            </select>
        </div>

        {{-- Tabla --}}
        <div class="table-wrapper">
            <table class="data-table" id="citasTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Paciente</th>
                        <th>Odontólogo</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>
                        <th style="text-align:center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($citas as $cita)
                    <tr data-estado="{{ $cita->estado }}">
                        <td style="color:var(--gray-500);font-size:.8rem;">{{ $cita->id }}</td>
                        <td>
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div class="user-avatar" style="width:30px;height:30px;font-size:.72rem;flex-shrink:0;">
                                    {{ strtoupper(substr($cita->paciente->nombre ?? 'P', 0, 1)) }}
                                </div>
                                <span style="font-weight:600;">
                                    {{ $cita->paciente->nombre ?? '—' }}
                                    {{ $cita->paciente->apellido ?? '' }}
                                </span>
                            </div>
                        </td>
                        <td style="color:var(--gray-500);">
                            Dr. {{ $cita->odontologo->nombre ?? '—' }}
                        </td>
                        <td>
                            <span style="font-weight:600;">
                                {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}
                            </span>
                        </td>
                        <td style="color:var(--gray-500);">
                            <i class="fa-solid fa-clock" style="font-size:.75rem;margin-right:4px;"></i>
                            {{ $cita->hora }}
                        </td>
                        <td>
                            @if($cita->estado == 'pendiente')
                                <span class="badge badge-orange">Pendiente</span>
                            @elseif($cita->estado == 'confirmada')
                                <span class="badge badge-blue">Confirmada</span>
                            @elseif($cita->estado == 'completada')
                                <span class="badge badge-green">Completada</span>
                            @elseif($cita->estado == 'cancelada')
                                <span class="badge badge-red">Cancelada</span>
                            @else
                                <span class="badge badge-gray">{{ ucfirst($cita->estado) }}</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;justify-content:center;">
                                <a href="{{ route('citas.edit', $cita->id) }}"
                                   class="btn btn-outline btn-sm btn-icon" title="Editar">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                                <form action="{{ route('citas.destroy', $cita->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Eliminar esta cita? Esta acción no se puede deshacer.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-icon" title="Eliminar">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:40px;color:var(--gray-500);">
                            <i class="fa-solid fa-calendar-xmark" style="font-size:2rem;opacity:.3;display:block;margin-bottom:10px;"></i>
                            No hay citas registradas.
                            <a href="{{ route('citas.create') }}" style="color:var(--blue);margin-left:6px;">Crear la primera</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;font-size:.8rem;color:var(--gray-500);">
            Total: <strong id="visibleCount">{{ $citas->count() }}</strong> cita(s)
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    const searchInput  = document.getElementById('searchInput');
    const filtroEstado = document.getElementById('filtroEstado');
    const rows         = document.querySelectorAll('#citasTable tbody tr[data-estado]');
    const counter      = document.getElementById('visibleCount');

    function filtrar() {
        const term   = searchInput.value.toLowerCase();
        const estado = filtroEstado.value.toLowerCase();
        let visible  = 0;

        rows.forEach(row => {
            const text     = row.textContent.toLowerCase();
            const rowEstado = row.dataset.estado;
            const matchText  = text.includes(term);
            const matchEstado = estado === '' || rowEstado === estado;

            if (matchText && matchEstado) {
                row.style.display = '';
                visible++;
            } else {
                row.style.display = 'none';
            }
        });

        counter.textContent = visible;
    }

    searchInput.addEventListener('input', filtrar);
    filtroEstado.addEventListener('change', filtrar);
</script>
@endpush