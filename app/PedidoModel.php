<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PedidoModel extends Model
{
    protected $table = "pedidos";
    protected $fillable = ['cliente', 'entrega', 'itens', 'formadepagamento', 'obs', 'cupom', 'total', 'telefone'];
}
