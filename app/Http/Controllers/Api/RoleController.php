<?php

// app/Http/Controllers/Api/RoleController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;

class RoleController extends Controller
{
    /**
     * @OA\Get(
     *     path="/roles",
     *     operationId="getRoles",
     *     tags={"Roles"},
     *     summary="Listar papéis",
     *     description="Retorna uma lista de todos os papéis com suas permissões",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de papéis",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="permissions", type="array")
     *             ))
     *         )
     *     ),
     *     @OA\Response(response=401, description="Não autenticado")
     * )
     */
    // Listar todos os papéis (Roles)
    public function index()
    {
        // Carrega as permissões relacionadas (ansiosamente)
        $roles = Role::with('permissions')->get(); 
        return RoleResource::collection($roles);
    }

    /**
     * @OA\Post(
     *     path="/roles",
     *     operationId="storeRole",
     *     tags={"Roles"},
     *     summary="Criar novo papel",
     *     description="Cria um novo papel no sistema",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="editor"),
     *             @OA\Property(property="permissions", type="array", @OA\Items(type="integer"), example={1,2,3})
     *         )
     *     ),
     *     @OA\Response(response=201, description="Papel criado com sucesso"),
     *     @OA\Response(response=401, description="Não autenticado")
     * )
     */
    // Criar novo papel
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles,name']);

        $role = Role::create(['name' => $request->name, 'guard_name' => 'api']);
        
        // Sincronizar permissões (se o frontend enviar uma lista de IDs)
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return new RoleResource($role);
    }

    /**
     * @OA\Get(
     *     path="/roles/{id}",
     *     operationId="showRole",
     *     tags={"Roles"},
     *     summary="Obter detalhes de um papel",
     *     description="Retorna informações detalhadas de um papel específico",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do papel",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes do papel",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="permissions", type="array")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Papel não encontrado")
     * )
     */
    // Exibir detalhes de um papel específico
    public function show($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        return new RoleResource($role);
    }

    /**
     * @OA\Put(
     *     path="/roles/{id}",
     *     operationId="updateRole",
     *     tags={"Roles"},
     *     summary="Atualizar papel",
     *     description="Atualiza as informações de um papel específico",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do papel",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="permissions", type="array", @OA\Items(type="integer"))
     *         )
     *     ),
     *     @OA\Response(response=200, description="Papel atualizado com sucesso"),
     *     @OA\Response(response=404, description="Papel não encontrado")
     * )
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
        ]);

        $role->name = $request->name;
        $role->save();

        // Sincronizar permissões (se o frontend enviar uma lista de IDs)
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return new RoleResource($role);
    }
}