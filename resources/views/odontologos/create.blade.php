@extends('layouts.admin')

@section('title', 'Nuevo Odontólogo')
@section('page_title', 'Nuevo Odontólogo')
@section('breadcrumb', 'Odontólogos / Crear')

@section('content')

<div style="max-width:680px;">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Registrar Odontólogo</div>
                <div class="card-subtitle">Completa los datos del nuevo profesional</div>
            </div>
            <a href="{{ route('odontologos.index') }}" class="btn btn-outline btn-sm">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('odontologos.store') }}" method="POST">
                @csrf

                <div class="form-grid">

                    {{-- Nombre --}}
                    <div class="form-group" style="grid-column:1/-1;">
                        <label class="form-label" for="nombre">
                            <i class="fa-solid fa-user-doctor" style="color:var(--blue);margin-right:5px;"></i>
                            Nombre completo
                        </label>
                        <input
                            type="text"
                            id="nombre"
                            name="nombre"
                            class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}"
                            value="{{ old('nombre') }}"
                            placeholder="Ej: Carlos Mendoza"
                            required
                        >
                        @error('nombre')
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Especialidad --}}
                    <div class="form-group">
                        <label class="form-label" for="especialidad">
                            <i class="fa-solid fa-tooth" style="color:var(--blue);margin-right:5px;"></i>
                            Especialidad
                        </label>
                        <select
                            id="especialidad"
                            name="especialidad"
                            class="form-control {{ $errors->has('especialidad') ? 'is-invalid' : '' }}"
                            required
                        >
                            <option value="" disabled {{ old('especialidad') ? '' : 'selected' }}>Seleccionar...</option>
                            @php
                                $especialidades = [
                                    'Odontología General','Ortodoncia','Periodoncia',
                                    'Endodoncia','Odontopediatría','Cirugía Maxilofacial',
                                    'Implantología','Prostodoncia',
                                ];
                            @endphp
                            @foreach($especialidades as $esp)
                                <option value="{{ $esp }}" {{ old('especialidad') == $esp ? 'selected' : '' }}>
                                    {{ $esp }}
                                </option>
                            @endforeach
                        </select>
                        @error('especialidad')
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Teléfono --}}
                    <div class="form-group">
                        <label class="form-label" for="telefono">
                            <i class="fa-solid fa-phone" style="color:var(--blue);margin-right:5px;"></i>
                            Teléfono
                        </label>
                        <input
                            type="text"
                            id="telefono"
                            name="telefono"
                            class="form-control {{ $errors->has('telefono') ? 'is-invalid' : '' }}"
                            value="{{ old('telefono') }}"
                            placeholder="Ej: 70012345"
                            required
                        >
                        @error('telefono')
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Administrador --}}
                    <div class="form-group" style="grid-column:1/-1;">
                        <label class="form-label" for="administrador_id">
                            <i class="fa-solid fa-user-shield" style="color:var(--blue);margin-right:5px;"></i>
                            Administrador responsable
                        </label>
                        <select
                            id="administrador_id"
                            name="administrador_id"
                            class="form-control {{ $errors->has('administrador_id') ? 'is-invalid' : '' }}"
                            required
                        >
                            <option value="" disabled {{ old('administrador_id') ? '' : 'selected' }}>Seleccionar administrador...</option>
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
                        <i class="fa-solid fa-floppy-disk"></i> Guardar Odontólogo
                    </button>
                    <a href="{{ route('odontologos.index') }}" class="btn btn-outline">Cancelar</a>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection