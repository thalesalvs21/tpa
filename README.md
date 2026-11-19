# Modelo de consulta – Ingressos de Eventos

Mesma estrutura da atividade da Loja de Produtos, com outro tema. Todo arquivo que você escreve na prova está aqui comentado:

- `// trocar:` = muda conforme a prova
- `// fixo:` = copia igual

## Tabela de tradução (este modelo → atividade de revisão)

| Aqui | Na revisão | Onde aparece |
|---|---|---|
| `Evento` / `eventos` | `Produto` / `produtos` | model, migration, controller, rotas, views |
| `Pedido` / `pedidos` | `Venda` / `vendas` | model e migration da compra |
| `evento_pedido` | `produto_venda` | pivô (os dois nomes no singular, em ordem alfabética) |
| `organizador()` / `organizador_id` | `vendedor()` / `vendedor_id` | dono do item |
| `'organizador'` (tipo e apelido) | `'vendedor'` | middleware, bootstrap/app.php, rotas |
| `classificacao` (0 a 18) | `garantia_meses` (0 a 36) | migration, fillable, FormRequest |
| `vagas` | `estoque` | migration, fillable, FormRequest, bônus |
| `EventoController` / `PedidoController` | `ProdutoController` / `CompraController` | já vêm criados na prova |

## Ordem e comandos

| # | Comando | Arquivo que você mexe |
|---|---|---|
| R1 | `php artisan make:model Evento` | `app/Models/Evento.php` |
| R1 | `php artisan make:migration create_eventos_table` | `database/migrations/..._create_eventos_table.php` |
| R1 | – | `EventoController@index` |
| R2 | – | `LoginController@attempt` e `@logout` |
| R3 | – | `routes/web.php` (grupo `auth`) |
| R4 | `php artisan make:middleware OrganizadorMiddleware` | o middleware + `bootstrap/app.php` + rotas |
| R5 | `php artisan make:request StoreEventoRequest` | o request + `EventoController@store` |
| R6 | – | `EventoController@store` (`Auth::id()`) |
| R7 | `php artisan make:model Pedido` | `app/Models/Pedido.php` |
| R7 | `php artisan make:migration create_pedidos_table` | migration da compra |
| R7 | `php artisan make:migration create_evento_pedido_table` | migration da pivô (sempre por último) |
| R7 | – | `PedidoController@store` |
| R8 | – | `PedidoController@index` |
| Bônus | – | `PedidoController@store` (estoque + `decrement`) |

Depois de criar as migrations: `php artisan migrate:fresh --seed`

## Regras de validação (texto do contrato → regra)

| Contrato diz | Regra |
|---|---|
| obrigatório | `required` |
| texto até 255 | `string\|max:255` |
| um destes: A, B, C | `in:A,B,C` |
| inteiro entre X e Y | `integer\|between:X,Y` |
| número maior que zero | `numeric\|gt:0` |
| inteiro ≥ 0 | `integer\|min:0` |

## Erros comuns

- Esquecer `return true` no `authorize()` do FormRequest → dá 403 em tudo.
- Esquecer `withPivot(...)` na relação → a tela de compras não mostra quantidade nem preço.
- Pivô criada antes das outras tabelas → erro de chave estrangeira no `migrate`.
- Coluna faltando no `$fillable` → o `create()` não salva aquele campo.
- Nome da variável no `compact()` diferente do que a view usa → a tabela aparece vazia.

## Como rodar

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate:fresh --seed
php artisan serve
```

Usuários (senha `senha123`): ana@eventos.test e bruno@eventos.test (organizadores), carla@eventos.test e diego@eventos.test (clientes).
