@extends('layouts.admin')

@section('title', 'Editar Pago')
@section('page_title', 'Editar Pago')
@section('breadcrumb', 'Pagos / Editar')

@section('content')

<div style="max-width:640px;">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Editar Pago</div>
                <div class="card-subtitle">Pago #{{ $pago->id }} — Bs {{ number_format($pago->monto, 2) }}</div>
            </div>
            <a href="{{ route('pagos.index') }}" class="btn btn-outline btn-sm">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="card-body">

            <div style="padding:14px;background:var(--sky);border-radius:10px;margin-bottom:24px;">
                <div style="font-weight:700;color:var(--navy);">
                    <i class="fa-solid fa-money-bill-wave" style="color:var(--blue);margin-right:6px;"></i>
                    Bs {{ number_format($pago->monto, 2) }} — {{ ucfirst($pago->metodo) }}
                </div>
                <div style="font-size:.8rem;color:var(--gray-500);margin-top:3px;">
                    Paciente: {{ $pago->cita->paciente->nombre ?? '—' }} {{ $pago->cita->paciente->apellido ?? '' }}
                </div>
            </div>

            <form action="{{ route('pagos.update', $pago->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="cita_id">
                        <i class="fa-solid fa-calendar-check" style="color:var(--blue);margin-right:5px;"></i> Cita
                    </label>
                    <select id="cita_id" name="cita_id"
                        class="form-control {{ $errors->has('cita_id') ? 'is-invalid' : '' }}" required>
                        @foreach($citas as $cita)
                            <option value="{{ $cita->id }}"
                                {{ old('cita_id', $pago->cita_id) == $cita->id ? 'selected' : '' }}>
                                #{{ $cita->id }} — {{ $cita->paciente->nombre ?? '—' }} {{ $cita->paciente->apellido ?? '' }}
                                ({{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }})
                            </option>
                        @endforeach
                    </select>
                    @error('cita_id')
                        <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-grid">

                    <div class="form-group">
                        <label class="form-label" for="monto">
                            <i class="fa-solid fa-money-bill" style="color:var(--blue);margin-right:5px;"></i> Monto (Bs)
                        </label>
                        <input type="number" id="monto" name="monto" step="0.01" min="0"
                            class="form-control {{ $errors->has('monto') ? 'is-invalid' : '' }}"
                            value="{{ old('monto', $pago->monto) }}" required>
                        @error('monto')
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="fecha">
                            <i class="fa-solid fa-calendar" style="color:var(--blue);margin-right:5px;"></i> Fecha
                        </label>
                        <input type="date" id="fecha" name="fecha"
                            class="form-control {{ $errors->has('fecha') ? 'is-invalid' : '' }}"
                            value="{{ old('fecha', \Carbon\Carbon::parse($pago->fecha)->format('Y-m-d')) }}" required>
                        @error('fecha')
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group" style="grid-column:1/-1;">
                        <label class="form-label" for="metodo">
                            <i class="fa-solid fa-credit-card" style="color:var(--blue);margin-right:5px;"></i> Método
                        </label>
                        <select id="metodo" name="metodo"
                            class="form-control {{ $errors->has('metodo') ? 'is-invalid' : '' }}" required>
                            <option value="efectivo"      {{ old('metodo', $pago->metodo) == 'efectivo'      ? 'selected' : '' }}>Efectivo</option>
                            <option value="transferencia" {{ old('metodo', $pago->metodo) == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                            <option value="tarjeta"       {{ old('metodo', $pago->metodo) == 'tarjeta'       ? 'selected' : '' }}>Tarjeta</option>
                        </select>
                        @error('metodo')
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div style="display:flex;gap:12px;margin-top:8px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Actualizar
                    </button>
                    <a href="{{ route('pagos.index') }}" class="btn btn-outline">Cancelar</a>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection