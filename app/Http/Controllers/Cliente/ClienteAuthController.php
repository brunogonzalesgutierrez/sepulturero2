<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClienteAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->hasRole('Cliente')) {
            return redirect()->route('cliente.dashboard');
        }
        return view('cliente.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'correo'   => 'required|email',
            'password' => 'required|string',
        ], [
            'correo.required'   => 'El correo es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        $user = User::where('email', $request->correo)
            ->whereNotNull('cliente_id')
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['correo' => 'Correo o contraseña incorrectos.'])->withInput();
        }

        if ($user->estado === 'inactivo') {
            return back()->withErrors(['correo' => 'Su cuenta está inactiva. Contáctenos.']);
        }

        Auth::login($user, $request->remember);
        return redirect()->route('cliente.dashboard');
    }

    public function showRegister()
    {
        return view('cliente.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'ci'       => 'required|string|max:20',
            'correo'   => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'correo.unique'      => 'Ya existe una cuenta con ese correo.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min'       => 'Mínimo 8 caracteres.',
        ]);

        // Buscar si existe el cliente con ese CI
        $cliente = Cliente::where('ci', $request->ci)->first();

        if (!$cliente) {
            return back()->withErrors([
                'ci' => 'No encontramos un cliente registrado con ese CI. Contáctenos para registrarse.'
            ])->withInput();
        }

        // Verificar que el cliente no tenga ya una cuenta
        if (User::where('cliente_id', $cliente->id)->exists()) {
            return back()->withErrors([
                'ci' => 'Ya existe una cuenta vinculada a ese CI.'
            ])->withInput();
        }

        // Actualizar correo del cliente si no tiene
        if (!$cliente->correo) {
            $cliente->update(['correo' => $request->correo]);
        }

        // Crear usuario
        $user = User::create([
            'cliente_id' => $cliente->id,
            'username'   => 'cliente_' . $cliente->ci,
            'email'      => $request->correo,
            'password'   => Hash::make($request->password),
            'estado'     => 'activo',
        ]);

        $user->assignRole('Cliente');
        Auth::login($user);

        return redirect()->route('cliente.dashboard')->with('success', '¡Bienvenido! Su cuenta ha sido creada.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home'); // cambia cliente.login por home
    }
}
