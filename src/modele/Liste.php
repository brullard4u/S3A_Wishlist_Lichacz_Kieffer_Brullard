<?php


namespace mywishlist\modele;

use Illuminate\Database\Eloquent\Model;

class Liste extends Model
{

    protected $table = 'liste';
    protected $primaryKey = 'no';
    public $timestamps = false;

    public function items()
    {
        return $this->hasMany('\mywishlist\modele\Item', 'liste_id');
    }
}
