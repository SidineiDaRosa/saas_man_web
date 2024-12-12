<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        Log::info('Entrou no método login');
        // dd('Entrou no método login');

        // Aqui você pode adicionar validações e lógica personalizada para o login
        $this->validateLogin($request);

        // Attempt to log the user in
        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will redirect back to the login form with the errors.
        return $this->sendFailedLoginResponse($request);
    }

    protected function authenticated(Request $request, $user)
    {
        Log::info('Entrou no método authenticated');
        // dd('Entrou no método authenticated', $user, 'Tenant ID:', $user->tenant_id);

        $tenant = Tenant::find($user->tenant_id);
        if ($tenant) {
            $this->setTenantConnection($tenant);
        } else {
            // dd('Tenant não encontrado');
        }

        return redirect()->intended($this->redirectPath());
    }

    protected function setTenantConnection(Tenant $tenant)
    {
        // Configura a conexão com o banco de dados do tenant
        config([
            'database.connections.tenant.database' => $tenant->database_name,
            'database.connections.tenant.username' => $tenant->db_username,
            'database.connections.tenant.password' => $tenant->db_password,
        ]);

        // Defina a conexão padrão para o banco de dados do tenant
        DB::setDefaultConnection('tenant');
    }

    public function logout(Request $request)
    {
        // Fazer logout do usuário
        Log::info('Entrou no método logout');
        // dd('Entrou no método logout');

        Auth::logout();

        // Resetar a conexão padrão para a conexão principal
        DB::setDefaultConnection(config('database.default'));

        // Redirecionar para a página de login
        return redirect('/login');
    }
}
