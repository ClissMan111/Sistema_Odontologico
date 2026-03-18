@extends('layouts.admin')

@section('title', 'Nueva Historia Clínica')
@section('page_title', 'Nueva Historia Clínica')
@section('breadcrumb', 'Historias / Crear')

@section('content')

<div style="max-width:680px;">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Registrar Historia Clínica</div>
                <div class="card-subtitle">Diagnóstico y observaciones del paciente</div>
            </div>
            <a href="{{ route('historias.index') }}" class="btn btn-outline btn-sm">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('historias.store') }}" method="POST">
                @csrf

                <div class="form-grid">

                    <div class="form-group">
                        <label class="form-label" for="paciente_id">
                            <i class="fa-solid fa-user" style="color:var(--blue);margin-right:5px;"></i> Paciente
                        </label>
                        <select id="paciente_id" name="paciente_id"
                            class="form-control {{ $errors->has('paciente_id') ? 'is-invalid' : '' }}" required>
                            <option value="" disabled {{ old('paciente_id') ? '' : 'selected' }}>Seleccionar paciente...</option>
                            @foreach($pacientes as $paciente)
                                <option value="{{ $paciente->id }}" {{ old('paciente_id') == $paciente->id ? 'selected' : '' }}>
                                    {{ $paciente->nombre }} {{ $paciente->apellido }}
                                </option>
                            @endforeach
                        </select>
                        @error('paciente_id')
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="fecha">
                            <i class="fa-solid fa-calendar" style="color:var(--blue);margin-right:5px;"></i> Fecha
                        </label>
                        <input type="date" id="fecha" name="fecha"
                            class="form-control {{ $errors->has('fecha') ? 'is-invalid' : '' }}"
                            value="{{ old('fecha', now()->format('Y-m-d')) }}" required>
                        @error('fecha')
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group" style="grid-column:1/-1;">
                        <label class="form-label" for="diagnostico">
                            <i class="fa-solid fa-stethoscope" style="color:var(--blue);margin-right:5px;"></i> Diagnóstico
                        </label>
                        <input type="text" id="diagnostico" name="diagnostico"
                            class="form-control {{ $errors->has('diagnostico') ? 'is-invalid' : '' }}"
                            value="{{ old('diagnostico') }}" placeholder="Ej: Caries en molar inferior derecho" required>
                        @error('diagnostico')
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group" style="grid-column:1/-1;">
                        <label class="form-label" for="observaciones">
                            <i class="fa-solid fa-notes-medical" style="color:var(--blue);margin-right:5px;"></i> Observaciones
                        </label>
                        <textarea id="observaciones" name="observaciones" rows="4"
                            class="form-control {{ $errors->has('observaciones') ? 'is-invalid' : '' }}"
                            placeholder="Detalla las observaciones clínicas..." required>{{ old('observaciones') }}</textarea>
                        @error('observaciones')
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div style="display:flex;gap:12px;margin-top:8px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar Historia
                    </button>
                    <a href="{{ route('historias.index') }}" class="btn btn-outline">Cancelar</a>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection