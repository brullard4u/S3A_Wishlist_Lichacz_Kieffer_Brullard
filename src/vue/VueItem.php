<?php

namespace mywishlist\vue;

use finfo;

class VueItem extends VueGenerale
{

    protected $liste, $item;

    public function __construct(string $role, $liste, $item)
    {
        $this->item = $item;
        $this->liste = $liste;
        $this->role = $role;
    }

    public static function creerItem()
    {
        return <<<FIN
        <h3>Ajouter un cadeau</h3>
        <from method='post' action=''>
        <p>Nom: <input type='text' name='titre'></p>
        <p>Description: <input type='text' name='descr'></p>
        <p>Prix: <input type='number' name='prix'></p>
        <input type='submit' value='Ajouter'>
        </form>
        FIN;
    }

    public function afficherItem()
    {
        $app = \Slim\Slim::getInstance();
        $this->html = <<<FIN
        <h2>{$this->item->nom}</h2>"
        <p>{$this->item->descriptif}</p>
        <p>{$this->item->tarif}€</p>
        <p><img src=../../web/img/{$this->item->img} alt=Photo de l'item height=500px width=auto></p>
        FIN;
    }

    public function afficherItemDetail()
    {
        $txt = '';
        $acquereur = '';
        if (!is_null($this->item)) {
            $acquereur = $this->item->acquereur;
            if (false) {
                
            } else {
                $txt = "<p>Cet item n'a pas encore été choisi.</p>";
            } 
        } else {
            if ($this->role == "participant") {
                $txt = "<p>Cet item a déjà été choisi par $acquereur</p>";
            } else {
                $txt = "<p>Cet item a été choisi !</p>";
            }
        }
        return <<<FIN
        <div><h3>{$this->item->nom}</h3>
        <p>{$this->item->descriptif}</p>
        <p>{$this->item->tarif}€</p>
        <p><img src=../../web/img/{$this->item->img} alt=Photo de l'item height=500px width=auto></p>
        $txt
        </div>
        FIN;
    }

    public function render()
    {
        $app = \Slim\Slim::getInstance();
        $url = $app->urlFor($this->role == 'participant' ? 'consulter_item' : 'voir_item', array('name' => $this->liste->token));
        $this->html = $this->afficherItemDetail();
        $this->menu = "<a href='$url'>Liste {$this->liste->titre}</a>";
        return parent::render();
    }
}
