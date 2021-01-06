<?php

namespace mywishlist\modele;

use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    protected $table = 'commentaire';
    protected $primarykey = 'id_commentaire';
    public $timestamps = false;
}