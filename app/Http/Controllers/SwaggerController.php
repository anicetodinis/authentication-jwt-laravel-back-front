<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="System API",
 *     description="API RESTful com autenticação JWT"
 * ),
 * @OA\Server(
 *     url="http://localhost:8000/api",
 *     description="Servidor Local"
 * ),
 * @OA\SecurityScheme(
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="bearerAuth"
 * )
 */
class SwaggerController extends Controller
{
    /**
     * Retorna a documentação Swagger em JSON
     */
    public function json()
    {
        $swagger = [
            'openapi' => '3.0.0',
            'info' => [
                'version' => '1.0.0',
                'title' => 'System API',
                'description' => 'API RESTful com Autenticação JWT e Controle de Permissões',
                'contact' => [
                    'name' => 'Support',
                    'email' => 'support@domine.com',
                ],
                'license' => [
                    'name' => 'MIT',
                ],
            ],
            'servers' => [
                [
                    'url' => 'http://localhost:8000/api',
                    'description' => 'Servidor Local',
                ],
                [
                    'url' => 'https://api.domin.com/api',
                    'description' => 'Servidor Produção',
                ],
            ],
            'paths' => $this->getPaths(),
            'components' => [
                'securitySchemes' => [
                    'bearerAuth' => [
                        'type' => 'http',
                        'scheme' => 'bearer',
                        'bearerFormat' => 'JWT',
                    ],
                ],
                'schemas' => [
                    'User' => [
                        'type' => 'object',
                        'properties' => [
                            'id' => ['type' => 'integer', 'example' => 1],
                            'name' => ['type' => 'string', 'example' => 'João Silva'],
                            'email' => ['type' => 'string', 'format' => 'email', 'example' => 'joao@example.com'],
                            'created_at' => ['type' => 'string', 'format' => 'date-time'],
                            'updated_at' => ['type' => 'string', 'format' => 'date-time'],
                        ],
                    ],
                    'Role' => [
                        'type' => 'object',
                        'properties' => [
                            'id' => ['type' => 'integer'],
                            'name' => ['type' => 'string', 'example' => 'admin'],
                            'permissions' => [
                                'type' => 'array',
                                'items' => ['$ref' => '#/components/schemas/Permission'],
                            ],
                        ],
                    ],
                    'Permission' => [
                        'type' => 'object',
                        'properties' => [
                            'id' => ['type' => 'integer'],
                            'name' => ['type' => 'string', 'example' => 'create users'],
                            'created_at' => ['type' => 'string', 'format' => 'date-time'],
                        ],
                    ],
                ],
            ],
        ];

        return response()->json($swagger);
    }

    /**
     * Retorna a página da UI do Swagger
     */
    public function ui()
    {
        return view('swagger');
    }

    /**
     * Define todos os paths da API
     */
    private function getPaths()
    {
        return [
            '/login' => [
                'post' => [
                    'operationId' => 'login',
                    'tags' => ['Auth'],
                    'summary' => 'Efetuar login',
                    'description' => 'Autentica o utilizador com email e password',
                    'requestBody' => [
                        'required' => true,
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'required' => ['email', 'password'],
                                    'properties' => [
                                        'email' => ['type' => 'string', 'format' => 'email', 'example' => 'user@example.com'],
                                        'password' => ['type' => 'string', 'format' => 'password', 'example' => 'password123'],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'responses' => [
                        '200' => [
                            'description' => 'Login bem-sucedido',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'access_token' => ['type' => 'string'],
                                            'token_type' => ['type' => 'string'],
                                            'expires_in' => ['type' => 'integer'],
                                            'user' => ['$ref' => '#/components/schemas/User'],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        '401' => ['description' => 'Email ou password inválidos'],
                    ],
                ],
            ],
            '/logout' => [
                'post' => [
                    'operationId' => 'logout',
                    'tags' => ['Auth'],
                    'summary' => 'Logout',
                    'security' => [['bearerAuth' => []]],
                    'responses' => [
                        '200' => ['description' => 'Logout bem-sucedido'],
                        '401' => ['description' => 'Não autenticado'],
                    ],
                ],
            ],
            '/me' => [
                'get' => [
                    'operationId' => 'me',
                    'tags' => ['Auth'],
                    'summary' => 'Obter dados do utilizador autenticado',
                    'security' => [['bearerAuth' => []]],
                    'responses' => [
                        '200' => [
                            'description' => 'Dados do utilizador',
                            'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/User']]],
                        ],
                        '401' => ['description' => 'Não autenticado'],
                    ],
                ],
            ],
            '/users' => [
                'get' => [
                    'operationId' => 'getUsers',
                    'tags' => ['Users'],
                    'summary' => 'Listar utilizadores',
                    'security' => [['bearerAuth' => []]],
                    'responses' => [
                        '200' => ['description' => 'Lista de utilizadores'],
                        '401' => ['description' => 'Não autenticado'],
                    ],
                ],
                'post' => [
                    'operationId' => 'storeUser',
                    'tags' => ['Users'],
                    'summary' => 'Criar novo utilizador',
                    'security' => [['bearerAuth' => []]],
                    'requestBody' => [
                        'required' => true,
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'required' => ['name', 'email', 'password'],
                                    'properties' => [
                                        'name' => ['type' => 'string'],
                                        'email' => ['type' => 'string', 'format' => 'email'],
                                        'password' => ['type' => 'string', 'format' => 'password'],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'responses' => [
                        '201' => ['description' => 'Utilizador criado com sucesso'],
                        '401' => ['description' => 'Não autenticado'],
                    ],
                ],
            ],
            '/users/{id}' => [
                'get' => [
                    'operationId' => 'getUser',
                    'tags' => ['Users'],
                    'summary' => 'Obter dados de um utilizador',
                    'parameters' => [
                        [
                            'name' => 'id',
                            'in' => 'path',
                            'required' => true,
                            'schema' => ['type' => 'integer'],
                        ],
                    ],
                    'security' => [['bearerAuth' => []]],
                    'responses' => [
                        '200' => ['description' => 'Dados do utilizador'],
                        '404' => ['description' => 'Utilizador não encontrado'],
                    ],
                ],
                'put' => [
                    'operationId' => 'updateUser',
                    'tags' => ['Users'],
                    'summary' => 'Atualizar utilizador',
                    'parameters' => [
                        [
                            'name' => 'id',
                            'in' => 'path',
                            'required' => true,
                            'schema' => ['type' => 'integer'],
                        ],
                    ],
                    'security' => [['bearerAuth' => []]],
                    'responses' => [
                        '200' => ['description' => 'Utilizador atualizado'],
                        '404' => ['description' => 'Utilizador não encontrado'],
                    ],
                ],
                'delete' => [
                    'operationId' => 'deleteUser',
                    'tags' => ['Users'],
                    'summary' => 'Deletar utilizador',
                    'parameters' => [
                        [
                            'name' => 'id',
                            'in' => 'path',
                            'required' => true,
                            'schema' => ['type' => 'integer'],
                        ],
                    ],
                    'security' => [['bearerAuth' => []]],
                    'responses' => [
                        '204' => ['description' => 'Utilizador deletado'],
                        '404' => ['description' => 'Utilizador não encontrado'],
                    ],
                ],
            ],
            '/roles' => [
                'get' => [
                    'operationId' => 'getRoles',
                    'tags' => ['Roles'],
                    'summary' => 'Listar papéis',
                    'security' => [['bearerAuth' => []]],
                    'responses' => [
                        '200' => ['description' => 'Lista de papéis'],
                    ],
                ],
                'post' => [
                    'operationId' => 'storeRole',
                    'tags' => ['Roles'],
                    'summary' => 'Criar novo papel',
                    'security' => [['bearerAuth' => []]],
                    'responses' => [
                        '201' => ['description' => 'Papel criado'],
                    ],
                ],
            ],
            '/roles/{id}' => [
                'get' => [
                    'operationId' => 'showRole',
                    'tags' => ['Roles'],
                    'summary' => 'Obter detalhes de um papel',
                    'parameters' => [
                        [
                            'name' => 'id',
                            'in' => 'path',
                            'required' => true,
                            'schema' => ['type' => 'integer'],
                        ],
                    ],
                    'security' => [['bearerAuth' => []]],
                    'responses' => [
                        '200' => ['description' => 'Detalhes do papel'],
                    ],
                ],
                'put' => [
                    'operationId' => 'updateRole',
                    'tags' => ['Roles'],
                    'summary' => 'Atualizar papel',
                    'security' => [['bearerAuth' => []]],
                    'responses' => [
                        '200' => ['description' => 'Papel atualizado'],
                    ],
                ],
            ],
            '/permissions' => [
                'get' => [
                    'operationId' => 'getPermissions',
                    'tags' => ['Permissions'],
                    'summary' => 'Listar permissões',
                    'security' => [['bearerAuth' => []]],
                    'responses' => [
                        '200' => ['description' => 'Lista de permissões'],
                    ],
                ],
                'post' => [
                    'operationId' => 'storePermission',
                    'tags' => ['Permissions'],
                    'summary' => 'Criar nova permissão',
                    'security' => [['bearerAuth' => []]],
                    'responses' => [
                        '201' => ['description' => 'Permissão criada'],
                    ],
                ],
            ],
        ];
    }
}
