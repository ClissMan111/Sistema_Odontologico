<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar Sesión — Sistema Odontológico</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="login-page">

    {{-- Formas decorativas de fondo --}}
    <div class="login-bg-shape s1"></div>
    <div class="login-bg-shape s2"></div>
    <div class="login-bg-shape s3"></div>

    <div class="login-panel">
        <div class="login-card">

            {{-- Logo --}}
            <div class="login-logo">
                <div class="login-logo-icon">🦷</div>
                <div class="login-logo-text">
                    <span class="login-logo-name">OdontoSys</span>
                    <span class="login-logo-sub">Sistema Odontológico</span>
                </div>
            </div>

            <h1 class="login-heading">Bienvenido</h1>
            <p class="login-subheading">Ingresa tus credenciales para acceder al panel</p>

            {{-- Alerta de error --}}
            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Formulario --}}
            <form method="POST" action="{{ route('admin.login.post') }}">
                @csrf

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label" for="email">Correo electrónico</label>
                    <div class="input-icon-wrap">
                        <span class="input-icon"><i class="fa-solid fa-envelope"></i></span>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                            value="{{ old('email') }}"
                            placeholder="admin@ejemplo.com"
                            autocomplete="email"
                            required
                        >
                    </div>
                    @error('email')
                        <div class="form-error">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Contraseña --}}
                <div class="form-group">
                    <label class="form-label" for="password">Contraseña</label>
                    <div class="input-icon-wrap">
                        <span class="input-icon"><i class="fa-solid fa-lock"></i></span>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            required
                        >
                        <button type="button" class="toggle-pw" id="togglePw" title="Ver contraseña">
                            <i class="fa-solid fa-eye" id="togglePwIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="form-error">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="login-submit">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Iniciar Sesión
                </button>

            </form>

        </div>{{-- /.login-card --}}
    </div>{{-- /.login-panel --}}

</div>{{-- /.login-page --}}

<script>
    // Toggle mostrar/ocultar contraseña
    const togglePw   = document.getElementById('togglePw');
    const pwInput    = document.getElementById('password');
    const toggleIcon = document.getElementById('togglePwIcon');

    togglePw.addEventListener('click', () => {
        const isPassword = pwInput.type === 'password';
        pwInput.type = isPassword ? 'text' : 'password';
        toggleIcon.className = isPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
    });
</script>
</body>
</html>