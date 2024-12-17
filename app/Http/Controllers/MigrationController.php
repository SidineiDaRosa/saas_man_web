<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

class MigrationController extends Controller
{
    public function exeute_migrations()
    {
        if (!auth()->user()->is_admin) {
            return response()->json(['message' => 'Você não tem permissão para executar migrações.'], 403);
        }
    
        try {
            Artisan::call('migrate');
            return response()->json(['message' => 'Migrações executadas com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao executar as migrações: ' . $e->getMessage()]);
        }
    }
}
