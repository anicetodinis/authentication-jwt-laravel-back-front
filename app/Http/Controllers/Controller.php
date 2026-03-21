<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\OpenApi(
 *     info=@OA\Info(
 *         version="1.0.0",
 *         title="System API",
 *         description="API de Autenticação com JWT para o Projeto",
 *         contact=@OA\Contact(
 *             email="support@furo.com"
 *         ),
 *         license=@OA\License(name="MIT")
 *     ),
 *     servers={
 *         @OA\Server(
 *             url="http://localhost:8000/api",
 *             description="Ambiente Local"
 *         ),
 *         @OA\Server(
 *             url="https://api.domin.com/api",
 *             description="Ambiente Produção"
 *         )
 *     },
 *     components=@OA\Components(
 *         securitySchemes={
 *             "bearerAuth"=@OA\SecurityScheme(
 *                 type="http",
 *                 scheme="bearer",
 *                 bearerFormat="JWT",
 *                 description="Token JWT"
 *             )
 *         }
 *     )
 * )
 */
abstract class Controller extends BaseController
{
    //
     use AuthorizesRequests, ValidatesRequests;
}
