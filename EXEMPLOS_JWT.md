# Exemplos de Código - JWT em Rotas Web

## 🔐 Casos de Uso Comuns

### 1. Proteger Rota Web

#### Antes (SEM PROTEÇÃO)
```php
// routes/web.php
Route::get('/dashboard', function () {
    return view('app.dashboard');
})->name('dashboard');
```

#### Depois (COM PROTEÇÃO)
```php
// routes/web.php
Route::middleware('auth:api')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
});
```

---

### 2. Proteger Rota com Role Específica

```php
// routes/api.php
Route::delete('/users/{user}', [UserController::class, 'destroy'])
    ->middleware('permission:delete users');
```

Na view, você pode verificar a permissão:

```blade
{{-- resources/views/app/users/index.blade.php --}}
@if (auth('api')->user()?->hasPermissionTo('delete users'))
    <button onclick="handleDeleteUser({{ $user->id }})">Eliminar</button>
@endif
```

---

### 3. Acessar Usuário Autenticado na View

#### No Controlador
```php
// app/Http/Controllers/Web/DashboardController.php
public function dashboard()
{
    $user = auth('api')->user();
    return view('app.dashboard', ['user' => $user]);
}
```

#### Na View
```blade
{{-- resources/views/app/dashboard.blade.php --}}
<h1>Bem-vindo, {{ $user->name }}!</h1>
<p>Email: {{ $user->email }}</p>

{{-- Mostrar roles --}}
@foreach ($user->getRoleNames() as $role)
    <span class="badge">{{ $role }}</span>
@endforeach
```

---

### 4. Verificar Permissão na View

```blade
{{-- Verificar permissão --}}
@if ($user->hasPermissionTo('edit users'))
    <button onclick="handleEditUser({{ $user->id }})">Editar</button>
@endif

{{-- Verificar role --}}
@if ($user->hasRole('admin'))
    <a href="/settings">Configurações</a>
@endif

{{-- Verificar múltiplas permissões --}}
@if ($user->hasAnyPermission(['edit users', 'delete users']))
    <div class="admin-panel">
        {{-- Conteúdo administrativo --}}
    </div>
@endif
```

---

### 5. Redirecionar Usuário Não Autorizado

#### Middleware Customizado
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = auth('api')->user();
        
        if (!$user || !$user->hasPermissionTo($permission)) {
            return redirect()->route('dashboard')->with('error', 'Não autorizado');
        }
        
        return $next($request);
    }
}
```

#### Usar no Routes
```php
// routes/web.php
Route::middleware('auth:api', 'permission:manage roles')->group(function () {
    Route::get('/settings/roles', [DashboardController::class, 'settingsRoles'])->name('settings.roles');
});
```

---

### 6. Logout com Confirmação

#### View
```blade
{{-- Botão de logout --}}
<button id="logout-btn">Logout</button>

<script>
document.getElementById('logout-btn').addEventListener('click', async () => {
    if (confirm('Tem certeza que deseja sair?')) {
        await window.authManager.logout();
    }
});
</script>
```

---

### 7. Requisição AJAX com Token

#### Exemplo 1: Fetch API
```javascript
// Fetch com token automático via interceptador
const response = await fetch('/api/users', {
    method: 'GET',
    headers: {
        'Authorization': `Bearer ${localStorage.getItem('jwt_token')}`
    }
});
const data = await response.json();
```

#### Exemplo 2: Axios (Recomendado)
```javascript
// Axios injeta token automaticamente via interceptador
const response = await axios.get('/api/users');
const data = response.data;
```

#### Exemplo 3: jQuery AJAX
```javascript
$.ajax({
    url: '/api/users',
    type: 'GET',
    headers: {
        'Authorization': `Bearer ${localStorage.getItem('jwt_token')}`
    },
    success: function(data) {
        console.log(data);
    }
});
```

---

### 8. Manipular Erros de Autenticação

#### Global (Bootstrap)
```javascript
// resources/js/bootstrap.js
axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response?.status === 401) {
            localStorage.removeItem('jwt_token');
            window.location.href = '/login';
            toastr.error('Sessão expirada. Faça login novamente.');
        }
        if (error.response?.status === 403) {
            toastr.error('Você não tem permissão para esta ação');
        }
        return Promise.reject(error);
    }
);
```

#### Local (Em um Componente)
```javascript
try {
    const response = await axios.delete(`/api/users/${userId}`);
    toastr.success('Usuário deletado com sucesso');
} catch (error) {
    if (error.response?.status === 401) {
        // Token expirou
        window.authManager.logout();
    } else if (error.response?.status === 403) {
        // Sem permissão
        toastr.error('Você não tem permissão para deletar usuários');
    } else {
        // Outro erro
        toastr.error(error.response?.data?.message || 'Erro na requisição');
    }
}
```

---

### 9. Form com Validação e Token

```blade
<form id="edit-user-form">
    @csrf
    
    <input type="hidden" name="user_id" value="{{ $user->id }}">
    
    <div class="mb-3">
        <label>Nome</label>
        <input type="text" name="name" value="{{ $user->name }}" class="form-control">
        <div class="invalid-feedback" id="error-name"></div>
    </div>
    
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" value="{{ $user->email }}" class="form-control">
        <div class="invalid-feedback" id="error-email"></div>
    </div>
    
    <button type="submit" class="btn btn-primary">Guardar</button>
</form>

<script type="module">
document.getElementById('edit-user-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const form = e.target;
    const userId = form.querySelector('[name="user_id"]').value;
    const formData = new FormData(form);
    
    // Limpar erros anteriores
    form.querySelectorAll('.invalid-feedback').forEach(el => {
        el.textContent = '';
        el.style.display = 'none';
    });
    
    try {
        const response = await axios.put(`/api/users/${userId}`, {
            name: formData.get('name'),
            email: formData.get('email')
        });
        
        toastr.success('Usuário atualizado com sucesso');
        setTimeout(() => location.reload(), 1000);
        
    } catch (error) {
        // Exibir erros de validação
        const errors = error.response?.data?.errors || {};
        Object.keys(errors).forEach(field => {
            const feedback = document.getElementById(`error-${field}`);
            if (feedback) {
                feedback.textContent = errors[field][0];
                feedback.style.display = 'block';
                form.querySelector(`[name="${field}"]`).classList.add('is-invalid');
            }
        });
    }
});
</script>
```

---

### 10. Verificar Autenticação em JavaScript

```javascript
// Verificar se está autenticado
if (window.authManager.isAuthenticated()) {
    console.log('Usuário está autenticado');
    console.log('Token:', window.authManager.getToken());
} else {
    console.log('Usuário não está autenticado');
    window.location.href = '/login';
}
```

---

### 11. Sincronizar Token Entre Abas

```javascript
// Detectar quando outro usuário faz login
window.addEventListener('storage', (e) => {
    if (e.key === 'jwt_token') {
        console.log('Token foi atualizado em outra aba');
        
        if (e.newValue) {
            // Novo token foi salvo
            toastr.info('Você foi autenticado em outra aba');
        } else {
            // Token foi removido (logout)
            toastr.warning('Você foi desconectado');
            window.location.href = '/login';
        }
    }
});
```

---

### 12. Botão de Logout com Confirmação

```blade
<div class="user-menu">
    <button class="dropdown-toggle">
        {{ auth('api')->user()?->name }} <i class="ki-down"></i>
    </button>
    
    <div class="dropdown-menu">
        <a href="/profile">Perfil</a>
        <a href="/settings">Configurações</a>
        <hr>
        <button id="logout-btn" class="dropdown-item text-danger">
            <i class="ki-exit"></i> Sair
        </button>
    </div>
</div>

<script>
document.getElementById('logout-btn').addEventListener('click', async () => {
    if (confirm('Tem certeza que deseja sair?')) {
        try {
            // Faz logout na API
            await axios.post('/api/logout');
            
            // Limpa token
            window.authManager.clearToken();
            
            // Redireciona
            window.location.href = '/login';
        } catch (error) {
            console.error('Erro ao fazer logout:', error);
            // Mesmo com erro, limpa e redireciona
            window.authManager.clearToken();
            window.location.href = '/login';
        }
    }
});
</script>
```

---

### 13. Loading State em Requisições

```javascript
// Mostrar spinner enquanto requisição está em progresso
async function loadUsers() {
    const spinner = document.getElementById('loading-spinner');
    const content = document.getElementById('users-content');
    
    try {
        // Mostrar spinner
        spinner.style.display = 'block';
        content.style.display = 'none';
        
        // Fazer requisição
        const response = await axios.get('/api/users');
        
        // Renderizar dados
        renderUsers(response.data);
        
    } catch (error) {
        toastr.error('Erro ao carregar usuários');
    } finally {
        // Ocultar spinner
        spinner.style.display = 'none';
        content.style.display = 'block';
    }
}
```

---

### 14. Verificar Token Antes de Fazer Requisição

```javascript
// Utilitário para verificar se precisa fazer login
function requireAuth() {
    if (!window.authManager.isAuthenticated()) {
        toastr.warning('Por favor, faça login para continuar');
        window.location.href = '/login';
        return false;
    }
    return true;
}

// Usar em qualquer ação
document.getElementById('delete-btn').addEventListener('click', async () => {
    if (!requireAuth()) return;
    
    // Prosseguir com a ação
    await axios.delete(`/api/users/${userId}`);
});
```

---

### 15. Trabalhar com Roles e Permissões

```javascript
// Esconder/Mostrar elementos baseado em permissão
async function checkUserPermissions() {
    try {
        const response = await axios.get('/api/me');
        const user = response.data.data;
        
        // Mostrar/Ocultar elementos baseado em permissões
        if (user.permissions.includes('edit users')) {
            document.getElementById('edit-btn').style.display = 'block';
        }
        
        if (user.permissions.includes('delete users')) {
            document.getElementById('delete-btn').style.display = 'block';
        }
        
        // Mostrar/Ocultar baseado em role
        if (user.roles.some(r => r.name === 'admin')) {
            document.getElementById('admin-panel').style.display = 'block';
        }
    } catch (error) {
        console.error('Erro ao carregar permissões:', error);
    }
}

// Chamar ao carregar página
checkUserPermissions();
```

---

## 📚 Referências Rápidas

| Ação | Código |
|------|--------|
| Login | `authManager.saveToken(token)` |
| Logout | `window.logout()` ou `authManager.logout()` |
| Verificar Auth | `authManager.isAuthenticated()` |
| Obter Token | `authManager.getToken()` |
| Requição AJAX | `axios.get('/api/users')` |
| Acesso ao User | `auth('api')->user()` ou `{{ auth('api')->user()?->name }}` |
| Verificar Permissão | `$user->hasPermissionTo('edit users')` |
| Verificar Role | `$user->hasRole('admin')` |

---

**Última atualização**: 2025-12-08
