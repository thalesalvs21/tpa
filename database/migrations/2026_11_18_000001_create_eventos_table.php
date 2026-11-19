<?php

// R1 - criar com: php artisan make:migration create_eventos_table (trocar eventos pela tabela da prova)

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eventos', function (Blueprint $table) { // trocar: nome da tabela (plural, minusculo)
            $table->id(); // fixo
            $table->string('nome'); // trocar: coluna de texto -> string
            $table->string('categoria'); // trocar: coluna de texto com lista de opcoes tambem e string
            $table->integer('classificacao'); // trocar: a coluna "diferente" da prova (inteiro -> integer)
            $table->decimal('preco', 8, 2); // trocar: decimal(8,2) do contrato vira decimal('coluna', 8, 2)
            $table->integer('vagas'); // trocar: coluna de quantidade/estoque
            $table->foreignId('organizador_id')->constrained('users'); // trocar: nome da chave do dono (ex: vendedor_id), sempre aponta pra users
            $table->timestamps(); // fixo
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eventos'); // trocar: mesmo nome da tabela de cima
    }
};
