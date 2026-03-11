<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Admin') — Sistema Odontológico</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    {{-- Iconos --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @stack('styles')
</head>
<body>

<div class="admin-wrapper">

    {{-- ========= SIDEBAR ========= --}}
    <aside class="sidebar" id="sidebar">

        {{-- Logo --}}
        <div class="sidebar-brand">
            <div class="brand-icon">🦷</div>
            <div class="brand-text">
                <span class="brand-name">OdontoSys</span>
                <span class="brand-sub">Admin Panel</span>
            </div>
        </div>

        {{-- Navegación --}}
        <nav class="sidebar-nav">

            <span class="nav-section-label">Principal</span>

            <div class="nav-item">
                <a href="{{ route('administradores.index') }}"
                   class="nav-link {{ request()->routeIs('administradores.*') && !request()->routeIs('administradores.dashboard') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-gauge-high"></i></span>
                    Dashboard
                </a>
            </div>

            <span class="nav-section-label">Gestión</span>

            <div class="nav-item">
                <a href="{{ route('odontologos.index') }}"
                   class="nav-link {{ request()->routeIs('odontologos.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-user-doctor"></i></span>
                    Odontólogos
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('pacientes.index') }}"
                   class="nav-link {{ request()->routeIs('pacientes.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-users"></i></span>
                    Pacientes
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('citas.index') }}"
                   class="nav-link {{ request()->routeIs('citas.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-calendar-check"></i></span>
                    Citas
                    {{-- Badge dinámico: puedes pasarlo con @section desde el controlador --}}
                    @hasSection('citas_pendientes')
                        <span class="nav-badge">@yield('citas_pendientes')</span>
                    @endif
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('tratamientos.index') }}"
                   class="nav-link {{ request()->routeIs('tratamientos.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-tooth"></i></span>
                    Tratamientos
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('historias.index') }}"
                   class="nav-link {{ request()->routeIs('historias.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-file-medical"></i></span>
                    Historias Clínicas
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('pagos.index') }}"
                   class="nav-link {{ request()->routeIs('pagos.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-money-bill-wave"></i></span>
                    Pagos
                </a>
            </div>

            <span class="nav-section-label">Reportes</span>

            <div class="nav-item">
                <a href="{{ route('reportes.index') }}" 
                  class="nav-link {{ request()->routeIs('reportes.*') ? 'active' : '' }}">
                  <span class="nav-icon"><i class="fa-solid fa-chart-line"></i></span>
                  Ver Reportes
                </a>
            </div>

        </nav>

        {{-- Footer del sidebar --}}
        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->nombre ?? 'A', 0, 1)) }}
                </div>
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->nombre ?? 'Administrador' }}</div>
                    <div class="user-role">Administrador</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn" title="Cerrar sesión">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </div>

    </aside>

    {{-- ========= CONTENIDO PRINCIPAL ========= --}}
    <div class="main-content">

        {{-- Topbar --}}
        <header class="topbar">
            <div class="topbar-left">
                {{-- Toggle móvil --}}
                <button class="topbar-btn" id="sidebarToggle" style="display:none">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div>
                    <div class="page-title">@yield('page_title', 'Dashboard')</div>
                    <div class="breadcrumb">
                        <a href="{{ route('administradores.index') }}">Inicio</a>
                        @hasSection('breadcrumb')
                            <span>/</span>
                            @yield('breadcrumb')
                        @endif
                    </div>
                </div>
            </div>

            <div class="topbar-right">
                <button class="topbar-btn" title="Notificaciones">
                    <i class="fa-solid fa-bell"></i>
                    <span class="dot"></span>
                </button>
                <button class="topbar-btn" title="Configuración">
                    <i class="fa-solid fa-gear"></i>
                </button>
            </div>
        </header>

        {{-- Cuerpo de página --}}
        <main class="page-body">

            {{-- Alertas globales de sesión --}}
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fa-solid fa-circle-xmark"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')

        </main>

    </div>{{-- /.main-content --}}

</div>{{-- /.admin-wrapper --}}

{{-- Scripts --}}
<script>
    // Toggle sidebar en móvil
    const toggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');

    function checkMobile() {
        if (window.innerWidth <= 768) {
            toggle.style.display = 'flex';
        } else {
            toggle.style.display = 'none';
            sidebar.classList.remove('open');
        }
    }

    toggle?.addEventListener('click', () => sidebar.classList.toggle('open'));
    window.addEventListener('resize', checkMobile);
    checkMobile();

    // Cerrar sidebar al hacer clic fuera en móvil
    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 768
            && !sidebar.contains(e.target)
            && e.target !== toggle) {
            sidebar.classList.remove('open');
        }
    });
</script>
@stack('scripts')
</body>
</html>