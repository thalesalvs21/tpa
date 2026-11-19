@extends('layouts.app')

@section('title', 'Sobre — Ingressos de Eventos')

@section('content')
<div class="card shadow-sm p-4">
    <h2 class="fw-bold">Sobre o site</h2>
    <p class="text-secondary">
        A Ingressos de Eventos é um projeto didático da disciplina de TPA (COTEMIG).
        O site já está pronto: falta implementar as features novas descritas no enunciado da prova.
    </p>
    <h5 class="fw-bold mt-3">Quem é quem</h5>
    <ul class="text-secondary">
        <li><strong>Organizador:</strong> cadastra eventos.</li>
        <li><strong>Cliente:</strong> compra ingressos e consulta os próprios pedidos.</li>
        <li><strong>Visitante:</strong> só navega pelo catálogo.</li>
    </ul>
</div>
@endsection
