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
                    <div class="float-left">Produtos - K Móveis</div>
                </div>
                <div class="card-body">
                    <h4>Novo Produto</h4>
                    <form action="{{route("adminprodutos.update", $produto->id)}}" method="post" enctype="multipart/form-data" style="margin: 0; padding: 0">
                        @csrf
                        <input value="put" type="hidden" name="_method">
                        <div class="row">

                            <div class="col-12">
                               <label for="nome">*Nome</label>
                               <input class="form-control" maxlength="100" type="text" value="{{$produto->nome}}" id="nome" name="nome" required>
                           </div>
                           <div class="col-12">
                               <label for="descricao">Descrição</label>
                               <textarea class="form-control" id="descricao" name="descricao" rows="4">{{$produto->descricao}}
                               </textarea>
                           </div>

                           <div class="col-6">
                               <label for="preco">*Preço</label>
                               <input class="form-control" type="text" id="preco" value="{{$produto->preco}}" name="preco" required>
                           </div>
                                <input class="form-control" type="hidden" id="parcelamento" value="" name="parcelamento">
                            <div class="col-6">
                                <label for="codigosistema">*Cod. Solidus</label>
                                <input class="form-control" type="text" id="codigosistema" value="{{$produto->codigosistema}}" name="codigosistema" required>
                            </div>
                            <div class="col-6">
                                <label for="id_categoria">*Categoria</label>
                                <select class="form-control" name="id_categoria" id="id_categoria" required>
                                    <option  value="{{$produto->id_categoria}}">Alterar categoria?</option>
                                    @foreach(\App\CategoriaModel::all() as $categoria)
                                        <option value="{{$categoria->id}}">{{$categoria->nome}}</option>
                                    @endforeach
                                </select>
                            </div>


                            @if($produto->foto_um == "fotos/icon_sem_foto.jpg")
                                <div class="col-6">
                                    <label for="foto_um">*Imagem 1</label>
                                    <input class="form-control" type="file" id="foto_um" name="foto_um">
                                </div>
                            @else
                                <div class="col-6" style="display: block"  id="div_botaoum">
                                    <label>&nbsp;</label>
                                    <button type="button" class="btn btn-danger w-100" onclick="alterarFotoUm()">Deseja Alterar Foto 1?</button>
                                </div>
                                <div class="col-6" style="display: none" id="div_fotoum">
                                    <label for="foto_um">*Imagem 1</label>
                                    <input class="form-control" type="file" id="foto_um" name="foto_um">
                                </div>
                            @endif



                            @if($produto->foto_dois == "fotos/icon_sem_foto.jpg")
                                <div class="col-6">
                                    <label for="foto_dois">Imagem 2</label>
                                    <input class="form-control" type="file" id="foto_dois" name="foto_dois">
                                </div>
                            @else
                                <div class="col-6" style="display: block" id="div_botaodois">
                                    <label>&nbsp;</label>
                                    <button type="button" class="btn btn-danger w-100" onclick="alterarFotoDois()">Deseja Alterar Foto 2?</button>
                                </div>
                            <div class="col-6" style="display: none" id="div_fotodois">
                                <label for="foto_dois">Imagem 2</label>
                                <input class="form-control" type="file" id="foto_dois" name="foto_dois">
                            </div>
                            @endif


                            @if($produto->foto_tres == "fotos/icon_sem_foto.jpg")
                                <div class="col-6">
                                    <label for="foto_tres">Imagem 3</label>
                                    <input class="form-control" type="file" id="foto_tres" name="foto_tres">
                                </div>
                            @else
                                <div class="col-6" style="display: block" id="div_botaotres">
                                    <label>&nbsp;</label>
                                    <button type="button" class="btn btn-danger w-100" onclick="alterarFotoTres()">Deseja Alterar Foto 3?</button>
                                </div>
                            <div class="col-6" style="display: none" id="div_fototres">
                                <label for="foto_tres">Imagem 3</label>
                                <input class="form-control" type="file" id="foto_tres" name="foto_tres">
                            </div>
                            @endif


                           <div class="offset-9 col-3" style="margin-top: 10px">
                               <button type="submit" class="btn btn-success" style="width: 100%">Salvar</button>
                           </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    <script type="text/javascript">
        window.onload = function()  {
            CKEDITOR.replace( 'descricao' );
        };

        function alterarFotoUm() {
            document.getElementById("div_fotoum").style.display = "block";
            document.getElementById("div_botaoum").style.display = "none";
        }
        function alterarFotoDois() {
            document.getElementById("div_fotodois").style.display = "block";
            document.getElementById("div_botaodois").style.display = "none";
        }
        function alterarFotoTres() {
            document.getElementById("div_fototres").style.display = "block";
            document.getElementById("div_botaotres").style.display = "none";
        }
    </script>
@endsection
