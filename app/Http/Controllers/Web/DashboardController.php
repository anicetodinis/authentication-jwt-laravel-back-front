<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\UserResource;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Usar middleware que valida SESSÃO web OU JWT
        // Exceções: login (público) e webLogin (cria sessão depois do JWT)
        $this->middleware(\App\Http\Middleware\EnsureWebOrJwtAuth::class)->except(['login', 'webLogin']);
    }

    public function login()
    {
        // Se já está autenticado, redireciona para dashboard
        if (auth('api')->check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function dashboard()
    {
        // A autenticação é verificada pelo middleware
        $user = auth('web')->user();
        //dd(new UserResource($user));
        return view('app.dashboard', ['user' => $user]);
    }

    public function usersIndex()
    {
        // A autenticação é verificada pelo middleware
        $user = auth('web')->user();
        return view('app.users.index', ['user' => $user]);
    }

    public function settingsRoles()
    {
        // A autenticação é verificada pelo middleware
        $user = auth('web')->user();
        return view('app.settings.roles', ['user' => $user]);
    }

    public function settingsPermissions()
    {
        // A autenticação é verificada pelo middleware
        $user = auth('web')->user();
        return view('app.settings.permissions', ['user' => $user]);
    }

    /**
     * Endpoint usado para criar uma sessão web a partir do token JWT.
     * Recebe o token no body (ou cookie) e autentica o usuário no guard web.
     */
    public function webLogin(Request $request)
    {
        $token = $request->input('token') ?: $request->cookie('jwt_token');

        if (! $token) {
            return response()->json(['message' => 'Token ausente'], 400);
        }

        try {
            // Autentica o token e obtém o usuário
            $user = JWTAuth::setToken($token)->authenticate();

            if (! $user) {
                return response()->json(['message' => 'Token inválido'], 401);
            }

            // Faz login no guard web para criar sessão baseada em cookie de sessão
            Auth::guard('web')->login($user);
            $request->session()->regenerate();

            Log::info('Web session created for user: ' . $user->email);
            return response()->json(['message' => 'Sessão criada']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar sessão: ' . $e->getMessage()], 401);
        }
    }


    public function webLogout(Request $request)
    {
        // Logout do guard web (remove auth session)
        \Illuminate\Support\Facades\Auth::guard('web')->logout();

        // Invalidar sessão e regenerar token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Se definiste um cookie 'jwt_token' no servidor ou queres ter certeza que é apagado:
        // retorna um response com cookie expirado
        $forgetCookie = cookie()->forget('jwt_token');

        return response()->json(['message' => 'Sessão terminada'])->withCookie($forgetCookie);
    }
}
