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
                    <div class="float-left">
                        <h4>Novo Produto</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route("adminprodutos.store")}}" method="post" enctype="multipart/form-data" style="margin: 0; padding: 0">
                        @csrf
                        <div class="row">

                            <div class="col-12">
                               <label for="nome">*Nome</label>
                               <input class="form-control" maxlength="100" type="text" id="nome" name="nome" required>
                           </div>
                           <div class="col-12">
                               <label for="descricao">Descrição</label>
                               <textarea class="form-control" id="descricao" name="descricao" rows="4"></textarea>
                           </div>

                           <div class="col-md-4 col-12">
                               <label for="preco">*Preço</label>
                               <input class="form-control" type="text" id="preco" name="preco" required>
                           </div>
                                <input class="form-control" type="hidden" value="" id="parcelamento" name="parcelamento">
                            <div class="col-md-4 col-12">
                                <label for="codigosistema">*Cod. Solidus</label>
                                <input class="form-control" type="text" id="codigosistema" name="codigosistema" required>
                            </div>
                            <div class="col-md-4 col-12">
                                <label for="id_categoria">*Categoria</label>
                                <select class="form-control" onchange="selecionarcategoria()" name="id_categoria" id="id_categoria" required>
                                    <option value="0">Selecione uma categoria...</option>
                                    @foreach(\App\CategoriaModel::all() as $categoria)
                                        <option value="{{$categoria->id}}">{{$categoria->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="foto_um">*Imagem 1</label>
                                <input class="form-control" type="file" id="foto_um" name="foto_um"  required>
                            </div>
                            <div class="col-6">
                                <label for="foto_dois">Imagem 2</label>
                                <input class="form-control" type="file" id="foto_dois" name="foto_dois">
                            </div>
                            <div class="col-6">
                                <label for="foto_tres">Imagem 3</label>
                                <input class="form-control" type="file" id="foto_tres" name="foto_tres">
                            </div>
                           <div class="offset-9 col-3" style="margin-top: 10px">
                               <button disabled id="salvar" type="submit" class="btn btn-success" style="width: 100%">Salvar</button>
                           </div>
                        </div>
                    </form>
                    <p style="color: lightslategrey">*Opção de salvar disponível após preencher campos e selecionar categoria.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    window.onload = function()  {
        CKEDITOR.replace( 'descricao' );
    };

    function selecionarcategoria() {
        var select = document.getElementById('id_categoria');
        if(select.options[select.selectedIndex].value === "0"){
            document.getElementById('salvar').disabled = true;
        }else{
            document.getElementById('salvar').disabled = false;
        }
    }
</script>

@endsection
