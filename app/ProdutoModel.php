<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdutoModel extends Model
{

    protected $table = 'produtos';
    protected $fillable = [
        'nome', 'descricao', 'preco', 'parcelamento', 'codigosistema', 'foto_um', 'foto_dois', 'foto_tres', 'id_categoria', 'id_user'
    ];
}
