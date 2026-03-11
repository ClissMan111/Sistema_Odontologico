@extends('layouts.admin')

@section('title', 'Editar Odontólogo')
@section('page_title', 'Editar Odontólogo')
@section('breadcrumb', 'Odontólogos / Editar')

@section('content')

<div style="max-width:680px;">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Editar Odontólogo</div>
                <div class="card-subtitle">Modifica los datos de <strong>Dr. {{ $odontologo->nombre }}</strong></div>
            </div>
            <a href="{{ route('odontologos.index') }}" class="btn btn-outline btn-sm">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="card-body">

            {{-- Info actual --}}
            <div style="display:flex;align-items:center;gap:14px;padding:16px;background:var(--sky);border-radius:10px;margin-bottom:24px;">
                <div class="user-avatar" style="width:46px;height:46px;font-size:1rem;background:linear-gradient(135deg,#3b82f6,#1a2e4a);">
                    {{ strtoupper(substr($odontologo->nombre, 0, 1)) }}
                </div>
                <div>
                    <div style="font-weight:700;color:var(--navy);">Dr. {{ $odontologo->nombre }}</div>
                    <div style="font-size:.8rem;color:var(--gray-500);">
                        {{ $odontologo->especialidad }} &nbsp;·&nbsp; ID #{{ $odontologo->id }}
                    </div>
                </div>
            </div>

            <form action="{{ route('odontologos.update', $odontologo->id) }}" method="POST">
                @csrf
                @method('PUT')

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
                            value="{{ old('nombre', $odontologo->nombre) }}"
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
                            @php
                                $especialidades = [
                                    'Odontología General','Ortodoncia','Periodoncia',
                                    'Endodoncia','Odontopediatría','Cirugía Maxilofacial',
                                    'Implantología','Prostodoncia',
                                ];
                            @endphp
                            @foreach($especialidades as $esp)
                                <option value="{{ $esp }}" {{ old('especialidad', $odontologo->especialidad) == $esp ? 'selected' : '' }}>
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
                            value="{{ old('telefono', $odontologo->telefono) }}"
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
                            @foreach($administradores as $admin)
                                <option value="{{ $admin->id }}"
                                    {{ old('administrador_id', $odontologo->administrador_id) == $admin->id ? 'selected' : '' }}>
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
                        <i class="fa-solid fa-floppy-disk"></i> Actualizar
                    </button>
                    <a href="{{ route('odontologos.index') }}" class="btn btn-outline">Cancelar</a>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection