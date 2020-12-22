<?php

namespace mywishlist\controleur;

use mywishlist\modele\Item;
use mywishlist\modele\Liste;
use mywishlist\vue\VueItem;
use mywishlist\vue\VueListe;

class ControleurParticipant
{

    public function afficherListe(string $name)
    {
        $liste = Liste::where('token', '=', $name)->firs();
        $aff = new VueListe("participant", $liste);
        $aff->afficherListe();
        echo $aff->render();
    }

    public function afficherItem(string $name, $id)
    {
        $liste = Liste::where('token', '=', $name)->first();
        $item = Item::where('liste_id', '=', $liste->no)->where('id', '=', $id)->first();
        $aff = new VueItem("participant", $liste, $item);
        echo $aff->render();
    }

    public function acquerirItem(string $name, $id)
    {
        $liste = Liste::where('token', '=', $name)->first();
        $item = Item::where('liste_id', '=', $liste->no)->where('id', '=', $id)->first();
        if (empty($item->acquereur)) {
            $app = \Slim\Slim::getInstance();
            $item->acquereur = $app->request->post('acquereur');
            $item->message = $app->request->post('message');
            $item->save();
            $this->afficherListe($name);
        }
    }
}
