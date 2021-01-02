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
        $this->html = "<h2>{$this->liste->titre}</h2>";
        foreach ($this->liste->items as $item) {
            if ($this->role == "createur" &&  $_COOKIE["user_id"] ==  $this->liste->user_id) {
                $url = $app->urlFor('voir_item', array('name' => $this->liste->token, 'id' => $item->id));
                $this->html .= "<p><a href='$url'>$item->nom</a></p>";
            } else {
                $url = $app->urlFor('consulter_item', array('name' => $this->liste->token, 'id' => $item->id));
                $this->html .= "<p><a href='$url'>$item->nom</a></p>";
            }
        }
        $url = $app->urlFor('formulaire_item', array('name' => $this->liste->token));
        if ($this->role == "createur")
            $this->html .= "<a href='$url'>Ajouter un item</a>";
    }
}
