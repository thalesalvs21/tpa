<?php

// R7 - criar com: php artisan make:model Pedido (trocar Pedido pela model da compra, ex: Venda)

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model // trocar: nome da model da compra
{
    protected $fillable = [
        'cliente_id', // trocar: chave de quem comprou
    ];

    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id'); // trocar: chave de quem comprou
    }

    // trocar: nome da funcao igual ao contrato (ex: produtos) e a model do item (ex: Produto)
    public function eventos()
    {
        return $this->belongsToMany(Evento::class)
            ->withPivot('quantidade', 'preco_unitario') // fixo: sem isso a view nao enxerga $item->pivot->quantidade
            ->withTimestamps(); // fixo: preenche created_at/updated_at da pivo
    }
}
