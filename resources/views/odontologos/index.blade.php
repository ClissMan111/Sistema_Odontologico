@extends('layouts.admin')

@section('title', 'Odontólogos')
@section('page_title', 'Odontólogos')
@section('breadcrumb', 'Odontólogos')

@section('content')

<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">Gestión de Odontólogos</div>
            <div class="card-subtitle">Todos los odontólogos registrados en el sistema</div>
        </div>
        <a href="{{ route('odontologos.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i>
            Nuevo Odontólogo
        </a>
    </div>

    <div class="card-body">

        {{-- Buscador --}}
        <div style="margin-bottom:20px;">
            <div class="search-bar">
                <span class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" id="searchInput" placeholder="Buscar por nombre o especialidad...">
            </div>
        </div>

        {{-- Tabla --}}
        <div class="table-wrapper">
            <table class="data-table" id="odontologosTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Especialidad</th>
                        <th>Teléfono</th>
                        <th style="text-align:center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($odontologos as $odontologo)
                    <tr>
                        <td style="color:var(--gray-500);font-size:.8rem;">{{ $odontologo->id }}</td>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div class="user-avatar" style="width:36px;height:36px;font-size:.82rem;flex-shrink:0;background:linear-gradient(135deg,#3b82f6,#1a2e4a);">
                                    {{ strtoupper(substr($odontologo->nombre, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight:700;">Dr. {{ $odontologo->nombre }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-blue">{{ $odontologo->especialidad }}</span>
                        </td>
                        <td style="color:var(--gray-500);">
                            <i class="fa-solid fa-phone" style="font-size:.75rem;margin-right:5px;"></i>
                            {{ $odontologo->telefono ?? '—' }}
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;justify-content:center;">
                                <a href="{{ route('odontologos.edit', $odontologo->id) }}"
                                   class="btn btn-outline btn-sm btn-icon" title="Editar">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                                <form action="{{ route('odontologos.destroy', $odontologo->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Eliminar al Dr. {{ $odontologo->nombre }}? Esta acción no se puede deshacer.')">
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
                        <td colspan="5" style="text-align:center;padding:40px;color:var(--gray-500);">
                            <i class="fa-solid fa-user-doctor" style="font-size:2rem;opacity:.3;display:block;margin-bottom:10px;"></i>
                            No hay odontólogos registrados.
                            <a href="{{ route('odontologos.create') }}" style="color:var(--blue);margin-left:6px;">Registrar el primero</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Contador --}}
        <div style="margin-top:16px;font-size:.8rem;color:var(--gray-500);">
            Total: <strong>{{ $odontologos->count() }}</strong> odontólogo(s)
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    document.getElementById('searchInput').addEventListener('input', function () {
        const term = this.value.toLowerCase();
        const rows = document.querySelectorAll('#odontologosTable tbody tr');
        rows.forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
        });
    });
</script>
@endpush