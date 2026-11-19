<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Evento;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class EventoSeeder extends Seeder
{
    public function run(): void
    {
        $eventos = [
            ['nome' => 'Show de Rock', 'categoria' => 'Show', 'classificacao' => 16, 'preco' => 120.0, 'vagas' => 50],
            ['nome' => 'Peça Infantil', 'categoria' => 'Teatro', 'classificacao' => 0, 'preco' => 40.0, 'vagas' => 30],
            ['nome' => 'Palestra de IA', 'categoria' => 'Palestra', 'classificacao' => 12, 'preco' => 25.0, 'vagas' => 80],
            ['nome' => 'Final do Campeonato', 'categoria' => 'Esporte', 'classificacao' => 0, 'preco' => 90.0, 'vagas' => 10],
        ];

        $colunas = [...array_keys($eventos[0]), 'organizador_id'];

        if (! class_exists(Evento::class) || ! Schema::hasColumns('eventos', $colunas)) {
            $this->command->warn('Eventos não semeados: crie a model Evento e a migration com as colunas '
                . implode(', ', $colunas) . '.');

            return;
        }

        $organizadores = User::where('tipo', 'organizador')->orderBy('id')->pluck('id');

        foreach ($eventos as $i => $dados) {
            Evento::forceCreate($dados + ['organizador_id' => $organizadores[$i % $organizadores->count()]]);
        }
    }
}
