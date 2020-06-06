<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{asset("logo.png")}}" type="image/x-icon">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>K Móveis</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Passion+One&display=swap" rel="stylesheet">
</head>
<body style="background-color: #ff8600">

<!-- <input type="hidden" id="url" value="www.google.com"> -->
<input type="hidden" id="url" value="{{$url}}">

<div class="col-12 mt-5" align="center">
    <div class="card col-12 col-lg-6 p-5" align="center">
        <div style="width: 100%;" align="center">
        <img src="http://vitrinekmoveis.atdsistemas.com.br/brasao.png" class="mb-4" width="200px">
        </div>
        <h1>Obrigado pela compra!</h1>
        <h4>Aguarde <span id="ct">3</span> segundos...</h4>
            <p>para concluir sua compra</p>
            <br>
            <p>Atenderemos o mais rápido possível</p>
        <div style="width: 100%;" align="center">
            <img src="http://vitrinekmoveis.atdsistemas.com.br/rede.png" class="mb-4" height="50px" width="60px">
        </div>
    </div>
</div>

<script>
    $(function() {
        var a = 3;
        var numero = $("#ct");
        setInterval(() => {
            if (a > 0) {
                a--;
                numero.text(a);
            } else {
                numero.text(0);
                window.location.replace($("#url").val());
            }
        }, 1000);
    });
</script>

</body>
</html>
