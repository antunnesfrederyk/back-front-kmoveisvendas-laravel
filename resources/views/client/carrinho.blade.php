@extends('layouts.app_cliente')
@section('content')
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 card" style="margin-top: 5px; padding-top: 20px;">
            <div class="card-header">
                <h3>Carrinho de Compras</h3>
            </div>
            <div class="card-body" style="padding: 0" align="center">
{{--                @php(session_start())--}}
                @if(\App\Http\Controllers\ClienteController::pegarcarrinho() > 0)
                    <table class="table table-bordered table-responsive-sm">
                        <thead class="table-dark">
                        <tr>
                            <td>Imagem</td>
                            <td>Produto</td>
                            <td>Quantidade</td>
                            <td>Preço</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($_SESSION['carrinho'] as $id => $produto)
                            <tr>
                                <td>
                                    <a href="{{route('produto', \App\ProdutoModel::where('id', $id)->get()[0]->id)}}" style="text-decoration: none">
                                    <img src="{{\App\ProdutoModel::where('id', $id)->get()[0]->foto_um}}" height="80px">
                                    </a>
                                </td>
                                <td>
                                    <a href="{{route('produto',  \App\ProdutoModel::where('id', $id)->get()[0]->id)}}" style="text-decoration: none">
                                    {{\App\ProdutoModel::where('id', $id)->get()[0]->nome}}
                                    </a>
                                </td>

                                <td align="center" style="padding-top: 30px">

                                    <div id="divqtd<?php echo $id ?>">
                                        {{$produto}}
                                        <a onclick="editar(<?php echo $id ?>)" style="text-decoration: none">&nbsp;&nbsp<i style=" font-size: 18px" class="fa fa-edit"></i></a>
                                    </div>
                                    <div id="divqtdedit<?php echo $id ?>" style="display: none">
                                        <input id="valor<?php echo $id ?>" type="number" min="0" value="{{$produto}}">
                                        <a id="btnsalvar<?php echo $id ?>" onclick="salvar(<?php echo $id ?>)" style="text-decoration: none">&nbsp;&nbsp<i style=" font-size: 18px" class="fa fa-save"></i></a>
                                    </div>
                                </td>
{{--                                <td align="center" style="padding-top: 30px">{{$produto}}--}}
{{--                                    <a href="{{route('removecart', [$id, $produto])}}" style="text-decoration: none">&nbsp;&nbsp;<i style="color: darkred; font-size: 18px" class="fa fa-edit"></i></a>--}}
{{--                                </td>--}}
                                <td>R$ {{\App\ProdutoModel::where('id', $id)->get()[0]->preco}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="col-12" align="right"><h4 style="margin: 0; font-weight: bold">Total R$ {{number_format($total, 2, ',', '.')}}</h4></div>
                    <div style="margin-top: 20px">
                        <a href="{{route('principal')}}" class="btn btn-dark float-left col-6">Comprar Mais</a>
                        <a href="{{route('limpar')}}" class="btn btn-danger float-left col-5 offset-1">Zerar Itens</a>
                        <br>
                        <br>
                        <br>
                        <div>
                            <form action="{{route('enviar')}}" method="post">
                                @csrf
                                <div class="card p-1 shadow p-3 mb-3 bg-white rounded" align="left">
                                    <h5 align="center">Dados para entrega</h5>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <label for="nome">Nome de Contato</label>
                                            <input class="form-control" type="text" id="nome" name="nome" required>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label for="telefone">Telefone</label>
                                            <input class="form-control" type="tel" id="telefone" name="telefone" required>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <label for="retirar">Retirar no Estabelecimento</label>
                                            <select class="form-control" id="retirar" name="retirar" onchange="retire()">
                                                <option value="nao">Não</option>
                                                <option value="sim">Sim</option>
                                            </select>
                                        </div>

                                        <div class="col-md-8 col-12">
                                            <label for="endereco">Endereço para Enrega</label>
                                            <input class="form-control" type="text" id="endereco" name="endereco" required>
                                        </div>

                                        <div class="col-12">
                                            <label for="obs">Observações sobre o pedido</label>
                                            <input class="form-control" type="text" id="obs" name="obs">
                                        </div>

                                        <div class="col-6">
                                            <label for="pagamento">Pagamento</label>
                                            <select class="form-control"id="pagamento" name="pagamento" onchange="alterPayment()" required>
                                                <option value="Cartão">Cartão</option>
                                                <option value="A vista">A vista</option>
                                                <option value="Crediário">Crediário (Apenas para clientes com crediário)</option>
                                            </select>
                                        </div>

                                        <div class="col-6" id="div_bandeira">
                                            <label for="parc_cartao">Parcelamento</label>
                                            <select class="form-control"id="parc_cartao" name="parc_cartao">
                                                <option value="(Débito) 1x R$ {{number_format($total, 2, ',', '.')}} s/juros">(Débito) 1 x R$ {{number_format($total, 2, ',', '.')}} s/juros</option>
                                                <option value="(Crédito) 1x R$ {{number_format($total, 2, ',', '.')}} s/juros">(Crédito) 1 x R$ {{number_format($total, 2, ',', '.')}} s/juros</option>
                                                <option value="(Crédito) 2x R$ {{number_format($total/2, 2, ',', '.')}} s/juros">(Crédito) 2x R$ {{number_format($total/2, 2, ',', '.')}} s/juros</option>
                                                <option value="(Crédito) 3x R$ {{number_format($total/3, 2, ',', '.')}} s/juros">(Crédito) 3x R$ {{number_format($total/3, 2, ',', '.')}} s/juros</option>
                                                <option value="(Crédito) 4x R$ {{number_format($total/4, 2, ',', '.')}} s/juros">(Crédito) 4x R$ {{number_format($total/4, 2, ',', '.')}} s/juros</option>
                                                <option value="(Crédito) 5x R$ {{number_format($total/5, 2, ',', '.')}} s/juros">(Crédito) 5x R$ {{number_format($total/5, 2, ',', '.')}} s/juros</option>
                                                <option value="(Crédito) 6x R$ {{number_format($total/6, 2, ',', '.')}} s/juros">(Crédito) 6x R$ {{number_format($total/6, 2, ',', '.')}} s/juros</option>
                                                <option value="(Crédito) 7x R$ {{number_format($total/7, 2, ',', '.')}} s/juros">(Crédito) 7x R$ {{number_format($total/7, 2, ',', '.')}} s/juros</option>
                                                <option value="(Crédito) 8x R$ {{number_format($total/8, 2, ',', '.')}} s/juros">(Crédito) 8x R$ {{number_format($total/8, 2, ',', '.')}} s/juros</option>
                                                <option value="(Crédito) 9x R$ {{number_format($total/9, 2, ',', '.')}} s/juros">(Crédito) 9x R$ {{number_format($total/9, 2, ',', '.')}} s/juros</option>
                                                <option value="(Crédito) 10x R$ {{number_format($total/10, 2, ',', '.')}} s/juros">(Crédito) 10x {{number_format($total/10, 2, ',', '.')}} s/juros</option>
                                            </select>
                                        </div>

                                        <div class="col-6" style="display: none" id="div_troco">
                                            <label for="troco">Troco</label>
                                            <input type="text" class="form-control"id="troco" value="" name="troco"/>
                                        </div>

                                        <div class="col-6" id="div_cred" style="display: none" >
                                            <label for="parc_cred">Parcelamento</label>
                                            <select class="form-control"id="parc_cred" name="parc_cred">
                                                <option value="0 %2B 1 de R$ {{number_format($total, 2, ',', '.')}} s/juros">0 + 1 de R$ {{number_format($total, 2, ',', '.')}} s/juros</option>
                                                <option value="1 %2B 1 de R$ {{number_format($total/2, 2, ',', '.')}} s/juros">1 + 1 de R$ {{number_format($total/2, 2, ',', '.')}} s/juros</option>
                                                <option value="1 %2B 2 de R$ {{number_format($total/3, 2, ',', '.')}} s/juros">1 + 2 de R$ {{number_format($total/3, 2, ',', '.')}} s/juros</option>
                                                <option value="1 %2B 3 de R$ {{number_format($total/4, 2, ',', '.')}} s/juros">1 + 3 de R$ {{number_format($total/4, 2, ',', '.')}} s/juros</option>
                                                <option value="1 %2B 4 de R$ {{number_format($total/5, 2, ',', '.')}} s/juros">1 + 4 de R$ {{number_format($total/5, 2, ',', '.')}} s/juros</option>
                                                <option value="1 %2B 5 de R$ {{number_format($total/6, 2, ',', '.')}} s/juros">1 + 5 de R$ {{number_format($total/6, 2, ',', '.')}} s/juros</option>
                                            </select>
                                        </div>

                                        <div class="col-12 col-md-6" style="display: none" id="div_cpf">
                                            <label for="cpf">CPF</label>
                                            <input type="text" class="form-control" id="cpf" name="cpf"/>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="cupom">CUPOM DE DESCONTO</label>
                                            <input type="text" class="form-control" id="cupom" name="cupom" style="background-color: #ffeadc"/>
                                        </div>
                                    </div>
                                    <label class="bg-warning mt-2" align="center">Atenção: Ao clicar em "Enviar Pedido" , clique no simbolo do Whatsapp e envie envie a mensagem que estará escrita!</label>
                                    <button type="submit" class="btn btn-lg btn-danger float-right col-12 mt-2">Enviar Pedido</button>

                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="card shadow p-3 mb-5 bg-white rounded">
                        <h4>Carrinho Vazio</h4> <a href="{{route('principal')}}" class="btn btn-dark">Adicionar Itens</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>

    <script>
        function alterPayment() {
            var cartao = document.getElementById("div_bandeira");
            var troco = document.getElementById("div_troco");
            var cpf = document.getElementById("div_cpf");
            var cred = document.getElementById("div_cred");

            var select = document.getElementById('pagamento');
            if(select.options[select.selectedIndex].value === "A vista"){
                cartao.style.display = "none";
                troco.style.display = "block";
                cpf.style.display = "none";
                cred.style.display = "none";

            }
            if(select.options[select.selectedIndex].value === "Cartão"){
                cartao.style.display = "block";
                troco.style.display = "none";
                cpf.style.display = "none";
                cred.style.display = "none";

            }
            if(select.options[select.selectedIndex].value === "Crediário"){
                cartao.style.display = "none";
                troco.style.display = "none";
                cpf.style.display = "block";
                cred.style.display = "block";

            }

        }

        function retire() {
            var select = document.getElementById('retirar');
            if(select.options[select.selectedIndex].value === "sim") {
                document.getElementById("endereco").disabled = true;
            }else{
                document.getElementById("endereco").disabled = false;
            }
        }


               function editar(id) {
                    document.getElementById("divqtd"+id).style.display = "none";
                    document.getElementById("divqtdedit"+id).style.display = "block";
                }
                function salvar(id) {
                    var qtd = document.getElementById("valor"+id).value;
                    document.getElementById("divqtdedit"+id).innerText = "Salvando...";
                    window.location.href = "/removecart/"+id+"/"+qtd;

                }
    </script>
{{--                    <div class="col-12" align="right"><h4 style="margin: 0; font-weight: bold">Total R$ {{number_format($total, 2, ',', '.')}}</h4></div>--}}
{{--                    <div style="margin-top: 20px">--}}
{{--                        <a href="{{route('principal')}}" class="btn btn-dark float-left col-6">Comprar Mais</a>--}}
{{--                        <a href="{{route('limpar')}}" class="btn btn-danger float-left col-5 offset-1">Zerar Itens</a>--}}
{{--                        <br>--}}
{{--                        <br>--}}
{{--                        <br>--}}
{{--                        <div>--}}
{{--                            <form action="{{route('enviar')}}" method="post">--}}
{{--                                @csrf--}}
{{--                                <div class="card p-1 shadow p-3 mb-3 bg-white rounded" align="left">--}}
{{--                                    <h5 align="center">Dados para entrega</h5>--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-12 col-md-6">--}}
{{--                                            <label for="nome">Nome de Contato</label>--}}
{{--                                            <input class="form-control" type="text" id="nome" name="nome" required>--}}
{{--                                        </div>--}}

{{--                                        <div class="col-12 col-md-6">--}}
{{--                                            <label for="telefone">Telefone</label>--}}
{{--                                            <input class="form-control" type="tel" id="telefone" name="telefone" required>--}}
{{--                                        </div>--}}

{{--                                        <div class="col-md-4 col-12">--}}
{{--                                            <label for="retirar">Retirar no Estabelecimento</label>--}}
{{--                                            <select class="form-control" id="retirar" name="retirar" onchange="retire()">--}}
{{--                                                <option value="nao">Não</option>--}}
{{--                                                <option value="sim">Sim</option>--}}
{{--                                            </select>--}}
{{--                                        </div>--}}

{{--                                        <div class="col-md-8 col-12">--}}
{{--                                            <label for="endereco">Endereço para Enrega</label>--}}
{{--                                            <input class="form-control" type="text" id="endereco" name="endereco" required>--}}
{{--                                        </div>--}}

{{--                                        <div class="col-4">--}}
{{--                                            <label for="obs">Observações sobre o pedido</label>--}}
{{--                                            <input class="form-control" type="text" id="obs" name="obs">--}}
{{--                                        </div>--}}

{{--                                        <div class="col-3">--}}
{{--                                            <label for="pagamento">Pagamento</label>--}}
{{--                                            <select class="form-control"id="pagamento" name="pagamento" onchange="alterPayment()" required>--}}
{{--                                                <option value="Cartão">Cartão</option>--}}
{{--                                                <option value="A vista">Dinheiro</option>--}}
{{--                                                <option value="Crediário">Crediário (Apenas para clientes com crediário)</option>--}}
{{--                                            </select>--}}
{{--                                        </div>--}}

{{--                                        <div class="col-5" id="div_bandeira">--}}
{{--                                            <label for="parc_cartao">Parcelamento</label>--}}
{{--                                            <select class="form-control"id="parc_cartao" name="parc_cartao">--}}
{{--                                                <option value="(Débito) 1x R$ {{number_format($total, 2, ',', '.')}} s/juros">(Débito) 1 x R$ {{number_format($total, 2, ',', '.')}} s/juros</option>--}}
{{--                                                <option value="(Crédito) 1x R$ {{number_format($total, 2, ',', '.')}} s/juros">(Crédito) 1 x R$ {{number_format($total, 2, ',', '.')}} s/juros</option>--}}
{{--                                                <option value="(Crédito) 2x R$ {{number_format($total/2, 2, ',', '.')}} s/juros">(Crédito) 2x R$ {{number_format($total/2, 2, ',', '.')}} s/juros</option>--}}
{{--                                                <option value="(Crédito) 3x R$ {{number_format($total/3, 2, ',', '.')}} s/juros">(Crédito) 3x R$ {{number_format($total/3, 2, ',', '.')}} s/juros</option>--}}
{{--                                                <option value="(Crédito) 4x R$ {{number_format($total/4, 2, ',', '.')}} s/juros">(Crédito) 4x R$ {{number_format($total/4, 2, ',', '.')}} s/juros</option>--}}
{{--                                                <option value="(Crédito) 5x R$ {{number_format($total/5, 2, ',', '.')}} s/juros">(Crédito) 5x R$ {{number_format($total/5, 2, ',', '.')}} s/juros</option>--}}
{{--                                                <option value="(Crédito) 6x R$ {{number_format($total/6, 2, ',', '.')}} s/juros">(Crédito) 6x R$ {{number_format($total/6, 2, ',', '.')}} s/juros</option>--}}
{{--                                                <option value="(Crédito) 7x R$ {{number_format($total/7, 2, ',', '.')}} s/juros">(Crédito) 7x R$ {{number_format($total/7, 2, ',', '.')}} s/juros</option>--}}
{{--                                                <option value="(Crédito) 8x R$ {{number_format($total/8, 2, ',', '.')}} s/juros">(Crédito) 8x R$ {{number_format($total/8, 2, ',', '.')}} s/juros</option>--}}
{{--                                                <option value="(Crédito) 9x R$ {{number_format($total/9, 2, ',', '.')}} s/juros">(Crédito) 9x R$ {{number_format($total/9, 2, ',', '.')}} s/juros</option>--}}
{{--                                                <option value="(Crédito) 10x R$ {{number_format($total/10, 2, ',', '.')}} s/juros">(Crédito) 10x {{number_format($total/10, 2, ',', '.')}} s/juros</option>--}}
{{--                                            </select>--}}
{{--                                        </div>--}}

{{--                                        <div class="col-5" style="display: none" id="div_troco">--}}
{{--                                            <label for="troco">Troco para:</label>--}}
{{--                                            <input type="text" class="form-control"id="troco" value="" name="troco"/>--}}
{{--                                        </div>--}}

{{--                                        <div class="col-6" id="div_cred" style="display: none" >--}}
{{--                                            <label for="parc_cred">Parcelamento</label>--}}
{{--                                            <select class="form-control"id="parc_cred" name="parc_cred">--}}
{{--                                                <option value="0 %2B 1 de R$ {{number_format($total, 2, ',', '.')}} s/juros">0 + 1 de R$ {{number_format($total, 2, ',', '.')}} s/juros</option>--}}
{{--                                                <option value="1 %2B 1 de R$ {{number_format($total/2, 2, ',', '.')}} s/juros">1 + 1 de R$ {{number_format($total/2, 2, ',', '.')}} s/juros</option>--}}
{{--                                                <option value="1 %2B 2 de R$ {{number_format($total/3, 2, ',', '.')}} s/juros">1 + 2 de R$ {{number_format($total/3, 2, ',', '.')}} s/juros</option>--}}
{{--                                                <option value="1 %2B 3 de R$ {{number_format($total/4, 2, ',', '.')}} s/juros">1 + 3 de R$ {{number_format($total/4, 2, ',', '.')}} s/juros</option>--}}
{{--                                                <option value="1 %2B 4 de R$ {{number_format($total/5, 2, ',', '.')}} s/juros">1 + 4 de R$ {{number_format($total/5, 2, ',', '.')}} s/juros</option>--}}
{{--                                                <option value="1 %2B 5 de R$ {{number_format($total/6, 2, ',', '.')}} s/juros">1 + 5 de R$ {{number_format($total/6, 2, ',', '.')}} s/juros</option>--}}
{{--                                            </select>--}}
{{--                                        </div>--}}

{{--                                        <div class="col-5">--}}
{{--                                            <label for="irmaos">Faz parte do Irmãos na Obra?</label>--}}
{{--                                            <select class="form-control"id="irmaos" name="irmaos" onchange="irmao()" required>--}}
{{--                                                <option selected value="nao">Não</option>--}}
{{--                                                <option value="sim">Sim</option>--}}
{{--                                            </select>--}}
{{--                                        </div>--}}

{{--                                        <div class="col-7" id="div_prof" style="display: none">--}}
{{--                                            <label for="profissional">Contato do Profissional (Nome, Telefone):</label>--}}
{{--                                            <input class="form-control" type="text" id="profissional" name="profissional">--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-6" style="display: none" id="div_cpf">--}}
{{--                                            <label for="cpf">CPF</label>--}}
{{--                                            <input type="text" class="form-control" id="cpf" name="cpf"/>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 col-md-6">--}}
{{--                                            <label for="cupom">CUPOM DE DESCONTO</label>--}}
{{--                                            <input type="text" class="form-control" id="cupom" value="" name="cupom" />--}}
{{--                                            <input type="hidden" class="form-control" id="cupom" value="" name="parc_cred"/>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <label class="bg-warning mt-2" align="center">Atenção: Ao clicar em "Enviar Pedido" , clique no simbolo do Whatsapp e envie envie a mensagem que estará escrita!</label>--}}
{{--                                    <button type="submit" class="btn btn-lg btn-danger float-right col-12 mt-2">Enviar Pedido</button>--}}

{{--                                </div>--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @else--}}
{{--                    <div class="card shadow p-3 mb-5 bg-white rounded">--}}
{{--                        <h4>Carrinho Vazio</h4> <a href="{{route('principal')}}" class="btn btn-dark">Adicionar Itens</a>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

{{--    <script>--}}
{{--        function alterPayment() {--}}
{{--            var cartao = document.getElementById("div_bandeira");--}}
{{--            var troco = document.getElementById("div_troco");--}}
{{--            // var cpf = document.getElementById("div_cpf");--}}
{{--            // var cred = document.getElementById("div_cred");--}}

{{--            var select = document.getElementById('pagamento');--}}
{{--            if(select.options[select.selectedIndex].value === "A vista"){--}}
{{--                 cartao.style.display = "none";--}}
{{--                 troco.style.display = "block";--}}
{{--                 // cpf.style.display = "none";--}}
{{--                 // cred.style.display = "none";--}}

{{--            }--}}
{{--            if(select.options[select.selectedIndex].value === "Cartão"){--}}
{{--                cartao.style.display = "block";--}}
{{--                troco.style.display = "none";--}}
{{--                // cpf.style.display = "none";--}}
{{--                // cred.style.display = "none";--}}

{{--            }--}}
{{--            // if(select.options[select.selectedIndex].value === "Crediário"){--}}
{{--            //     cartao.style.display = "none";--}}
{{--            //     troco.style.display = "none";--}}
{{--            //     cpf.style.display = "block";--}}
{{--            //     cred.style.display = "block";--}}
{{--            //--}}
{{--            // }--}}

{{--        }--}}

{{--        function irmao() {--}}

{{--            var prof = document.getElementById("div_prof");--}}

{{--            var select = document.getElementById('irmaos');--}}
{{--            if(select.options[select.selectedIndex].value === "sim"){--}}
{{--                prof.style.display = "block";--}}
{{--            }--}}
{{--            if(select.options[select.selectedIndex].value === "nao"){--}}
{{--                prof.style.display = "none";--}}
{{--            }--}}

{{--        }--}}

{{--        function retire() {--}}
{{--            var select = document.getElementById('retirar');--}}
{{--            if(select.options[select.selectedIndex].value === "sim") {--}}
{{--                document.getElementById("endereco").disabled = true;--}}
{{--            }else{--}}
{{--                document.getElementById("endereco").disabled = false;--}}
{{--            }--}}
{{--        }--}}

{{--        function editar(id) {--}}
{{--            document.getElementById("divqtd"+id).style.display = "none";--}}
{{--            document.getElementById("divqtdedit"+id).style.display = "block";--}}
{{--        }--}}
{{--        function salvar(id) {--}}
{{--            var qtd = document.getElementById("valor"+id).value;--}}
{{--            document.getElementById("divqtdedit"+id).innerText = "Salvando...";--}}
{{--            window.location.href = "/removecart/"+id+"/"+qtd;--}}

{{--        }--}}

{{--    </script>--}}
@endsection
