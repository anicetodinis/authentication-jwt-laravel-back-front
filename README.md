# Sistema de Gestão de Contenciosos

## Sobre o Projeto

Sistema de gestão de contenciosos desenvolvido com Laravel e Vue.js, utilizando o tema Metronic para a interface do usuário. O sistema implementa autenticação JWT, controle de acesso baseado em roles e permissões, e uma arquitetura modular para fácil manutenção e escalabilidade.

## Tecnologias Utilizadas

### Backend
- Laravel 10.x
- PHP 8.1+
- JWT Authentication
- Spatie Laravel Permission
- MySQL/MariaDB

### Frontend
- Vue.js
- Axios para requisições HTTP
- Metronic Theme 8
- Bootstrap 5

### Ferramentas de Desenvolvimento
- Composer
- NPM
- Git
- Visual Studio Code

## Estrutura do Projeto

```
contenciosos-app/
├── app/                    # Código principal da aplicação
│   ├── Http/              # Controllers, Middleware, Resources
│   ├── Models/            # Models do Eloquent
│   └── Policies/          # Políticas de autorização
├── config/                # Arquivos de configuração
├── database/              # Migrations e Seeders
├── public/                # Arquivos públicos e assets
├── resources/             # Views e assets não compilados
│   ├── js/               # Código JavaScript
│   ├── css/              # Estilos
│   └── views/            # Templates Blade
├── routes/                # Definições de rotas
└── tests/                # Testes automatizados
```

## Requisitos

- PHP >= 8.1
- Composer
- Node.js >= 16.x
- MySQL >= 8.0
- Extensões PHP:
  - BCMath
  - Ctype
  - JSON
  - Mbstring
  - OpenSSL
  - PDO
  - Tokenizer
  - XML

## Instalação e Configuração

1. Clone o repositório:
```bash
git clone [url-do-repositorio]
```

2. Instale as dependências PHP:
```bash
composer install
```

3. Instale as dependências JavaScript:
```bash
npm install
```

4. Configure o ambiente:
```bash
cp .env.example .env
php artisan key:generate
```

5. Configure o banco de dados no arquivo .env

6. Execute as migrations e seeders:
```bash
php artisan migrate:fresh --seed
```

7. Gere a chave JWT:
```bash
php artisan jwt:secret
```

## Comandos Úteis

### Desenvolvimento
```bash
# Iniciar servidor de desenvolvimento
php artisan serve

# Compilar assets
npm run dev

# Compilar assets para produção
npm run build

# Limpar cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Criar nova migration
php artisan make:migration create_nome_tabela_table

# Criar novo controller
php artisan make:controller Api/RoleController --resource
php artisan make:resource RoleResource

# Criar novo model com migration
php artisan make:model Nome -m
```

## Fluxo de Desenvolvimento

### 1. Planejamento
- Definir requisitos da funcionalidade
- Identificar modelos e relacionamentos necessários
- Planejar estrutura de rotas e controllers
- Definir permissões necessárias

### 2. Desenvolvimento Backend

#### 2.1 Criação da Estrutura Básica
```bash
# 1. Criar o Model com Migration (se necessário)
php artisan make:model NomeModel -m

# 2. Criar Controller REST com referência ao Model
php artisan make:controller Api/NomeController --resource --model=NomeModel

# 3. Criar Form Requests para validação
php artisan make:request StoreNomeRequest
php artisan make:request UpdateNomeRequest

# 4. Criar Resource para formatação da API
php artisan make:resource NomeResource

# 5. Criar Policy para autorização (opcional)
php artisan make:policy NomePolicy --model=NomeModel
```

Exemplo prático para um CRUD de Usuários:
```bash
# Estrutura do Controller com Model
php artisan make:controller Api/UserController --resource --model=User

# Requests para validação
php artisan make:request StoreUserRequest
php artisan make:request UpdateUserRequest

# Resource para formatação da resposta
php artisan make:resource UserResource
```

#### 2.2 Desenvolvimento dos Componentes

1. **Migration** (`database/migrations/xxxx_create_nomes_table.php`):
```php
public function up()
{
    Schema::create('nomes', function (Blueprint $table) {
        $table->id();
        $table->string('campo1');
        $table->text('campo2');
        $table->timestamps();
    });
}
```

2. **Model** (`app/Models/Nome.php`):
```php
class Nome extends Model
{
    protected $fillable = ['campo1', 'campo2'];
    
    // Relacionamentos
    public function outroModel()
    {
        return $this->belongsTo(OutroModel::class);
    }
}
```

3. **Form Requests** (`app/Http/Requests/StoreNomeRequest.php`):
```php
public function rules()
{
    return [
        'campo1' => 'required|string|max:255',
        'campo2' => 'required|string'
    ];
}
```

4. **Resource** (`app/Http/Resources/NomeResource.php`):
```php
public function toArray($request)
{
    return [
        'id' => $this->id,
        'campo1' => $this->campo1,
        'campo2' => $this->campo2,
        'created_at' => $this->created_at->format('d/m/Y H:i:s')
    ];
}
```

5. **Controller** (`app/Http/Controllers/Api/NomeController.php`):
```php
public function index()
{
    $items = Nome::paginate(10);
    return NomeResource::collection($items);
}

public function store(StoreNomeRequest $request)
{
    $item = Nome::create($request->validated());
    return new NomeResource($item);
}
```

6. **Rotas** (`routes/api.php`):
```php
Route::apiResource('nomes', NomeController::class);
```

#### 2.3 Implementação de Permissões

1. **Criar Permissões**:
```php
// No seeder ou migration
Permission::create(['name' => 'view nomes']);
Permission::create(['name' => 'create nomes']);
Permission::create(['name' => 'edit nomes']);
Permission::create(['name' => 'delete nomes']);
```

2. **Adicionar Middleware nas Rotas**:
```php
Route::middleware(['auth:api', 'permission:view nomes'])
    ->apiResource('nomes', NomeController::class);
```

3. **Policy** (`app/Policies/NomePolicy.php`):
```php
public function viewAny(User $user)
{
    return $user->hasPermissionTo('view nomes');
}
```

### 3. Desenvolvimento Frontend
1. Criar/atualizar views Blade
2. Implementar componentes JavaScript
3. Adicionar chamadas à API
4. Implementar validação de formulários
5. Adicionar feedback visual para o usuário
6. Implementar controle de acesso na interface

### 4. Testes e Validação
1. Testar funcionalidade completa
2. Verificar permissões e autorização
3. Validar feedback de erros
4. Testar em diferentes resoluções
5. Verificar performance

### 5. Documentação
1. Atualizar README se necessário
2. Documentar novas rotas da API
3. Atualizar documentação de permissões
4. Documentar mudanças no banco de dados

## Padrões de Código

- PSR-12 para PHP
- Airbnb Style Guide para JavaScript
- BEM para CSS
- Commits seguindo Conventional Commits

## Segurança

- Todas as requisições devem ser autenticadas via JWT
- Validar todas as entradas de usuário
- Usar policies para autorização
- Sanitizar saída de dados
- Manter logs de ações importantes

## Suporte

Para reportar bugs ou sugerir melhorias, abra uma issue no repositório do projeto.

## Licença

Este projeto é software proprietário. Todos os direitos reservados.


