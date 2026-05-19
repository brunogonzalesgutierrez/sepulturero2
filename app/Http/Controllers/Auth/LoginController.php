<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    protected int $maxIntentos = 5;
    protected int $decayMinutos = 10;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Verificar si está bloqueado
        if (RateLimiter::tooManyAttempts($this->throttleKey($request), $this->maxIntentos)) {
            $segundos = RateLimiter::availableIn($this->throttleKey($request));
            throw ValidationException::withMessages([
                'username' => "Demasiados intentos fallidos. Intenta de nuevo en {$segundos} segundos.",
            ]);
        }

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey($request), $this->decayMinutos * 60);

            $intentosRestantes = $this->maxIntentos - RateLimiter::attempts($this->throttleKey($request));

            throw ValidationException::withMessages([
                'username' => $intentosRestantes > 0
                    ? "Credenciales incorrectas. Te quedan {$intentosRestantes} intentos."
                    : "Cuenta bloqueada por {$this->decayMinutos} minutos.",
            ]);
        }

        RateLimiter::clear($this->throttleKey($request));

        $user = Auth::user();

        if ($user->two_factor_enabled) {
            session(['2fa_user_id' => $user->id]);
            Auth::logout();
            return redirect()->route('2fa.verify');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    protected function throttleKey(Request $request): string
    {
        return Str::lower($request->input('username')) . '|' . $request->ip();
    }
}