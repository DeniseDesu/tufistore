<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function attemptLogin(Request $request)
    {
        // Obtener las credenciales del formulario de login
        $credentials = $this->credentials($request);

        // Agregar la condición adicional de que 'is_visible' sea true
        $credentials['is_visible'] = true;

        // Intentar autenticación con las credenciales y la condición adicional
        return $this->guard()->attempt($credentials, $request->filled('remember'));
    }
}
