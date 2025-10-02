<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    protected $auth;

    public function __construct()
    {
        // Resolve o Auth do Firebase direto pelo container
        $this->auth = app('firebase.auth');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            // Autentica no Firebase
            $signInResult = $this->auth->signInWithEmailAndPassword(
                $credentials['email'],
                $credentials['password']
            );

            // Pega o ID Token do usuário autenticado
            $idToken = $signInResult->idToken();

            // Salva em sessão do Laravel
            Session::put('firebase_token', $idToken);
            Session::put('user_email', $credentials['email']);

            return redirect('/dashboard')->with('success', 'Login realizado!');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Login inválido: '.$e->getMessage()]);
        }
    }
}
