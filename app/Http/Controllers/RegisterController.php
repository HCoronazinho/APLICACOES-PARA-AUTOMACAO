<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    protected $auth;

    public function __construct()
    {
        // Resolve o Auth do Firebase direto pelo container, igual ao LoginController
        $this->auth = app('firebase.auth');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        try {
            // Cria o usuário no Firebase
            $user = $this->auth->createUser([
                'displayName' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            // Salva algo em sessão se quiser
            Session::put('firebase_token', $user->uid);
            Session::put('user_email', $request->email);

            return redirect('/login')->with('success', 'Usuário cadastrado com sucesso!');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Erro: '.$e->getMessage()]);
        }
    }
}
