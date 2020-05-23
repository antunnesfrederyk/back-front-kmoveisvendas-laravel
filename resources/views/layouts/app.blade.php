<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Vendas Kmóveis</title>

    <!-- Scripts --><!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{asset('js/ckeditor/ckeditor.js')}}"></script>

    <script src="{{asset('js/ckeditor/ckeditor.js')}}"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable(
                {
                    "language": {
                        "search":"Buscar",
                        "lengthMenu": "Visualizar _MENU_ itens por página",
                        "zeroRecords": "Nenhum itens encontrado",
                        "info": "Exibindo pagina _PAGE_ de _PAGES_",
                        "infoEmpty": "Sem Registros",
                        "infoFiltered": "(Filtro aplicado em _MAX_ itens)",
                        "paginate": {
                            "previous": "Anterior",
                            "next": "Próxima"
                        }
                    }
                }
            );
        });
    </script>

</head>
<body style="background-image: linear-gradient(to bottom right, red, yellow);">
    <div id="app">

        @auth

        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/admin') }}">
                   Vendas K Móveis
                </a>


                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @if(strstr(\Illuminate\Support\Facades\Auth::user()->email, '@') != "@vendas.com.br")
                        <div class="dropdown show m-1">
                            <a class="btn btn-secondary w-100 h-100 dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Produtos
                            </a>
                        </div>
                        <a class="btn btn-secondary m-1" href="{{route('admincategorias.index')}}" >Categorias</a>
                        <a class="btn btn-secondary m-1" href="{{route('adminbanners.index')}}" >Banners</a>
                        @endif
                        <a class="btn btn-secondary m-1" href="{{route('adminpedidos.index')}}" >Pedidos</a>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @if(strstr(\Illuminate\Support\Facades\Auth::user()->email, '@') != "@vendas.com.br")
                                    <a class="dropdown-item" href="{{url('/register')}}">Novo Usuário</a>
                                    <a class="dropdown-item" href="{{route('usuarios')}}">Listar Usuários</a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>

                    </ul>
                </div>
            </div>
        </nav>
        @endauth
        <main class="py-4">
            <div class="container">
                @include('flash::message')
            </div>
            @yield('content')
        </main>
    </div>
</body>
</html>
