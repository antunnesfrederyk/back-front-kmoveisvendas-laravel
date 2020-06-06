@extends('layouts.app_cliente')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 card" style="margin-top: 5px; padding-top: 20px;">
            <div class="row justify-content-center" style="padding: 5px">
                @php(session_start())
                    @foreach($dados as $produto)
                    <div class="col-lg-4 col-sm-6 col-12">
                            <div class="card shadow p-3 mb-5 bg-white rounded">
                                <a href="{{route('produto', $produto->id)}}" style="text-decoration: none">
                                <div class="card-header bg-white" style="padding: 5px; height: 300px">
                                    <img src="{{asset($produto->foto_um)}}" width="100%" height="200px" style="object-fit: cover; object-position: center; border-color: grey; border-width: 1px">
                                    <h6 style="margin: 5px; text-align: justify; color: dimgray;">{{$produto->nome}}</h6>
                                </div>
                                <div class="card-body" style="padding: 5px;">
                                    <p style="margin: 0; padding: 0; font-size: 30px; color: darkslategray; font-weight: bold">R$ {{$produto->preco}}</p>
                                    @if($produto->disponivel == 1)
                                        <p style="margin: 0; padding: 0; color: grey">Até 10x no cartão</p>
                                        <p style="margin: 0; padding: 0; color: grey">1+5 Crediário</p>
                                        <p style="margin: 0; padding: 0; color: grey">À vista</p>
                                    @else
                                        <span class="badge badge-danger">Indisponível</span>
                                        <p style="color: grey">Realize seu pedido e aguarde entrega.</p>
                                    @endif
                                </div>
                                </a>
                                <div class="card-footer" align="center" style="padding: 5px">
                                    @if($produto->disponivel == 1)
                                        <button onclick="quantidade({{$produto->id}}, '{{$produto->nome}}')" data-toggle="modal" data-target="#exampleModal"   class="btn btn-danger" style="width: 100%">Adicionar &nbsp;&nbsp;<i class="fas fa-cart-plus"></i></button>
                                    @else
                                        <a href="https://api.whatsapp.com/send?phone=5583999900364&text=*K Móveis*%0a%0aTenho interesse em:%0a{{$produto->nome}} - ({{$produto->codigosistema}})%0a%0a" class="btn btn-outline-danger" style="width: 100%">Tenho Interesse&nbsp;&nbsp;&nbsp;<i class="fab fa-whatsapp"></i></a>
                                    @endif
                                </div>
                            </div>
                    </div>
                    @endforeach
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
            <form id="formularioqtd" action="{{route("addcart")}}" method="post">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="idproduto" name="id">
                    <label>Quantidade</label>
                    <input type="number" class="form-control" id="qtd" min="0" name="qtd" value="1">
                </div>
                <div class="modal-footer">
                    <button id="btncanc" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button id="btnadd" onclick="disable()" type="submit" class="btn btn-success">Adicionar</button>
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
    function disable() {
        document.getElementById("btnadd").innerHTML = "Adicionando...";
        document.getElementById("btnadd").disabled = true;
        document.getElementById("btncanc").style.display = "none";
        document.getElementById("formularioqtd").submit();
    }
</script>
@endsection
