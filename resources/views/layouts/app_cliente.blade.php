<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Vendas Kmóveis</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body style="background-image: linear-gradient(to bottom right, red, yellow);">
    <div id="app">

        <nav class="d-lg-none navbar navbar-light bg-white fixed-top">
            <a class="navbar-brand" href="{{ url('/') }}">
               <img src="{{asset('brasao.png')}}" height="45px">
               <img class="ml-2" src="{{asset('rede.png')}}" height="40px">
            </a>
            <a href="{{route('carrinho')}}" class="navbar-toggler pt-2 pb-2">
                <div align="center">
                    <i style="font-size: 15px;" class="fa fa-shopping-cart"></i>
                    <p class="p-0 pt-1 m-0" style="font-size: 10px">Carrinho</p>
                </div>
            </a>
        </nav>

        <div class="d-none d-lg-block bg-white pt-2 pl-2 fixed-top" id="buscar">
            <form action="{{route('buscar')}}" method="GET">
                <div class="row">
                    <div class="col-3">
                        <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{asset('brasao.png')}}" height="70px">
                        <img class="ml-2" src="{{asset('rede.png')}}" height="40px">
                        </a>
                    </div>
                    <div class="col-5 form-inline">
                        <input type="search" name="produto" class="form-control w-75" style="float: left" placeholder="Buscar produtos...">
                        <button type="submit" class="btn btn-dark ml-1"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="dropdown show col-2 w-100 form-inline">
                        <a class="btn btn-primary dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Categorias
                        </a>
                        <div class="dropdown-menu mt-5" aria-labelledby="dropdownMenuLink">
                            @foreach(\App\CategoriaModel::all() as $categoria)
                                <a class="dropdown-item" href="{{route('listarporcategoria', $categoria->id)}}">{{$categoria->nome}}</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-2 w-100 float-right">
                        <a href="{{route('carrinho')}}" class="btn btn-lg pt-2 pb-2 float-right">
                            <div align="center" class="btn btn-success text-white">
                                <i style="font-size: 15px;" class="fa fa-shopping-cart"></i>
                                <p class="p-0 pt-0 m-0" style="font-size: 10px">Carrinho</p>
                            </div>
                        </a>
                    </div>
                </div>
            </form>
        </div>
        <br>
        <br>
        <br>
        <br>
        <div class="row mt-lg-3" style="display: none" id="slide">
            <div class="col-12">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @php($cont = 0 )
                        @foreach($banners as $banner)
                            @if($cont ==0)
                                @php($cont = 1 )
                                <div class="carousel-item active">
                            @else
                                 <div class="carousel-item">
                            @endif
                            <img class="d-block w-100" style="max-height: 220px; object-fit: contain" src="{{asset($banner->foto)}}" alt="{{$banner->titulo}}">
                            <div class="carousel-caption d-none d-md-block">
                                <h1>{{$banner->titulo}}</h1>
                                <p>{{$banner->descricao}}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Anterior</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Próximo</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="d-lg-none">
            <div align="center" class="container" style="padding: 0">
                <div class="card shadow p-2 mb-0 bg-white rounded col-11 mt-3" style="padding: 10px; margin: 0" align="left">
                    <form action="{{route('buscar')}}" method="GET">
                        <div class="row">
                            <div class="dropdown show col-md-2 mb-1">
                                <a class="btn btn-primary dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Categorias
                                </a>
                                <div class="dropdown-menu" style="margin-top: 125px; margin-left: 25px; margin-right: 5px" aria-labelledby="dropdownMenuLink">
                                    @foreach(\App\CategoriaModel::all() as $categoria)
                                        <a class="dropdown-item" href="{{route('listarporcategoria', $categoria->id)}}">{{$categoria->nome}}</a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-8 col-8">
                                <input type="search" name="produto" class="form-control" placeholder="Buscar produtos...">
                            </div>
                            <div class="col-md-2 col-4">
                                <button type="submit" class="btn btn-dark w-100"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                    <div class="col-12 m-0 p-0" align="center">

                    </div>
                </div>
            </div>
        </div>

        <main>
            <div class="container">
                @include('flash::message')
            </div>
            <div class="p-3">
            @yield('content')
            </div>
        </main>
    </div>
<div class="col-12" align="center">
    <p>Dúvidas?&nbsp;&nbsp;&nbsp;<a href="https://api.whatsapp.com/send?phone=5583999900364&text=Olá! Estou com uma dúvida!" class="btn btn-primary">Clique aqui</a></p>
    <p style="margin: 0; padding: 0"><strong>Endereço: </strong>Rua Cel. Marcolino Pereira Lima</p>
    <p style="margin: 0; padding: 0"><strong></strong>Centro, Princesa Isabel-PB</p>
    <p style="margin: 0; padding: 0"><strong>Contatos: </strong>(83) 3457-2894 / (83)99990-0364</p>
    <p style="color: grey">2020 © atdsistemas.com.br</p>
</div>
</body>
</html>
