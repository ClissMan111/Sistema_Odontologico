@extends('layouts.admin')

@section('title', 'Editar Paciente')
@section('page_title', 'Editar Paciente')
@section('breadcrumb', 'Pacientes / Editar')

@section('content')

<div style="max-width:720px;">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Editar Paciente</div>
                <div class="card-subtitle">Modificando datos de <strong>{{ $paciente->nombre }} {{ $paciente->apellido }}</strong></div>
            </div>
            <a href="{{ route('pacientes.index') }}" class="btn btn-outline btn-sm">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="card-body">

            <div style="display:flex;align-items:center;gap:14px;padding:16px;background:var(--sky);border-radius:10px;margin-bottom:24px;">
                <div class="user-avatar" style="width:46px;height:46px;font-size:1rem;">
                    {{ strtoupper(substr($paciente->nombre, 0, 1)) }}
                </div>
                <div>
                    <div style="font-weight:700;color:var(--navy);">{{ $paciente->nombre }} {{ $paciente->apellido }}</div>
                    <div style="font-size:.8rem;color:var(--gray-500);">C.I. {{ $paciente->ci }} &nbsp;·&nbsp; ID #{{ $paciente->id }}</div>
                </div>
            </div>

            <form action="{{ route('pacientes.update', $paciente->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-grid">

                    <div class="form-group">
                        <label class="form-label" for="nombre">
                            <i class="fa-solid fa-user" style="color:var(--blue);margin-right:5px;"></i> Nombre
                        </label>
                        <input type="text" id="nombre" name="nombre"
                            class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}"
                            value="{{ old('nombre', $paciente->nombre) }}" required>
                        @error('nombre')
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="apellido">
                            <i class="fa-solid fa-user" style="color:var(--blue);margin-right:5px;"></i> Apellido
                        </label>
                        <input type="text" id="apellido" name="apellido"
                            class="form-control {{ $errors->has('apellido') ? 'is-invalid' : '' }}"
                            value="{{ old('apellido', $paciente->apellido) }}" required>
                        @error('apellido')
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="ci">
                            <i class="fa-solid fa-id-card" style="color:var(--blue);margin-right:5px;"></i> C.I.
                        </label>
                        <input type="text" id="ci" name="ci"
                            class="form-control {{ $errors->has('ci') ? 'is-invalid' : '' }}"
                            value="{{ old('ci', $paciente->ci) }}" required>
                        @error('ci')
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="telefono">
                            <i class="fa-solid fa-phone" style="color:var(--blue);margin-right:5px;"></i> Teléfono
                        </label>
                        <input type="text" id="telefono" name="telefono"
                            class="form-control {{ $errors->has('telefono') ? 'is-invalid' : '' }}"
                            value="{{ old('telefono', $paciente->telefono) }}" required>
                        @error('telefono')
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="fecha_nacimiento">
                            <i class="fa-solid fa-cake-candles" style="color:var(--blue);margin-right:5px;"></i> Fecha de Nacimiento
                        </label>
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"
                            class="form-control {{ $errors->has('fecha_nacimiento') ? 'is-invalid' : '' }}"
                            value="{{ old('fecha_nacimiento', \Carbon\Carbon::parse($paciente->fecha_nacimiento)->format('Y-m-d')) }}" required>
                        @error('fecha_nacimiento')
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group" style="grid-column:1/-1;">
                        <label class="form-label" for="direccion">
                            <i class="fa-solid fa-location-dot" style="color:var(--blue);margin-right:5px;"></i> Dirección
                        </label>
                        <input type="text" id="direccion" name="direccion"
                            class="form-control {{ $errors->has('direccion') ? 'is-invalid' : '' }}"
                            value="{{ old('direccion', $paciente->direccion) }}" required>
                        @error('direccion')
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div style="display:flex;gap:12px;margin-top:8px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Actualizar
                    </button>
                    <a href="{{ route('pacientes.index') }}" class="btn btn-outline">Cancelar</a>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection