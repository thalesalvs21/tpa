<?php

// R1 - criar com: php artisan make:model Evento (trocar Evento pelo nome da model, singular e com maiuscula)

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model // trocar: nome da model
{
    // trocar: todas as colunas da tabela, menos id e timestamps
    protected $fillable = [
        'nome',
        'categoria',
        'classificacao',
        'preco',
        'vagas',
        'organizador_id',
    ];

    // trocar: nome da funcao igual ao contrato (ex: vendedor) e a chave (ex: vendedor_id)
    public function organizador()
    {
        return $this->belongsTo(User::class, 'organizador_id');
    }

    // opcional: lado contrario do N:M, trocar o nome da funcao e a model da compra
    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class)
            ->withPivot('quantidade', 'preco_unitario') // fixo: colunas extras da pivo
            ->withTimestamps(); // fixo
    }
}
