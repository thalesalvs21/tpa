<?php

// R2 - esse arquivo quase sempre e igual em qualquer prova, so confere a rota de redirecionamento

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // fixo: precisa importar

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login'); // ja vem pronto
    }

    public function attempt(Request $request)
    {
        $credenciais = $request->validate([ // fixo: nomes iguais aos name="" do formulario de login
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credenciais)) { // fixo: confere email e senha no banco
            $request->session()->regenerate(); // fixo: seguranca da sessao

            return redirect()->intended(route('eventos.index')); // trocar: pra onde vai depois de logar (volta pra pagina que tentou abrir)
        }

        return back() // fixo: senha errada volta pro login
            ->withErrors(['email' => 'E-mail ou senha inválidos.']) // fixo: mensagem aparece embaixo do campo email
            ->onlyInput('email'); // fixo: mantem o email preenchido
    }

    public function logout(Request $request)
    {
        Auth::logout(); // fixo: desloga

        $request->session()->invalidate(); // fixo: apaga a sessao
        $request->session()->regenerateToken(); // fixo: novo token csrf

        return redirect()->route('login'); // fixo: volta pro login
    }
}
