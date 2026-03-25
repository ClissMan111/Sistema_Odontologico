<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PacienteController;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\OdontologoController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\HistoriaClinicaController;
use App\Http\Controllers\TratamientoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\AdminGestionController;
use App\Http\Controllers\ReporteController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas Resource
Route::resource('pacientes', PacienteController::class);
Route::resource('administradores', AdministradorController::class);
Route::resource('odontologos', OdontologoController::class);
Route::resource('citas', CitaController::class);
Route::resource('historias', HistoriaClinicaController::class);
Route::resource('tratamientos', TratamientoController::class);
Route::resource('pagos', PagoController::class);
Route::resource('admin-gestion', AdminGestionController::class)
    ->parameters(['admin-gestion' => 'administrador']);


// Login del administrador
// Login (público)
Route::get('/login',  [AdministradorController::class, 'showLogin'])->name('admin.login');
Route::post('/login', [AdministradorController::class, 'login'])->name('admin.login.post');
Route::post('/logout',[AdministradorController::class, 'logout'])->name('logout');
Route::get('reportes', [ReporteController::class, 'index'])->name('reportes.index');


// Rutas protegidas (requieren auth del guard 'administrador')
Route::middleware(['auth:administrador'])->group(function () {
    Route::resource('administradores', AdministradorController::class);
    Route::resource('odontologos',     OdontologoController::class);
    Route::resource('pacientes',       PacienteController::class);
    Route::resource('citas',           CitaController::class);
    Route::resource('historias',       HistoriaClinicaController::class);
    Route::resource('tratamientos',    TratamientoController::class);
    Route::resource('pagos',           PagoController::class);
});
 
// Rutas para los reportes
Route::get('reportes', [ReporteController::class, 'index'])->name('reportes.index');