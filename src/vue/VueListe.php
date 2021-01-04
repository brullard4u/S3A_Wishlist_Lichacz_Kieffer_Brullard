<?php

namespace mywishlist\vue;

use mywishlist\modele\Liste;

class VueListe extends VueGenerale
{

    protected $liste;

    public function __construct($createur, $liste)
    {
        parent::__construct($createur);
        $this->liste = $liste;
    }

    public function creerListe()
    {
        $this->html = <<<FIN
        <h3>Créer une nouvelle liste de souhaits<h3>
        <form method='post' action=''>
        <p>Nom de la liste: <input type='text' name='nom'></p>
        <p>Description: <input type="text" name='description'></p>
        <p>Expire: <input type='date' name='expire'></p>
        <input type='submit' value='Créer'>
        </form>
        FIN;
    }

    public function afficherListes()
    {
        $app = \Slim\Slim::getInstance();
        $this->html = "<h2>Choisir une liste de souhaits</h2>";
        $listes = Liste::get();
        foreach ($listes as $liste) {
            $url = $app->urlFor('voir_liste', array('name' => $liste->token));
            $this->html .= <<<FIN
            <p><a href="$url">$liste->titre</a></p>
            FIN;
        }
    }

    public function afficherListeNvItem()
    {
        $this->html = "<h2>{$this->liste->titre}</h2>";
        $this->html .= VueItem::creerItem();
    }

    public function afficherListe()
    {
        $app = \Slim\Slim::getInstance();
        if ($this::$role == "createur" &&  $_COOKIE["user_id"] ==  $this->liste->user_id) {
            $url = $app->urlFor('formulaire_item', array('name' => $this->liste->token));
            $this->html .= "<a href='$url'>Ajouter un item</a>";
        }
        $this->html = "<h2>{$this->liste->titre}</h2>";
        foreach ($this->liste->items as $item) {
            if ($this::$role == "createur" &&  $_COOKIE["user_id"] ==  $this->liste->user_id) {
                $url = $app->urlFor('voir_item', array('name' => $this->liste->token, 'id' => $item->id));
                $this->html .= "<p><a href='$url'>$item->nom</a></p>";
            } else {
                $url = $app->urlFor('consulter_item', array('name' => $this->liste->token, 'id' => $item->id));
                $this->html .= "<p><a href='$url'>$item->nom</a></p>";
            }
        }
        $this->html .= "<p> Role : {$this::$role}</p>";
        /*
        $url = $app->urlFor('supprimer_liste', array('name' => $this->liste->token));
        $this->menu = <<<END
        <p><a href='$url>Supprimer la liste</a></p>;
        END;
        */
    }

    public function supprimerListe()
    {
        $app = \Slim\Slim::getInstance();
        $url = $app->urlFor('voir_liste', array('name' => $this->liste->token));
        $this->html .= <<<END
        <h2>Suppression de liste</h2>
        <h3>Voulez-vous vraiment supprimer la liste suivante ?</h3>
        <p><a href='$url'></a>{$this->liste->titre}</p>
        <form method='post' action=''>
        <input type='submit' value='Supprimer'>
        </form>
        END;
    }

    public function modifierListe(){
        $app = \Slim\Slim::getInstance();
        $url = $app->urlFor('voir_liste', array('name' => $this->liste->token));
        $this->html .= <<<FIN
        <h3>Voulez-vous vraiment modifier la liste suivante ?</h3>
        <p><a href='$url'></a>{$this->liste->titre}</p>
        <form method='post' action=''>
        <p>Nouveau nom de la liste: <input type='text' name='nom'></p>
        <p>Nouvelle description de la liste <input type="text" name='description'></p>
        <p>Nouvelle date d'expiration: <input type='date' name='expire'></p>
        <input type='submit' value='Modifier'>
        </form>
        FIN;

    }

    public function postmodificationListe(){
        $app = \Slim\Slim::getInstance();
        $url = $app->urlFor('voir_liste', array('name' => $this->liste->token));
        $this->html = <<<FIN
        <h3>Votre modification a été réalisé avec succès</h3>
        FIN;
        $this->afficherListes();
        $this->title ="Modification validé";
        $this->render();
    }

    public function changerEtatListe(){
        $app = \Slim\Slim::getInstance();
        $url = $app->urlFor('voir_liste', array('name' => $this->liste->token));
        $this->html = <<<FIN
        <h2>Suppression de liste</h2>
        <h3>Voulez-vous vraiment passez cette liste en publique ? </h3>
        <p><a href='$url'></a>{$this->liste->titre}</p>
        <form method='post' action=''>
        <input type='submit' value='Valider'>
        </form>
        FIN;
    }

    public function postChangementEtatListe(){
        $app = \Slim\Slim::getInstance();
        $url = $app->urlFor('voir_liste', array('name' => $this->liste->token));
        $this->html = <<<FIN
        <h3>Votre liste a bien été passé en publique </h3>
        FIN;
        $this->afficherListes();
        $this->title ="Liste Publique!";
        $this->render();

    }
}
