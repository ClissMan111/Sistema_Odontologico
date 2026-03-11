@extends('layouts.admin')

@section('title', 'Nueva Cita')
@section('page_title', 'Nueva Cita')
@section('breadcrumb', 'Citas / Crear')

@section('content')

<div style="max-width:720px;">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Registrar Cita</div>
                <div class="card-subtitle">Completa los datos para agendar una nueva cita</div>
            </div>
            <a href="{{ route('citas.index') }}" class="btn btn-outline btn-sm">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('citas.store') }}" method="POST">
                @csrf

                <div class="form-grid">

                    {{-- Paciente --}}
                    <div class="form-group">
                        <label class="form-label" for="paciente_id">
                            <i class="fa-solid fa-user" style="color:var(--blue);margin-right:5px;"></i>
                            Paciente
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

                    {{-- Odontólogo --}}
                    <div class="form-group">
                        <label class="form-label" for="odontologo_id">
                            <i class="fa-solid fa-user-doctor" style="color:var(--blue);margin-right:5px;"></i>
                            Odontólogo
                        </label>
                        <select id="odontologo_id" name="odontologo_id"
                            class="form-control {{ $errors->has('odontologo_id') ? 'is-invalid' : '' }}" required>
                            <option value="" disabled {{ old('odontologo_id') ? '' : 'selected' }}>Seleccionar odontólogo...</option>
                            @foreach($odontologos as $odontologo)
                                <option value="{{ $odontologo->id }}" {{ old('odontologo_id') == $odontologo->id ? 'selected' : '' }}>
                                    Dr. {{ $odontologo->nombre }} — {{ $odontologo->especialidad }}
                                </option>
                            @endforeach
                        </select>
                        @error('odontologo_id')
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Fecha --}}
                    <div class="form-group">
                        <label class="form-label" for="fecha">
                            <i class="fa-solid fa-calendar" style="color:var(--blue);margin-right:5px;"></i>
                            Fecha
                        </label>
                        <input type="date" id="fecha" name="fecha"
                            class="form-control {{ $errors->has('fecha') ? 'is-invalid' : '' }}"
                            value="{{ old('fecha') }}" required>
                        @error('fecha')
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Hora --}}
                    <div class="form-group">
                        <label class="form-label" for="hora">
                            <i class="fa-solid fa-clock" style="color:var(--blue);margin-right:5px;"></i>
                            Hora
                        </label>
                        <input type="time" id="hora" name="hora"
                            class="form-control {{ $errors->has('hora') ? 'is-invalid' : '' }}"
                            value="{{ old('hora') }}" required>
                        @error('hora')
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Estado --}}
                    <div class="form-group">
                        <label class="form-label" for="estado">
                            <i class="fa-solid fa-flag" style="color:var(--blue);margin-right:5px;"></i>
                            Estado
                        </label>
                        <select id="estado" name="estado"
                            class="form-control {{ $errors->has('estado') ? 'is-invalid' : '' }}" required>
                            <option value="" disabled {{ old('estado') ? '' : 'selected' }}>Seleccionar estado...</option>
                            <option value="pendiente"  {{ old('estado') == 'pendiente'  ? 'selected' : '' }}>Pendiente</option>
                            <option value="confirmada" {{ old('estado') == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                            <option value="completada" {{ old('estado') == 'completada' ? 'selected' : '' }}>Completada</option>
                            <option value="cancelada"  {{ old('estado') == 'cancelada'  ? 'selected' : '' }}>Cancelada</option>
                        </select>
                        @error('estado')
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Administrador --}}
                    <div class="form-group">
                        <label class="form-label" for="administrador_id">
                            <i class="fa-solid fa-user-shield" style="color:var(--blue);margin-right:5px;"></i>
                            Administrador
                        </label>
                        <select id="administrador_id" name="administrador_id"
                            class="form-control {{ $errors->has('administrador_id') ? 'is-invalid' : '' }}" required>
                            <option value="" disabled {{ old('administrador_id') ? '' : 'selected' }}>Seleccionar...</option>
                            @foreach($administradores as $admin)
                                <option value="{{ $admin->id }}" {{ old('administrador_id') == $admin->id ? 'selected' : '' }}>
                                    {{ $admin->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('administrador_id')
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div style="display:flex;gap:12px;margin-top:8px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-calendar-plus"></i> Guardar Cita
                    </button>
                    <a href="{{ route('citas.index') }}" class="btn btn-outline">Cancelar</a>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection