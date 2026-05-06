<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('cliente.login');
        }

        if (!Auth::user()->hasRole('Cliente')) {
            Auth::logout();
            return redirect()->route('cliente.login')
                ->withErrors(['correo' => 'Acceso no autorizado.']);
        }

        return $next($request);
    }
}
