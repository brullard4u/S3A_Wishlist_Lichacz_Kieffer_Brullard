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
        $aff = new VueListe($this->liste);
        $aff->afficherListeNvItem();
        echo $aff->render();
    }

    public function ajouterItem()
    {
        $app = \Slim\Slim::getInstance();
        $item = new Item();
        $title = filter_var($app->request->post('titre'), FILTER_SANITIZE_STRING);
        $descr = filter_var($app->request->post('descr'), FILTER_SANITIZE_STRING);
        $url = filter_var($app->request->post('url'), FILTER_SANITIZE_STRING);
        $tarif = $app->request->post('prix');
        $item->liste_id = $this->liste->no;
        $item->nom = $title;
        $item->descr = $descr;
        $item->tarif = $tarif;
        $item->url = $url;
        $item->save();
        $aff = new VueListe($this->liste);
        $aff->afficherListe();
        echo $aff->render();
    }

    public function afficherItem($id)
    {
        $item = Item::where('liste_id', '=', $this->liste->no)->where('id', '=', $id)->first();
        $aff = new VueItem($this->liste, $item);
        $aff->afficherItem();
        echo $aff->render(); // methode render de la vue item
    }

    public function ajouterImage($id)
    {
        $item = Item::where('liste_id', '=', $this->liste->no)->where('id', '=', $id)->first();
        $aff = new VueItem($this->liste, $item);
        $aff->ajouterImageItem();
        echo $aff->render();
    }

    public function enregistrerImage($id) {
        $app = \Slim\Slim::getInstance(); 
        $item = Item::where('liste_id', '=', $this->liste->no)->where('id', '=', $id)->first();
        $img = $app->request->post('URL');
        if(empty($img)) {
            $img = $app->request->post('fichier');
        }
        $item->img = filter_var($img,FILTER_SANITIZE_STRING);
    }

    public function modifierImage($id) {
        
    }
}
