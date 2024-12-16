<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
class TenantMiddleware
{
    public function handle($request, Closure $next)
    {
        // Verifique se o usuário está autenticado
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Obtenha o tenant associado ao usuário autenticado
        $user = auth()->user();
        $tenant = $user->tenant;

        if (!$tenant) {
            return response()->json(['error' => 'Tenant não encontrado'], 404);
        }

        // Configure a conexão para o banco de dados do tenant
        config([
            'database.connections.tenant' => [
                'driver' => 'mysql',
                'host' => $tenant->database_host,
                'port' => env('DB_PORT'),
                'database' => $tenant->tenancy_db_name,
                'username' => $tenant->database_username,
                'password' => $tenant->database_password,
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
            ],
        ]);

        // Tente conectar ao banco de dados
        try {
            DB::connection('tenant')->getPdo();
            DB::setDefaultConnection('tenant');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Falha na conexão com o banco de dados do tenant: ' . $e->getMessage()], 500);
        }

        return $next($request);
    }
}