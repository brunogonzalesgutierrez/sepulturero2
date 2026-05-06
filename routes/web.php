<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CementerioController;
use App\Http\Controllers\EspacioController;
use App\Http\Controllers\TipoInhumacionController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\InhumacionController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\RolController;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(function () {
    Route::get('/sistema', [DashboardController::class, 'index'])->name('dashboard');

    // Módulos CRUD
    Route::resource('clientes',          ClienteController::class);
    Route::resource('empleados',         EmpleadoController::class);
    Route::resource('usuarios',          UsuarioController::class);
    Route::resource('cementerios',       CementerioController::class);
    Route::resource('espacios',          EspacioController::class);
    Route::resource('tipo_inhumaciones', TipoInhumacionController::class);
    Route::resource('mantenimientos',    MantenimientoController::class);
    Route::resource('inhumaciones', InhumacionController::class)->parameters([
        'inhumaciones' => 'inhumacion'
    ]);
    Route::resource('contratos',         ContratoController::class);
    Route::resource('ventas',            VentaController::class);
    Route::resource('roles',             RolController::class)->except(['show']);

    // Rutas especiales ANTES del resource de pagos
    Route::post('/pagos/marcar-vencidas', [PagoController::class, 'marcarVencidas'])
        ->name('pagos.marcarVencidas');
    Route::resource('pagos', PagoController::class);

    // Correos manuales
    Route::post('/ventas/{venta}/enviar-factura', [VentaController::class, 'enviarFactura'])
        ->name('ventas.enviarFactura');
    Route::post('/pagos/{pago}/enviar-recibo', [PagoController::class, 'enviarRecibo'])
        ->name('pagos.enviarRecibo');

    // Bitácora
    Route::get('/bitacora', [BitacoraController::class, 'index'])->name('bitacora.index');

    // Reportes
    Route::get('/reportes',           [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/reportes/ventas',    [ReporteController::class, 'ventas'])->name('reportes.ventas');
    Route::get('/reportes/pagos',     [ReporteController::class, 'pagos'])->name('reportes.pagos');
    Route::get('/reportes/espacios',  [ReporteController::class, 'espacios'])->name('reportes.espacios');
    Route::get('/reportes/contratos', [ReporteController::class, 'contratos'])->name('reportes.contratos');

    // Perfil
    Route::get('/perfil',          [PerfilController::class, 'index'])->name('perfil.index');
    Route::put('/perfil',          [PerfilController::class, 'update'])->name('perfil.update');
    Route::put('/perfil/password', [PerfilController::class, 'cambiarPassword'])->name('perfil.password');
});



// ── PORTAL CLIENTE ──────────────────────────────────────
Route::prefix('cliente')->name('cliente.')->group(function () {

    // Rutas públicas (sin autenticación)
    Route::middleware('guest')->group(function () {
        Route::get('/login',       [\App\Http\Controllers\Cliente\ClienteAuthController::class, 'showLogin'])->name('login');
        Route::post('/login',      [\App\Http\Controllers\Cliente\ClienteAuthController::class, 'login'])->name('login.post');
        Route::get('/register',    [\App\Http\Controllers\Cliente\ClienteAuthController::class, 'showRegister'])->name('register');
        Route::post('/register',   [\App\Http\Controllers\Cliente\ClienteAuthController::class, 'register'])->name('register.post');
    });

    // Rutas protegidas (solo clientes autenticados)
    Route::middleware('cliente')->group(function () {
        Route::get('/dashboard',       [\App\Http\Controllers\Cliente\ClientePortalController::class, 'dashboard'])->name('dashboard');
        Route::get('/contrato/{id}',   [\App\Http\Controllers\Cliente\ClientePortalController::class, 'contrato'])->name('contrato');
        Route::get('/cuotas',          [\App\Http\Controllers\Cliente\ClientePortalController::class, 'cuotas'])->name('cuotas');
        Route::post('/logout',         [\App\Http\Controllers\Cliente\ClienteAuthController::class, 'logout'])->name('logout');
        Route::get('/pagar/{cuota}', [\App\Http\Controllers\Cliente\ClientePortalController::class, 'pagar'])->name('pagar');

        // Pago de cuotas
        Route::get('/pagar/{cuota}',          [\App\Http\Controllers\Cliente\ClientePortalController::class,  'pagar'])->name('pagar');

        // PayPal
        Route::post('/paypal/{cuota}',         [\App\Http\Controllers\Cliente\PaypalPagoController::class, 'pagar'])->name('paypal.pagar');
        Route::get('/paypal/{cuota}/success',  [\App\Http\Controllers\Cliente\PaypalPagoController::class, 'success'])->name('paypal.success');
        Route::get('/paypal/{cuota}/cancel',   [\App\Http\Controllers\Cliente\PaypalPagoController::class, 'cancel'])->name('paypal.cancel');

        // Stripe
        Route::post('/stripe/{cuota}',         [\App\Http\Controllers\Cliente\StripePagoController::class, 'pagar'])->name('stripe.pagar');
        Route::get('/stripe/{cuota}/success',  [\App\Http\Controllers\Cliente\StripePagoController::class, 'success'])->name('stripe.success');
        Route::get('/stripe/{cuota}/cancel',   [\App\Http\Controllers\Cliente\StripePagoController::class, 'cancel'])->name('stripe.cancel');

        Route::get('/perfil',  [\App\Http\Controllers\Cliente\ClientePortalController::class, 'perfil'])->name('perfil');
        Route::put('/perfil',  [\App\Http\Controllers\Cliente\ClientePortalController::class, 'actualizarPerfil'])->name('perfil.update');
    });
});
