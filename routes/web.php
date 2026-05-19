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
use App\Http\Controllers\TwoFactorController;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home.alt');

Route::get('/buscar-espacios', [App\Http\Controllers\HomeController::class, 'buscarEspacios'])->name('home.buscar');  // 👈 aquí
Route::get('/espacios-disponibles', [App\Http\Controllers\HomeController::class, 'espaciosDisponibles'])->name('home.espacios');
Route::post('/contacto', [App\Http\Controllers\HomeController::class, 'enviarContacto'])->name('home.contacto');

Auth::routes(['register' => false]);

// Verificación 2FA al login — FUERA del grupo auth
Route::get('/2fa/verify',  [TwoFactorController::class, 'showVerify'])->name('2fa.verify');
Route::post('/2fa/verify', [TwoFactorController::class, 'verify'])->name('2fa.verify.post');

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
    Route::resource('tipo_mantenimientos', App\Http\Controllers\TipoMantenimientoController::class);
    Route::resource('venta_mantenimientos', \App\Http\Controllers\VentaMantenimientoController::class);
    
    Route::resource('inhumaciones', InhumacionController::class)->parameters([
        'inhumaciones' => 'inhumacion'
    ]);
    Route::resource('contratos',         ContratoController::class);
    Route::resource('ventas',            VentaController::class);
    Route::resource('roles',             RolController::class)->except(['show']);

    Route::post('/pagos/marcar-vencidas', [PagoController::class, 'marcarVencidas'])
        ->name('pagos.marcarVencidas');
    Route::resource('pagos', PagoController::class);

    Route::post('/ventas/{venta}/enviar-factura', [VentaController::class, 'enviarFactura'])
        ->name('ventas.enviarFactura');
    Route::post('/pagos/{pago}/enviar-recibo', [PagoController::class, 'enviarRecibo'])
        ->name('pagos.enviarRecibo');

    Route::get('/bitacora', [BitacoraController::class, 'index'])->name('bitacora.index');

    Route::get('/reportes',           [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/reportes/ventas',    [ReporteController::class, 'ventas'])->name('reportes.ventas');
    Route::get('/reportes/pagos',     [ReporteController::class, 'pagos'])->name('reportes.pagos');
    Route::get('/reportes/espacios',  [ReporteController::class, 'espacios'])->name('reportes.espacios');
    Route::get('/reportes/contratos', [ReporteController::class, 'contratos'])->name('reportes.contratos');

    Route::get('/perfil',          [PerfilController::class, 'index'])->name('perfil.index');
    Route::put('/perfil',          [PerfilController::class, 'update'])->name('perfil.update');
    Route::put('/perfil/password', [PerfilController::class, 'cambiarPassword'])->name('perfil.password');

    // 2FA setup desde perfil
    Route::get('/2fa/setup',       [TwoFactorController::class, 'setup'])->name('2fa.setup');
    Route::post('/2fa/activate',   [TwoFactorController::class, 'activate'])->name('2fa.activate');
    Route::post('/2fa/desactivar', [TwoFactorController::class, 'desactivar'])->name('2fa.desactivar');
});

// ── PORTAL CLIENTE ──────────────────────────────────────
Route::prefix('cliente')->name('cliente.')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('/login',     [\App\Http\Controllers\Cliente\ClienteAuthController::class, 'showLogin'])->name('login');
        Route::post('/login',    [\App\Http\Controllers\Cliente\ClienteAuthController::class, 'login'])->name('login.post');
        Route::get('/register',  [\App\Http\Controllers\Cliente\ClienteAuthController::class, 'showRegister'])->name('register');
        Route::post('/register', [\App\Http\Controllers\Cliente\ClienteAuthController::class, 'register'])->name('register.post');
    });

    Route::middleware('cliente')->group(function () {
        Route::get('/dashboard',     [\App\Http\Controllers\Cliente\ClientePortalController::class, 'dashboard'])->name('dashboard');
        Route::get('/contrato/{id}', [\App\Http\Controllers\Cliente\ClientePortalController::class, 'contrato'])->name('contrato');
        Route::get('/cuotas',        [\App\Http\Controllers\Cliente\ClientePortalController::class, 'cuotas'])->name('cuotas');
        Route::post('/logout',       [\App\Http\Controllers\Cliente\ClienteAuthController::class, 'logout'])->name('logout');
        Route::get('/pagar/{cuota}', [\App\Http\Controllers\Cliente\ClientePortalController::class, 'pagar'])->name('pagar');

        // PayPal
        Route::post('/paypal/{cuota}',        [\App\Http\Controllers\Cliente\PaypalPagoController::class, 'pagar'])->name('paypal.pagar');
        Route::get('/paypal/{cuota}/success', [\App\Http\Controllers\Cliente\PaypalPagoController::class, 'success'])->name('paypal.success');
        Route::get('/paypal/{cuota}/cancel',  [\App\Http\Controllers\Cliente\PaypalPagoController::class, 'cancel'])->name('paypal.cancel');

        // Stripe
        Route::post('/stripe/{cuota}',        [\App\Http\Controllers\Cliente\StripePagoController::class, 'pagar'])->name('stripe.pagar');
        Route::get('/stripe/{cuota}/success', [\App\Http\Controllers\Cliente\StripePagoController::class, 'success'])->name('stripe.success');
        Route::get('/stripe/{cuota}/cancel',  [\App\Http\Controllers\Cliente\StripePagoController::class, 'cancel'])->name('stripe.cancel');

        // Libélula
        // Libélula — Cuotas
        Route::post('/libelula/{cuota}',          [\App\Http\Controllers\Cliente\LibelulaPagoController::class, 'pagar'])->name('libelula.pagar');
        Route::get('/libelula/{cuota}/retorno',   [\App\Http\Controllers\Cliente\LibelulaPagoController::class, 'retorno'])->name('libelula.retorno');
        Route::get('/libelula/{cuota}/verificar', [\App\Http\Controllers\Cliente\LibelulaPagoController::class, 'verificar'])->name('libelula.verificar');
        Route::get('/libelula/{cuota}/qr',        [\App\Http\Controllers\Cliente\LibelulaPagoController::class, 'mostrarQr'])->name('libelula.qr');

        // Libélula — Mantenimientos (prefijo propio para no chocar con {cuota})
        Route::post('/libelula-mant/{venta}',          [\App\Http\Controllers\Cliente\LibelulaMantenimientoPagoController::class, 'pagar'])->name('libelula.mantenimiento.pagar');
        Route::get('/libelula-mant/{venta}/retorno',   [\App\Http\Controllers\Cliente\LibelulaMantenimientoPagoController::class, 'retorno'])->name('libelula.mantenimiento.retorno');
        Route::get('/libelula-mant/{venta}/qr',        [\App\Http\Controllers\Cliente\LibelulaMantenimientoPagoController::class, 'mostrarQr'])->name('libelula.mantenimiento.qr');
        Route::get('/libelula-mant/{venta}/verificar', [\App\Http\Controllers\Cliente\LibelulaMantenimientoPagoController::class, 'verificar'])->name('libelula.mantenimiento.verificar');
        // Pagar mantenimiento — página de selección de método
        Route::get('/mantenimientos/{venta}/pagar', [\App\Http\Controllers\Cliente\ClienteMantenimientoController::class, 'pagar'])->name('mantenimientos.pagar');

        // Perfil
        Route::get('/perfil', [\App\Http\Controllers\Cliente\ClientePortalController::class, 'perfil'])->name('perfil');
        Route::put('/perfil', [\App\Http\Controllers\Cliente\ClientePortalController::class, 'actualizarPerfil'])->name('perfil.update');
    
        Route::get('/mantenimientos',          [\App\Http\Controllers\Cliente\ClienteMantenimientoController::class, 'index'])->name('mantenimientos.index');
        Route::post('/mantenimientos',         [\App\Http\Controllers\Cliente\ClienteMantenimientoController::class, 'store'])->name('mantenimientos.store');
        Route::get('/mantenimientos/solicitar',[\App\Http\Controllers\Cliente\ClienteMantenimientoController::class, 'create'])->name('mantenimientos.create');


    });
});

// Callback Libélula — FUERA de todo grupo
Route::get('/cliente/libelula/callback', [\App\Http\Controllers\Cliente\LibelulaPagoController::class, 'callback'])
    ->name('cliente.libelula.callback');



Route::get('/cliente/libelula/mantenimiento/callback', [\App\Http\Controllers\Cliente\LibelulaMantenimientoPagoController::class, 'callback'])
    ->name('cliente.libelula.mantenimiento.callback');