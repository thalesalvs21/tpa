<?php

// R7 - criar com: php artisan make:migration create_evento_pedido_table (pivo = as duas tabelas no singular, em ordem alfabetica)
// essa migration tem que ter data DEPOIS das outras duas, senao a chave estrangeira quebra

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evento_pedido', function (Blueprint $table) { // trocar: nome da pivo do contrato (ex: produto_venda)
            $table->id(); // fixo
            $table->foreignId('pedido_id')->constrained('pedidos')->cascadeOnDelete(); // trocar: chave e tabela da compra (ex: venda_id, vendas)
            $table->foreignId('evento_id')->constrained('eventos'); // trocar: chave e tabela do item (ex: produto_id, produtos)
            $table->integer('quantidade'); // fixo: coluna extra da pivo (confere o nome no contrato)
            $table->decimal('preco_unitario', 8, 2); // fixo: coluna extra da pivo (confere o nome no contrato)
            $table->timestamps(); // fixo
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evento_pedido'); // trocar: mesmo nome da pivo de cima
    }
};
