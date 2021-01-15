<?php

namespace mywishlist\vue;

use finfo;
use Slim\Slim;

class VueUtilisateur
{

    private $title;
    private $html;

    /*
    L'onglet "Mes participations à des listes" permet à un utilisateur connecté d'afficher les listes auquel il participe

    */

    public function render()
    {
        $app = Slim::getInstance();
        $road = "/S3A_Wishlist_Lichacz_Kieffer_Brullard/web/css/style.css";
        $ins = $app->urlFor('inscription_uti');
        $con = $app->urlFor('connexion_uti');
        $lsp = $app->urlFor('aff_liste');
        $ac = $app->urlFor('accueil');
        $cls = $app->urlFor('creation_liste');
        $ls = $app->urlFor('cons_liste');
        $deco = $app->urlFor('deconnexion_uti');
        $esp = $app->urlFor('es_p');
        if (!isset($_SESSION['profile'])) {
            $connect = <<<FIN
            <li class = "connect"><a href="$con">Se connecter </a></li>
            <li class = "connect"><a href="$ins"> S'inscrire </a></li>
            FIN;
        } else {
            $connect = <<<FIN
            <li >
                <a href=$esp>Mon compte</a>
                    <ul class ="sous" > 
                        <li><a href="$cls">Créer une liste</a></li>
                        <li><a href="$ls">Mes listes</a></li>
                        <li><a href="#">Mes participations à des listes</a></li>
                    </ul>
            </li>
            <li class = "connect"><a href="$deco">Se déconnecter </a></li>
            FIN;
        }

        echo <<<END
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="utf-8">
            <meta name="description" content="">
            <link rel="stylesheet" href=$road>
            <title>{$this->title}</title>
        </head>
        <body>
            <header>
                <nav class ="menu">
                    <ul>
                        <li><a href="$ac">Projet PHP MyWishList</a></li>
                        <li ><a href="$lsp">Consulter les listes</a></li>
                        $connect
                        
                    </ul>
                </nav>
            </header>
            
            <div class='contenu'>
            <h1>{$this->title}</h1>
            {$this->html}
            </div>
            <footer>Sarah Lichacz | Charlie Kieffer | Baptiste Brullard</footer>
        </body>
        </html>
        END;
    }


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
        $this->render();
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
        $this->render();
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
        $this->render();
    }

    public function connected()
    {
        $name = $_SESSION['profile']['username'];
        $this->html = <<<FIN
        <h3>Bonjour $name ! Vous êtes connecté.</h3>
        FIN;
        $this->title = "Connexion";
        $this->render();
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
        $this->render();
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
        $this->render();
    }

    public function affEsP(){
        $app =Slim::getInstance();
        $url =$app->urlfor('supprimerCompte');
        $urlMod = $app->urlFor('modifier_compte');
        $this->html = <<<FIN
        <h3>Bienvenue sur votre espace personnel</h3>
        <p><a href=$url>Supprimer votre compte</a></p>
        <p><a href=$urlMod>Modifier votre compte</p>
        FIN;
        $this->title = "Espace Personnel";
        $this->render();
    }

    public function affichageSuppressionCompte(){
        $this->html .= <<<FIN
        <h3>Voulez-vous vraiment supprimer votre compte ?</h3>
        <form method='post' action=''>
        <input type='submit' class='submit' value='Supprimer'>
        </form>
        FIN;
        $this->title = "Supprimer Compte";
        $this->render();
    }

    public function affichageNotSup(){
        $this->html .= <<<FIN
        <h3>nous n'avons pas supprimer le compte car il n'existe pas</h3>
        
        FIN;
        $this->render();
    }

    public function modifierCompte(){
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
}
