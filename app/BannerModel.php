<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BannerModel extends Model
{
    //
    protected $table = "banner";
    protected $fillable = ['foto', 'titulo', 'descricao'];
}
