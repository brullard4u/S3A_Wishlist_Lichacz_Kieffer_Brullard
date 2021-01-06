<?php

namespace mywishlist\controleur;

use mywishlist\modele\Item;
use mywishlist\modele\Liste;
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

    public function ajouterItem($title, $descr, $tarif)
    {
        $item = new Item();
        $item->liste_id = $this->liste->no;
        $item->nom = $title;
        $item->descr = $descr;
        $item->tarif = $tarif;
        $item->save();
        $aff = new VueListe("createur",$this->liste);
        $aff->afficherListe();
        echo $aff->render();
    }

    public function afficherItem($id)
    {
        $item = Item::where('liste_id', '=', $this->liste->no)->where('id', '=', $id)->first();
        $aff = new VueItem("participant", $this->liste, $item);
        $aff->afficherItem();
        echo $aff->render(); // methode render de la vue item
    }

    public function ajouterImage($id)
    {
        $item = Item::where('liste_id', '=', $this->liste->no)->where('id', '=', $id)->first();
        $aff = new VueItem("createur", $this->liste, $item);
        $aff->ajouterImageItem();
        echo $aff->render();
    }

    public function enregistrerImage($id) {
        $app = \Slim\Slim::getInstance(); 
    }
}
