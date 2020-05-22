<?php

namespace App\Http\Controllers;

use App\ProdutoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdutoAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $dados = ProdutoModel::all();
        return view('admin.produtos_list', compact('dados'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.produto_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //

        $file1 = $request->file('foto_um');
        $file2 = $request->file('foto_dois');
        $file3 = $request->file('foto_tres');

        $newName1 = 'icon_sem_foto.jpg';
        $newName2 = 'icon_sem_foto.jpg';
        $newName3 = 'icon_sem_foto.jpg';

        if ($file1 !=null){
            $newName1 = str_replace('.'.$file1->getClientOriginalExtension() , '' , strtolower( preg_replace('/[ -]+/' , '_' , strtr(utf8_decode(trim($file1->getClientOriginalName())), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")) )).'_'.uniqid().'.'.$file1->getClientOriginalExtension();
            $file1->move(public_path('fotos'), $newName1);
        }

        if ($file2 !=null){
            $newName2 = str_replace('.'.$file2->getClientOriginalExtension() , '' , strtolower( preg_replace('/[ -]+/' , '_' , strtr(utf8_decode(trim($file2->getClientOriginalName())), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")) )).'_'.uniqid().'.'.$file2->getClientOriginalExtension();
            $file2->move(public_path('fotos'), $newName2);
        }

        if ($file3 !=null){
            $newName3 = str_replace('.'.$file3->getClientOriginalExtension() , '' , strtolower( preg_replace('/[ -]+/' , '_' , strtr(utf8_decode(trim($file3->getClientOriginalName())), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")) )).'_'.uniqid().'.'.$file3->getClientOriginalExtension();
            $file3->move(public_path('fotos'), $newName3);
        }

        $categoria = new ProdutoModel();
        $categoria->nome = $request['nome'];
        $categoria->descricao = $request['descricao'];
        $categoria->preco = $request['preco'];
        $categoria->parcelamento = $request['parcelamento'];
        $categoria->disponivel = $request['disponivel'];
        $categoria->codigosistema = $request['codigosistema'];
        $categoria->foto_um =  'fotos/' . $newName1;
        $categoria->foto_dois =  'fotos/' . $newName2;
        $categoria->foto_tres =  'fotos/' . $newName3;
        $categoria->id_categoria = $request['id_categoria'];
        $categoria->id_user = Auth::user()->id;
        $categoria->save();
        flash('Produto Inserido')->success();
        return  redirect()->route('adminprodutos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $produto = ProdutoModel::findOrFail($id);
        return view('admin.produto_edit', compact('produto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $produto = ProdutoModel::findOrFail($id);
        $produto->update($request->all());
        $mudou = 0;
        $file1 = $request->file('foto_um');
        $file2 = $request->file('foto_dois');
        $file3 = $request->file('foto_tres');


        if ($file1 !=null){
            $newName1 = str_replace('.'.$file1->getClientOriginalExtension() , '' , strtolower( preg_replace('/[ -]+/' , '_' , strtr(utf8_decode(trim($file1->getClientOriginalName())), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")) )).'_'.uniqid().'.'.$file1->getClientOriginalExtension();
            $file1->move(public_path('fotos'), $newName1);
            $produto->foto_um = "fotos/".$newName1;
            $mudou = 1;
        }

        if ($file2 !=null){
            $newName2 = str_replace('.'.$file2->getClientOriginalExtension() , '' , strtolower( preg_replace('/[ -]+/' , '_' , strtr(utf8_decode(trim($file2->getClientOriginalName())), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")) )).'_'.uniqid().'.'.$file2->getClientOriginalExtension();
            $file2->move(public_path('fotos'), $newName2);
            $produto->foto_dois = "fotos/".$newName2;
            $mudou = 1;
        }

        if ($file3 !=null){
            $newName3 = str_replace('.'.$file3->getClientOriginalExtension() , '' , strtolower( preg_replace('/[ -]+/' , '_' , strtr(utf8_decode(trim($file3->getClientOriginalName())), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")) )).'_'.uniqid().'.'.$file3->getClientOriginalExtension();
            $file3->move(public_path('fotos'), $newName3);
            $produto->foto_tres = "fotos/".$newName3;
            $mudou = 1;
        }

        if($mudou == 1){
            $produto->save();
        }


        flash('Produto Editado com Sucesso')->success();
        return  redirect()->route('adminprodutos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        //

        $prod = ProdutoModel::findOrFail($id);
        $prod->delete();
        flash('Produto Excluído')->success();
        return  redirect()->route('adminprodutos.index');
    }
}
