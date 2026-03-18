@extends('layouts.admin')

@section('title', 'Pagos')
@section('page_title', 'Pagos')
@section('breadcrumb', 'Pagos')

@section('content')

<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">Gestión de Pagos</div>
            <div class="card-subtitle">Registro de pagos por cita atendida</div>
        </div>
        <a href="{{ route('pagos.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Registrar Pago
        </a>
    </div>

    <div class="card-body">

        <div style="margin-bottom:20px;">
            <div class="search-bar">
                <span class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" id="searchInput" placeholder="Buscar por paciente o método...">
            </div>
        </div>

        <div class="table-wrapper">
            <table class="data-table" id="pagosTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Paciente</th>
                        <th>Fecha</th>
                        <th>Monto</th>
                        <th>Método</th>
                        <th style="text-align:center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pagos as $pago)
                    <tr>
                        <td style="color:var(--gray-500);font-size:.8rem;">{{ $pago->id }}</td>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div class="user-avatar" style="width:32px;height:32px;font-size:.72rem;flex-shrink:0;">
                                    {{ strtoupper(substr($pago->cita->paciente->nombre ?? 'P', 0, 1)) }}
                                </div>
                                <span style="font-weight:600;">
                                    {{ $pago->cita->paciente->nombre ?? '—' }}
                                    {{ $pago->cita->paciente->apellido ?? '' }}
                                </span>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-blue">
                                {{ \Carbon\Carbon::parse($pago->fecha)->format('d/m/Y') }}
                            </span>
                        </td>
                        <td>
                            <span style="font-weight:800;color:var(--navy);">
                                Bs {{ number_format($pago->monto, 2) }}
                            </span>
                        </td>
                        <td>
                            @if($pago->metodo == 'efectivo')
                                <span class="badge badge-green"><i class="fa-solid fa-money-bill"></i> Efectivo</span>
                            @elseif($pago->metodo == 'transferencia')
                                <span class="badge badge-blue"><i class="fa-solid fa-building-columns"></i> Transferencia</span>
                            @elseif($pago->metodo == 'tarjeta')
                                <span class="badge badge-orange"><i class="fa-solid fa-credit-card"></i> Tarjeta</span>
                            @else
                                <span class="badge badge-gray">{{ ucfirst($pago->metodo) }}</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;justify-content:center;">
                                <a href="{{ route('pagos.edit', $pago->id) }}"
                                   class="btn btn-outline btn-sm btn-icon" title="Editar">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                                <form action="{{ route('pagos.destroy', $pago->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Eliminar este pago?')">
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
                            <i class="fa-solid fa-money-bill-wave" style="font-size:2rem;opacity:.3;display:block;margin-bottom:10px;"></i>
                            No hay pagos registrados.
                            <a href="{{ route('pagos.create') }}" style="color:var(--blue);margin-left:6px;">Registrar el primero</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;display:flex;justify-content:space-between;align-items:center;">
            <span style="font-size:.8rem;color:var(--gray-500);">
                Total: <strong>{{ $pagos->count() }}</strong> pago(s)
            </span>
            <span style="font-weight:800;color:var(--navy);">
                Total recaudado: Bs {{ number_format($pagos->sum('monto'), 2) }}
            </span>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    document.getElementById('searchInput').addEventListener('input', function () {
        const term = this.value.toLowerCase();
        document.querySelectorAll('#pagosTable tbody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
        });
    });
</script>
@endpush