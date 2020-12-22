<?php

namespace mywishlist\vue;

use Slim\Slim;

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
        foreach ($this->liste as $liste) {
            $url = $app->urlFor('voir_liste', array('name' => $liste->token));
            $this->html .= <<<FIN
            <div><a href="$url">$liste->titre</a></div>
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
            $i = new VueItem($this->role, $this->liste, $item);
            $this->html .= $i->afficherItem();
        }
        $url = $app->urlFor('formulaire_item', array('name' => $this->liste->token));
        if ($this->role == "createur")
            $this->html .= "<a href='$url'>Ajouter un item</a>";
    }
}
