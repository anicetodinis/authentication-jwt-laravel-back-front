<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\PermissionResource;

class PermissionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/permissions",
     *     operationId="getPermissions",
     *     tags={"Permissions"},
     *     summary="Listar permissões",
     *     description="Retorna uma lista de todas as permissões disponíveis",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de permissões",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string")
     *             ))
     *         )
     *     ),
     *     @OA\Response(response=401, description="Não autenticado")
     * )
     */
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $permissions = Permission::all();
        return PermissionResource::collection($permissions);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/permissions",
     *     operationId="storePermission",
     *     tags={"Permissions"},
     *     summary="Criar nova permissão",
     *     description="Cria uma nova permissão no sistema",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="create users")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Permissão criada com sucesso"),
     *     @OA\Response(response=401, description="Não autenticado")
     * )
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate(['name' => 'required|unique:permissions,name']);
        $permission = Permission::create(['name' => $request->name, 'guard_name' => 'api']);
        return new PermissionResource($permission);
    }

    /**
     * @OA\Get(
     *     path="/permissions/{id}",
     *     operationId="showPermission",
     *     tags={"Permissions"},
     *     summary="Obter detalhes de uma permissão",
     *     description="Retorna informações detalhadas de uma permissão específica",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da permissão",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes da permissão",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="name", type="string")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Permissão não encontrada")
     * )
     */
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * @OA\Delete(
     *     path="/permissions/{id}",
     *     operationId="deletePermission",
     *     tags={"Permissions"},
     *     summary="Deletar permissão",
     *     description="Remove uma permissão do sistema",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da permissão",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Permissão deletada com sucesso"),
     *     @OA\Response(response=404, description="Permissão não encontrada")
     * )
     */
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
