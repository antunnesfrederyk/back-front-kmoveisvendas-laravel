<?php

namespace App\Http\Controllers;

use App\BannerModel;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados = BannerModel::all();
        return view('admin.banner', compact('dados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file1 = $request->file('foto');
        if ($file1 !=null){
            $newName1 = str_replace('.'.$file1->getClientOriginalExtension() , '' , strtolower( preg_replace('/[ -]+/' , '_' , strtr(utf8_decode(trim($file1->getClientOriginalName())), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")) )).'_'.uniqid().'.'.$file1->getClientOriginalExtension();
            $file1->move(public_path('imagens'), $newName1);
            $banner = new BannerModel();
            $banner->titulo = $request['titulo'];
            $banner->descricao = $request['descricao'];
            $banner->foto =  'imagens/' . $newName1;
            $banner->save();
            flash('Banner Inserido')->success();
        }else{
            flash('Erro ao carregar Banner')->error();
        }
        return  redirect()->route('adminbanners.index');
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dado = BannerModel::findOrFail($id);
        unlink($dado->foto);
        $dado->delete();
        flash("Banner Excluído com Sucesso")->success();
        return redirect()->route("adminbanners.index");
    }
}
