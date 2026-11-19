<?php

// R7 - criar com: php artisan make:migration create_pedidos_table (trocar pedidos pela tabela da compra na prova, ex: vendas)

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) { // trocar: nome da tabela da compra
            $table->id(); // fixo
            $table->foreignId('cliente_id')->constrained('users'); // trocar: nome da chave de quem comprou (confere no contrato)
            $table->timestamps(); // fixo
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos'); // trocar: mesmo nome da tabela de cima
    }
};
