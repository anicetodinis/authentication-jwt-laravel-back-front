<?php


use Illuminate\Support\Facades\Route;

// Rota de Login (Pública)
Route::get('/login', function () {
    return view('auth.login');
})->name('login'); //->middleware('CheckToken');

// Rotas Protegidas (Dashboard e CRUD de Utilizadores)
Route::group(['middleware' => ['web']], function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('app.dashboard'); // Usará o layout mestre
    })->name('dashboard');

    // CRUD de Utilizadores
    Route::get('/users', function () {
        return view('app.users.index'); // Onde ficará a lista de utilizadores
    })->name('users.index');

    // Redirecionar a raiz para login
    Route::get('/', function () {
        return redirect()->route('login');
    });
});
