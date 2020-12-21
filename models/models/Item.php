<?php

namespace mywishlist\models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'item';
    protected $primarykey = 'id';
    public $timestamps = false;

    public function liste()
    {
        return $this->belongsTo('\mywishlist\models\Liste', 'liste_id');
    }
}
