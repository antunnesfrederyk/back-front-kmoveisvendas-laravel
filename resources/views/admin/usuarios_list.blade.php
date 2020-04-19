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
                    <div class="float-left"><a><h4>Usuários</h4></a></div>
                </div>
                <div class="card-body table-responsive">
                    <h4>Lista de Usuários</h4>
                    <table  id="myTable" class="table table-striped table-bordered">
                        <thead class="table-dark">
                        <tr>
                            <td>Nome</td>
                            <td>Email</td>
                            <td>Itens Cadastrados</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dados as $dado)
                        <tr>
                            <td>
                                <p style="margin: 0">{{$dado->name}}</p>
                                Conta criada em: {{\Carbon\Carbon::parse($dado->created_at)->format('d/m/Y H:i:s')}}
                            </td>
                            <td>
                                {{$dado->email}}

                            </td>
                            <td align="center">
                                {{\App\ProdutoModel::all()->where('id_user', $dado->id)->count()}}

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

@endsection
