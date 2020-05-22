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
            <div class="card shadow mb-5 bg-white rounded">
                <div class="card-header">
                    <div class="float-left"><a><h4>Produtos</h4></a></div>
                    <div class="float-right"><a class="btn btn-success" href="{{route('adminprodutos.create')}}">Novo Produto</a></div>
                </div>
                <div class="card-body">
                    <h4>Lista de Produtos</h4>
                    <table  id="myTable" class="table table-striped table-bordered">
                        <thead class="table-dark">
                        <tr>
                            <td>Nome</td>
                            <td>Preço</td>
                            <td>Estoque</td>
                            <td>Ações</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dados as $dado)
                        <tr>
                            <td>
                                <h6 class="m-0">{{$dado->nome}}</h6>
                                <p class="m-0" style="color: dimgray">Código Solidus: {{$dado->codigosistema}}</p>
{{--                                {{$dado->descricao}}--}}
                            </td>
                            <td>
                                R$ {{$dado->preco}}
                            </td>
                            <td>
                                @if($dado->disponivel==1)
                                    <label class="btn-sm btn-success disabled">Disponível</label>
                                @else
                                    <label class="btn-sm btn-danger disabled">Indisponível</label>
                                @endif
                            </td>
                            <td align="center">
                                    <a href="{{route("adminprodutos.edit", $dado->id)}}" class="btn btn-primary btn-sm">Editar</a>
                                    <form id="deleteform{{$dado->id}}" action="{{route('adminprodutos.destroy', $dado->id)}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="button" onclick="pergunta({{$dado->id}})" class="btn btn-danger btn-sm mt-1">Remover</button>
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
    <script type="text/javascript">

        function pergunta(id){
            if (confirm('Tem certeza que deseja excluir o produto indicado?')){
                document.getElementById("deleteform"+id).submit()
            }
        }
    </script>
@endsection
