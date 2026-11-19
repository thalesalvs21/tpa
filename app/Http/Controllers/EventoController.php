<?php

// R1, R5 e R6 - esse controller ja vem criado na prova, so preencher os metodos

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventoRequest; // trocar: nome do FormRequest
use App\Models\Evento; // trocar: nome da model
use Illuminate\Support\Facades\Auth; // fixo: precisa pra usar Auth::id()

class EventoController extends Controller // trocar: nome do controller (ja existe na prova)
{
    // R1
    public function index()
    {
        $eventos = Evento::with('organizador')->orderBy('nome')->get(); // trocar: model, nome da relacao do dono e nome da variavel

        return view('eventos.index', compact('eventos')); // trocar: nome da view e da variavel (a view mostra qual ela espera)
    }

    public function create()
    {
        return view('eventos.create'); // ja vem pronto
    }

    // R5 e R6
    public function store(StoreEventoRequest $request) // trocar: Request pelo seu FormRequest (isso que liga a validacao)
    {
        $dados = $request->validated(); // fixo: pega so os campos que passaram na validacao
        $dados['organizador_id'] = Auth::id(); // trocar: chave do dono, R6 (nunca vem do formulario)

        Evento::create($dados); // trocar: nome da model

        return redirect()->route('eventos.index')->with('sucesso', 'Evento cadastrado!'); // trocar: rota da listagem
    }
}
