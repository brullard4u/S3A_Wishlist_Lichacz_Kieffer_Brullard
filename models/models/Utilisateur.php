<?php

namespace mywishlist\models;

class utilisateur extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'utilisateur';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public static function getCurrentUser()
    {
        return 1;
    }
}
