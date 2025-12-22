<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class EnsureWebOrJwtAuth
{
    /**
     * Verifica se o user está autenticado via:
     * 1. Sessão web (cookie laravel_session + Auth guard 'web')
     * 2. Ou JWT token (header Authorization: Bearer)
     * 
     * Se nenhum estiver disponível, redireciona para /login
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Verificar se tem sessão web válida
        if (auth('web')->check()) {
            Log::info('Web auth check passed for user: ' . auth('web')->user()?->email);
            return $next($request);
        }

        // 2. Se não tem sessão web, tenta validar JWT via header
        // O middleware PassJwtTokenFromLocalStorage já injetou o token no header
        if (auth('api')->check()) {
            Log::info('API auth check passed for user: ' . auth('api')->user()?->email);
            return $next($request);
        }

        // 3. Se nenhum estiver disponível, redireciona para login
        Log::warning('Auth check failed for route: ' . $request->path());
        return redirect()->route('login');
    }
}
