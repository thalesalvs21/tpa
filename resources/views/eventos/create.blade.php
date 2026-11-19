@extends('layouts.app')

@section('title', 'Cadastrar Evento — Ingressos de Eventos')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm p-4">
            <h3 class="fw-bold mb-3">➕ Cadastrar Evento</h3>
            <form method="POST" action="{{ route('eventos.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="nome" class="form-label text-secondary">Nome</label>
                    <input type="text" name="nome" id="nome" value="{{ old('nome') }}" class="form-control @error('nome') is-invalid @enderror">
                    @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="categoria" class="form-label text-secondary">Categoria</label>
                    <select name="categoria" id="categoria" class="form-select @error('categoria') is-invalid @enderror">
                        <option value="">Selecione…</option>
                        <option value="Eletrônicos" @selected(old('categoria') == 'Eletrônicos')>Eletrônicos</option>
                        <option value="Vestuário" @selected(old('categoria') == 'Vestuário')>Vestuário</option>
                        <option value="Casa" @selected(old('categoria') == 'Casa')>Casa</option>
                        <option value="Alimentos" @selected(old('categoria') == 'Alimentos')>Alimentos</option>
                    </select>
                    @error('categoria') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="classificacao" class="form-label text-secondary">Classificação (idade)</label>
                    <input type="number" name="classificacao" id="classificacao" value="{{ old('classificacao') }}" class="form-control @error('classificacao') is-invalid @enderror">
                    @error('classificacao') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="preco" class="form-label text-secondary">Preço (R$)</label>
                    <input type="number" step="0.01" name="preco" id="preco" value="{{ old('preco') }}" class="form-control @error('preco') is-invalid @enderror">
                    @error('preco') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="vagas" class="form-label text-secondary">Vagas</label>
                    <input type="number" name="vagas" id="vagas" value="{{ old('vagas') }}" class="form-control @error('vagas') is-invalid @enderror">
                    @error('vagas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold">Cadastrar</button>
            </form>
        </div>
    </div>
</div>
@endsection
