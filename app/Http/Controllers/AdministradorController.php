<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use App\Models\Odontologo;
use App\Models\Paciente;
use App\Models\Cita;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministradorController extends Controller
{
    // ── LOGIN ──────────────────────────────────────────

    public function showLogin()
    {
        if (Auth::guard('administrador')->check()) {
            return redirect()->route('administradores.index');
        }
        return view('administradores.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('administrador')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('administradores.index')
                ->with('success', '¡Bienvenido al panel de administración!');
        }

        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Credenciales incorrectas. Verifica tu correo y contraseña.');
    }

    public function logout(Request $request)
    {
        Auth::guard('administrador')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')
            ->with('success', 'Sesión cerrada correctamente.');
    }

    // ── DASHBOARD ─────────────────────────────────────

    public function index()
    {
        $stats = [
            'odontologos' => Odontologo::count(),
            'pacientes'   => Paciente::count(),
            'citas_total' => Cita::count(),
            'citas_hoy'   => Cita::whereDate('fecha', today())->count(),
            'pendientes'  => Cita::where('estado', 'pendiente')->count(),
            'confirmadas' => Cita::where('estado', 'confirmada')->count(),
            'completadas' => Cita::where('estado', 'completada')->count(),
            'canceladas'  => Cita::where('estado', 'cancelada')->count(),
            'ingresos'    => Pago::sum('monto'),
            'pagos_mes'   => Pago::whereMonth('fecha', now()->month)
                                  ->whereYear('fecha', now()->year)
                                  ->sum('monto'),
        ];

        $ultimasCitas     = Cita::with(['paciente', 'odontologo'])->latest()->take(5)->get();
        $ultimosPacientes = Paciente::latest()->take(5)->get();

        return view('administradores.index', compact('stats', 'ultimasCitas', 'ultimosPacientes'));
    }

    // ── CRUD ADMINISTRADORES ──────────────────────────

    public function create()
    {
        return view('administradores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:administradores,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        Administrador::create([
            'nombre'   => $request->nombre,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('administradores.index')
            ->with('success', 'Administrador registrado correctamente.');
    }

    public function edit(Administrador $administrador)
    {
        return view('administradores.edit', compact('administrador'));
    }

    public function update(Request $request, Administrador $administrador)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email'  => 'required|email|max:255|unique:administradores,email,' . $administrador->id,
        ]);

        $administrador->update([
            'nombre' => $request->nombre,
            'email'  => $request->email,
        ]);

        return redirect()->route('administradores.index')
            ->with('success', 'Administrador actualizado correctamente.');
    }

    public function destroy(Administrador $administrador)
    {
        $administrador->delete();
        return redirect()->route('administradores.index')
            ->with('success', 'Administrador eliminado correctamente.');
    }
}