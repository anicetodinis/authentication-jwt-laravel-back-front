<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Exemplo de paginação
        $users = User::paginate(10); 
        return UserResource::collection($users);
    }

    // 2. Criar novo: /api/users (POST)
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            // O StoreUserRequest deve garantir que password e password_confirmation existam
            'password' => Hash::make($request->password), 
        ]);

        return new UserResource($user);
    }

    // 3. Mostrar detalhe: /api/users/{user} (GET)
    public function show(User $user)
    {
        return new UserResource($user);
    }

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

    // 5. Deletar: /api/users/{user} (DELETE)
    public function destroy(User $user)
    {
        $user->delete();
        
        // Resposta HTTP 204 No Content para deleção bem-sucedida
        return response()->noContent(); 
    }
}
