@extends('layouts.app')
@section('content')
    @if(strstr(\Illuminate\Support\Facades\Auth::user()->email, '@') == "@vendas.com.br")
        <script type="text/javascript">
            window.location.href = "{{route('adminpedidos.index')}}";
        </script>
    @endif
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><h4>Categorias</h4></div>
                <div class="card-body">
                    <div class="card shadow p-3 mb-5 bg-white rounded" style="padding: 10px">
                        <h4>Nova Categoria</h4>
                        <form action="{{route("admincategorias.store")}}" method="post" enctype="multipart/form-data" style="margin: 0; padding: 0">
                            @csrf
                            <div class="row">
                                <div class="col-9">
                                    <label for="nome">Categoria</label>
                                    <input class="form-control" type="text" id="nome" name="nome" required>
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
                            <td width="65%">Categoria</td>
                            <td width="10%">Itens</td>
                            <td width="25%">Ações</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dados as $dado)
                        <tr>
                            <td>
                                <h5 style="margin: 0">{{$dado->nome}}</h5>
                            </td>
                            <td align="center">
                                {{\App\ProdutoModel::all()->where('id_categoria', $dado->id)->count()}}
                            </td>
                            <td align="center">
                                <form action="{{route('admincategorias.destroy', $dado->id)}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    @if(\App\ProdutoModel::all()->where('id_categoria', $dado->id)->count() > 0)
                                        <button disabled class="btn btn-danger" style="width: 90%;">Excluir</button>
                                    @else
                                        <button class="btn btn-danger" style="width: 90%;">Excluir</button>
                                    @endif
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
