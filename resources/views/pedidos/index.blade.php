@extends('layouts.app')

@section('title', 'Meus pedidos — Ingressos de Eventos')

@section('content')
<h2 class="fw-bold mb-3">🧾 Meus pedidos</h2>

@forelse ($pedidos ?? [] as $pedido)
    <div class="card shadow-sm mb-3">
        <div class="card-header d-flex justify-content-between">
            <strong>Pedido #{{ $pedido->id }}</strong>
            <span class="text-secondary">{{ $pedido->created_at?->format('d/m/Y H:i') }}</span>
        </div>
        <table class="table table-dark mb-0">
            <thead>
                <tr>
                    <th>Evento</th>
                    <th>Quantidade</th>
                    <th>Preço unitário</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pedido->eventos as $evento)
                    <tr>
                        <td>{{ $evento->nome }}</td>
                        <td>{{ $evento->pivot->quantidade }}</td>
                        <td>R$ {{ number_format($evento->pivot->preco_unitario, 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($evento->pivot->quantidade * $evento->pivot->preco_unitario, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="card-footer text-end fw-bold">
            Total: R$ {{ number_format($pedido->eventos->sum(fn ($item) => $item->pivot->quantidade * $item->pivot->preco_unitario), 2, ',', '.') }}
        </div>
    </div>
@empty
    <p class="text-secondary">Você ainda não fez nenhum pedido.</p>
@endforelse
@endsection
