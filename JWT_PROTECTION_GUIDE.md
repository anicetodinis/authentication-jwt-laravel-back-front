# Proteção de Rotas Web com JWT

## Visão Geral

Este projeto implementa proteção de rotas web (views) usando JWT (JSON Web Tokens) para autenticação e autorização. O sistema sincroniza o token entre localStorage (armazenamento do cliente) e cookies (para requisições web).

## Arquitetura

### 1. **Fluxo de Autenticação**

```
1. Usuário faz login em /login
2. Credenciais são enviadas para /api/login (POST)
3. API retorna um JWT token
4. Token é armazenado em localStorage e cookie
5. Usuário é redirecionado para /dashboard
6. Token é incluído em todas as requisições (header Authorization)
7. Se token expirar, usuário é redirecionado para /login
```

### 2. **Componentes Principais**

#### **Backend**

- **routes/api.php**: Rotas da API protegidas com middleware `auth:api`
- **routes/web.php**: Rotas web protegidas com middleware `auth:api`
- **DashboardController**: Controlador que serve as views e verifica autenticação
- **Middlewares**:
  - `HandleJwtExceptions`: Trata exceções do JWT
  - `PassJwtTokenFromLocalStorage`: Passa token do cookie para header
  - `CheckJwtToken`: Verifica se o token JWT é válido

#### **Frontend**

- **resources/js/auth.js**: Gerenciador de autenticação (classe `AuthManager`)
- **resources/js/bootstrap.js**: Configuração de interceptadores do Axios
- **resources/views/auth/login.blade.php**: View de login
- **resources/views/app/**: Views protegidas

### 3. **Gerenciador de Autenticação (AuthManager)**

Classe responsável por:
- Armazenar token em localStorage e cookies
- Sincronizar token entre abas do navegador
- Validar autenticação
- Gerenciar logout

**Métodos principais**:
- `saveToken(token)`: Armazena o token
- `getToken()`: Obtém o token
- `clearToken()`: Remove o token
- `isAuthenticated()`: Verifica se está autenticado
- `logout()`: Faz logout

## Fluxo de Requisições

### 1. **Requisição Inicial (GET /dashboard)**

```
Cliente                          Servidor
  |                                 |
  |-- GET /dashboard (sem token)    |
  |                                 |
  |<-- Middleware verifica cookie   |
  |                                 |
  |<-- Se cookie tem token, passa   |
  |     para header Authorization   |
  |                                 |
  |<-- auth:api verifica token      |
  |                                 |
  |<-- Sucesso: Retorna view        |
```

### 2. **Requisição AJAX/Fetch (GET /api/users)**

```
Cliente                          Servidor
  |                                 |
  |-- GET /api/users                |
  |    Authorization: Bearer ...    |
  |                                 |
  |<-- Interceptador do Axios       |
  |    injeta token no header       |
  |                                 |
  |<-- auth:api verifica token      |
  |                                 |
  |<-- Sucesso: Retorna JSON        |
```

## Configuração Passo a Passo

### 1. **Armazenar Token (Login)**

```javascript
// Em resources/views/auth/login.blade.php
authManager.saveToken(response.data.access_token);
// Armazena em:
// - localStorage['jwt_token']
// - Cookie 'jwt_token' (7 dias)
```

### 2. **Incluir Token em Requisições**

**Para requisições AJAX (axios)**:
```javascript
// Interceptador em bootstrap.js
axios.interceptors.request.use(config => {
    const token = localStorage.getItem('jwt_token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});
```

**Para requisições web (HTML)**:
```php
// Middleware PassJwtTokenFromLocalStorage
// Lê o token do cookie e passa para o header Authorization
```

### 3. **Proteger Rotas Web**

```php
// routes/web.php
Route::middleware('auth:api')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard']);
    Route::get('/users', [DashboardController::class, 'usersIndex']);
    // ... outras rotas
});
```

### 4. **Trata Erros de Autenticação**

```javascript
// Em bootstrap.js
axios.interceptors.response.use(response => response, error => {
    if (error.response && error.response.status === 401) {
        localStorage.removeItem('jwt_token');
        window.location.href = '/login';
    }
    return Promise.reject(error);
});
```

## Sincronização Entre Abas

O sistema detecta mudanças no localStorage em diferentes abas:

```javascript
// Em auth.js
window.addEventListener('storage', (e) => {
    if (e.key === this.tokenKey) {
        this.syncTokenToCookie();
    }
});
```

Se um usuário faz login em uma aba, o token é automaticamente sincronizado para as outras abas via evento `storage`.

## Segurança

### ✅ Medidas Implementadas

1. **Middleware `auth:api`**: Verifica JWT em todas as rotas protegidas
2. **Sincronização localStorage → cookies**: Permite que o servidor acesse o token
3. **SameSite Cookies**: Cookie definido com `SameSite=Strict` para proteção contra CSRF
4. **Interceptadores de Erro**: Detecta tokens expirados (401) e redireciona para login
5. **Limpeza de Token**: Remove token do armazenamento ao fazer logout

### ⚠️ Considerações Adicionais

1. **HTTPS**: Sempre usar HTTPS em produção
2. **Expiração do Token**: Configure TTL apropriado em `config/jwt.php`
3. **Refresh Token**: Considere implementar refresh tokens para tokens de longa duração
4. **CORS**: Configure CORS adequadamente em `config/cors.php`

## Testes

### 1. **Teste de Login**

```bash
# Fazer login
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"password"}'

# Resposta
{
  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "token_type": "bearer",
  "expires_in": 3600,
  "user": {...}
}
```

### 2. **Teste de Requisição Protegida**

```bash
# Com token válido
curl -X GET http://localhost:8000/api/users \
  -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGc..."

# Resposta: 200 OK com dados

# Sem token
curl -X GET http://localhost:8000/api/users

# Resposta: 401 Unauthorized
```

### 3. **Teste de Acesso a Views**

```bash
# Sem token
curl -X GET http://localhost:8000/dashboard

# Resposta: 401 ou redirecionado para /login

# Com token no cookie
curl -X GET http://localhost:8000/dashboard \
  -H "Cookie: jwt_token=eyJ0eXAiOiJKV1QiLCJhbGc..."

# Resposta: 200 OK com HTML da view
```

## Troubleshooting

### Erro: "Token inválido ou expirado"

1. Verificar se o token está sendo armazenado em localStorage
2. Verificar se o token está sendo incluído no header das requisições
3. Verificar se o TTL do token não expirou

### Erro: "Middleware auth:api não funciona"

1. Verificar se o guard padrão em `config/auth.php` é `api`
2. Verificar se o JWT está configurado corretamente em `config/jwt.php`
3. Verificar se a key JWT está definida em `.env`

### Cookies não estão sendo sincronizados

1. Verificar se o navegador permite cookies
2. Verificar se o cookie foi definido com `SameSite=Strict`
3. Verificar se o caminho do cookie é `/`

## Recursos Adicionais

- [Laravel JWT Documentation](https://github.com/PHP-Open-Source-Saver/jwt-auth)
- [Laravel Middleware](https://laravel.com/docs/middleware)
- [HTTP Cookies](https://developer.mozilla.org/en-US/docs/Web/HTTP/Cookies)
