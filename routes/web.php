<?php

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

Route::get('/', 'ClienteController@principal')->name('principal');
Route::get('/buscar/', 'ClienteController@buscarProdutoNome')->name('buscar');
Route::get('/categoria/{id}', 'ClienteController@buscarProdutoCategoria')->name('listarporcategoria');
Route::get('/produto/{idproduto}', 'ClienteController@produto')->name('produto');
Route::post('/addcart/', 'ClienteController@addCart')->name('addcart');
Route::get('/removecart/{idproduto}/{qtd}', 'ClienteController@removecart')->name('removecart');
Route::get('/carrinho', 'ClienteController@carrinho')->name('carrinho');
Route::get('/limpar', 'ClienteController@limpar')->name('limpar');
Route::post('/enviar', 'ClienteController@enviar')->name('enviar');

Auth::routes();


Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin', 'HomeController@index')->name('home');
    Route::resource('admincategorias', 'CategoriaAdminController');
    Route::resource('adminbanners', 'BannerController');
    Route::resource('adminprodutos', 'ProdutoAdminController');
    Route::resource('adminpedidos', 'PedidosAdminController');
    Route::get('admin/usuarios', 'ClienteController@listarUsuarios')->name('usuarios');
    Route::post('status/{id}', 'ClienteController@alterarStatus')->name('status');
});
