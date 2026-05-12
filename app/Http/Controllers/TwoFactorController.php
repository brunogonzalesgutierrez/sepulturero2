<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class TwoFactorController extends Controller
{
    // Vista para activar 2FA desde el perfil
    public function setup()
    {
        $user   = Auth::user();
        $google2fa = new Google2FA();

        if (!$user->two_factor_secret) {
            $secret = $google2fa->generateSecretKey();
            $user->update(['two_factor_secret' => $secret]);
        }

        $qrUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email ?? $user->username,
            $user->two_factor_secret
        );

        // Generar QR como SVG
        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrSvg  = $writer->writeString($qrUrl);

        return view('auth.2fa-setup', compact('qrSvg', 'user'));
    }

    // Activar 2FA confirmando con el primer código
    public function activate(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);

        $user      = Auth::user();
        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey($user->two_factor_secret, $request->code);

        if (!$valid) {
            return back()->withErrors(['code' => 'Código incorrecto. Intenta de nuevo.']);
        }

        $user->update(['two_factor_enabled' => true]);

        return redirect()->route('perfil.index')->with('success', 'Autenticación de dos factores activada correctamente.');
    }

    // Desactivar 2FA
    public function desactivar(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);

        $user      = Auth::user();
        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey($user->two_factor_secret, $request->code);

        if (!$valid) {
            return back()->withErrors(['code' => 'Código incorrecto.']);
        }

        $user->update([
            'two_factor_enabled' => false,
            'two_factor_secret'  => null,
        ]);

        return redirect()->route('perfil.index')->with('success', '2FA desactivado.');
    }

    // Vista para verificar código al iniciar sesión
    public function showVerify()
    {
        if (!session('2fa_user_id')) {
            return redirect()->route('login');
        }

        return view('auth.2fa-verify');
    }

    // Verificar código al iniciar sesión
    public function verify(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);

        $userId = session('2fa_user_id');
        if (!$userId) {
            return redirect()->route('login');
        }

        $user      = User::findOrFail($userId);
        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey($user->two_factor_secret, $request->code);

        if (!$valid) {
            return back()->withErrors(['code' => 'Código incorrecto. Intenta de nuevo.']);
        }

        // Código correcto — autenticar
        Auth::login($user);
        session()->forget('2fa_user_id');
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }
}