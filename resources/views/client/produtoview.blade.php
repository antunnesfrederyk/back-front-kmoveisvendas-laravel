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
                <div class="col-lg-5 col-sm-12">
                    <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">

                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="{{asset($produto->foto_um)}}" alt="Foto 1">
                                <div class="carousel-caption d-none d-md-block">
                                    <h1></h1>
                                    <p></p>
                                </div>
                            </div>
                            @if($produto->foto_dois != "fotos/icon_sem_foto.jpg")
                            <div class="carousel-item">
                                <img class="d-block w-100" src="{{asset($produto->foto_dois)}}" alt="Foto 2">
                                <div class="carousel-caption d-none d-md-block">
                                    <h1></h1>
                                    <p></p>
                                </div>
                            </div>
                            @endif
                            @if($produto->foto_tres != "fotos/icon_sem_foto.jpg")
                            <div class="carousel-item">
                                <img class="d-block w-100" src="{{asset($produto->foto_tres)}}" alt="Foto 3">
                                <div class="carousel-caption d-none d-md-block">
                                    <h1></h1>
                                    <p></p>
                                </div>
                            </div>
                            @endif

                        </div>

                        <a class="carousel-control-prev" href="#carouselExampleIndicators2" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Anterior</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators2" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Próximo</span>
                        </a>
                    </div>
                    <br>
                    <div class="w-100" align="center">
                        <ol class="">
                            <img class="active p-1" style="background-color: white" data-target="#myCarousel" src="{{asset($produto->foto_um)}}" data-slide-to="0" height="40px" />
                            @if($produto->foto_dois != "fotos/icon_sem_foto.jpg")
                                <img class="p-1" style="background-color: white" data-target="#myCarousel" src="{{asset($produto->foto_dois)}}" data-slide-to="1" height="40px" />
                            @endif
                            @if($produto->foto_tres != "fotos/icon_sem_foto.jpg")
                                <img class=" p-1" style="background-color: white" data-target="#myCarousel" src="{{asset($produto->foto_tres)}}" data-slide-to="2" height="40px" />
                            @endif
                        </ol>
                    </div>

                </div>
                <div class="col-lg-7 col-sm-12 mt-sm-3" align="left">
                    <h6 align="justify">
                        <?php
                        echo $produto->descricao;;
                        ?>
                    </h6>
                       <div class="row mt-5 mb-5">
                           <div class="col-lg-6 col-sm-12  float-left">
                               @if($produto->disponivel ==1)
                               <h1 style="color: #1b4b72; font-weight: bold">R$ {{$produto->preco}}</h1>
                               <p style="margin: 0; padding: 0; color: grey">Até 10x no cartão</p>
                               <p style="margin: 0; padding: 0; color: grey">1+5 Crediário</p>
                               <p style="margin: 0; padding: 0; color: grey">À vista</p>
                                   @else
                                   <p style="margin: 0; padding: 0; color: darkslategray; height: 117px; padding: 5px">Ops! Já vendemos todo o estoque.</p>

                               @endif

                           </div>
                           @if($produto->disponivel ==1)
                           <div class="col-lg-6 col-sm-12 float-right">
                               <button onclick="quantidade({{$produto->id}}, '{{$produto->nome}}')" data-toggle="modal" data-target="#exampleModal"   class="btn btn-danger" style="width: 100%; margin-bottom: 20px; margin-top: 10px">Adicionar ao Carrinho&nbsp;&nbsp;<i class="fas fa-cart-plus"></i></button>
                           </div>

                               @else
                               <div class="col-lg-6 col-sm-12 float-right">
                                <a href="https://api.whatsapp.com/send?phone=5583999900364&text=*K Móveis*%0a%0aTenho interesse em:%0a{{$produto->nome}} - ({{$produto->codigosistema}})%0a%0a" class="btn btn-outline-danger" style="width: 100%">Tenho Interesse&nbsp;&nbsp;&nbsp;<i class="fab fa-whatsapp"></i></a>
                               </div>
                           @endif
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
