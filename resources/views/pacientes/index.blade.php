@extends('layouts.admin')

@section('title', 'Pacientes')
@section('page_title', 'Pacientes')
@section('breadcrumb', 'Pacientes')

@section('content')

<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">Gestión de Pacientes</div>
            <div class="card-subtitle">Todos los pacientes registrados en el sistema</div>
        </div>
        <a href="{{ route('pacientes.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Nuevo Paciente
        </a>
    </div>

    <div class="card-body">

        <div style="margin-bottom:20px;">
            <div class="search-bar">
                <span class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" id="searchInput" placeholder="Buscar por nombre, apellido o C.I...">
            </div>
        </div>

        <div class="table-wrapper">
            <table class="data-table" id="pacientesTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>C.I.</th>
                        <th>Teléfono</th>
                        <th>Fecha Nacimiento</th>
                        <th>Dirección</th>
                        <th style="text-align:center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pacientes as $paciente)
                    <tr>
                        <td style="color:var(--gray-500);font-size:.8rem;">{{ $paciente->id }}</td>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div class="user-avatar" style="width:34px;height:34px;font-size:.78rem;flex-shrink:0;">
                                    {{ strtoupper(substr($paciente->nombre, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight:700;">{{ $paciente->nombre }} {{ $paciente->apellido }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="color:var(--gray-500);">{{ $paciente->ci }}</td>
                        <td style="color:var(--gray-500);">{{ $paciente->telefono }}</td>
                        <td>
                            <span class="badge badge-blue">
                                {{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->format('d/m/Y') }}
                            </span>
                        </td>
                        <td style="color:var(--gray-500);max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $paciente->direccion }}
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;justify-content:center;">
                                <a href="{{ route('pacientes.edit', $paciente->id) }}"
                                   class="btn btn-outline btn-sm btn-icon" title="Editar">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                                <form action="{{ route('pacientes.destroy', $paciente->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Eliminar a {{ $paciente->nombre }} {{ $paciente->apellido }}?')">
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
                            <i class="fa-solid fa-users-slash" style="font-size:2rem;opacity:.3;display:block;margin-bottom:10px;"></i>
                            No hay pacientes registrados.
                            <a href="{{ route('pacientes.create') }}" style="color:var(--blue);margin-left:6px;">Registrar el primero</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;font-size:.8rem;color:var(--gray-500);">
            Total: <strong>{{ $pacientes->count() }}</strong> paciente(s)
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    document.getElementById('searchInput').addEventListener('input', function () {
        const term = this.value.toLowerCase();
        document.querySelectorAll('#pacientesTable tbody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
        });
    });
</script>
@endpush