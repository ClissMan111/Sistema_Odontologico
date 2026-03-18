@extends('layouts.admin')

@section('title', 'Nuevo Tratamiento')
@section('page_title', 'Nuevo Tratamiento')
@section('breadcrumb', 'Tratamientos / Crear')

@section('content')

<div style="max-width:680px;">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Registrar Tratamiento</div>
                <div class="card-subtitle">Asocia un tratamiento a una historia clínica</div>
            </div>
            <a href="{{ route('tratamientos.index') }}" class="btn btn-outline btn-sm">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('tratamientos.store') }}" method="POST">
                @csrf

                <div class="form-grid">

                    <div class="form-group" style="grid-column:1/-1;">
                        <label class="form-label" for="historia_clinica_id">
                            <i class="fa-solid fa-file-medical" style="color:var(--blue);margin-right:5px;"></i> Historia Clínica
                        </label>
                        <select id="historia_clinica_id" name="historia_clinica_id"
                            class="form-control {{ $errors->has('historia_clinica_id') ? 'is-invalid' : '' }}" required>
                            <option value="" disabled {{ old('historia_clinica_id') ? '' : 'selected' }}>Seleccionar historia...</option>
                            @foreach($historias as $historia)
                                <option value="{{ $historia->id }}" {{ old('historia_clinica_id') == $historia->id ? 'selected' : '' }}>
                                    #{{ $historia->id }} — {{ $historia->paciente->nombre ?? '—' }} {{ $historia->paciente->apellido ?? '' }} ({{ \Carbon\Carbon::parse($historia->fecha)->format('d/m/Y') }})
                                </option>
                            @endforeach
                        </select>
                        @error('historia_clinica_id')
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group" style="grid-column:1/-1;">
                        <label class="form-label" for="nombre">
                            <i class="fa-solid fa-tooth" style="color:var(--blue);margin-right:5px;"></i> Nombre del tratamiento
                        </label>
                        <input type="text" id="nombre" name="nombre"
                            class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}"
                            value="{{ old('nombre') }}" placeholder="Ej: Extracción dental" required>
                        @error('nombre')
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group" style="grid-column:1/-1;">
                        <label class="form-label" for="descripcion">
                            <i class="fa-solid fa-align-left" style="color:var(--blue);margin-right:5px;"></i> Descripción
                        </label>
                        <textarea id="descripcion" name="descripcion" rows="3"
                            class="form-control {{ $errors->has('descripcion') ? 'is-invalid' : '' }}"
                            placeholder="Describe el procedimiento..." required>{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="costo">
                            <i class="fa-solid fa-money-bill" style="color:var(--blue);margin-right:5px;"></i> Costo (Bs)
                        </label>
                        <input type="number" id="costo" name="costo" step="0.01" min="0"
                            class="form-control {{ $errors->has('costo') ? 'is-invalid' : '' }}"
                            value="{{ old('costo') }}" placeholder="Ej: 250.00" required>
                        @error('costo')
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div style="display:flex;gap:12px;margin-top:8px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar Tratamiento
                    </button>
                    <a href="{{ route('tratamientos.index') }}" class="btn btn-outline">Cancelar</a>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection