<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/users",
     *     operationId="getUsers",
     *     tags={"Users"},
     *     summary="Listar utilizadores",
     *     description="Retorna uma lista paginada de utilizadores",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Número da página",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de utilizadores",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="email", type="string")
     *             )),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Não autenticado"),
     *     @OA\Response(response=403, description="Sem permissão")
     * )
     */
    /**
     * Display a listing of the resource.
     */
    public function index($id=null)
    {
        if ($id) {
            $user = User::findOrFail($id);
            return new UserResource($user);
        }
        // Exemplo de paginação
        $users = User::paginate(10); 
        return UserResource::collection($users);
    }

    /**
     * @OA\Post(
     *     path="/users",
     *     operationId="storeUser",
     *     tags={"Users"},
     *     summary="Criar novo utilizador",
     *     description="Cria um novo utilizador no sistema",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password"},
     *             @OA\Property(property="name", type="string", example="João Silva"),
     *             @OA\Property(property="email", type="string", format="email", example="joao@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *             @OA\Property(property="role_id", type="integer", example=1),
     *             @OA\Property(property="permissions", type="array", @OA\Items(type="string"))
     *         )
     *     ),
     *     @OA\Response(response=201, description="Utilizador criado com sucesso"),
     *     @OA\Response(response=401, description="Não autenticado"),
     *     @OA\Response(response=403, description="Sem permissão")
     * )
     */
    // 2. Criar novo: /api/users (POST)
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            // O StoreUserRequest deve garantir que password e password_confirmation existam
            'password' => Hash::make($request->password), 
        ]);

        // Atribuir roles ou permissões se fornecido
        if ($request->has('role_id')) {
            $user->assignRole($request->role_id);
        }
        if ($request->has('permissions')) {
            $user->givePermissionTo($request->permissions);
        }

        return new UserResource($user);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

         // Atribuir roles ou permissões se fornecido
        if ($request->has('role_id')) {
            $user->assignRole($request->role_id);
        }

        //$token = $this->make('auth')->guard('api')->login($user);
        return new UserResource($user);
        //return $this->respondWithToken($token);
    }

    /**
     * @OA\Get(
     *     path="/users/{id}",
     *     operationId="getUserById",
     *     tags={"Users"},
     *     summary="Obter dados de um utilizador",
     *     description="Retorna os detalhes de um utilizador específico",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do utilizador",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dados do utilizador",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Utilizador não encontrado")
     * )
     */
    // 3. Mostrar detalhe: /api/users/{user} (GET)
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * @OA\Put(
     *     path="/users/{id}",
     *     operationId="updateUser",
     *     tags={"Users"},
     *     summary="Atualizar utilizador",
     *     description="Atualiza os dados de um utilizador específico",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do utilizador",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string", format="password")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Utilizador atualizado com sucesso"),
     *     @OA\Response(response=404, description="Utilizador não encontrado"),
     *     @OA\Response(response=403, description="Sem permissão")
     * )
     */
    // 4. Atualizar: /api/users/{user} (PUT/PATCH)
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        
        // Se a senha foi fornecida, faça o hash
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            // Remove 'password' para não tentar atualizar com vazio/null
            unset($data['password']); 
        }

        $user->update($data);

        return new UserResource($user);
    }

    /**
     * @OA\Delete(
     *     path="/users/{id}",
     *     operationId="deleteUser",
     *     tags={"Users"},
     *     summary="Deletar utilizador",
     *     description="Remove um utilizador do sistema",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do utilizador",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Utilizador deletado com sucesso"),
     *     @OA\Response(response=404, description="Utilizador não encontrado"),
     *     @OA\Response(response=403, description="Sem permissão")
     * )
     */
    // 5. Deletar: /api/users/{user} (DELETE)
    public function destroy(User $user)
    {
        $user->delete();
        
        // Resposta HTTP 204 No Content para deleção bem-sucedida
        return response()->noContent(); 
    }
}
