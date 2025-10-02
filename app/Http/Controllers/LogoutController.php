<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        // Limpa a sessão do usuário
        Session::flush();

        // Redireciona para login
        return redirect('/login')->with('success', 'Logout realizado com sucesso!');
    }
}
