@extends('layouts.app_cliente')
@section('content')
    @php(session_start())
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 card" style="margin-top: 5px; padding-top: 20px;">
            <div class="row justify-content-center" style="padding: 5px">
                <div class="col-12 mb-2">
                    <h4>{{$produto->nome}}</h4>
                </div>

                <div class="col-lg-4 col-sm-12 col-12">
                    <img src="{{asset($produto->foto_um)}}"width="100%">
                </div>
                <div class="col-lg-4 col-sm-6 col-6">
                    @if($produto->foto_dois != "fotos/icon_sem_foto.jpg")
                    <img src="{{asset($produto->foto_dois)}}" width="100%">
                    @endif
                </div>
                <div class="col-lg-4 col-sm-6 col-6">
                    @if($produto->foto_tres != "fotos/icon_sem_foto.jpg")
                    <img src="{{asset($produto->foto_tres)}}"width="100%">
                    @endif
                </div>
                <div class="col-12 pt-2" align="left" style="margin-top: 40px">
                    <h6 align="justify">
                        <?php
                        echo $produto->descricao;;
                        ?>
                    </h6>
                       <div class="container" style="margin-top: 50px">
                           <div class="col-lg-8 col-12  float-left">
                               <h1 style="color: #1b4b72; font-weight: bold">R$ {{$produto->preco}}</h1>
                               <p style="margin: 0; padding: 0; color: grey">Até 10x no cartão</p>
                               <p style="margin: 0; padding: 0; color: grey">1+5 Crediário</p>
                               <p style="margin: 0; padding: 0; color: grey">À vista</p>

                           </div>
                           <div class="col-lg-4 col-12 float-right">
                               <button onclick="quantidade({{$produto->id}}, '{{$produto->nome}}')" data-toggle="modal" data-target="#exampleModal"   class="btn btn-danger" style="width: 100%; margin-bottom: 20px; margin-top: 10px">Adicionar ao Carrinho&nbsp;&nbsp;<i class="fas fa-cart-plus"></i></button>
                           </div>
                       </div>

                </div>

                @auth
                   <div class="col-12">
                       <br>
                       <br>
                       <br>
                       <br>
                       <div class="card p-3 col-6">
                           <h4 align="center">Administrativo</h4>
                           <p align="center">Recurso apresentado apenas aos usuarios logados!</p>
                           <a href="{{route("adminprodutos.edit", $produto->id)}}"  class="btn btn-dark">Editar Produto</a>
                           <form id="deleteform{{$produto->id}}" action="{{route('adminprodutos.destroy', $produto->id)}}" method="POST">
                               @csrf
                               <input type="hidden" name="_method" value="DELETE">
                               <button type="button" onclick="pergunta({{$produto->id}})" class="btn btn-danger w-100 mt-1">Excluir Item</button>
                           </form>
                           <p>Ultima alteração realizada por {{\App\User::findOrFail($produto->id_user)->name}} em {{\Carbon\Carbon::parse($produto->updated_at)->format('d/m/Y H:i:s')}}</p>
                       </div>
                       <br>
                       <br>
                   </div>

                    <script type="text/javascript">

                        function pergunta(id){
                            if (confirm('Tem certeza que deseja excluir o produto indicado?')){
                                document.getElementById("deleteform"+id).submit()
                            }
                        }
                    </script>
                @endauth

            </div>
        </div>
    </div>
</div>


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route("addcart")}}" method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="idproduto" name="id">
                        <label>Quantidade</label>
                        <input type="number" class="form-control" id="qtd" name="qtd" value="1">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Adicionar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function quantidade(id, nome) {

            document.getElementById("exampleModalLabel").innerHTML = nome;
            document.getElementById("idproduto").value = id;
        }
    </script>
@endsection
