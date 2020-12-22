<?php

namespace mywishlist\controleur;

use mywishlist\modele\Liste;
use mywishlist\vue\VueListe;

class ControleurListe
{

    public function nouvelleListe()
    {
        $a = new VueListe("createur", null);
        $a->creerListe();
        echo $a->render();
    }

    public function choixListe()
    {
    }

    public function enregistrerListe()
    {
        $app = \Slim\Slim::getInstance();
        $titre = $app->request->post('titre');
        $liste = new Liste();
        $liste->titre = filter_var($titre, FILTER_SANITIZE_STRING);
        $liste->expiration = filter_var($app->request->post('expire'), FILTER_SANITIZE_NUMBER_INT);
        $liste->id = $this->user;
        $liste->token = dechex(random_int(0, 0xFFFFFFF));
        $liste->save();
        $this->choixListe();
    }

    public function afficherListe($name)
    {
        $liste = Liste::where('token', '=', $name)->first();
        $aff = new VueListe("createur", $liste);
        $aff->afficherListe();
        echo $aff->render();
    }
}
