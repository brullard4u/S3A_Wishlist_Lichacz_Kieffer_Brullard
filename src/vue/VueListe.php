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
            <h3>Créez une nouvelle liste de souhaits<h3>
            <form method='post' action=''>
            <p>Nom de la liste: <input type='text' name='nom'></p>
            <p>Description: <input type="text" name='description'></p>
            <p>Expire: <input type='date' name='expire'></p>
            <input type='submit' class="submit" value='Créer'>
            </form>
            FIN;
        }
        $this->title = "Création de listes de souhaits";
    }

    public function afficherListes($val)
    {
        $app = \Slim\Slim::getInstance();
        $listes = Liste::get();
        // Switch utilisé pour afficher les listes selon le cas et donc ne pas faire deux méthodes
        switch ($val) {
                // Affichage des listes publiques
            case 1:
                $this->title = "Affichage des listes publiques";
                $this->html .= "<h2>Choississez une liste de souhaits publique</h2>";
                foreach ($listes as $liste) {
                    if ($liste->privacy == 'public' && $liste->user_id != $this->user_id) {
                        $url = $app->urlFor('voir_liste', array('name' => $liste->token));
                        $this->html .= <<<FIN
                        <p><a href="$url">$liste->titre</a></p>
                        FIN;
                    }
                }
                break;

                // Affichage des listes du createur
            case 2:
                $this->title = "Affichage des listes créées";
                $this->html .= "<h2>Choississez une de vos listes</h2>";
                foreach ($listes as $liste) {
                    if ($liste->user_id == $this->user_id) {
                        $url = $app->urlFor('consulter_liste', array('name' => $liste->token));
                        $this->html .= <<<FIN
                        <p><a href="$url">$liste->titre</a></p>
                        FIN;
                    }
                }
                break;
        }
    }

    public function afficherListeNvItem()
    {
        $app = \Slim\Slim::getInstance();
        $this->title = "Création d'un nouvel item";
        $url = $app->urlFor('voir_liste', array('name' => $this->liste->token));
        $this->html = "<h2>Nom de la liste: <a href=$url>{$this->liste->titre}</a></h2>";
        $this->html .= VueItem::creerItem();
    }

    public function enregisterMessage()
    {
        $this->afficherListe();
        $this->title = "Enregistrement d'un message";
        $this->html .= "<h2>Votre message a bien été enregistré</h2>";
    }
    public function afficherListe()
    {
        $app = \Slim\Slim::getInstance();
        $this->title = "Affichage des informations d'une liste";
        $today = date("Y-m-d");
        $gestion = "";
        $messages = "";
        $items = "";
        $add = "";
        // On test si c'est bien l'auteur de la liste actuelle
        if ($this->role == "createur" && $this->user_id ==  $this->liste->user_id) {
            $this->title = "Affichage et gestion de votre liste";
            $url = $app->urlFor('formulaire_item', array('name' => $this->liste->token));
            $gestion .= "<p class='ajout'><a href='$url'>Ajouter un item</a></p>";
            $url = $app->urlFor('modifier_liste', array('name' => $this->liste->token));
            $gestion .= "<p class ='modif'><a href='$url'>Modifier la liste</a></p>";
            $url = $app->urlFor('supprimer_liste', array('name' => $this->liste->token));
            $gestion .= "<p class='sup'><a href='$url'>Supprimer la liste</a></p>";

            if($this->liste->privacy == "private") {
                $url = $app->urlFor('rendre_publique', array('name' => $this->liste->token));
                $gestion .= "<p class='public'><a href='$url'>Rendre la liste publique</a></p>";
            }
            $url = $app->urlFor('partager', array('name' => $this->liste->token));  
            $gestion .= "<p class='share'><a href='$url'>Partager votre liste</a></p>"; 
        }

        // On test si la date d'échéance de la liste est dépassée ou si la liste est consultée par un participant,
        // si c'est le cas on affiche les messages
        if ($this->role != "createur" || ($this->role == "createur" &&  $this->liste->expiration <= $today)) {
            $messages .= "<div class='message'>";
            // Recuperation des messages laissés sur la liste (messages représentés par la table Commentaire)
            $commentaires = Commentaire::where('no', '=', $this->liste->no)->get();
            if (!(count($commentaires) == 0)) {
                $messages .= "<h3>Liste des messages :</h3>";
                foreach ($commentaires as $commentaire) {
                    $messages .= "<p>\"$commentaire->message\"</p>";
                }
               
            }
            $messages .= "</div>";
        }

        // Possibilité de laisser un message pour les participants
        if ($this->role != "createur" || ($this->role == "createur" && $this->user_id != $this->liste->user_id)) {
            $add = <<<FIN
            <form method='post' action=''>
            <p>Laisser un message:</p>
            <textarea rows="5" cols="50" name='mess'></textarea>
            <p><input type='submit' class="submit" value='Envoyer'></p><br>
            </form>
            FIN;
        }

        // Creation de la liste de selection des items de la liste
        $items .= <<<FIN
        <h2>{$this->liste->titre}</h2>
        <p>Expire le {$this->liste->expiration}</p>
        <div class='select'>
        <select class='item' onchange='location = this.value';>
        <option >voir les items</option>"
        FIN;
        // Rajout de chaque item dans la liste permettant de choisir l'item voulu
        foreach ($this->liste->items as $item) {
            if ($this->role == "createur" &&  $this->user_id ==  $this->liste->user_id) {
                $url = $app->urlFor('voir_item', array('name' => $this->liste->token, 'id' => $item->id));
                $items .= "<option value='$url'> $item->nom</option>";
            } else {
                $url = $app->urlFor('consulter_item', array('name' => $this->liste->token, 'id' => $item->id));
                $items .= "<option value= '$url'>$item->nom</option>";
            }
        }
        $items .= "</select></div>";

        // On ajoute tous ces différents morceaux de html dans la vue générale
        $this->html .= <<<END
        $gestion
        $items
        $messages
        $add
        END;
    }

    public function supprimerListe()
    {
        $app = \Slim\Slim::getInstance();
        $url = $app->urlFor('voir_liste', array('name' => $this->liste->token));
        $this->title = "Suppression de liste";
        $this->html .= <<<END
        <h3>Voulez-vous vraiment supprimer la liste suivante ?</h3>
        <p><a href='$url'>{$this->liste->titre}</a></p>
        <form method='post' action=''>
        <input type='submit' class='submit' value='Supprimer'>
        </form>
        END;
    }

    public function modifierListe()
    {
        $app = \Slim\Slim::getInstance();
        $url = $app->urlFor('voir_liste', array('name' => $this->liste->token));
        $this->title = "Modification de liste";
        $this->html .= <<<FIN
        <h3>Voulez-vous vraiment modifier la liste suivante ?</h3>
        <p><a href='$url'>{$this->liste->titre}</a></p>
        <form method='post' action=''>
        <p>Nouveau nom de la liste: <input type='text' name='nom'></p>
        <p>Nouvelle description de la liste <input type="text" name='description'></p>
        <p>Nouvelle date d'expiration: <input type='date' name='expire'></p>
        <input type='submit' class='submit' value='Modifier'>
        </form>
        FIN;
    }

    public function postModificationListe()
    {
        $app = \Slim\Slim::getInstance();
        $this->html = <<<FIN
        <h3>La liste "{$this->liste->titre}" a été modifée avec succès</h3>
        FIN;
        $this->title = "Mise à jour de la liste";
        $this->afficherListe();
    }

    public function changerEtatListe()
    {
        $app = \Slim\Slim::getInstance();
        $url = $app->urlFor('voir_liste', array('name' => $this->liste->token));
        $this->title = "Publication d'une liste";
        $this->html = <<<FIN
        <h3>Voulez-vous vraiment rendre cette liste publique ? </h3>
        <p><a href='$url'>{$this->liste->titre}</a></p>
        <form method='post' action=''>
        <input type='submit'class='submit' value='Valider'>
        </form>
        FIN;
    }

    public function postChangementEtatListe()
    {
        $app = \Slim\Slim::getInstance();
        $url = $app->urlFor('voir_liste', array('name' => $this->liste->token));
        $this->title = "Mise à jour de la liste";
        $this->html = <<<FIN
        <h3>Votre liste a bien été passé en publique </h3>
        FIN;
        $this->afficherListe();;
    }

    public function partagerListe() {
        $this->title = "Partage d'une liste";
        $this->html = <<<FIN
        <h3>Voulez-vous envoyer un lien d'invitation vers votre liste ?</h3>
        <form method='post' action=''>
        <p>Votre email: <input type='text' name='expeditaire'></p>
        <p>Email du destinataire: <input type="text" name='destinataire'></p>
        <input type='submit'class='submit' value='Envoyer'>
        </form>
        FIN;
    }
}
