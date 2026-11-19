# Guia da prova – TPA

**Como usar:**
1. Preencha a tabela de nomes abaixo com o que estiver no enunciado da prova.
2. Faça os passos na ordem: abra o arquivo, cole o código, teste.
3. Toda linha que tem `// trocar: [X]` usa um nome da tabela. Troque o nome da revisão pelo da sua prova.
4. Linha **sem** comentário é igual em qualquer tema: só copiar.

> Se a prova for igual à revisão (Produto, Venda, vendedor), não precisa trocar nada.

---

## Tabela de nomes (preencha primeiro)

Tudo isso está no README da prova, na parte de **Contratos**.

| Código | O que é | Na revisão | Exemplo de outro tema | **Na sua prova** |
|---|---|---|---|---|
| **[A]** | Model do item (singular, maiúscula) | `Produto` | `Evento` | |
| **[B]** | Tabela do item (plural, minúscula) | `produtos` | `eventos` | |
| **[C]** | Tipo do dono / apelido do middleware | `vendedor` | `organizador` | |
| **[D]** | Chave do dono | `vendedor_id` | `organizador_id` | |
| **[E]** | Model da compra | `Venda` | `Pedido` | |
| **[F]** | Tabela da compra | `vendas` | `pedidos` | |
| **[G]** | Chave de quem comprou | `cliente_id` | `cliente_id` | |
| **[H]** | Tabela pivô | `produto_venda` | `evento_pedido` | |
| **[I]** | Colunas do item | `nome, categoria, garantia_meses, preco, estoque` | `nome, categoria, classificacao, preco, vagas` | |
| **[J]** | Categorias permitidas | `Eletrônicos,Vestuário,Casa,Alimentos` | `Show,Teatro,Palestra,Esporte` | |
| **[K]** | Coluna "diferente" e limite | `garantia_meses` 0 a 36 | `classificacao` 0 a 18 | |
| **[L]** | Coluna de estoque | `estoque` | `vagas` | |
| **[M]** | Controller do item | `ProdutoController` | `EventoController` | |
| **[N]** | Controller da compra | `CompraController` | `PedidoController` | |
| **[O]** | Nome das rotas do item | `produtos.index` ... | `eventos.index` ... | |
| **[P]** | Nome das rotas da compra | `compras.index` ... | `pedidos.index` ... | |
| **[Q]** | Mensagem de sucesso da compra | `Compra realizada!` | (copiar do enunciado) | |

**Regras pra não errar:**
- **Pivô [H]:** os dois nomes no **singular**, em **ordem alfabética**, com `_` no meio. Ex: `produto` + `venda` = `produto_venda`. Mas sempre confira no contrato.
- **Nomes das rotas [O] [P]:** veja no `routes/web.php` da prova (o que está dentro de `->name('...')`). **Nunca mude**.
- **Nomes das views e variáveis:** abra a view (ex: `resources/views/produtos/index.blade.php`) e procure `@forelse ($produtos ...`. O nome depois do `$` é o que vai no `compact()`.
- **Variáveis de dentro das funções** (`$dados`, `$itens`, `$produto`, `$venda`, `$quantidade`) **não precisam ser trocadas**. Funcionam com qualquer tema.

---

## Antes de começar

Ligue o projeto (cole no terminal, uma linha de cada vez):

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate:fresh --seed
php artisan serve
```

---

## R1 – Mostrar os itens

**1. No terminal:**

```bash
php artisan make:model Produto                  # trocar: [A]
php artisan make:migration create_produtos_table   # trocar: [B]
```

**2. Abra `database/migrations/..._create_produtos_table.php`**
Troque o que está dentro do `Schema::create(...)` por:

```php
Schema::create('produtos', function (Blueprint $table) {   // trocar: [B]
    $table->id();
    $table->string('nome');                                 // trocar: [I]
    $table->string('categoria');                            // trocar: [I]
    $table->integer('garantia_meses');                      // trocar: [K]
    $table->decimal('preco', 8, 2);                         // trocar: [I]
    $table->integer('estoque');                             // trocar: [L]
    $table->foreignId('vendedor_id')->constrained('users'); // trocar: [D]
    $table->timestamps();
});
```

E no `down()`:

```php
Schema::dropIfExists('produtos');   // trocar: [B]
```

> **Tipo da coluna:** texto = `string`, inteiro = `integer`, decimal (8,2) = `decimal('nome', 8, 2)`, chave estrangeira = `foreignId('nome')->constrained('users')`.
> Se a prova tiver mais ou menos colunas, acrescente ou apague linhas seguindo esse padrão.

**3. Abra `app/Models/Produto.php`** — trocar: [A]
Dentro da classe, cole:

```php
protected $fillable = ['nome', 'categoria', 'garantia_meses', 'preco', 'estoque', 'vendedor_id'];   // trocar: [I] e [D]

public function vendedor()                              // trocar: [C]
{
    return $this->belongsTo(User::class, 'vendedor_id'); // trocar: [D]
}
```

**4. Abra `app/Http/Controllers/ProdutoController.php`** — trocar: [M]

No topo, cole:

```php
use App\Models\Produto;   // trocar: [A]
```

Troque a função `index` por:

```php
public function index()
{
    $produtos = Produto::with('vendedor')->orderBy('nome')->get();   // trocar: [B] [A] [C]

    return view('produtos.index', compact('produtos'));              // trocar: [B] (confira o nome da view)
}
```

**5. No terminal:** `php artisan migrate:fresh --seed`

✅ **Teste:** sem login, abra a listagem. Tem que aparecer a lista com o nome do dono em cada linha.

---

## R2 – Login e logout

> Esse é **igual em qualquer tema**. Só a rota pra onde vai depois do login muda.

**Abra `app/Http/Controllers/LoginController.php`**

No topo, cole:

```php
use Illuminate\Support\Facades\Auth;
```

Troque as funções `attempt` e `logout` por:

```php
public function attempt(Request $request)
{
    $credenciais = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credenciais)) {
        $request->session()->regenerate();

        return redirect()->intended(route('produtos.index'));   // trocar: [O]
    }

    return back()
        ->withErrors(['email' => 'E-mail ou senha inválidos.'])
        ->onlyInput('email');
}

public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
}
```

✅ **Teste:** senha errada → volta com erro. Senha certa → seu nome aparece no topo. Sair → volta o botão Entrar.

---

## R3 e R4 – Bloquear páginas

**1. No terminal:**

```bash
php artisan make:middleware VendedorMiddleware   # trocar: [C] (com maiuscula)
```

**2. Abra `app/Http/Middleware/VendedorMiddleware.php`**

No topo, cole:

```php
use Illuminate\Support\Facades\Auth;
```

Dentro da função `handle`, apague o que tiver e cole:

```php
if (! Auth::check() || Auth::user()->tipo !== 'vendedor') {   // trocar: [C]
    abort(403);
}

return $next($request);
```

**3. Abra `bootstrap/app.php`**
Procure `withMiddleware`. Troque o `//` de dentro dele por:

```php
$middleware->alias([
    'vendedor' => \App\Http\Middleware\VendedorMiddleware::class,   // trocar: [C] nos dois lugares
]);
```

**4. Abra `routes/web.php`**
Coloque as rotas de **cadastro** e de **compra** dentro dos grupos. A rota da listagem fica de fora.

```php
// so o dono logado (R3 + R4)
Route::middleware(['auth', 'vendedor'])->group(function () {   // trocar: [C]
    // aqui dentro: as 2 rotas de cadastro (create e store) que ja existem
});

// qualquer pessoa logada (R3)
Route::middleware('auth')->group(function () {
    // aqui dentro: as 3 rotas de compra que ja existem
});
```

Na revisão fica assim:

```php
Route::middleware(['auth', 'vendedor'])->group(function () {
    Route::get('/produtos/create', [ProdutoController::class, 'create'])->name('produtos.create');
    Route::post('/produtos', [ProdutoController::class, 'store'])->name('produtos.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/compras', [CompraController::class, 'index'])->name('compras.index');
    Route::get('/compras/create', [CompraController::class, 'create'])->name('compras.create');
    Route::post('/compras', [CompraController::class, 'store'])->name('compras.store');
});
```

> **Não reescreva as rotas.** Recorte as linhas que já existem na prova e cole dentro dos grupos.

✅ **Teste:**
- Deslogado: cadastrar e as páginas de compra → vão pro login.
- Logado como cliente: cadastrar → página 403.
- Logado como dono: cadastrar → aparece o formulário.

---

## R5 e R6 – Cadastrar com validação

**1. No terminal:**

```bash
php artisan make:request StoreProdutoRequest   # trocar: [A]
```

**2. Abra `app/Http/Requests/StoreProdutoRequest.php`**
Troque as duas funções por:

```php
public function authorize(): bool
{
    return true;
}

public function rules(): array
{
    return [
        'nome' => 'required|string|max:255',                                 // trocar: [I]
        'categoria' => 'required|in:Eletrônicos,Vestuário,Casa,Alimentos',   // trocar: [J]
        'garantia_meses' => 'required|integer|between:0,36',                 // trocar: [K] (nome e limite)
        'preco' => 'required|numeric|gt:0',                                  // trocar: [I]
        'estoque' => 'required|integer|min:0',                               // trocar: [L]
    ];
}
```

> **Muito importante:** o `authorize` vem com `false`. Se não trocar pra `true`, dá erro 403.
> A chave do dono **[D]** não entra aqui.

**Como transformar o texto do contrato em regra:**

| O contrato diz | Você escreve |
|---|---|
| obrigatório | `required` |
| texto até 255 caracteres | `string\|max:255` |
| um destes: A, B, C | `in:A,B,C` (sem espaço depois da vírgula) |
| inteiro entre X e Y | `integer\|between:X,Y` |
| número maior que zero | `numeric\|gt:0` |
| inteiro maior ou igual a 0 | `integer\|min:0` |

**3. Abra `app/Http/Controllers/ProdutoController.php`** — trocar: [M]

No topo, cole:

```php
use App\Http\Requests\StoreProdutoRequest;   // trocar: [A]
use Illuminate\Support\Facades\Auth;
```

Troque a função `store` por:

```php
public function store(StoreProdutoRequest $request)   // trocar: [A]
{
    $dados = $request->validated();
    $dados['vendedor_id'] = Auth::id();   // trocar: [D]

    Produto::create($dados);              // trocar: [A]

    return redirect()->route('produtos.index')->with('sucesso', 'Produto cadastrado!');   // trocar: [O]
}
```

✅ **Teste** (logado como dono):
- Formulário vazio → erro em todos os campos.
- Valor fora do limite → erro no campo.
- Preço 0 → erro no preço.
- Tudo certo → volta pra lista com o item novo e o seu nome na coluna do dono.

---

## R7 – Fazer uma compra

**1. No terminal (nessa ordem):**

```bash
php artisan make:model Venda                         # trocar: [E]
php artisan make:migration create_vendas_table          # trocar: [F]
php artisan make:migration create_produto_venda_table   # trocar: [H]
```

> A pivô tem que ser criada **por último**. Senão dá erro de "foreign key" no migrate.

**2. Abra `database/migrations/..._create_vendas_table.php`** — trocar: [F]

```php
Schema::create('vendas', function (Blueprint $table) {    // trocar: [F]
    $table->id();
    $table->foreignId('cliente_id')->constrained('users'); // trocar: [G]
    $table->timestamps();
});
```

No `down()`: `Schema::dropIfExists('vendas');` — trocar: [F]

**3. Abra `database/migrations/..._create_produto_venda_table.php`** — trocar: [H]

```php
Schema::create('produto_venda', function (Blueprint $table) {                   // trocar: [H]
    $table->id();
    $table->foreignId('venda_id')->constrained('vendas')->cascadeOnDelete();    // trocar: [E] no singular + _id, e [F]
    $table->foreignId('produto_id')->constrained('produtos');                   // trocar: [A] no singular + _id, e [B]
    $table->integer('quantidade');
    $table->decimal('preco_unitario', 8, 2);
    $table->timestamps();
});
```

No `down()`: `Schema::dropIfExists('produto_venda');` — trocar: [H]

> Ex. com outro tema: `pedido_id` → `constrained('pedidos')` e `evento_id` → `constrained('eventos')`.

**4. Abra `app/Models/Venda.php`** — trocar: [E]
Dentro da classe, cole:

```php
protected $fillable = ['cliente_id'];   // trocar: [G]

public function produtos()                       // trocar: [B] (nome da relacao no contrato)
{
    return $this->belongsToMany(Produto::class)   // trocar: [A]
        ->withPivot('quantidade', 'preco_unitario')
        ->withTimestamps();
}
```

> Se o nome da pivô no contrato **não** seguir a regra (singular + ordem alfabética), informe o nome: `belongsToMany(Produto::class, 'nome_da_pivo')`.

**5. No terminal:** `php artisan migrate:fresh --seed`

**6. Abra `app/Http/Controllers/CompraController.php`** — trocar: [N]

No topo, cole:

```php
use App\Models\Venda;   // trocar: [E]
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
```

Troque a função `store` por (já inclui o bônus):

```php
public function store(Request $request)
{
    // tira os itens com quantidade 0
    $itens = collect($request->input('itens', []))
        ->map(fn ($quantidade) => (int) $quantidade)
        ->filter(fn ($quantidade) => $quantidade > 0);

    if ($itens->isEmpty()) {
        return back()->withErrors(['itens' => 'Escolha pelo menos um item.'])->withInput();
    }

    $produtos = Produto::whereIn('id', $itens->keys())->get()->keyBy('id');   // trocar: [A]

    // bonus: confere o estoque
    foreach ($itens as $produtoId => $quantidade) {
        $produto = $produtos->get($produtoId);

        if (! $produto) {
            return back()->withErrors(['itens' => 'Item inválido.'])->withInput();
        }

        if ($quantidade > $produto->estoque) {   // trocar: [L]
            return back()
                ->withErrors(['itens' => "Estoque insuficiente para {$produto->nome}."])
                ->withInput();
        }
    }

    DB::transaction(function () use ($itens, $produtos) {
        // cria a compra
        $venda = Venda::create(['cliente_id' => Auth::id()]);   // trocar: [E] [G]

        foreach ($itens as $produtoId => $quantidade) {
            $produto = $produtos->get($produtoId);

            // salva o item na tabela pivo
            $venda->produtos()->attach($produtoId, [   // trocar: [B] (nome da relacao)
                'quantidade' => $quantidade,
                'preco_unitario' => $produto->preco,
            ]);

            // bonus: diminui o estoque
            $produto->decrement('estoque', $quantidade);   // trocar: [L]
        }
    });

    return redirect()->route('compras.index')->with('sucesso', 'Compra realizada!');   // trocar: [P] [Q]
}
```

> O formulário de compra manda `itens[id] = quantidade`. Se na prova o campo tiver outro nome (diferente de `itens`), troque no `$request->input('itens', [])`.

✅ **Teste** (logado como cliente): quantidade 2 num item e 1 em outro → vai pra página de compras com a mensagem de sucesso.

---

## R8 – Minhas compras

**Ainda no controller da compra [N]**, troque a função `index` por:

```php
public function index()
{
    $vendas = Venda::with('produtos')           // trocar: [F] [E] [B]
        ->where('cliente_id', Auth::id())       // trocar: [G]
        ->orderByDesc('created_at')
        ->get();

    return view('compras.index', compact('vendas'));   // trocar: nome da view e [F] (confira na view)
}
```

✅ **Teste:** o cliente vê a compra dele com os itens e o total. Entrando com outro cliente, a compra do primeiro **não** aparece.

---

## Bônus – Estoque

Já está pronto no código do R7 (as linhas com `// bonus`).

✅ **Teste:** quantidade maior que o estoque → volta com erro. Comprar 1 → o estoque diminui 1.

---

## Deu erro?

| O que aparece | O que fazer |
|---|---|
| "... não semeados" | Confira os nomes das colunas [I] na migration e rode `php artisan migrate:fresh --seed` |
| Lista vazia | O nome no `compact('...')` tem que ser igual ao da view |
| 403 até pro dono no cadastrar | Troque `false` por `true` no `authorize` do Request |
| `Target class [vendedor] does not exist` | Faltou o passo 3 do R3/R4 (`bootstrap/app.php`), ou o apelido [C] está diferente nos dois arquivos |
| `Class "..." not found` | Faltou um `use` no topo do arquivo, ou o nome [A]/[E] está escrito diferente |
| Um campo não salva | Faltou a coluna no `$fillable` |
| Erro de "foreign key" no migrate | A migration da pivô [H] tem que ser criada **depois** da tabela da compra [F] |
| Quantidade e preço vazios em Minhas compras | Faltou o `withPivot(...)` na model da compra [E] |
| `Route [...] not defined` | Você mudou um nome de rota. Volte como estava |
| `no such table` | O nome da tabela na migration está diferente de [B]/[F]/[H] |

---

## Antes de entregar

1. Rode `php artisan migrate:fresh --seed` → sem erro.
2. Faça os testes ✅ de cada parte.
3. Compacte a pasta inteira em `.zip` e envie.