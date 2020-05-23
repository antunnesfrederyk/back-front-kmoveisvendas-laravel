<?php

namespace App\Http\Controllers;

use App\BannerModel;
use App\CategoriaModel;
use App\PedidoModel;
use App\ProdutoModel;
use App\User;
use Carbon\Traits\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Sodium\add;



class ClienteController extends Controller
{

    public function principal()
    {
        $dados = ProdutoModel::orderByRaw('RAND()')->take(12)->get();
        $banners = BannerModel::all();
        return view('client.principal', compact('dados'), compact('banners'));
    }


    public function produto($id){
        $produto = ProdutoModel::findOrFail($id);
        return view('client.produtoview', compact('produto'));
    }

    public function buscarProdutoNome(Request $request)
    {
        $dados = ProdutoModel::where('nome', 'like', '%' . $request->produto . '%')->get();
        $busca = "Resultados para: ". $request->produto;
        return view('client.produtos', compact('dados', 'busca'));
    }

    public function buscarProdutoCategoria($id)
    {

        $categoria = CategoriaModel::findOrFail($id);
        $dados = ProdutoModel::all()->where('id_categoria', $id);
        $busca = 'Filtro Categoria: '. $categoria->nome;
        return view('client.produtos', compact('dados', 'busca'));
    }

    public function addCart(Request $request)
    {
        $id = $request['id'];
        $qtd = $request['qtd'];
        $dado = ProdutoModel::findOrFail($id);
        session_start();
        if(isset($_SESSION['carrinho'])){
            array_push($_SESSION['carrinho'], [$id, $qtd]);
            $_SESSION['total'] += (str_replace(',', '.', str_replace('.', '', $dado->preco)) * str_replace(',', '.', $qtd));
        }else{
            $_SESSION['total'] = (str_replace(',', '.', str_replace('.', '', $dado->preco)) * str_replace(',', '.', $qtd));
            $_SESSION['carrinho'] = array();
            array_push($_SESSION['carrinho'], [$id, $qtd]);
        }
        flash("Item Adicionado")->success();
        return redirect()->route('carrinho');

    }

    public function removecart($id, $qtd)
    {
        session_start();
        foreach ($_SESSION['carrinho'] as $car){
            if($car[0]==$id){
                $pos = array_search([$id, $qtd], $_SESSION['carrinho']);
                unset($_SESSION['carrinho'][$pos]);
            }
        }
        $dado = ProdutoModel::findOrFail($id);
        $_SESSION['total'] -= (str_replace(',', '.', str_replace('.', '', $dado->preco)) * str_replace(',', '.', $qtd));
        flash("Item Removido")->success();
        return redirect()->route('carrinho');
    }

    public function carrinho()
    {
        return view('client.carrinho');
    }

    public function enviar(Request $request)
    {

        session_start();

        $pedido = new PedidoModel();

        $nome = $request['nome'];
        $telefone = $request['telefone'];
        $endereco = $request['endereco'];
        $retirar = $request['retirar'];
        $obs = $request['obs'];
        $pagamento = $request['pagamento'];
        $parc_cart = $request['parc_cartao'];
        $parc_cred = $request['parc_cred'];
        $troco = $request['troco'];
        $cpf = $request['cpf'];
        $cupom = $request['cupom'];

        if($retirar == "sim"){
            $endereco = "Retirar no Estabelecimento";
        }

        if ($pagamento == "Cartão") {
            $detalhespay = $parc_cart;
        }else if ($pagamento == "A vista") {
            $detalhespay = "Troco para ".$troco;
        }else if ($pagamento == "Crediário") {
            $detalhespay = $parc_cred . " - CPF:".$cpf;
        }

        $itens = "";
        $texto = "🛍 *NOVO PEDIDO* - K Móveis%0a".$cupom."%0a%0a👤 *Cliente:* ".$nome."%0a%f0%9f%93%8d _".$endereco. "_%0a".$telefone."0a%0a📦 *Produtos*%0a------------------------%0a";
        foreach ( $_SESSION['carrinho'] as $item){
            $dado = ProdutoModel::findOrFail($item[0]);
            $texto = $texto . "%e2%80%a2%20" . $dado->codigosistema ."%0a". explode(" ", $dado->nome)[0]." ". explode(" ", $dado->nome)[1]  ."%0aQtd: ". $item[1] . "%0aR$ ".$dado->preco ."%0a%0a";
            $itens = $itens . " (".$dado->codigosistema." - ".  $item[1] .'x '.explode(" ", $dado->nome)[0]." ". explode(" ", $dado->nome)[1]." - ".$dado->preco.") ";
        }

        $texto = $texto . "------------------------%0a*Total:* R$ ".self::pegartotal()." %0a------------------------%0a💳 *Forma de Pagamento:* ".$pagamento."%0a" . $detalhespay ."%0a%0a*Observações:* ".$obs ."%0a------------------------%0a". date('d/m/Y h:i:s A');

        $pedido->cliente = $nome;
        $pedido->entrega = $endereco;
        $pedido->formadepagamento = $pagamento . " - " .str_replace("%2B", "+", $detalhespay);
        $pedido->obs = $obs;
        $pedido->telefone = $telefone;
        $pedido->cupom = $cupom;
        $pedido->total = self::pegartotal();
        $pedido->itens = $itens;

        $pedido->save();
        return redirect(url('https://api.whatsapp.com/send?phone=5583999900364&text='. $texto));
    }

    public function limpar()
    {
        session_start();
        session_destroy();
        return redirect()->route('carrinho');
    }

    public static function pegarcarrinho(){
        if(isset($_SESSION['carrinho'])){
            return count($_SESSION['carrinho']);
        } else{
            return 0;
        }
    }

    public static function pegartotal(){
        $total=0.00;
        //session_start();
        foreach ( $_SESSION['carrinho'] as $item){
            $dado = ProdutoModel::findOrFail($item[0]);
            $total += (str_replace(',', '.', str_replace('.', '', $dado->preco)) * str_replace(',', '.', $item[1]));
        }
        return number_format($_SESSION['total'], 2, ',', '.');
    }



    public function listarUsuarios(){
        $dados = User::all();

//        return $dados;
         return view('admin.usuarios_list', compact('dados'));
    }

    public function alterarStatus(Request $request, $id){
        $dado = PedidoModel::findOrFail($id);
        $dado->status = $request['status'];
        $dado->id_user = Auth::user()->id;
        $dado->save();
        return redirect()->route('adminpedidos.index');
    }
}
