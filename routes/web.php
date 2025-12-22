<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DashboardController;

// Rota de Login (Pública)
Route::get('/login', [DashboardController::class, 'login'])->name('login');

// Endpoint para criar sessão web a partir do token JWT (chamado pelo frontend após login)
Route::post('/session', [DashboardController::class, 'webLogin'])->name('web.session.login');
Route::post('/session/logout', [DashboardController::class, 'webLogout'])->name('web.session.logout');

// Redirecionar a raiz para dashboard ou login
Route::get('/', function () {
    return auth('web')->check() 
        ? redirect()->route('dashboard') 
        : redirect()->route('login');
});

// Rotas Protegidas (Requerem Sessão Web OU JWT Token)
// O middleware é aplicado no construtor do controller
//Route::middleware('auth:web', 'permission:manage roles')->group(function () {
Route::middleware('auth:web', 'role:admin|super-admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [DashboardController::class, 'usersIndex'])->name('users.index');
    Route::get('/settings/roles', [DashboardController::class, 'settingsRoles'])->name('settings.roles');
    Route::get('/settings/permissions', [DashboardController::class, 'settingsPermissions'])->name('settings.permissions'); 

});
