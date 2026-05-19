<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function buscarEspacios(Request $request)
    {
        $tipo = $request->get('tipo');

        $espacios = \App\Models\Espacio::with(['cementerio', 'tipoInhumacion', 'dimension'])
            ->where('estado', 'disponible')
            ->when($tipo, fn($q) => $q->whereHas('tipoInhumacion', fn($q2) => $q2->where('nombre', $tipo)))
            ->get();

        return response()->json($espacios);
    }

    public function espaciosDisponibles(Request $request)
    {
        $tipo = $request->get('tipo');

        $espacios = \App\Models\Espacio::with(['cementerio', 'tipoInhumacion', 'dimension', 'direccion'])
            ->where('estado', 'disponible')
            ->when($tipo, fn($q) => $q->whereHas('tipoInhumacion', fn($q2) => $q2->where('nombre', $tipo)))
            ->get();

        return view('home-espacios', compact('espacios', 'tipo'));
    }


    public function enviarContacto(Request $request)
    {
        $request->validate([
            'nombre'  => 'required|string|max:100',
            'email'   => 'required|email',
            'mensaje' => 'required|string|max:1000',
        ]);

        // Verificar reCAPTCHA
        $recaptchaToken = $request->input('g-recaptcha-response');

        if (!$recaptchaToken) {
            return back()->withErrors(['captcha' => 'Por favor verifica que no eres un robot.'])->withInput();
        }

        $verify = \Illuminate\Support\Facades\Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => config('services.recaptcha.secret_key'),
            'response' => $recaptchaToken,
            'remoteip' => $request->ip(),
        ])->json();

        if (!($verify['success'] ?? false)) {
            return back()->withErrors(['captcha' => 'Verificación de reCAPTCHA fallida. Inténtalo de nuevo.'])->withInput();
        }

        \Illuminate\Support\Facades\Mail::raw(
            "Nombre: {$request->nombre}\n" .
            "Teléfono: {$request->telefono}\n" .
            "Correo: {$request->email}\n" .
            "Servicio: {$request->servicio}\n\n" .
            "Mensaje:\n{$request->mensaje}",
            function ($m) use ($request) {
                $m->to('info@sepulturerojuan.xyz')
                ->subject("Consulta web de {$request->nombre}")
                ->replyTo($request->email, $request->nombre);
            }
        );

        return back()->with('contacto_ok', true);
    }


}