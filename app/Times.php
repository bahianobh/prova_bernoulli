<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Times extends Model
{
   protected $table = "times_serie_a";

   protected $primaryKey = 'id_time';

   protected $guarded = ['id_time'];

   public $timestamps = false;
}
