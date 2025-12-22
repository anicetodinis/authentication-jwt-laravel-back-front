# 🗺️ Mapa Visual - Proteção de Rotas Web com JWT

## 📊 Arquitetura do Sistema

```
┌─────────────────────────────────────────────────────────────────────────┐
│                          APLICAÇÃO CONTENCIOSOS                         │
├─────────────────────────────────────────────────────────────────────────┤
│                                                                          │
│  ┌──────────────────────────────────────────────────────────────────┐  │
│  │                       CLIENTE (Browser)                          │  │
│  │  ┌────────────────────────────────────────────────────────────┐ │  │
│  │  │  Frontend                                                  │ │  │
│  │  │  ├─ resources/views/auth/login.blade.php                 │ │  │
│  │  │  ├─ resources/views/app/dashboard.blade.php              │ │  │
│  │  │  ├─ resources/views/app/users/index.blade.php            │ │  │
│  │  │  └─ resources/views/app/settings/*.blade.php             │ │  │
│  │  └────────────────────────────────────────────────────────────┘ │  │
│  │  ┌────────────────────────────────────────────────────────────┐ │  │
│  │  │  JavaScript (Module)                                       │ │  │
│  │  │  ├─ resources/js/auth.js                                  │ │  │
│  │  │  │  ├─ class AuthManager                                  │ │  │
│  │  │  │  │  ├─ saveToken(token)                              │ │  │
│  │  │  │  │  ├─ getToken()                                    │ │  │
│  │  │  │  │  ├─ clearToken()                                  │ │  │
│  │  │  │  │  ├─ isAuthenticated()                            │ │  │
│  │  │  │  │  └─ logout()                                     │ │  │
│  │  │  │  └─ Sincronização localStorage ↔ Cookie            │ │  │
│  │  │  │                                                       │ │  │
│  │  │  ├─ resources/js/bootstrap.js                           │ │  │
│  │  │  │  ├─ axios.interceptors.request                      │ │  │
│  │  │  │  │  └─ Injeta token no header Authorization       │ │  │
│  │  │  │  └─ axios.interceptors.response                     │ │  │
│  │  │  │     └─ Trata erro 401 (redirect para /login)       │ │  │
│  │  │  │                                                       │ │  │
│  │  │  ├─ Storage: localStorage['jwt_token']                 │ │  │
│  │  │  └─ Storage: Cookie 'jwt_token'                        │ │  │
│  │  └────────────────────────────────────────────────────────────┘ │  │
│  └──────────────────────────────────────────────────────────────────┘  │
│                                                                          │
│         ↑ HTTP Request com Token ↓ HTTP Response com User Data          │
│                                                                          │
│  ┌──────────────────────────────────────────────────────────────────┐  │
│  │                      SERVIDOR (Laravel)                          │  │
│  │  ┌────────────────────────────────────────────────────────────┐ │  │
│  │  │  Rotas Web (routes/web.php)                               │ │  │
│  │  │  ├─ GET /login → Pública                                │ │  │
│  │  │  ├─ GET /dashboard → Protegida (auth:api)              │ │  │
│  │  │  ├─ GET /users → Protegida (auth:api)                 │ │  │
│  │  │  └─ GET /settings/* → Protegida (auth:api)            │ │  │
│  │  └────────────────────────────────────────────────────────────┘ │  │
│  │  ┌────────────────────────────────────────────────────────────┐ │  │
│  │  │  Controlador (app/Http/Controllers/Web/)                 │ │  │
│  │  │  ├─ DashboardController                                  │ │  │
│  │  │  │  ├─ login() → View login                            │ │  │
│  │  │  │  ├─ dashboard() → View dashboard                    │ │  │
│  │  │  │  ├─ usersIndex() → View users                       │ │  │
│  │  │  │  └─ settingsRoles() → View settings                │ │  │
│  │  │  └─ Middleware: auth:api (exceto login)                │ │  │
│  │  └────────────────────────────────────────────────────────────┘ │  │
│  │  ┌────────────────────────────────────────────────────────────┐ │  │
│  │  │  Middlewares (app/Http/Middleware/)                       │ │  │
│  │  │  ├─ PassJwtTokenFromLocalStorage.php                    │ │  │
│  │  │  │  └─ Lê token do cookie → Injeta em Authorization   │ │  │
│  │  │  ├─ HandleJwtExceptions.php                            │ │  │
│  │  │  │  └─ Trata exceções JWT → Redireciona para login   │ │  │
│  │  │  └─ CheckJwtToken.php                                  │ │  │
│  │  │     └─ Verifica validade do token                     │ │  │
│  │  └────────────────────────────────────────────────────────────┘ │  │
│  │  ┌────────────────────────────────────────────────────────────┐ │  │
│  │  │  Guard JWT (config/auth.php)                              │ │  │
│  │  │  ├─ Driver: jwt                                            │ │  │
│  │  │  ├─ Provider: Eloquent User model                         │ │  │
│  │  │  └─ TTL: 3600 segundos (1 hora)                          │ │  │
│  │  └────────────────────────────────────────────────────────────┘ │  │
│  │  ┌────────────────────────────────────────────────────────────┐ │  │
│  │  │  Autenticação JWT (config/jwt.php)                        │ │  │
│  │  │  ├─ Secret: JWT_SECRET do .env                            │ │  │
│  │  │  ├─ Algorithm: HS256                                        │ │  │
│  │  │  └─ TTL: 3600 segundos                                    │ │  │
│  │  └────────────────────────────────────────────────────────────┘ │  │
│  └──────────────────────────────────────────────────────────────────┘  │
│                                                                          │
│         ↑ POST /api/login ↓ access_token + user                        │
│                                                                          │
│  ┌──────────────────────────────────────────────────────────────────┐  │
│  │                    API (routes/api.php)                         │  │
│  │  ├─ POST /api/login → AuthController@login                    │  │
│  │  ├─ POST /api/logout → AuthController@logout                  │  │
│  │  ├─ GET /api/me → AuthController@me                           │  │
│  │  ├─ GET /api/users → UserController@index (protegida)        │  │
│  │  ├─ GET /api/users/{id} → UserController@show (protegida)    │  │
│  │  ├─ POST /api/users → UserController@store (protegida)       │  │
│  │  ├─ PUT /api/users/{id} → UserController@update (protegida)  │  │
│  │  ├─ DELETE /api/users/{id} → UserController@destroy (prot.)  │  │
│  │  └─ Middleware: auth:api (protege exceto /api/login)         │  │
│  └──────────────────────────────────────────────────────────────────┘  │
│                                                                          │
│         ↑ Usuário/Perfil ↓ Rotas Protegidas                           │
│                                                                          │
│  ┌──────────────────────────────────────────────────────────────────┐  │
│  │                        Base de Dados                             │  │
│  │  ├─ Table: users                                                 │  │
│  │  │  ├─ id, name, email, password_hash, created_at             │  │
│  │  │  └─ Relacionamento: roles, permissions                      │  │
│  │  ├─ Table: roles                                                │  │
│  │  ├─ Table: permissions                                          │  │
│  │  ├─ Table: role_has_permissions                                │  │
│  │  └─ Table: model_has_roles / model_has_permissions             │  │
│  └──────────────────────────────────────────────────────────────────┘  │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

---

## 📲 Fluxo de Login

```
┌──────────────────────────────────────────────────────────────────────────┐
│ 1. Usuário acessa /login                                                 │
├──────────────────────────────────────────────────────────────────────────┤
│ Browser GET /login                                                        │
│   ↓                                                                        │
│ DashboardController::login() (não requer auth)                           │
│   ↓                                                                        │
│ Retorna view: resources/views/auth/login.blade.php                       │
│   ↓                                                                        │
│ Formulário exibido no navegador                                          │
└──────────────────────────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────────────────────────┐
│ 2. Usuário submete credenciais                                           │
├──────────────────────────────────────────────────────────────────────────┤
│ Form submit → JavaScript event listener                                   │
│   ↓                                                                        │
│ POST /api/login { email, password }                                      │
│   ↓                                                                        │
│ AuthController::login()                                                   │
│   ├─ Valida credenciais                                                  │
│   ├─ Se válidas: Cria token JWT                                          │
│   └─ Retorna: { access_token, user, expires_in }                         │
│   ↓                                                                        │
│ JavaScript recebe resposta                                                │
│   ├─ authManager.saveToken(token) armazena em:                          │
│   │  ├─ localStorage['jwt_token']                                        │
│   │  └─ Cookie 'jwt_token' (7 dias)                                     │
│   └─ window.location.href = '/dashboard'                                │
└──────────────────────────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────────────────────────┐
│ 3. Usuário acessa rota protegida                                         │
├──────────────────────────────────────────────────────────────────────────┤
│ Browser GET /dashboard (token no cookie)                                  │
│   ↓                                                                        │
│ PassJwtTokenFromLocalStorage Middleware:                                  │
│   ├─ Lê token do cookie: jwt_token                                       │
│   └─ Injeta no header: Authorization: Bearer eyJ0e...                   │
│   ↓                                                                        │
│ auth:api Middleware (Guard JWT):                                          │
│   ├─ Extrai token do header Authorization                                │
│   ├─ Valida token JWT                                                    │
│   ├─ Se válido: recupera User do token                                   │
│   └─ auth('api')->user() ← User autenticado                             │
│   ↓                                                                        │
│ DashboardController::dashboard()                                          │
│   ├─ $user = auth('api')->user()                                         │
│   ├─ return view('app.dashboard', ['user' => $user])                    │
│   ↓                                                                        │
│ View renderizada com dados do usuário                                     │
└──────────────────────────────────────────────────────────────────────────┘
```

---

## 🔄 Fluxo de Sincronização Entre Abas

```
┌──────────────────────────────────────────────────────────────────────────┐
│ Aba 1: Login                          │  Aba 2: Dashboard                │
├─────────────────────────────────────────────────────────────────────────┤
│ 1. Usuário faz login                  │                                   │
│    ↓                                   │                                   │
│ 2. authManager.saveToken(token)       │                                   │
│    └─ localStorage['jwt_token'] = ... │                                   │
│    └─ Cookie 'jwt_token' = ...        │                                   │
│       ↓                                │                                   │
│       Event 'storage' disparado       │                                   │
│       (localStorage mudou)             │                                   │
│                                        │  3. Event listener dispara       │
│                                        │     window.addEventListener(     │
│                                        │       'storage', ...)            │
│                                        │     ↓                            │
│                                        │  4. Sincroniza token para cookie │
│                                        │     authManager.syncTokenToCookie()
│                                        │     ↓                            │
│                                        │  5. Agora tem acesso ao token    │
│                                        │     localStorage['jwt_token']    │
│                                        │     Cookie 'jwt_token'           │
└──────────────────────────────────────────────────────────────────────────┘
```

---

## 🛡️ Fluxo de Proteção de Rota

```
┌──────────────────────────────────────────────────────────────────────────┐
│ Requisição HTTP                                                          │
│ GET /dashboard (sem token)                                               │
├──────────────────────────────────────────────────────────────────────────┤
│   ↓                                                                        │
│ Middleware: PassJwtTokenFromLocalStorage                                 │
│   ├─ Tenta ler token do cookie                                           │
│   ├─ Não encontra cookie → sem header Authorization                     │
│   └─ Continua para próximo middleware                                    │
│   ↓                                                                        │
│ Middleware: auth:api                                                      │
│   ├─ Procura por Authorization header                                    │
│   ├─ Não encontra token                                                   │
│   └─ Lança exceção Unauthenticated                                      │
│   ↓                                                                        │
│ Middleware: HandleJwtExceptions                                           │
│   ├─ Captura a exceção                                                   │
│   └─ redirect('/login')->with('error', 'msg')                          │
│   ↓                                                                        │
│ Usuário é redirecionado para /login                                     │
└──────────────────────────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────────────────────────┐
│ Requisição HTTP (COM TOKEN)                                              │
│ GET /dashboard (token no cookie)                                          │
├──────────────────────────────────────────────────────────────────────────┤
│   ↓                                                                        │
│ Middleware: PassJwtTokenFromLocalStorage                                 │
│   ├─ Lê token do cookie: eyJ0eXA...                                      │
│   ├─ Injeta no header Authorization                                      │
│   └─ $request->headers['Authorization'] = 'Bearer eyJ0eXA...'           │
│   ↓                                                                        │
│ Middleware: auth:api                                                      │
│   ├─ Extrai token de Authorization header                                │
│   ├─ Valida assinatura JWT (com JWT_SECRET)                             │
│   ├─ Verifica expiração (exp claim)                                      │
│   ├─ Se válido: recupera User ID do token (sub claim)                   │
│   ├─ Consulta database para obter User                                   │
│   └─ auth('api')->user() ← User autenticado ✅                         │
│   ↓                                                                        │
│ DashboardController::dashboard()                                          │
│   ├─ Recebe requisição autenticada                                       │
│   ├─ $user = auth('api')->user() ✅                                     │
│   └─ return view('app.dashboard', ['user' => $user]) ✅               │
│   ↓                                                                        │
│ View renderizada com sucesso                                              │
└──────────────────────────────────────────────────────────────────────────┘
```

---

## 📋 Matriz de Proteção de Rotas

| Rota | Método | Pública | Middleware | Controlador |
|------|--------|---------|-----------|-------------|
| /login | GET | ✅ | - | DashboardController@login |
| / | GET | ✅ | - | Redirect |
| /dashboard | GET | ❌ | auth:api | DashboardController@dashboard |
| /users | GET | ❌ | auth:api | DashboardController@usersIndex |
| /settings/roles | GET | ❌ | auth:api | DashboardController@settingsRoles |
| /settings/permissions | GET | ❌ | auth:api | DashboardController@settingsPermissions |
| /api/login | POST | ✅ | - | AuthController@login |
| /api/logout | POST | ❌ | auth:api | AuthController@logout |
| /api/me | GET | ❌ | auth:api | AuthController@me |
| /api/users | GET | ❌ | auth:api, role:admin | UserController@index |
| /api/users/{id} | GET | ❌ | auth:api, role:admin | UserController@show |
| /api/users | POST | ❌ | auth:api, permission:create users | UserController@store |
| /api/users/{id} | PUT | ❌ | auth:api, permission:edit users | UserController@update |
| /api/users/{id} | DELETE | ❌ | auth:api, permission:delete users | UserController@destroy |

---

## 🎯 Checklist de Implementação

### Backend
- [x] DashboardController criado
- [x] Middlewares criados (3x)
- [x] routes/web.php protegidas
- [x] bootstrap/app.php registra middlewares
- [x] config/auth.php com guard JWT
- [x] Sem erros de sintaxe

### Frontend
- [x] resources/js/auth.js expandido com AuthManager
- [x] resources/js/bootstrap.js com interceptadores
- [x] resources/views/auth/login.blade.php atualizado
- [x] Sincronização localStorage ↔ cookie
- [x] Sincronização entre abas

### Documentação
- [x] JWT_PROTECTION_GUIDE.md (guia técnico)
- [x] IMPLEMENTACAO_JWT_RESUMO.md (resumo visual)
- [x] EXEMPLOS_JWT.md (15+ exemplos)
- [x] JWT_CHECKLIST.md (testes e debug)
- [x] README_JWT.md (resumo executivo)

---

## 🚀 Status da Implementação

```
┌─────────────────────────────────────────────────┐
│       PROTEÇÃO DE ROTAS WEB COM JWT            │
│                                                 │
│  Backend:      ✅ 100% Completo                │
│  Frontend:     ✅ 100% Completo                │
│  Documentação: ✅ 100% Completo                │
│  Testes:       ✅ Verificados                  │
│                                                 │
│  Status:       🚀 PRONTO PARA PRODUÇÃO        │
└─────────────────────────────────────────────────┘
```

---

**Última atualização**: 8 de Dezembro de 2025
**Versão**: 1.0
**Desenvolvido por**: GitHub Copilot
