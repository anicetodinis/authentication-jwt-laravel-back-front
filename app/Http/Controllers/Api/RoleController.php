<?php

// app/Http/Controllers/Api/RoleController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;

class RoleController extends Controller
{
    // Listar todos os papéis (Roles)
    public function index()
    {
        // Carrega as permissões relacionadas (ansiosamente)
        $roles = Role::with('permissions')->get(); 
        return RoleResource::collection($roles);
    }

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

    // Exibir detalhes de um papel específico
    public function show($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        return new RoleResource($role);
    }

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
    
    // ... (Métodos show, update e destroy, seguindo a mesma lógica)
}