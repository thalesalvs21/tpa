@extends('layouts.app')

@section('title', 'Comprar — Ingressos de Eventos')

@section('content')
<h2 class="fw-bold mb-3">🛒 Novo pedido</h2>
<p class="text-secondary">Informe a quantidade de cada item. Itens com quantidade 0 ficam de fora do pedido.</p>

<form method="POST" action="{{ route('pedidos.store') }}">
    @csrf
    <div class="card shadow-sm mb-3">
        <table class="table table-dark align-middle mb-0">
            <thead>
                <tr>
                    <th>Evento</th>
                    <th>Preço</th>
                    <th>Vagas</th>
                    <th style="width: 9rem">Quantidade</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($eventos ?? [] as $evento)
                    <tr>
                        <td>{{ $evento->nome }}</td>
                        <td>R$ {{ number_format($evento->preco, 2, ',', '.') }}</td>
                        <td>{{ $evento->vagas }}</td>
                        <td>
                            <input type="number" min="0" name="itens[{{ $evento->id }}]"
                                   value="{{ old('itens.' . $evento->id, 0) }}" class="form-control">
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-secondary py-4">Nenhum evento para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <button type="submit" class="btn btn-primary fw-bold">Finalizar pedido</button>
</form>
@endsection
