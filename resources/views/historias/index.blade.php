@extends('layouts.admin')

@section('title', 'Historias Clínicas')
@section('page_title', 'Historias Clínicas')
@section('breadcrumb', 'Historias Clínicas')

@section('content')

<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">Gestión de Historias Clínicas</div>
            <div class="card-subtitle">Registro de diagnósticos y observaciones por paciente</div>
        </div>
        <a href="{{ route('historias.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Nueva Historia
        </a>
    </div>

    <div class="card-body">

        <div style="margin-bottom:20px;">
            <div class="search-bar">
                <span class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" id="searchInput" placeholder="Buscar por paciente o diagnóstico...">
            </div>
        </div>

        <div class="table-wrapper">
            <table class="data-table" id="historiasTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Paciente</th>
                        <th>Fecha</th>
                        <th>Diagnóstico</th>
                        <th>Observaciones</th>
                        <th style="text-align:center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($historias as $historia)
                    <tr>
                        <td style="color:var(--gray-500);font-size:.8rem;">{{ $historia->id }}</td>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div class="user-avatar" style="width:32px;height:32px;font-size:.72rem;flex-shrink:0;">
                                    {{ strtoupper(substr($historia->paciente->nombre ?? 'P', 0, 1)) }}
                                </div>
                                <span style="font-weight:600;">
                                    {{ $historia->paciente->nombre ?? '—' }}
                                    {{ $historia->paciente->apellido ?? '' }}
                                </span>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-blue">
                                {{ \Carbon\Carbon::parse($historia->fecha)->format('d/m/Y') }}
                            </span>
                        </td>
                        <td style="font-weight:600;max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $historia->diagnostico }}
                        </td>
                        <td style="color:var(--gray-500);max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $historia->observaciones }}
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;justify-content:center;">
                                <a href="{{ route('historias.edit', $historia->id) }}"
                                   class="btn btn-outline btn-sm btn-icon" title="Editar">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                                <form action="{{ route('historias.destroy', $historia->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Eliminar esta historia clínica?')">
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
                        <td colspan="6" style="text-align:center;padding:40px;color:var(--gray-500);">
                            <i class="fa-solid fa-file-medical" style="font-size:2rem;opacity:.3;display:block;margin-bottom:10px;"></i>
                            No hay historias clínicas registradas.
                            <a href="{{ route('historias.create') }}" style="color:var(--blue);margin-left:6px;">Crear la primera</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;font-size:.8rem;color:var(--gray-500);">
            Total: <strong>{{ $historias->count() }}</strong> historia(s)
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    document.getElementById('searchInput').addEventListener('input', function () {
        const term = this.value.toLowerCase();
        document.querySelectorAll('#historiasTable tbody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
        });
    });
</script>
@endpush