<?php

namespace mywishlist\controleur;

require_once  "./vendor/autoload.php";

use mywishlist\models\Item;
use mywishlist\models\Liste;
use mywishlist\vue\VueListe;
use mywishlist\vue\VueItem;


class ControleurItem
{

    protected $liste;

    public function __construct($name)
    {
        $this->liste = Liste::where('token', '=', $name)->first();
    }

    public function itemCreation()
    {
        $aff = new VueListe("createur", $this->liste);
        $aff->afficherListeNvItem();
        echo $aff->render();
    }

    public function ajouterItem()
    {
        $app = \Slim\Slim::getInstance();
        $title = $app->request->post('titre');
        $descr = $app->request->post('descr');
        $item = new Item();
        $item->nom = filter_var($title, FILTER_SANITIZE_STRING);
        $item->descr = filter_var($descr, FILTER_SANITIZE_STRING);
        $item->liste = $this->liste->no;
        $item->tarif = intval($app->request->post('prix'));
        $item->save();
        $aff = new Liste();
        $aff->afficherListe($this->liste->token);
    }

    public function afficheritem($id)
    {
        $item = Item::where('liste_id', '=', $this->liste->no)->where('id', '=', $id)->first();
        $aff = new VueItem("createur", $this->liste, $item);
        echo $aff->render(); // methode render de la vue item
    }
}
