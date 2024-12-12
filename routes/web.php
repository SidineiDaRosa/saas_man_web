<?php

use App\Http\Controllers\Check_listController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdemServicoController;
use App\Http\Controllers\PedidoCompraListaController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\QrCodeController;
use app\Http\Controllers\EstoqueProdutoController;
use App\Http\Controllers\PedidosSaidaController;
use App\Http\Controllers\SaidaProdutoController;
use App\Http\Controllers\PedidoCompraAutoGenerateController;
use App\Http\Controllers\EquipamentoHistoryController;
use App\Http\Controllers\DahboardStatusOsController;
use App\Http\Controllers\UtilsController;
use App\Http\Controllers\SolicitacaoOsController;
use App\Http\Controllers\CheckListController;
use App\Http\Controllers\CheckListExecutadoController;
use App\Http\Controllers\CustosController;

use App\Http\Controllers\PecaEquipamentoController;
use App\Models\PedidoCompraLista;
use App\Http\Controllers\KPIsController;
use App\Http\Controllers\EquipamentoController;
//use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('site.home');
})->name('site.home'); // Dashboard principal

Route::get('/site/sobre_nos', function () {
    return view('site.sobre_nos');
})->name('site.sobre_nos');
Route::get('/site-panel', function () {
    return view('site.control_panel');
})->name('site.control_panel');
Route::get('/configuracoes', function () {
    return view('site.configuracoes');
})->name('site.configuracoes');


//---------------------------------------------------------//
//    login
//---------------------------------------------------------//
use App\Http\Controllers\Auth\LoginController;

Route::get('/login_start', [LoginController::class, 'showLoginForm'])->name('login_start');
Route::post('/login', [LoginController::class, 'login'])->name('login'); // Adicionando a rota POST para login

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('tenant')->group(function () {
    Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('app.home');
    //Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    //----------------------------------------------//
    //                Ordem de serviço
    //---------------------------------------------//
    Route::get('/ordem-servico-open/{id}', [App\Http\Controllers\OrdemServicoController::class, 'show'])->name('ordem-servico-open');

    Route::middleware('auth')->get(
        'utils/search',
        'App\Http\Controllers\UtilsController@search'
    )->name('search');
    Route::get('/dashboard-status-os', [DahboardStatusOsController::class, 'index'])->name('dashboard-status-os');

    Route::middleware('auth')->resource('/ordem-servico', 'App\Http\Controllers\OrdemServicoController');

    Route::middleware('auth')->get('/program_os', [App\Http\Controllers\DahboardStatusOsController::class, 'programer_os'])->name('program_os');

    Route::put('/ordem_servico_up/{ordem_servico}', [OrdemServicoController::class, 'update'])->name('ordem_servico.update');
    //ordem de serviço rota de pesquisas
    Route::middleware('auth')->post('/filtro-os', [App\Http\Controllers\OrdemServicoController::class, 'index']);
    //----------------   os   ------------------------------//
    Route::middleware('auth')->get(
        'utils/updateos',
        'App\Http\Controllers\UtilsController@updateos'
    )->name('updateos');
    Route::middleware('auth')->get(
        'utils/start-os',
        'App\Http\Controllers\UtilsController@startos'
    )->name('start-os');
    Route::middleware('auth')->get(
        'utils/get-last-id-os',
        'App\Http\Controllers\UtilsController@getLastIdOs'
    )->name('get-last-id-os');
    //---------------------------------------------------//
    //   Serviços executados
    //-------------------------------------------------//
    Route::middleware('auth')->post(
        'utils/validar-data-hora-termino',
        'App\Http\Controllers\UtilsController@validarDataHoraTermino'
    )->name('validar-data-hora-termino');

    //----------------------------------------------//
    //                Equipamento
    //---------------------------------------------//
    Route::middleware('auth')->resource('/equipamento', 'App\Http\Controllers\EquipamentoController');
    Route::post('/assets', [EquipamentoHistoryController::class, 'assets'])->name('assets'); //acesso sem autenticação
    Route::post('/asset_history', [EquipamentoHistoryController::class, 'asset_show'])->name('asset_history'); //acesso sem autenticação
    //------------------------------------------//
    //  Pedidos de compra                       //
    //------------------------------------------//
    Route::middleware('auth')->resource('/pedido-compra', 'App\Http\Controllers\PedidoCompraController');
    //--------------------------------------------------------//
    //               Pedidos de saida
    //--------------------------------------------------------//
    Route::middleware('auth')->resource('/pedido-saida', 'App\Http\Controllers\PedidosSaidaController');
    Route::middleware('auth')->resource('/pedido-saida-lista', 'App\Http\Controllers\PedidoSaidaListaController');
    Route::middleware('auth')->post('/pedido-saida-filtro', [App\Http\Controllers\PedidosSaidaController::class, 'index']);
    Route::middleware('auth')->resource('/item-produto-saida', 'App\Http\Controllers\ItemSaidaProdutoController');
    //--------------------------------------------------------------------//
    //          Pedido de compra lista                                    //
    //--------------------------------------------------------------------//
    Route::middleware('auth')->resource('/pedido-compra-lista', 'App\Http\Controllers\PedidoCompraListaController');
    //Rota que atualiza pedido de compra
    Route::middleware('auth')->get(
        'utils/updatepedidocompra',
        'App\Http\Controllers\UtilsController@updatepedidocompra'
    )->name('updatepedidocompra');
    Route::middleware('auth')->get('/pedido-compra-printer/{numpedidocompra}', 'App\Http\Controllers\PedidoCompraListaController@printer')->name('pedido-compra-lista-printer');
    Route::delete('/delete-item-pedido-delete', 'App\Http\Controllers\PedidoCompraListaController@destroy')->name('delete-item-pedido-delete');
    //--------------------------------------------------------------------//
    //          Produto                                  
    //--------------------------------------------------------------------//
    Route::middleware('auth')->resource('/produto', 'App\Http\Controllers\ProdutoController');

    //-------------------------------------------------------------//
    //           Estoque de produtos
    //-------------------------------------------------------------//
    Route::middleware('auth')->post('/Estoque-Produtos-filtro', [App\Http\Controllers\EstoqueProdutoController::class, 'index']);
    Route::middleware('auth')->resource('/Estoque-produto', 'App\Http\Controllers\EstoqueProdutoController');
    Route::middleware('auth')->resource('Estoque-produto', EstoqueProdutoController::class);
    //Entrada
    Route::middleware('auth')->resource('/entrada-produto', 'App\Http\Controllers\EntradaProdutoController');
    //------------------------------------------------//
    //   produto-fornecedor
    //------------------------------------------------//
    Route::middleware('auth')->get(
        'produto_fornecedor/create',
        'App\Http\Controllers\ProdutoFornecedorController@create'
    )->name('produto-fornecedor.create');

    Route::middleware('auth')->post(
        'produto_fornecedor/store',
        'App\Http\Controllers\ProdutoFornecedorController@store'
    )->name('produto-fornecedor.store');

    Route::middleware('auth')->post(
        'produto_fornecedor/show',
        'App\Http\Controllers\ProdutoFornecedorController@show'
    )->name('produto-fornecedor.show');

    Route::middleware('auth')->delete(
        'produto_fornecedor/{produtoFornecedor}/{fornecedor}',
        'App\Http\Controllers\ProdutoFornecedorController@destroy'
    )->name('produto-fornecedor.destroy');

    Route::middleware('auth')->post(
        'produto_fornecedor/store/{fornecedor}',
        'App\Http\Controllers\ProdutoFornecedorController@store'
    )->name('produto-fornecedor.store');

    //-------------------------------------------------------------//
    //           Control Panel
    //-------------------------------------------------------------//
    Route::middleware('auth')->resource('/control-panel', 'App\Http\Controllers\ControlPanelController');
    //-------------------------------------------------------------//
    //                Busca empresas
    //-------------------------------------------------------------//
    Route::middleware('auth')->post('/Empresas-filtro', [App\Http\Controllers\EmpresasController::class, 'index']);
    Route::middleware('auth')->resource('/empresas', 'App\Http\Controllers\EmpresasController');
    //Filtro Produtos
    Route::middleware('auth')->post('/Produtos-filtro', [App\Http\Controllers\ProdutoController::class, 'index']);
    //Rota saida de produtos
    Route::middleware('auth')->resource('/Saida-produto', 'App\Http\Controllers\SaidaProdutoController');
    Route::middleware('auth')->resource('/mostra-produto', 'App\Http\Controllers\SaidaProdutoController');

    //-------------------------------------------------------------//
    //                Marcas Categorias
    //-------------------------------------------------------------//
    Route::middleware('auth')->resource('/marca', 'App\Http\Controllers\MarcaController');
    //Categoria
    Route::middleware('auth')->resource('/categoria', 'App\Http\Controllers\CategoriaController');
    Route::middleware('auth')->resource('/categoria-edit', 'App\Http\Controllers\CategoriaController');
    //fornecedor
    Route::middleware('auth')->resource('/fornecedor', 'App\Http\Controllers\FornecedorController');
    //----------------------------------------------------------//
    //   CUSTOS GERAIS           
    //----------------------------------------------------------//

    Route::get('/dashboard-custos', [CustosController::class, 'dashboard'])->name('custos.dashboard');

    //-------------------------------------------------------------//
    //          Peças equipamentos
    //-------------------------------------------------------------//

    Route::middleware('auth')->resource('/Peca-equipamento', 'App\Http\Controllers\PecaEquipamentoController');
    //--
    Route::middleware('auth')->post('/peca-equpamento-filtro', [App\Http\Controllers\PecaEquipamentoController::class, 'index']);


    Route::middleware(['auth'])->get('/peca-equipamento-editar/{peca_equipamento_id}', [PecaEquipamentoController::class, 'edit'])->name('Peca-equipamento-editar.edit');
    Route::middleware(['auth'])->put('/peca-equipamento/{pecas_equipamento}', [PecaEquipamentoController::class, 'update'])->name('Peca-equipamento.update');
    //----------------------------------------------------------//
    //   KPYs          
    //----------------------------------------------------------//

    Route::get('/dashboard-kpis', [KPIsController::class, 'index'])->name('kpis.dashboard');
    //--------------------------------------------------------//
    //                  Ordem de produção
    //--------------------------------------------------------//
    Route::middleware('auth')->resource('/ordem-producao', 'App\Http\Controllers\OrdemProducaoController');

    //recursos-ordem-producao
    Route::middleware('auth')->post(
        'recursos-producao/store/{ordem_producao}',
        'App\Http\Controllers\RecursosProducaoController@store'
    )->name('recursos-producao.store');

    Route::middleware('auth')->post(
        'parada-equipamento/store/{ordem_producao}',
        'App\Http\Controllers\ParadaEquipamentoController@store'
    )->name('parada-equipamento.store');
    //----------------------------------------------------//
    //               Serviços executados       
    //----------------------------------------------------//
    //Route::middleware('auth')->post('/Servicos-executado-index', [App\Http\Controllers\ServicosExecutadosController::class, 'index']);
    Route::middleware('auth')->resource('/Servicos-executado', 'App\Http\Controllers\ServicosExecutadoController');
    //----------------------------------------------------------//
    //   Imprimir em PDF
    //----------------------------------------------------------//
    Route::post('/imprimir-pdf', [App\Http\Controllers\PdfController::class, 'gerarPDF'])->name('gerar.pdf');
    //--------------------------------------------------------//
    //   Deletar o pedido de saida
    //--------------------------------------------------------//
    Route::middleware('auth')->delete('/pedidos-saida/{id}', [PedidosSaidaController::class, 'destroy'])->name('pedidos-saida.destroy');
    //----------------------------------------------------//
    //               Saida De Produtos     
    //----------------------------------------------------//
    Route::middleware('auth')->resource('/saida-produto-add-item', 'App\Http\Controllers\SaidaProdutoController');
    //Filtro Produtos item  saida 
    Route::middleware('auth')->post('/Item-Saida-Produto', [App\Http\Controllers\ItemSaidaProdutoController::class, 'index']);
    Route::middleware('auth')->post('/pedido-saida-searching-products', [App\Http\Controllers\PedidoSaidaListaController::class, 'searching_products'])->name('pedido-saida-searching-products');
    // Deleta item pedido de saida
    Route::middleware('auth')->delete('/saida-produto/{id}', [SaidaProdutoController::class, 'destroy'])->name('saida-produto.destroy');
});
/*
    Route::get('/asset-show', [EquipamentoHistoryController::class, 'asset_show'])->name('asset.show');
    Auth::routes();
    //--------------------------------------------------------//
    //------------------Utilis controller---------------------//
    //   Busca o horimetro inicial de Ordem de produção via ajax

    Route::middleware('auth')->get(
        'utils/get-horimetro-inicial',
        'App\Http\Controllers\UtilsController@getHorimetroInicial'
    )->name('utils.get-horimetro-inicial');
    //----------------------------------
    //busca o horimetro inicial de recursos de produção via ajax.
    Route::middleware('auth')->get(
        'utils/get-horimetro-inicial-recursos',
        'App\Http\Controllers\UtilsController@getHorimetroInicialRecursos'
    )->name('utils.get-horimetro-inicial-recursos');
    //busca ultimo registro de ordem de serviço ajax.
  
    //busca conta os por equipamento ajax.
    Route::middleware('auth')->get(
        'utils/get-cont-os-equip',
        'App\Http\Controllers\UtilsController@getContOsEquip'
    )->name('get-cont-os-equip');

    //busca ordem se serviços todas.
    Route::middleware('auth')->get(
        'utils/get-todas-os',
        'App\Http\Controllers\UtilsController@getTodasOs'
    )->name('get-todas-os');

   
    //------------------------------------------//
    // Filtro pedido de entrada
    //------------------------------------------//
    Route::middleware('auth')->post('/Ent-Produtos-filtro', [App\Http\Controllers\EntradaProdutoController::class, 'index']);
    //Rota Busca produto para dicionar item a pedidos
    Route::middleware('auth')->resource('/item-produto', 'App\Http\Controllers\ItemProdutoController');
    //Filtro Produtos item
    Route::middleware('auth')->post('/item-produto-filtro', [App\Http\Controllers\ItemProdutoController::class, 'index']);

    

    //===============================================================//
    //Adiciona componente ao equipamento
    //---------------------------------------------------------------//
    //Filtro Produtos
    Route::middleware('auth')->post('/Produtos-filtro-componente', [App\Http\Controllers\PecaEquipamentoController::class, 'create'])->name('Produtos-filtro-componente');
    //Edita o componente
    Route::middleware('auth')->post('/Produtos-filtro-componente-edit', [App\Http\Controllers\PecaEquipamentoController::class, 'searching_products'])->name('Produtos-filtro-componente-edit');
    //---------------------------------------------------------------//
    // Envia requisição ajax para atualizar um chek-list
    //---------------------------------------------------------------//
    Route::post('/checklist/send', [Check_listController::class, 'send'])->name('checklist.send');
    //---------------------------------------------------------------//
    // Envia requisição ajax para atualizar um chek-list
    //---------------------------------------------------------------//
    Route::middleware('auth')->get(
        'utils/update-chek-list',
        'App\Http\Controllers\UtilsController@update_chek_list'
    )->name('update-chek-list');
    
    //------------------------------------------------------------//
    // Deletar um item de umpedido de compra
    Route::delete('/pedido-compra-lista/{id}', [PedidoCompraListaController::class, 'destroy'])->name('pedido-compra-lista.destroy');
    //-----------------------------------------------------------//
    // Gerar Qr code

    Route::middleware('auth')->post('/gerar-qrcode', 'App\Http\Controllers\QrCodeController@gerarQRCode')->name('generate-qrcode');
  
  
    //----------------------------------------------------------//
    //   PedidoCompraAutoGenerateController

    //Route::get('/pedido-compra/auto-generate', [PedidoCompraAutoGenerateController::class, 'pedido_compra_auto_generate'])
    // ->name('pedido-compra-auto-generate');

    // routes/web.php
    Route::middleware('auth')->post('/pedido-compra-auto-generate', [PedidoCompraAutoGenerateController::class, 'pedido_compra_auto_generate'])->name('pedido-compra-auto-generate');
    Route::middleware('auth')->get('/pedido-compra/show', [PedidoCompraAutoGenerateController::class, 'show'])
        ->name('pedido.compra.show');
    //----------------------------------------------------------//
    //   Deletar peças de equipamento
    //----------------------------------------------------------//
    Route::delete('/peca-equipamento/{id}', [PecaEquipamentoController::class, 'destroy'])->name('peca_equipamento.destroy');
    //---------------------------------------------------------//
    //    QRcode equipamentos history
    //---------------------------------------------------------//
    Route::get('/assets', [EquipamentoHistoryController::class, 'assets'])->name('assets');

    //---------------------------------------------------------//
    //    Criar solicitação de Os
    //---------------------------------------------------------//
    Route::get('/solicitacao-os', [SolicitacaoOsController::class, 'create']);
    Route::post('solicitacao-os', [SolicitacaoOsController::class, 'store'])->name('solicitacao-os.store');
    Route::get('/solicitacoes-pendentes', [SolicitacaoOsController::class, 'cont']);
    Route::get('/solicitacoes-os', [SolicitacaoOsController::class, 'index']);
    Route::post('/solicitacao_os/{id}/aceitar', [SolicitacaoOsController::class, 'aceitar'])->name('solicitacao_os.aceitar');
    Route::post('/solicitacao_os/{id}/espera', [SolicitacaoOsController::class, 'espera'])->name('solicitacao_os.espera');
    Route::post('/solicitacao_os/{id}/recusar', [SolicitacaoOsController::class, 'recusar'])->name('solicitacao_os.recusar');
    Route::get('/solicitacoes', [SolicitacaoOsController::class, 'solicitacoes'])->name('solicitacoes-os');
    //----------------------------------------------------------//
    //   CHECK LIST                 
    //----------------------------------------------------------//

    Route::get('/check-list-index', [CheckListController::class, 'index'])->name('check-list-index');
    //rota acessada pelos executante de check list
    Route::get('/check-list-index-executar', [CheckListController::class, 'executar'])->name('check-list-index-executar');
    Route::post('/check-list-show', [CheckListController::class, 'show'])->name('check-list-show');
    Route::post('/check-list-save', [CheckListController::class, 'store'])->name('check-list-gravar');
    Route::post('/check-list/gravar', [CheckListController::class, 'store'])->name('check-list-gravar');
    Route::get('/check-list-show', [CheckListController::class, 'show'])->name('check-list-show');
    Route::get('/check-list-edit', [CheckListController::class, 'edit'])->name('check-list-edit');
    Route::get('/check-list-pendentes', [CheckListController::class, 'cont']);
    // Rota para atualizar um check-list
    Route::get('/check-list/update', [CheckListController::class, 'update'])->name('check-list-update');
    Route::delete('/check-list-delete/{check_list_id}', [CheckListController::class, 'destroy'])->name('check-list-delete');
    //----------------------------------------------------------//
    //   CHECK LIST  EXECUTADOS             
    //----------------------------------------------------------//
    Route::post('/check-list-cheked', [CheckListExecutadoController::class, 'store'])->name('check-list-executado');
    Route::get('/check-list-cheked-index', [CheckListExecutadoController::class, 'index'])->name('check-list-cheked-index');
    Route::get('/check-list-finalizado', [CheckListExecutadoController::class, 'executado'])->name('check-list-finalizado');
    Route::get('/check-list-funcionario', [CheckListExecutadoController::class, 'funcionario'])->name('check-list-funcionario');
    Route::delete('/check-list-exec-delete/{id}', [CheckListExecutadoController::class, 'destroy'])->name('check-list-exec-delete');

 
    //----------------------------------------------------------//
    //   Atualizar orímetro        
    //----------------------------------------------------------//

    Route::post('/update-horimetro', [EquipamentoController::class, 'update_hour_meter']);
});
*/
