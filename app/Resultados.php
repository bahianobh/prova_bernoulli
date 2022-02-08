<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resultados extends Model
{
    protected $table = "resultado";

    protected $primaryKey = 'id_resultado';
 
    protected $guarded = ['id_resultado'];
 
    public $timestamps = false;
}
