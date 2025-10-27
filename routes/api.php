<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
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
    Route::resource('users', UserController::class)->except(['create', 'edit']);
});