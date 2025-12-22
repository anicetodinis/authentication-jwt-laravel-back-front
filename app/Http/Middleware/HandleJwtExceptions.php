<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use PHPOpenSourceSaver\JwtAuth\Exceptions\JwtException;
use PHPOpenSourceSaver\JwtAuth\Exceptions\TokenInvalidException;

class HandleJwtExceptions
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            return $next($request);
        } catch (JwtException | TokenInvalidException $e) {
            // Se for uma requisição AJAX, retornar JSON
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => 'Token inválido ou expirado',
                    'error' => $e->getMessage()
                ], 401);
            }
            
            // Caso contrário, redirecionar para login
            return redirect()->route('login')->with('error', 'Sessão expirada. Por favor, faça login novamente.');
        }
    }
}
