<?php

namespace mywishlist\modele;

class utilisateur extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'utilisateur';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    public static function getCurrentUser()
    {
        return 1;
    }
}
