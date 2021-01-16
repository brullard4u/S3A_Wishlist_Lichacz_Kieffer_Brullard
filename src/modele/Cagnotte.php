<?php

namespace mywishlist\modele;

use Illuminate\Database\Eloquent\Model;

class Cagnotte extends Model{

    protected $table = 'cagnotte';
    protected $primarykey = 'id_cagnotte';
    public $timestamps = false;
    
}
