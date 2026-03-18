@extends('layouts.admin')

@section('title', 'Gestión de Administradores')
@section('page_title', 'Gestión de Administradores')
@section('breadcrumb', 'Admin Gestión')

@section('content')

<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">Administradores del Sistema</div>
            <div class="card-subtitle">Agrega, edita o elimina cuentas de administrador</div>
        </div>
        <a href="{{ route('admin-gestion.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Nuevo Administrador
        </a>
    </div>

    <div class="card-body">

        <div style="margin-bottom:20px;">
            <div class="search-bar">
                <span class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" id="searchInput" placeholder="Buscar administrador...">
            </div>
        </div>

        <div class="table-wrapper">
            <table class="data-table" id="adminTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Registrado</th>
                        <th style="text-align:center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($administradores as $admin)
                    <tr>
                        <td style="color:var(--gray-500);font-size:.8rem;">{{ $admin->id }}</td>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div class="user-avatar" style="width:34px;height:34px;font-size:.78rem;flex-shrink:0;
                                    {{ $admin->id === auth()->guard('administrador')->id() ? 'background:linear-gradient(135deg,#22c55e,#16a34a);' : '' }}">
                                    {{ strtoupper(substr($admin->nombre, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight:700;">{{ $admin->nombre }}</div>
                                    @if($admin->id === auth()->guard('administrador')->id())
                                        <div style="font-size:.7rem;color:#16a34a;font-weight:600;">Tú</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td style="color:var(--gray-500);">{{ $admin->email }}</td>
                        <td>
                            <span class="badge badge-gray">
                                {{ $admin->created_at ? $admin->created_at->format('d/m/Y') : '—' }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;justify-content:center;">
                                <a href="{{ route('admin-gestion.edit', $admin->id) }}"
                                   class="btn btn-outline btn-sm btn-icon" title="Editar">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                                @if($admin->id !== auth()->guard('administrador')->id())
                                <form action="{{ route('admin-gestion.destroy', $admin->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Eliminar a {{ $admin->nombre }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-icon" title="Eliminar">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                                @else
                                <button class="btn btn-sm btn-icon" disabled style="opacity:.3;cursor:not-allowed;" title="No puedes eliminarte a ti mismo">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:40px;color:var(--gray-500);">
                            No hay administradores registrados.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;font-size:.8rem;color:var(--gray-500);">
            Total: <strong>{{ $administradores->count() }}</strong> administrador(es)
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    document.getElementById('searchInput').addEventListener('input', function () {
        const term = this.value.toLowerCase();
        document.querySelectorAll('#adminTable tbody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
        });
    });
</script>
@endpush