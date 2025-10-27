<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Se a requisição não for AJAX/API, não podemos verificar o JWT no servidor.
        // A verificação de validade do token é feita pelo JS/Axios.
        // Apenas verificamos se o usuário está tentando acessar a rota de login/registro.

        // Se o usuário tentar acessar login/register, mas JÁ tem um token no localstorage
        // (Isso é uma simplificação, a verificação robusta é no lado do cliente)
        if ($request->routeIs('login') && $request->cookie('jwt_token')) {
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
