<?php

// R5 - criar com: php artisan make:request StoreEventoRequest (trocar Evento pela model da prova)

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventoRequest extends FormRequest // trocar: nome da classe
{
    public function authorize(): bool
    {
        return true; // fixo: vem false, tem que mudar pra true senao da 403
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255', // trocar: "texto ate 255" = string|max:255
            'categoria' => 'required|in:Show,Teatro,Palestra,Esporte', // trocar: "um destes" = in: com as opcoes separadas por virgula, sem espaco
            'classificacao' => 'required|integer|between:0,18', // trocar: "inteiro entre X e Y" = integer|between:X,Y
            'preco' => 'required|numeric|gt:0', // trocar: "numero maior que zero" = numeric|gt:0
            'vagas' => 'required|integer|min:0', // trocar: "inteiro >= 0" = integer|min:0
            // dono (organizador_id) nao entra aqui, ele vem do Auth::id() no controller
        ];
    }
}
