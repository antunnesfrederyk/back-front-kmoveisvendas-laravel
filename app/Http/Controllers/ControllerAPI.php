<?php

namespace App\Http\Controllers;

use App\CategoriaModel;
use App\ProdutoModel;
use Illuminate\Http\Request;

class ControllerAPI extends Controller
{
    //
    public function listarProdutos(){
        return ProdutoModel::all();
    }

    public function listarCategorias(){
        return CategoriaModel::all();
    }

    public function listarProdutosPorNome($search){
        return ProdutoModel::where('nome', 'like', '%' . $search . '%')->get();
    }

    public function listarProdutosPorCategoria($id){
        return ProdutoModel::where('id_categoria', $id)->get();
    }
}
