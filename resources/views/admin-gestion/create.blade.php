@extends('layouts.admin')

@section('title', 'Nuevo Administrador')
@section('page_title', 'Nuevo Administrador')
@section('breadcrumb', 'Admin Gestión / Crear')

@section('content')

<div style="max-width:600px;">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Crear Administrador</div>
                <div class="card-subtitle">Nueva cuenta con acceso al panel</div>
            </div>
            <a href="{{ route('admin-gestion.index') }}" class="btn btn-outline btn-sm">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('admin-gestion.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="nombre">
                        <i class="fa-solid fa-user-shield" style="color:var(--blue);margin-right:5px;"></i> Nombre
                    </label>
                    <input type="text" id="nombre" name="nombre"
                        class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}"
                        value="{{ old('nombre') }}" placeholder="Nombre completo" required>
                    @error('nombre')
                        <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">
                        <i class="fa-solid fa-envelope" style="color:var(--blue);margin-right:5px;"></i> Correo
                    </label>
                    <input type="email" id="email" name="email"
                        class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        value="{{ old('email') }}" placeholder="admin@ejemplo.com" required>
                    @error('email')
                        <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">
                        <i class="fa-solid fa-lock" style="color:var(--blue);margin-right:5px;"></i> Contraseña
                    </label>
                    <div class="input-icon-wrap">
                        <input type="password" id="password" name="password"
                            class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                            placeholder="Mínimo 6 caracteres" required>
                        <button type="button" class="toggle-pw" onclick="togglePassword('password','icon1')">
                            <i id="icon1" class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">
                        <i class="fa-solid fa-lock" style="color:var(--blue);margin-right:5px;"></i> Confirmar contraseña
                    </label>
                    <div class="input-icon-wrap">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-control" placeholder="Repite la contraseña" required>
                        <button type="button" class="toggle-pw" onclick="togglePassword('password_confirmation','icon2')">
                            <i id="icon2" class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div style="display:flex;gap:12px;margin-top:8px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Crear Administrador
                    </button>
                    <a href="{{ route('admin-gestion.index') }}" class="btn btn-outline">Cancelar</a>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function togglePassword(fieldId, iconId) {
        const field = document.getElementById(fieldId);
        const icon  = document.getElementById(iconId);
        field.type  = field.type === 'password' ? 'text' : 'password';
        icon.className = field.type === 'password' ? 'fa-solid fa-eye' : 'fa-solid fa-eye-slash';
    }
</script>
@endpush