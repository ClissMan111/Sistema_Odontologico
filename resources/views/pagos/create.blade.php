@extends('layouts.admin')

@section('title', 'Registrar Pago')
@section('page_title', 'Registrar Pago')
@section('breadcrumb', 'Pagos / Crear')

@section('content')

<div style="max-width:640px;">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Registrar Pago</div>
                <div class="card-subtitle">Asocia el pago a una cita completada</div>
            </div>
            <a href="{{ route('pagos.index') }}" class="btn btn-outline btn-sm">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('pagos.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="cita_id">
                        <i class="fa-solid fa-calendar-check" style="color:var(--blue);margin-right:5px;"></i> Cita
                    </label>
                    <select id="cita_id" name="cita_id"
                        class="form-control {{ $errors->has('cita_id') ? 'is-invalid' : '' }}" required>
                        <option value="" disabled {{ old('cita_id') ? '' : 'selected' }}>Seleccionar cita...</option>
                        @foreach($citas as $cita)
                            <option value="{{ $cita->id }}" {{ old('cita_id') == $cita->id ? 'selected' : '' }}>
                                #{{ $cita->id }} — {{ $cita->paciente->nombre ?? '—' }} {{ $cita->paciente->apellido ?? '' }}
                                ({{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }} {{ $cita->hora }})
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
                            value="{{ old('monto') }}" placeholder="Ej: 300.00" required>
                        @error('monto')
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="fecha">
                            <i class="fa-solid fa-calendar" style="color:var(--blue);margin-right:5px;"></i> Fecha de pago
                        </label>
                        <input type="date" id="fecha" name="fecha"
                            class="form-control {{ $errors->has('fecha') ? 'is-invalid' : '' }}"
                            value="{{ old('fecha', now()->format('Y-m-d')) }}" required>
                        @error('fecha')
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group" style="grid-column:1/-1;">
                        <label class="form-label" for="metodo">
                            <i class="fa-solid fa-credit-card" style="color:var(--blue);margin-right:5px;"></i> Método de pago
                        </label>
                        <select id="metodo" name="metodo"
                            class="form-control {{ $errors->has('metodo') ? 'is-invalid' : '' }}" required>
                            <option value="" disabled {{ old('metodo') ? '' : 'selected' }}>Seleccionar método...</option>
                            <option value="efectivo"       {{ old('metodo') == 'efectivo'       ? 'selected' : '' }}>Efectivo</option>
                            <option value="transferencia"  {{ old('metodo') == 'transferencia'  ? 'selected' : '' }}>Transferencia</option>
                            <option value="tarjeta"        {{ old('metodo') == 'tarjeta'        ? 'selected' : '' }}>Tarjeta</option>
                        </select>
                        @error('metodo')
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div style="display:flex;gap:12px;margin-top:8px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Registrar Pago
                    </button>
                    <a href="{{ route('pagos.index') }}" class="btn btn-outline">Cancelar</a>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection