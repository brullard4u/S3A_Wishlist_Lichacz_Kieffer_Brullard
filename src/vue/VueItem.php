<?php

namespace mywishlist\vue;

class VueItem extends VueGenerale {

    protected $liste, $item;

    public function __construct(string $role,$liste,$item)
    {
        $this->item=$item;
        $this->liste=$liste;
        $this->role=$role;
    }

    public static function creerItem() {
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

    public function afficherItem() {

    }
    
    public function afficherItemDetail() {
        if(true) { // Manque ce qu'il va dans le if

        } else {
            if($this->role == "participant") {
                $txt="<p>Cet item a été choisi par {$this->item->acquereur}</p>";
            } else {
                $txt="<p>Cet item a été choisi !</p>";
            }
        }
        return <<<FIN
        <div><h3>{$this->item->nom}</h3>
        <p>{$this->item->descriptif}</p>
        <p>{$this->item->tarif}€</p>
        $txt
        </div>
        FIN;
    }

    public function render() {
        $app = \Slim\Slim::getInstance();
        $url = $app->urlFor($this->role == "participant" ? 'consulter_liste' : 'voir_liste', array('name'=>$this->liste->token));
        $this->html = $this->afficherItemDetail();
        $this->menu = "<a href='$url'>Liste {$this->liste->titre}</a>";
        return parent::render();
    }
}