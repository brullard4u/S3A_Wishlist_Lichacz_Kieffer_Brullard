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
        <p>Prix: <input type='number' name='prix' min="1"></p>
        <p>Lien vers un site marchand: </p>
        <textarea name='url' rows="3" cols="80"></textarea>
        <p><input type='submit'class='submit' value='Ajouter'></p>
        </form>
        FIN;
    }

    public function afficherItemCreateur()
    {
        $app = \Slim\Slim::getInstance();
        $this->title = "Affichage d'un item";
        $url = '';
        $gestion = '';
        $today = date("Y-m-d");
        $url1 = $app->urlFor('ajouter_img', array('name' => $this->liste->token, 'id' => $this->item->id));
        $url2 = $app->urlFor('modifier_img', array('name' => $this->liste->token, 'id' => $this->item->id));
        $url3 = $app->urlFor('supprimer_img', array('name' => $this->liste->token, 'id' => $this->item->id));
        $url4 = $app->urlFor('modif_item', array('name' => $this->liste->token, 'id' => $this->item->id));
        $url5 = $app->urlFor('supp_item', array('name' => $this->liste->token, 'id' => $this->item->id));

        if (!empty($this->item->url))
            $url = "<a href={$this->item->url}>Achetable ici</a>";

        if (!empty($this->item->img)) {
            $this->html = <<<FIN
            <p><a href=$url2>Modifier l'image</a></p>
            <p><a href=$url3>Supprimer l'image</a></p>
            FIN;
        } else {
            $this->html = "<p><a href=$url1>Ajouter une image</a></p>";
        }
        
        if (empty($this->item->acquereur)) {
            $this->html .= "<p><a href=$url4>Modifier l'item</a></p><p><a href=$url5>Supprimer l'item</a></p>";
        }

        $this->html .= <<<FIN
        <h2>{$this->item->nom}</h2>
        <p>{$this->item->descr} {$url}</p>
        <p>{$this->item->tarif}€</p>
        <p><img src=/S3A_Wishlist_Lichacz_Kieffer_Brullard/web/img/{$this->item->img} alt="Photo indisponible" height=300px width=auto></p>
        
        FIN;
        if (!empty($this->item->acquereur)) {
            if($today < $this->liste->expiration)
                $this->html .= "<br><p>Cet item a été choisi !</p>";
            else
                $this->html .= "<br><p>Cet item a été choisi par {$this->item->acquereur} qui a laissé le message suivant : \"{$this->item->message}\"</p>";
        } else {
            $this->html .= "<br><p>Cet item n'a pas été choisi !</p>";
        }
    }

    public function afficherItemParticipant()
    {
        $txt = '';
        $url = '';
        $this->title = "Affichage d'un item";
        if (!is_null($this->item)) {
            if (!empty($this->item->acquereur)) {
                $txt = "<p>Cet item a déjà été choisi par {$this->item->acquereur}</p>";
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
        <div class='choisi'>
        $txt
        </div>
        FIN;
    }

    public function modifierItem()
    {
        $app = Slim::getInstance();
        $url = $app->urlFor('voir_item', array('name' => $this->liste->token, 'id' => $this->item->id));
        $this->title = "Modification d'un item";
        $this->html .= <<<FIN
        <h3>Voulez-vous vraiment modifier l'item suivant ?</h3>
        <p><a href="$url">{$this->item->nom}</a><p>
        <form method='post' action=''>
            <p>Nouveau Nom: <input type='text' name='nom'></p>
            <p>Nouvelle Description: <input type='text' name='descr'></p>
            <p>Nouveau Prix: <input type='number' name='prix' min="1"></p>
            <p>Nouveau Lien vers un site marchand: </p>
            <textarea name='url' rows="3" cols="80"></textarea>
            <p><input type='submit'class='submit' value='Modifier'></p>
        </form>
        FIN;
    }

    public function ajouterImageItem()
    {
        $app = Slim::getInstance();
        $this->title = "Ajout d'une image";
        $this->html .= <<<FIN
        <h3>Vous pouvez ajouter une image à l'item "{$this->item->nom}"</h3>
        <form method='post' action=''>
            <p>L'image sera soit depuis un URL soit depuis vos fichiers</p>
            <p>Depuis un URL : <textarea name="URL" rows="1" cols="60"></textarea></p>
            <p>Ou</p>
            <p>Depuis un fichier : <textarea name="fichier" rows="1" cols="60">nomdufichier.jpg</textarea></p>
            <input type='submit' class='submit' value='Ajouter'>
        </form>
        FIN;
    }

    public function modifierImage()
    {
        $app = Slim::getInstance();
        $this->title = "Modification d'une image";
        $this->html .= <<<FIN
        <h3>Vous pouvez modifier l'image de l'item "{$this->item->nom}"</h3>
        <form method='post' action=''>
        <p>L'image sera soit depuis un URL soit depuis vos fichiers</p>
        <p>Depuis un URL : <textarea name="URL" rows="1" cols="60"></textarea></p>
        <p>Ou</p>
        <p>Depuis un fichier : <textarea name="fichier" rows="1" cols="60">nomdufichier.jpg</textarea></p>
        <input type='submit' class='submit' value='Modifier'>
        </form>
        FIN;
    }

    public function supprimerImage()
    {
        $app = Slim::getInstance();
        $this->title = "Suppression d'une image";
        $this->html .= <<<FIN
        <h3>Voulez-vous vraiment supprimer l'image de l'item "{$this->item->nom}" ?</h3>
        <form method='post' action=''>
        <input type='submit' class='submit' value='Supprimer'>
        </form>
        FIN;
    }

    public function affSupprimer()
    {
        $app = Slim::getInstance();
        $this->title = "Suppression d'un item";
        $url = $app->urlFor('voir_item', array('name' => $this->liste->token, 'id' => $this->item->id));
        $this->html .= <<<FIN
        <h3>Voulez-vous vraiment supprimer l'item suivant ?</h3>
        <p><a href="$url">{$this->item->nom}</a><p>
        <form method='post' action=''>
        <input type='submit' class='submit' value='Supprimer'>
        </form>
        FIN;
    }

    public function affSuppression()
    {   
        $app = Slim::getInstance();
        $url = $app->urlFor('consulter_liste', array('name' => $this->liste->token));
        $this->title = "Suppression d'un item";
        $this->html .= <<<FIN
        <h3>L'item vient d'etre supprimé</h3>
        <p><a href=$url>Retourner à la liste</a></p>
        FIN;
    }
}
