<?php

use App\Http\Controllers\PedidoController; // trocar: controller da compra
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EventoController; // trocar: controller do item
use Illuminate\Support\Facades\Route;

// Páginas de ilustração (prontas)
Route::view('/', 'home')->name('home');
Route::view('/sobre', 'sobre')->name('sobre');

// Autenticação
Route::get('/login', [LoginController::class, 'create'])->name('login'); // fixo: o middleware auth manda pra rota com nome login
Route::post('/login', [LoginController::class, 'attempt'])->name('login.attempt');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Eventos
Route::get('/eventos', [EventoController::class, 'index'])->name('eventos.index'); // listagem fica fora do grupo (publica)

// R3 + R4: cadastro so pra logado E do tipo certo
Route::middleware(['auth', 'organizador'])->group(function () { // trocar: 'organizador' pelo apelido do middleware da prova
    Route::get('/eventos/create', [EventoController::class, 'create'])->name('eventos.create'); // so mover pra dentro do grupo
    Route::post('/eventos', [EventoController::class, 'store'])->name('eventos.store'); // so mover pra dentro do grupo
});

// R3: compras so pra logado
Route::middleware('auth')->group(function () { // fixo
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index'); // so mover pra dentro do grupo
    Route::get('/pedidos/create', [PedidoController::class, 'create'])->name('pedidos.create'); // so mover pra dentro do grupo
    Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store'); // so mover pra dentro do grupo
});
