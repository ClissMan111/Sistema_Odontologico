@extends('layouts.admin')

@section('title', 'Editar Tratamiento')
@section('page_title', 'Editar Tratamiento')
@section('breadcrumb', 'Tratamientos / Editar')

@section('content')

<div style="max-width:680px;">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Editar Tratamiento</div>
                <div class="card-subtitle">Modificando: <strong>{{ $tratamiento->nombre }}</strong></div>
            </div>
            <a href="{{ route('tratamientos.index') }}" class="btn btn-outline btn-sm">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="card-body">

            <div style="padding:14px;background:var(--sky);border-radius:10px;margin-bottom:24px;">
                <div style="font-weight:700;color:var(--navy);">
                    <i class="fa-solid fa-tooth" style="color:var(--blue);margin-right:6px;"></i>
                    {{ $tratamiento->nombre }}
                </div>
                <div style="font-size:.8rem;color:var(--gray-500);margin-top:3px;">
                    Costo actual: <strong>Bs {{ number_format($tratamiento->costo, 2) }}</strong>
                </div>
            </div>

            <form action="{{ route('tratamientos.update', $tratamiento->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-grid">

                    <div class="form-group" style="grid-column:1/-1;">
                        <label class="form-label" for="historia_clinica_id">
                            <i class="fa-solid fa-file-medical" style="color:var(--blue);margin-right:5px;"></i> Historia Clínica
                        </label>
                        <select id="historia_clinica_id" name="historia_clinica_id"
                            class="form-control {{ $errors->has('historia_clinica_id') ? 'is-invalid' : '' }}" required>
                            @foreach($historias as $historia)
                                <option value="{{ $historia->id }}"
                                    {{ old('historia_clinica_id', $tratamiento->historia_clinica_id) == $historia->id ? 'selected' : '' }}>
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
                            <i class="fa-solid fa-tooth" style="color:var(--blue);margin-right:5px;"></i> Nombre
                        </label>
                        <input type="text" id="nombre" name="nombre"
                            class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}"
                            value="{{ old('nombre', $tratamiento->nombre) }}" required>
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
                            required>{{ old('descripcion', $tratamiento->descripcion) }}</textarea>
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
                            value="{{ old('costo', $tratamiento->costo) }}" required>
                        @error('costo')
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div style="display:flex;gap:12px;margin-top:8px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Actualizar
                    </button>
                    <a href="{{ route('tratamientos.index') }}" class="btn btn-outline">Cancelar</a>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection