<?php

// R4 - criar com: php artisan make:middleware OrganizadorMiddleware (trocar pelo perfil da prova, ex: VendedorMiddleware)
// depois registrar o apelido em bootstrap/app.php e usar nas rotas

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OrganizadorMiddleware // trocar: nome da classe igual ao nome do arquivo
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check() || Auth::user()->tipo !== 'organizador') { // trocar: valor do tipo que pode entrar (ex: 'vendedor')
            abort(403); // fixo: mostra a pagina errors/403
        }

        return $next($request); // fixo: deixa a requisicao seguir
    }
}
