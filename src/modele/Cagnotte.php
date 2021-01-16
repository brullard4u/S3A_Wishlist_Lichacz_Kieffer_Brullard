<?php

namespace mywishlist\modele;

use Illuminate\Database\Eloquent\Model;

class Cagnotte extends Model{

    protected $table = 'cagnotte';
    protected $primarykey = 'cagnotte_id';
    public $timestamps = false;
    
}
