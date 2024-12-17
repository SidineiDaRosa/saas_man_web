<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataBaseController extends Controller
{
    public function create()
    {
        // Criação do banco de dados
        $nomeBanco = 'novo_banco'; // Nome do banco de dados
        $query = "CREATE DATABASE IF NOT EXISTS $nomeBanco";

        try {
            DB::statement($query); // Executa a query SQL para criar o banco
            return response()->json(['message' => 'Banco de dados criado com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar banco de dados: ' . $e->getMessage()]);
        }
    }
}
