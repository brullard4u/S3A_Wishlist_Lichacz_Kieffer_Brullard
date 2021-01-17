<?php

namespace mywishlist\controleur;

use mywishlist\modele\Commentaire;
use mywishlist\modele\Liste;
use mywishlist\modele\Joindre;
use mywishlist\vue\VueListe;

class ControleurListe
{

    public function nouvelleListe()
    {
        $v = new VueListe(null);
        $v->creerListe();
        echo $v->render();
    }

    public function suppressionListe($name)
    {
        $liste = Liste::where('token', '=', $name)->first();
        $v = new VueListe($liste);
        $v->supprimerListe();
        echo $v->render();
    }

    public function supprimerListe($name)
    {
        $liste = Liste::where('token', '=', $name);
        if (!is_null($liste)) {
            $liste->delete();
        }
        $this->choixListe(2);
    }
    public function choixListe($val)
    {
        $v = new VueListe(null);
        $v->afficherListes($val);
        echo $v->render();
    }

    public function enregistrerListe()
    {
        $app = \Slim\Slim::getInstance();
        $titre = $app->request->post('nom');
        $description = $app->request->post('description');
        $liste = new Liste();
        $liste->titre = filter_var($titre, FILTER_SANITIZE_STRING);
        $liste->description = filter_var($description, FILTER_SANITIZE_STRING);
        $liste->expiration = filter_var($app->request->post('expire'), FILTER_SANITIZE_NUMBER_INT);
        $liste->user_id = $_SESSION['profile']['userid'];
        $liste->token = dechex(random_int(0, 0xFFFFFFF));
        $liste->save();
        $joindre = new Joindre();
        $joindre->liste_id = $liste->no;
        $joindre->user_id =  $_SESSION['profile']['userid'];
        $joindre->createur = true;
        $joindre->save();
        $this->choixListe(2);
    }

    public function enregistrerMessage($name)
    {

        $app = \Slim\Slim::getInstance();
        $liste = Liste::where('token', '=', $name)->first();
        $no = $liste->no;
        $mess = $app->request->post('mess');
        $commentaire = new Commentaire();
        $commentaire->no = filter_var($no, FILTER_SANITIZE_NUMBER_INT);
        $commentaire->message = filter_var($mess, FILTER_SANITIZE_STRING);
        $commentaire->save();
        $v = new VueListe($liste);
        $v->enregisterMessage();
        echo $v->render();
    }

    public function modifierListe($name)
    {
        $app = \Slim\Slim::getInstance();
        $titre = $app->request->post('nom');
        $description = $app->request->post('description');
        $expiration = $app->request->post('expire');
        Liste::where('token', '=', $name)->update(['titre' => $titre, 'description' => $description, 'expiration' => $expiration]);
        $liste = Liste::where('token', '=', $name)->first();
        $v = new VueListe($liste);
        $v->postModificationListe();
        echo $v->render();
    }

    public function modificationListe($name)
    {
        $liste = Liste::where('token', '=', $name)->first();
        $v = new VueListe($liste);
        $v->modifierListe();
        echo $v->render();
    }

    public function afficherListe($name)
    {
        $liste = Liste::where('token', '=', $name)->first();
        if(is_null($liste))
            $liste = Liste::where('tokenPartage', '=', $name)->first();

        $aff = new VueListe($liste);
        $aff->afficherListe();
        echo $aff->render();
    }

    public function publicationListe($name)
    {
        $liste = Liste::where('token', '=', $name)->first();
        $v = new VueListe($liste);
        $v->changerEtatListe();
        echo $v->render();
    }

    public function publierListe($name)
    {
        Liste::where('token', '=', $name)->update(['privacy' => 'public']);
        $liste = Liste::where('token', '=', $name)->first();
        $v = new VueListe($liste);
        $v->postChangementEtatListe();
        echo $v->render();
    }

    public function partagerListe($name)
    {
        $liste = Liste::where('token', '=', $name)->first();
        $v = new VueListe($liste);
        $tokenInvitation = $v->partagerListe();
        Liste::where('token', '=', $name)->update(['tokenPartage' => $tokenInvitation]);
        echo $v->render();
    }

    public function affJoindreliste($name){
        $liste = Liste::where('token', '=', $name)->first();
        $v = new VueListe($liste);
        $v->JoindreListe();
        echo $v->render();
    }

    public function JoindreListe($name){
        $app = \Slim\Slim::getInstance();
        $liste = Liste::where('token', '=', $name)->first();
        $joindre = new Joindre();
        $joindre->liste_id = $liste->no;
        $joindre->user_id =  $_SESSION['profile']['userid'];
        $joindre->save();
        $aff = new VueListe($liste);
        $aff->afficherListe();
        echo $aff->render();
    }
}
