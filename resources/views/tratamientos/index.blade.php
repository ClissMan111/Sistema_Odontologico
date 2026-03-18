@extends('layouts.admin')

@section('title', 'Tratamientos')
@section('page_title', 'Tratamientos')
@section('breadcrumb', 'Tratamientos')

@section('content')

<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">Gestión de Tratamientos</div>
            <div class="card-subtitle">Tratamientos registrados por historia clínica</div>
        </div>
        <a href="{{ route('tratamientos.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Nuevo Tratamiento
        </a>
    </div>

    <div class="card-body">

        <div style="margin-bottom:20px;">
            <div class="search-bar">
                <span class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" id="searchInput" placeholder="Buscar por nombre o paciente...">
            </div>
        </div>

        <div class="table-wrapper">
            <table class="data-table" id="tratamientosTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Paciente</th>
                        <th>Descripción</th>
                        <th>Costo</th>
                        <th style="text-align:center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tratamientos as $tratamiento)
                    <tr>
                        <td style="color:var(--gray-500);font-size:.8rem;">{{ $tratamiento->id }}</td>
                        <td style="font-weight:700;">{{ $tratamiento->nombre }}</td>
                        <td style="color:var(--gray-500);">
                            {{ $tratamiento->historiaClinica->paciente->nombre ?? '—' }}
                            {{ $tratamiento->historiaClinica->paciente->apellido ?? '' }}
                        </td>
                        <td style="color:var(--gray-500);max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $tratamiento->descripcion }}
                        </td>
                        <td>
                            <span class="badge badge-green">Bs {{ number_format($tratamiento->costo, 2) }}</span>
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;justify-content:center;">
                                <a href="{{ route('tratamientos.edit', $tratamiento->id) }}"
                                   class="btn btn-outline btn-sm btn-icon" title="Editar">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                                <form action="{{ route('tratamientos.destroy', $tratamiento->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Eliminar este tratamiento?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-icon">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:40px;color:var(--gray-500);">
                            <i class="fa-solid fa-tooth" style="font-size:2rem;opacity:.3;display:block;margin-bottom:10px;"></i>
                            No hay tratamientos registrados.
                            <a href="{{ route('tratamientos.create') }}" style="color:var(--blue);margin-left:6px;">Crear el primero</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;font-size:.8rem;color:var(--gray-500);">
            Total: <strong>{{ $tratamientos->count() }}</strong> tratamiento(s)
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    document.getElementById('searchInput').addEventListener('input', function () {
        const term = this.value.toLowerCase();
        document.querySelectorAll('#tratamientosTable tbody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
        });
    });
</script>
@endpush
