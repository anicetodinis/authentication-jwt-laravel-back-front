<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckJwtToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar se o token JWT está no localStorage do cliente
        // Nota: O token é armazenado no localStorage do front-end após login
        // Aqui fazemos uma verificação simples: se a sessão não tem o user, redireciona para login
        
        // Opção 1: Verificar se tem token no header (para AJAX)
        $token = $request->bearerToken();
        
        // Opção 2: Se não tiver token no header, verificar na sessão
        // (pode ser necessário sincronizar o token da API para a sessão)
        if (!$token && !auth('api')->check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar autenticado.');
        }

        return $next($request);
    }
}
