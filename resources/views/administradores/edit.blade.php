@extends('layouts.admin')

@section('title', 'Editar Administrador')
@section('page_title', 'Editar Administrador')
@section('breadcrumb', 'Administradores / Editar')

@section('content')

<div style="max-width: 680px;">

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Editar Administrador</div>
                <div class="card-subtitle">Modifica los datos de <strong>{{ $administrador->nombre }}</strong></div>
            </div>
            <a href="{{ route('administradores.index') }}" class="btn btn-outline btn-sm">
                <i class="fa-solid fa-arrow-left"></i>
                Volver
            </a>
        </div>

        <div class="card-body">

            {{-- Info del administrador --}}
            <div style="display:flex; align-items:center; gap:14px; padding:16px; background:var(--sky); border-radius:10px; margin-bottom:24px;">
                <div class="user-avatar" style="width:46px;height:46px;font-size:1rem;">
                    {{ strtoupper(substr($administrador->nombre, 0, 1)) }}
                </div>
                <div>
                    <div style="font-weight:700; color:var(--navy);">{{ $administrador->nombre }}</div>
                    <div style="font-size:.8rem; color:var(--gray-500);">
                        ID #{{ $administrador->id }} &nbsp;·&nbsp;
                        Registrado {{ $administrador->created_at ? $administrador->created_at->format('d/m/Y') : '—' }}
                    </div>
                </div>
            </div>

            <form action="{{ route('administradores.update', $administrador->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nombre --}}
                <div class="form-group">
                    <label class="form-label" for="nombre">
                        <i class="fa-solid fa-user" style="color:var(--blue); margin-right:5px;"></i>
                        Nombre completo
                    </label>
                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}"
                        value="{{ old('nombre', $administrador->nombre) }}"
                        required
                    >
                    @error('nombre')
                        <div class="form-error">
                            <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label" for="email">
                        <i class="fa-solid fa-envelope" style="color:var(--blue); margin-right:5px;"></i>
                        Correo electrónico
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        value="{{ old('email', $administrador->email) }}"
                        required
                    >
                    @error('email')
                        <div class="form-error">
                            <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Nota sobre contraseña --}}
                <div class="alert alert-info" style="margin-bottom:20px;">
                    <i class="fa-solid fa-circle-info"></i>
                    La contraseña no se puede modificar desde aquí por seguridad.
                </div>

                {{-- Acciones --}}
                <div style="display:flex; gap:12px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Actualizar
                    </button>
                    <a href="{{ route('administradores.index') }}" class="btn btn-outline">
                        Cancelar
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection