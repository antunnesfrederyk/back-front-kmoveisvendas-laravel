@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><h4>Banners</h4></div>
                <div class="card-body">
                    <div class="card shadow p-3 mb-5 bg-white rounded" style="padding: 10px">
                        <h4>Novo Banner</h4>
                        <form action="{{route("adminbanners.store")}}" method="post" enctype="multipart/form-data" style="margin: 0; padding: 0">
                            @csrf
                            <div class="row">
                                <div class="col-3">
                                    <label for="foto">Imagem</label>
                                    <input class="form-control" type="file" id="foto" name="foto" required>
                                </div>
                                <div class="col-4">
                                    <label for="titulo">Título</label>
                                    <input class="form-control" type="text" id="titulo" name="titulo" placeholder="Optional">
                                </div>
                                <div class="col-5">
                                    <label for="descricao">Descrição</label>
                                    <input class="form-control" type="text" id="descricao" max="190" name="descricao"  placeholder="Optional">
                                </div>
                                <div class="col-3" style="margin-top: 10px">
                                    <label></label>
                                    <button type="submit" class="btn btn-success" style="width: 100%">Salvar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <h4>Lista de Categorias</h4>
                    <table  id="myTable" class="table table-striped table-bordered">
                        <thead class="table-dark">
                        <tr>
                            <td>Banner</td>
                            <td>Titulo/Descrição</td>
                            <td>Ações</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dados as $dado)
                        <tr>
                            <td align="center">
                                <img src="{{asset($dado->foto)}}" height="50px"/>
                            </td>
                            <td>
                                <h5 style="margin: 0">{{$dado->titulo}}</h5>
                                <p>{{$dado->descricao}}</p>
                            </td>
                            <td align="center">
                                <form action="{{route('adminbanners.destroy', $dado->id)}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button class="btn btn-danger" style="width: 90%;">Excluir</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
