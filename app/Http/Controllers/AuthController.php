<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Mostra o formulário de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Processa o login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // No projeto acadêmico, podemos aceitar qualquer email
        // Se quiser, validar apenas formato de email
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Aqui só vamos simular login
        // Normalmente usaríamos Auth::attempt($credentials)
        session(['user_email' => $credentials['email']]);

        return redirect('/dashboard'); // redireciona para dashboard
    }
}
