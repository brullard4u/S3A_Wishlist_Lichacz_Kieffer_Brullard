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
        <form method='post' action=''>
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
        <p>{$this->item->descr}</p>
        <p>{$this->item->tarif}€</p>
        <p><img src=/S3A_Wishlist_Lichacz_Kieffer_Brullard/web/img/{$this->item->img} alt=Photo de l'item height=400px width=auto></p>
        FIN;
    }

    public function afficherItemDetail()
    {
        $txt = '';
        $acquereur = '';
        if (!is_null($this->item)) {
            $acquereur = $this->item->acquereur;
            if ($this->role == "participant") {
                if (!empty($acquereur)) {
                    $txt = "<p>Cet item a déjà été choisi par $acquereur</p>";
                } else {
                    $txt = <<<END
                    <p>Cet item n'a pas encore été choisi !</p>
                    <form method='post' action=''>
                    Nom: <input type='text' name='acquereur'>
                    Message: <input type='text' name='message'>
                    <input type='submit' value='Acquérir'>
                    </form>
                    END;
                }
            } else {
                if (!empty($acquereur)) {
                    $txt = "<p>Cet item a déjà été choisi !</p>";
                } else {
                    $txt = "<p>Cet item n'a pas encore été choisi !</p>";
                }
            }
        }

        return <<<FIN
        <h3>{$this->item->nom}</h3>
        <p>{$this->item->descr}</p>
        <p>{$this->item->tarif}€</p>
        <p><img src=/S3A_Wishlist_Lichacz_Kieffer_Brullard/web/img/{$this->item->img} alt=Photo de l'item height=400px width=auto></p>
        $txt
        FIN;
    }

    public function render()
    {
        $app = \Slim\Slim::getInstance();
        $url = "";
        $url = $app->urlFor($this->role == 'participant' ? 'consulter_liste' : 'voir_liste', array('name' => $this->liste->token));
        // Ou placer consutler liste dans vue liste ??
        $this->html = $this->afficherItemDetail();
        $this->menu = "<a href='$url'>{$this->liste->titre}</a>";
        return parent::render();
    }
}
