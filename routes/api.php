<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\PermissionController;
use Illuminate\Support\Facades\Route;

// Rotas de Autenticação (Públicas)
Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

// Rotas Protegidas (Exige Token JWT Válido)
Route::middleware('auth:api')->group(function () {
    // Auth
    Route::controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout');
        Route::get('me', 'me'); // Obter dados do usuário logado
    });

    // CRUD de Utilizadores
    Route::prefix('users')->controller(UserController::class)->group(function () {
        
        // Exige que o usuário tenha a role 'admin'
        Route::get('/', 'index')->middleware('role:admin'); 
        
        // Exige a permissão 'create users'
        Route::post('/', 'store')->middleware('permission:create users'); 

        Route::post('/registar', 'register')->middleware('permission:create users'); 
        
        // Exige a permissão 'edit users' ou a role 'super-admin'
        Route::put('/{user}', 'update')->middleware('role_or_permission:super-admin|edit users'); 
        
        // Exige a permissão 'delete users'
        Route::delete('/{user}', 'destroy')->middleware('permission:delete users'); 
    });

    // CRUD de Papéis (Roles)
    // Exigir que apenas usuários com a permissão 'manage roles' possam acessar
    Route::resource('roles', RoleController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy'])
        ->middleware('permission:manage roles'); 

    // CRUD de Permissões (Permissions)
    // Exigir que apenas usuários com a permissão 'manage permissions' possam acessar
    Route::resource('permissions', PermissionController::class)
        ->only(['index', 'store', 'show', 'destroy'])
        ->middleware('permission:manage permissions');
});