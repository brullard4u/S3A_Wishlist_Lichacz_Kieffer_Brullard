<?php

namespace mywishlist\vue;

use Slim\Slim;

class VueItem extends VueGenerale
{

    protected $liste, $item;

    public function __construct($liste, $item)
    {
        $this->item = $item;
        $this->liste = $liste;
    }

    public static function creerItem()
    {
        return <<<FIN
        <h3>Ajouter un cadeau</h3>
        <form method='post' action=''>
        <p>Nom: <input type='text' name='titre'></p>
        <p>Description: <input type='text' name='descr'></p>
        <p>Prix: <input type='number' name='prix'></p>
        <p>Lien vers un site marchand: </p>
        <textarea name='url' rows="3" cols="80"></textarea>
        <p><input type='submit'class='submit' value='Ajouter'></p>
        </form>
        FIN;
    }

    public function afficherItem()
    {
        $app = \Slim\Slim::getInstance();
        $acquereur = $this->item->acquereur;
        $url = '';
        $url1 = $app->urlFor('ajouter_img', array('name' => $this->liste->token, 'id' => $this->item->id));
        $url2 = $app->urlFor('modifier_img', array('name' => $this->liste->token, 'id' => $this->item->id));
        $url3 = $app->urlFor('supprimer_img', array('name' => $this->liste->token, 'id' => $this->item->id));
        if (!empty($this->item->url))
            $url = "<a href={$this->item->url}>Achetable ici</a>";
        $this->html = <<<FIN
        <p><a href=$url1>Ajouter une image</a></p>
        <p><a href=$url2>Modifier l'image</a></p>
        <p><a href=$url3>Supprimer l'image</a></p>
        <h2>{$this->item->nom}</h2>
        <p>{$this->item->descr} {$url}</p>
        <p>{$this->item->tarif}€</p>
        <p><img src=/S3A_Wishlist_Lichacz_Kieffer_Brullard/web/img/{$this->item->img} alt="Photo indisponible" height=300px width=auto></p>
        
        FIN;
        if (!empty($acquereur)) {
            $mess = $this->item->message;
            $this->html .= "<br><p>Cet item a déjà été choisi ! => \"$mess\"</p>";
        } else {
            $this->html .= "<br><p>Cet item n'a pas encore été choisi !</p>";
        }
    }

    public function afficherItemDetail()
    {
        $txt = '';
        $acquereur = '';
        $url = '';
        if (!is_null($this->item)) {
            $acquereur = $this->item->acquereur;
            if (!empty($acquereur)) {
                $txt = "<p>Cet item a déjà été choisi par $acquereur</p>";
            } else {
                $txt = <<<END
                    <div class='choisi'>
                    <p>Cet item n'a pas encore été choisi !</p>
                    <form method='post' action=''>
                    Nom: <input type='text' name='acquereur'>
                    Message: <input type='text' name='message'>
                    <input type='submit' class='submit' value='Acquérir'>
                    </form>
                    </div>
                    END;
            }
        }
        if (!empty($this->item->url))
            $url = "<a href={$this->item->url}>Achetable ici</a>";
        $this->html = <<<FIN
        <h3>{$this->item->nom}</h3>
        <p>{$this->item->descr} {$url}</p>
        <p>{$this->item->tarif}€</p>
        <p><img src=/S3A_Wishlist_Lichacz_Kieffer_Brullard/web/img/{$this->item->img} alt="Photo indisponible" height="400px" width="auto"></p>
        $txt
        FIN;
    }

    public function modifierItem()
    {
        $app = Slim::getInstance();
        $this->html .= <<<FIN
        <h3>Voulez vous modifier l'item suivant ? "{$this->item->nom}"</h3>
        <form method='post' action=''>
            <p>Nouveau Nom: <input type='text' name='nom'></p>
            <p>Nouvelle Description: <input type='text' name='descr'></p>
            <p>Nouveau Prix: <input type='number' name='prix'></p>
            <p>Nouveau Lien vers un site marchand: </p>
            <textarea name='url' rows="3" cols="80"></textarea>
            <p><input type='submit'class='submit' value='modifier'></p>
        </form>
        FIN;
    }

    public function ajouterImageItem()
    {
        $app = Slim::getInstance();
        $this->html .= <<<FIN
        <h3>Vous pouvez ajouter une image à l'item "{$this->item->nom}"</h3>
        <form method='post' action=''>
            <p>L'image sera soit depuis un URL soit depuis vos fichiers</p>
            <p>Depuis un URL : <textarea name="URL" rows="1" cols="60"></textarea></p>
            <p>Ou</p>
            <p>Depuis un fichier : <textarea name="fichier" rows="1" cols="60"></textarea></p>
            <input type='submit' class='submit' value='Ajouter'>
        </form>
        FIN;
        //$this->title = "Ajouter une image à votre item";
    }

    public function modifierImage()
    {
        $app = Slim::getInstance();
        if (empty($this->item->img)) {
            $url = $app->urlFor('ajouter_img', array('name' => $this->liste->token, 'id' => $this->item->id));
            $this->html .= <<<FIN
            <h3>Cet item n'a pas encore d'image !</h3>
            <a href=$url>Cliquez-ici pour ajouter une image</a>
            FIN;
        } else {
            $this->html .= <<<FIN
            <h3>Vous pouvez modifier l'image de l'item "{$this->item->nom}"</h3>
            <form method='post' action=''>
            <p>L'image sera soit depuis un URL soit depuis vos fichiers</p>
            <p>Depuis un URL : <textarea name="URL" rows="1" cols="60"></textarea></p>
            <p>Ou</p>
            <p>Depuis un fichier : <textarea name="fichier" rows="1" cols="60"></textarea></p>
            <input type='submit' class='submit' value='Modifier'>
            </form>
            FIN;
        }
        //$this->title = "Ajouter une image à votre item";
    }

    public function supprimerImage()
    {
        $app = Slim::getInstance();
        $url = $app->urlFor('ajouter_img', array('name' => $this->liste->token, 'id' => $this->item->id));
        if (empty($this->item->img)) {
            $this->html .= <<<FIN
            <h2>Suppresion de l'image d'un item</h2>
            <h3>Cette image n'a pas d'image !</h3>
            <a href=$url>Cliquez-ici pour ajouter une image</a>
            FIN;
        } else {
            $this->html .= <<<FIN
            <h2>Suppresion de l'image d'un item</h2>
            <h3>Voulez-vous vraiment supprimer l'image de l'item {$this->item->name} ?</h3>
            <form method='post' action=''>
            <input type='submit' class='submit' value='Supprimer'>
            </form>
            FIN;
        }
    }

    /**public function render()
    {
        $app = \Slim\Slim::getInstance();
        $url = $app->urlFor($this->role == "participant" ? 'consulter_liste' : 'voir_liste', array('name' => $this->liste->token));
        // Ou placer consutler liste dans vue liste ??
        $this->html = $this->afficherItemDetail();
        $this->menu = "<a href='$url'>{$this->liste->titre}</a>";
        return parent::render();
    }
     */
}
