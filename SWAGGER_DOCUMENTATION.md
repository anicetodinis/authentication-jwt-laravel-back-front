# Swagger/OpenAPI - Documentação da API Furo

Este documento explica como usar a documentação Swagger da API Furo.

## 🎯 Introdução

A API utiliza **OpenAPI 3.0** (anteriormente conhecido como Swagger) para documentar todos os endpoints disponíveis. A documentação é gerada automaticamente a partir das anotações nos controladores PHP.

## 📍 Acessar a Documentação

### Interface Web (Swagger UI)
```
http://localhost:8000/api/docs
```

### JSON OpenAPI (para integração)
```
http://localhost:8000/api/documentation
```

## 🔐 Autenticação JWT

Todos os endpoints (exceto `/api/login`) requerem um token JWT válido.

### Fluxo de Autenticação

1. **Login**
   ```bash
   POST /api/login
   Content-Type: application/json

   {
     "email": "user@example.com",
     "password": "password123"
   }
   ```

2. **Resposta**
   ```json
   {
     "access_token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
     "token_type": "bearer",
     "expires_in": 3600,
     "user": {
       "id": 1,
       "name": "Nome do Utilizador",
       "email": "user@example.com"
     }
   }
   ```

3. **Usar o Token em Requisições**
   ```bash
   GET /api/me
   Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGc...
   ```

## 📚 Grupos de Endpoints

### 1. **Auth** (Autenticação)
- `POST /api/login` - Efetuar login
- `POST /api/logout` - Efetuar logout (requer autenticação)
- `GET /api/me` - Obter dados do utilizador autenticado (requer autenticação)

### 2. **Users** (Gestão de Utilizadores)
- `GET /api/users` - Listar utilizadores (requer role: admin|super-admin)
- `GET /api/users/{id}` - Obter dados de um utilizador
- `POST /api/users` - Criar novo utilizador (requer permissão: create users)
- `PUT /api/users/{id}` - Atualizar utilizador (requer permissão: edit users ou role: super-admin)
- `DELETE /api/users/{id}` - Deletar utilizador (requer permissão: delete users)

### 3. **Roles** (Gestão de Papéis)
- `GET /api/roles` - Listar papéis (requer permissão: manage roles)
- `GET /api/roles/{id}` - Obter detalhes de um papel
- `POST /api/roles` - Criar novo papel (requer permissão: manage roles)
- `PUT /api/roles/{id}` - Atualizar papel (requer permissão: manage roles)

### 4. **Permissions** (Gestão de Permissões)
- `GET /api/permissions` - Listar permissões (requer permissão: manage permissions)
- `POST /api/permissions` - Criar nova permissão (requer permissão: manage permissions)
- `DELETE /api/permissions/{id}` - Deletar permissão (requer permissão: manage permissions)

## 🛠️ Como Usar a Swagger UI

### 1. Autenticar-se
- Accede a `http://localhost:8000/api/docs`
- Clica no botão **"Authorize"** no topo da página
- Cole o token JWT no campo `Authorization: Bearer`
- Clique em **"Authorize"**

### 2. Testar Endpoints
- Seleciona um endpoint na lista
- Clica em **"Try it out"**
- Preenche os parâmetros necessários
- Clica em **"Execute"** para enviar a requisição

### 3. Ver Resultados
- Vês a resposta da API (status code, headers, body)
- Podes ver exemplos de requisições e respostas

## 📋 Códigos de Status HTTP

- **200** - OK (Sucesso)
- **201** - Created (Recurso criado com sucesso)
- **204** - No Content (Sucesso, sem conteúdo)
- **400** - Bad Request (Parâmetros inválidos)
- **401** - Unauthorized (Requer autenticação)
- **403** - Forbidden (Sem permissão)
- **404** - Not Found (Recurso não encontrado)
- **422** - Unprocessable Entity (Validação falhou)
- **500** - Internal Server Error (Erro do servidor)

## 🔄 Exemplo de Fluxo Completo

### 1. Login
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@example.com",
    "password": "password123"
  }'
```

**Resposta:**
```json
{
  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "token_type": "bearer",
  "expires_in": 3600,
  "user": {
    "id": 1,
    "name": "Admin",
    "email": "admin@example.com"
  }
}
```

### 2. Obter Token
```bash
TOKEN="eyJ0eXAiOiJKV1QiLCJhbGc..."
```

### 3. Listar Utilizadores
```bash
curl -X GET http://localhost:8000/api/users \
  -H "Authorization: Bearer $TOKEN"
```

### 4. Criar Novo Utilizador
```bash
curl -X POST http://localhost:8000/api/users \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Novo Utilizador",
    "email": "novo@example.com",
    "password": "password123"
  }'
```

### 5. Logout
```bash
curl -X POST http://localhost:8000/api/logout \
  -H "Authorization: Bearer $TOKEN"
```

## 🔌 Integração com Postman

1. Acede a `http://localhost:8000/api/documentation`
2. Copia o JSON completo
3. No Postman, vá a **File** → **Import**
4. Cola o JSON e importa a collection
5. Configure a variável de ambiente `token` para armazenar o JWT

## 📖 Esquemas de Dados

### User
```json
{
  "id": 1,
  "name": "João Silva",
  "email": "joao@example.com",
  "created_at": "2025-03-20T10:30:00Z",
  "updated_at": "2025-03-20T10:30:00Z"
}
```

### Role
```json
{
  "id": 1,
  "name": "admin",
  "permissions": [
    {
      "id": 1,
      "name": "create users"
    },
    {
      "id": 2,
      "name": "edit users"
    }
  ]
}
```

### Permission
```json
{
  "id": 1,
  "name": "create users",
  "created_at": "2025-03-20T10:30:00Z"
}
```

## ⚙️ Adicionar Novos Endpoints

Para adicionar um novo endpoint documentado com Swagger:

1. **Cria o controlador e método**
   ```php
   public function store(Request $request)
   {
       // Lógica...
   }
   ```

2. **Adiciona as anotações OpenAPI**
   ```php
   /**
    * @OA\Post(
    *     path="/recursos",
    *     tags={"Recursos"},
    *     summary="Criar novo recurso",
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(...)
    *     ),
    *     @OA\Response(response=201, description="Recurso criado")
    * )
    */
   public function store(Request $request) { }
   ```

3. **A documentação será atualizada automaticamente**

## 🐛 Troubleshooting

### Token Expirado
Se receberes erro `401 Unauthorized`:
1. Faz login novamente para obter um novo token
2. Atualiza a autenticação no Swagger UI

### Endpoint Não Aparece
1. Verifica se as anotações estão corretas
2. Recarrega a página do Swagger UI
3. Verifica a sintaxe das anotações OpenAPI

### Problemas de CORS
Se tiver problemas de CORS ao testar do Swagger UI:
1. Verifica a configuração de CORS em `config/cors.php`
2. Adiciona `localhost:8000` aos origins permitidos

## 📝 Referências

- [OpenAPI 3.0 Specification](https://spec.openapis.org/oas/v3.0.3)
- [Swagger UI](https://github.com/swagger-api/swagger-ui)
- [JWT Auth Laravel](https://github.com/tymondessy/jwt-auth)

---

**Última atualização:** Março 2025
