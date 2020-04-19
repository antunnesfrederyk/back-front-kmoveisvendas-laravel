@extends('layouts.app')
@section('content')
    @if(strstr(\Illuminate\Support\Facades\Auth::user()->email, '@') == "@vendas.com.br")
        <script type="text/javascript">
            window.location.href = "{{route('adminpedidos.index')}}";
        </script>
    @endif
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow mb-5 bg-white rounded">
                <div class="card-header">Gerenciamento de Informaçôes - K Móveis</div>
                <div class="card-body" align="center">
                    <img src="{{asset('brasao.png')}}" height="100px">
                    <h6>Olá {{\Illuminate\Support\Facades\Auth::user()->name}}, bem vindo ao painel administrativo de vendas Online.</h6>
                    <p></p>
                    <br>
                    <div class="row">
                        <div class="col-6">
                            <a href="{{route("admincategorias.index")}}" class="btn btn-primary btn-lg" style="width: 100%">Categorias</a>
                        </div>
                        <div class="col-6">
                            <a href="{{route("adminprodutos.index")}}" class="btn btn-primary btn-lg" style="width: 100%">Produtos</a>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <p style="margin: 0">Develop by <span style="font-weight: bold">Frederyk Antunnes</span></p>
                    <a href="http://atdsistemas.com.br" style="color: cadetblue; text-decoration: none">www.atdsistemas.com.br</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
