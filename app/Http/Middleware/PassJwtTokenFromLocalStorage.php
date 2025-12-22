<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PassJwtTokenFromLocalStorage
{
    /**
     * Middleware para passar o JWT token do localStorage para o header Authorization.
     * 
     * Este middleware é executado no lado do servidor, então ele não consegue acessar
     * o localStorage do cliente. Para isso, precisamos criar um middleware JavaScript
     * que injete o token no header das requisições.
     * 
     * Para requisições de página (não AJAX), o servidor não consegue acessar o token
     * armazenado no localStorage do cliente. Portanto, vamos usar cookies como alternativa.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Se o token está no cookie, adicionar ao header Authorization
        $token = $request->cookie('jwt_token');
        
        if ($token) {
            $request->headers->set('Authorization', 'Bearer ' . $token);
        }

        return $next($request);
    }
}
