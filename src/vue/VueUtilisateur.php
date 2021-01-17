<?php

namespace mywishlist\vue;

use mywishlist\modele\utilisateur;
use mywishlist\modele\Liste;

use Slim\Slim;

class VueUtilisateur extends VueGenerale
{

    public function registerForm()
    {
        $this->html = <<<FIN
        <h3>Enregistrez-vous</h3>
        <form action="" method="post">
        Nom: <input type="text" name="nom">
        <p>Mot de passe: <input type="password" name="password"></p>
        <input type="submit" name="i" class="submit" value="S'enregistrer">
        </form>
        FIN;
        $this->title = "Enregistrement";
    }

    public function logInForm()
    {
        $app = Slim::getInstance();
        $url = $app->urlFor('inscription_uti');
        $this->html .= <<<FIN
        <h3>Connectez-vous</h3>
        <form action="" method="post">
        Nom: <input type="text" name="nom">
        <p>Mot de passe: <input type="password" name="password"></p>
        <input type="submit" name="i" class="submit" value="Se connecter">
        </form>
        <h3>Pas encore enregistré ?</h3>
        <a href=$url>Enregistrez-vous ici</a>
        FIN;
        $this->title = "Connexion";
    }

    public function afterRegisterForm()
    {
        $app = Slim::getInstance();
        $url = $app->urlFor('connexion_uti');
        $this->html = <<<FIN
        <h3>Votre enregistrement a été réalisé avec succès</h3>
        <p>Vous pouvez maintenant vous connecter en utilisant vos identifiants </p>
        <a href=$url>Page de connexion</a>
        FIN;
        $this->title = "Enregistrement validé";
    }

    public function connected()
    {
        $name = $_SESSION['profile']['username'];
        $this->html = <<<FIN
        <h3>Bonjour $name ! Vous êtes connecté.</h3>
        FIN;
        $this->title = "Connexion";
    }

    public function notConnected()
    {
        $app = Slim::getInstance();
        $url = $app->urlFor('connexion_uti');
        $this->html = <<<FIN
        <h3>Vous n'êtes pas connecté.</h3>
        <p>Identifiant ou mot de passe incorrect.</p>
        <a href=$url>réessayer</a>
        FIN;
        $this->title = "Erreur";
    }

    public function affichageAccueil()
    {
        $this->html = <<<FIN
        <h3>Bienvenue sur le site MyWishlist!<br> Ici vous pourrez créer vos propres listes de souhaits personalisables au maximum!<br> 
        Pour pourrez créer des listes de cadeaux pour n'importe quel évènement,<br> que ce soit pour un anniversaire, une crémaillère ou autres.<br>
        N'hésitez pas à partager vos listes avec les autres personnes!<br> Et vous pourrez toujours venir les consulter en temps voulu </h3>
        <div class="a_img">
        <img src="/S3A_Wishlist_Lichacz_Kieffer_Brullard/web/img/portrait-couple-personnes-agees-heureux-cadeau-anniversaire-fond-bleu_23-2147951814.jpg">
        </div>
        FIN;
        $this->title = "Accueil";
    }

    public function affEsP()
    {
        $app = Slim::getInstance();
        $url = $app->urlfor('supprimerCompte');
        $urlMod = $app->urlFor('modifier_compte');
        $this->html = <<<FIN
        <h3>Bienvenue sur votre espace personnel</h3>
        <p><a href=$url>Supprimer votre compte</a></p>
        <p><a href=$urlMod>Modifier votre compte</p>
        FIN;
        $this->title = "Espace Personnel";
    }

    public function affichageSuppressionCompte()
    {
        $this->html .= <<<FIN
        <h3>Voulez-vous vraiment supprimer votre compte ?</h3>
        <form method='post' action=''>
        <input type='submit' class='submit' value='Supprimer'>
        </form>
        FIN;
        $this->title = "Supprimer Compte";
    }

    public function affichageNotSup()
    {
        $this->html .= <<<FIN
        <h3>Nous n'avons pas supprimer le compte car il n'existe pas</h3>
        FIN;
    }

    public function modifierCompte()
    {
        $app = Slim::getInstance();
        $this->title = "Modification du compte";
        $this->html .= <<<FIN
        <h3>Voulez vous modifier votre compte?</h3>
        <form method='post' action=''>
        <p>Nouveau mot de passe: <input type="password" name="password"></p>
        <p><input type='submit' class='submit' value='Modifier'></p>
        </form>
        FIN;
    }

    public function afficherCreateursPubliques()
    {
        $app = \Slim\Slim::getInstance();
        $listes = Liste::get();
        $this->title = "Affichage des créateurs ayant une liste publique";
        $this->html .= "<div>";
        $utilisateurs = array();
        foreach ($listes as $liste) {
            $utilisateur = Utilisateur::where('user_id', '=', $liste->user_id)->first();

            if ($liste->privacy == 'public' && !is_null($utilisateur) && !in_array($utilisateur, $utilisateurs)) {
                array_push($utilisateurs, $utilisateur);
                $this->html .= "<h3>$utilisateur->nom</h3>";
            }
        }
        $this->html .= "</div>";
    }
}
