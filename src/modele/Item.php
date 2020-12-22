<?php

namespace mywishlist\modele;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'item';
    protected $primarykey = 'id';
    public $timestamps = false;

    public function liste()
    {
        return $this->belongsTo('\mywishlist\modele\Liste', 'liste_id');
    }
}