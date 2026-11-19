<?php

// R7, R8 e bonus - esse controller ja vem criado na prova, so preencher index e store

namespace App\Http\Controllers;

use App\Models\Evento; // trocar: model do item
use App\Models\Pedido; // trocar: model da compra
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // fixo
use Illuminate\Support\Facades\DB; // fixo: pra usar DB::transaction

class PedidoController extends Controller // trocar: nome do controller (ja existe na prova, ex: CompraController)
{
    // R8
    public function index()
    {
        $pedidos = Pedido::with('eventos') // trocar: model da compra e nome da relacao N:M
            ->where('cliente_id', Auth::id()) // trocar: chave do cliente (so as compras de quem esta logado)
            ->orderByDesc('created_at') // fixo: mais recente primeiro
            ->get();

        return view('pedidos.index', compact('pedidos')); // trocar: nome da view e da variavel que a view usa
    }

    public function create()
    {
        $eventos = Evento::orderBy('nome')->get(); // ja vem pronto

        return view('pedidos.create', compact('eventos')); // ja vem pronto
    }

    // R7
    public function store(Request $request)
    {
        // R7 passo 1: tira os itens com quantidade 0 (formulario manda itens[id] = quantidade)
        $itens = collect($request->input('itens', [])) // trocar: so se o name do formulario nao for itens
            ->map(fn ($quantidade) => (int) $quantidade) // fixo: transforma em numero
            ->filter(fn ($quantidade) => $quantidade > 0); // fixo: fica so o que for maior que 0

        if ($itens->isEmpty()) { // fixo: nao deixa criar compra vazia
            return back()->withErrors(['itens' => 'Escolha pelo menos um evento.'])->withInput(); // trocar: texto da mensagem
        }

        $eventos = Evento::whereIn('id', $itens->keys())->get()->keyBy('id'); // trocar: model do item (busca tudo de uma vez pelo id)

        // bonus: confere o estoque antes de criar qualquer coisa
        foreach ($itens as $eventoId => $quantidade) {
            $evento = $eventos->get($eventoId);

            if (! $evento) { // fixo: id que nao existe no banco
                return back()->withErrors(['itens' => 'Evento inválido.'])->withInput(); // trocar: texto
            }

            if ($quantidade > $evento->vagas) { // trocar: coluna de estoque (ex: estoque)
                return back()
                    ->withErrors(['itens' => "Vagas insuficientes para {$evento->nome}."]) // trocar: texto
                    ->withInput();
            }
        }

        DB::transaction(function () use ($itens, $eventos) { // fixo: se der erro no meio, desfaz tudo
            $pedido = Pedido::create(['cliente_id' => Auth::id()]); // trocar: model da compra e chave do cliente (R7 passo 2)

            foreach ($itens as $eventoId => $quantidade) {
                $evento = $eventos->get($eventoId);

                $pedido->eventos()->attach($eventoId, [ // trocar: nome da relacao N:M (R7 passo 3)
                    'quantidade' => $quantidade, // fixo: coluna extra da pivo
                    'preco_unitario' => $evento->preco, // fixo: preco atual do item
                ]);

                $evento->decrement('vagas', $quantidade); // trocar: coluna de estoque (bonus)
            }
        });

        return redirect()->route('pedidos.index')->with('sucesso', 'Compra realizada!'); // trocar: rota e mensagem (R7 passo 4, copia a mensagem do enunciado)
    }
}
