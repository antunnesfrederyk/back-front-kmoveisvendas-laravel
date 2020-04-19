<?php

use Illuminate\Http\Request;

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

Route::get('produtos', 'ControllerAPI@listarProdutos');
Route::get('categorias', 'ControllerAPI@listarCategorias');
Route::get('produto/{search}', 'ControllerAPI@listarProdutosPorNome');
Route::get('categoria/{id}', 'ControllerAPI@listarProdutosPorCategoria');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
