<?php

namespace mywishlist\vue;

use mywishlist\modele\Commentaire;
use mywishlist\modele\Liste;

class VueListe extends VueGenerale
{

    protected $liste;

    public function __construct($liste)
    {
        parent::__construct();
        $this->liste = $liste;
    }

    public function creerListe()
    {
        if (empty($this->user_id)) {
            $app = \Slim\Slim::getInstance();
            $url = $url = $app->urlFor('connexion_uti');;
            $this->html = <<<FIN
            <h3>Veuillez d'abord vous connectez</h3>
            <a href=$url>Page de connexion</a>
            FIN;
        } else {
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
    }

    public function afficherListes()
    {
        $app = \Slim\Slim::getInstance();
        $this->html .= "<h2>Choisir une liste de souhaits</h2>";
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
        $this->html = "<h2>Nom de la liste: {$this->liste->titre}</h2>";
        $this->html .= VueItem::creerItem();
    }

    public function enregisterMessage() {
        $this->afficherListe();
        $this->html .= "<h2>Votre message a bien été enregisré</h2>";
    }
    public function afficherListe()
    {
        $app = \Slim\Slim::getInstance();

        if ($this->role == "createur" && $this->user_id ==  $this->liste->user_id) {
            $url = $app->urlFor('formulaire_item', array('name' => $this->liste->token));
            $this->html .= "<p><a href='$url'>Ajouter un item</a></p>";
            $url = $app->urlFor('modifier_liste', array('name' => $this->liste->token));
            $this->html .= "<p><a href='$url'>Modifier la liste</a></p>";
            $url = $app->urlFor('supprimer_liste', array('name' => $this->liste->token));
            $this->html .= "<p><a href='$url'>Supprimer la liste</a></p>";
        }
        $this->html .= <<<FIN
        <h2>{$this->liste->titre}</h2>
        <form method='post' action=''>
        <p>Laisser un message:</p>
        <textarea rows="5" cols="50" name='mess'></textarea>
        <p><input type='submit' value='Envoyer'></p><br>
        </form>
        FIN;
        foreach ($this->liste->items as $item) {
            if ($this->role == "createur" &&  $this->user_id ==  $this->liste->user_id) {
                $url = $app->urlFor('voir_item', array('name' => $this->liste->token, 'id' => $item->id));
                $this->html .= "<p><a href='$url'>$item->nom</a></p>";
            } else {
                $url = $app->urlFor('consulter_item', array('name' => $this->liste->token, 'id' => $item->id));
                $this->html .= "<p><a href='$url'>$item->nom</a></p>";
            }
        }
        $commentaires = Commentaire::where('no','=',$this->liste->no)->get();
        if(!(count($commentaires) == 0))
            $this->html .= "<h3>Liste des messages :</h3>";
        foreach($commentaires as $commentaire) {
            $this->html .= "<p>\"$commentaire->message\"</p>";
        }
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

    public function modifierListe()
    {
        $app = \Slim\Slim::getInstance();
        $url = $app->urlFor('voir_liste', array('name' => $this->liste->token));
        $this->html .= <<<FIN
        <h3>Voulez-vous vraiment modifier la liste suivante ?</h3>
        <p><a href='$url'>{$this->liste->titre}</a></p>
        <form method='post' action=''>
        <p>Nouveau nom de la liste: <input type='text' name='nom'></p>
        <p>Nouvelle description de la liste <input type="text" name='description'></p>
        <p>Nouvelle date d'expiration: <input type='date' name='expire'></p>
        <input type='submit' value='Modifier'>
        </form>
        FIN;
    }

    public function postmodificationListe()
    {
        $app = \Slim\Slim::getInstance();
        $this->html = <<<FIN
        <h3>La liste "{$this->liste->titre}" a été modifée avec succès</h3>
        FIN;
        //$this->title ="Modification validé";
        $this->afficherListes();
    }

    public function changerEtatListe()
    {
        $app = \Slim\Slim::getInstance();
        $url = $app->urlFor('voir_liste', array('name' => $this->liste->token));
        $this->html = <<<FIN
        <h2>Rendre une liste publique</h2>
        <h3>Voulez-vous vraiment rendre cette liste publique ? </h3>
        <p><a href='$url'>{$this->liste->titre}</a></p>
        <form method='post' action=''>
        <input type='submit' value='Valider'>
        </form>
        FIN;
    }

    public function postChangementEtatListe()
    {
        $app = \Slim\Slim::getInstance();
        $url = $app->urlFor('voir_liste', array('name' => $this->liste->token));
        $this->html = <<<FIN
        <h3>Votre liste a bien été passé en publique </h3>
        FIN;
        $this->afficherListes();
        $this->title = "Liste Publique!";
        $this->render();
    }
}
