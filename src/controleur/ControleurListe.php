<?php

namespace mywishlist\controleur;

use mywishlist\modele\Liste;
use mywishlist\vue\VueListe;

class ControleurListe
{

    public function nouvelleListe()
    {
        $v = new VueListe("createur", null);
        $v->creerListe();
        echo $v->render();
    }

    public function suppressionListe($name) {
        $liste = Liste::where('token', '=', $name)->first();
        $v = new VueListe("createur", $liste);
        $v->supprimerListe();
        echo $v->render();
    }

    public function supprimerListe($name) {
        $liste = Liste::where('token', '=', $name);
        if (!is_null($liste)) {
            $liste->delete();
        }
        $this->choixListe();
    }
    public function choixListe()
    {
        $v = new VueListe("createur", null);
        $v->afficherListes();
        echo $v->render();
    }

    public function enregistrerListe()
    {
        $app = \Slim\Slim::getInstance();
        $titre = $app->request->post('nom');
        $description = $app->request->post('description');
        $liste = new Liste();
        $liste->titre = filter_var($titre, FILTER_SANITIZE_STRING);
        $liste->description = filter_var($description,FILTER_SANITIZE_STRING);
        $liste->expiration = filter_var($app->request->post('expire'), FILTER_SANITIZE_NUMBER_INT);
        $liste->user_id = $_COOKIE['user_id'];
        $liste->token = dechex(random_int(0, 0xFFFFFFF));
        $liste->save();
        $this->choixListe();
    }

    public function modifierListe($name) {
        $app = \Slim\Slim::getInstance();
        $titre = $app->request->post('nom');
        $description = $app->request->post('description');
        $expiration = $app->request->post('expire');
        Liste::where('token','=',$name)->update(['titre' => $titre, 'description' => $description, 'expiration' => $expiration]);
        $liste = Liste::where('token','=',$name)->first();
        $v = new VueListe("createur", $liste);
        $v->postmodificationListe();
        echo $v->render();
    }

    public function modificationListe($name) {
        $liste = Liste::where('token', '=', $name)->first();
        $v = new VueListe("createur", $liste);
        $v->modifierListe();
        echo $v->render();
    }

    public function afficherListe($name)
    {
        $liste = Liste::where('token', '=', $name)->first();
        $aff = new VueListe("participant", $liste);
        $aff->afficherListe();
        echo $aff->render();
    }

    public function publicationListe($name) {
        $liste = Liste::where('token', '=', $name)->first();
        $v = new VueListe("createur", $liste);
        $v->changerEtatListe();
        echo $v->render();
    }
}
