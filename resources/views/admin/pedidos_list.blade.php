@extends('layouts.app')

@section('content')
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow mb-5 bg-white rounded">
                <div class="card-header">
                    <div class="float-left"><a><h4>Pedidos</h4></a></div>
                </div>
                <div class="card-body table-responsive">
                    <h4>Lista de Pedidos</h4>
                    <table  id="myTable" class="table table-striped table-bordered">
                        <thead class="table-dark">
                        <tr>
                            <td>Cliente/Entrega</td>
                            <td>itens</td>
                            <td>Pagamento</td>
                            <td>Obs</td>
                            <td>Cupom</td>
                            <td>Total/Data</td>
                            <td>Status</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dados as $dado)
                        <tr>
                            <td>
                                <p style="margin: 0">{{$dado->cliente}}</p>
                                <p style="margin: 0; color: darkred">{{$dado->telefone}}</p>
                                <p style="color: grey; margin: 0">{{$dado->entrega}}</p>
                            </td>
                            <td>
                                {{$dado->itens}}

                            </td>
                            <td>
                                {{$dado->formadepagamento}}

                            </td>
                            <td>
                                {{$dado->obs}}

                            </td>
                            <td>
                                {{$dado->cupom}}

                            </td>
                            <td>
                                <h4>{{$dado->total}}</h4>
                                <p style="margin: 0; color: darkred">{{\Carbon\Carbon::parse($dado->created_at)->format('d/m/Y H:i:s')}}</p>
                            </td>
                            <td>
                                @if($dado->status ==0)
                                    <p>Pedido Recebido</p>
                                @elseif($dado->status ==1)
                                    <p style="color: dimgrey">Atendimento Iniciado por {{\App\User::findOrFail($dado->id_user)->name}}</p>
                                @elseif($dado->status ==2)
                                    <p style="color: green">Atendimento Concluído por {{\App\User::findOrFail($dado->id_user)->name}}</p>
                                @elseif($dado->status ==3)
                                    <p style="color: darkred">Venda Cancelada por {{\App\User::findOrFail($dado->id_user)->name}}</p>
                                @endif

                                    @if($dado->status == 0 || $dado->status == 1)
                                    <form id="form_status" method="post" action="{{route('status', $dado->id)}}">
                                        @csrf
                                            <select onchange="selecionarcategoria({{$dado->id}})" name="status" class="form-control">
                                                <option value="0">Alterar status...</option>
                                                <option value="1">Atendimento Iniciado</option>
                                                <option value="2">Atendimento Concluído</option>
                                                <option value="3">Venda Cancelada</option>
                                            </select>
                                        <button id="button{{$dado->id}}" style="display: none" type="submit" class="btn btn-sm w-100 btn-danger mt-1">Alterar</button>
                                        </form>
                                    @endif
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

    <script type="text/javascript">
        function selecionarcategoria(id) {
           document.getElementById('button'+id).style.display = "block";
        }
    </script>

@endsection
