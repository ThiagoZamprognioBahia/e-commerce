<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Auth')->group(function() {

    // Rotas admin
    Route::post('/admin', AuthController::class . '@auth');
    
    // Rotas de clientes
    Route::post('/login', LoginContoller::class . '@login');
    Route::post('/registrar-se', RegistroController::class . '@store');

});

// Rotas autenticadas
Route::namespace('API')->middleware('auth:sanctum')->group(function () {

    //Criar usario administrador
    Route::post('/admin/registrar-se', RegistroAdminController::class . '@store');

    Route::resource('/departamento', DepartamentoController::class);
    Route::resource('/categoria', CategoriaController::class);
    Route::resource('/sub-categoria', SubCategoriaController::class);

    //Produto
    Route::resource('/produto', ProdutoController::class);
});

