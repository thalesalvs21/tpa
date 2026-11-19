@extends('layouts.app')

@section('title', 'Eventos — Ingressos de Eventos')

@section('content')
<h2 class="fw-bold mb-3">📦 Eventos disponíveis</h2>

<div class="card shadow-sm">
    <table class="table table-dark table-hover mb-0">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Classificação (idade)</th>
                <th>Preço (R$)</th>
                <th>Vagas</th>
                <th>Organizador</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($eventos ?? [] as $evento)
                <tr>
                    <td>{{ $evento->nome }}</td>
                    <td>{{ $evento->categoria }}</td>
                    <td>{{ $evento->classificacao }}</td>
                    <td>R$ {{ number_format($evento->preco, 2, ',', '.') }}</td>
                    <td>{{ $evento->vagas }}</td>
                    <td>{{ $evento->organizador->name }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="99" class="text-center text-secondary py-4">Nenhum evento para mostrar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
