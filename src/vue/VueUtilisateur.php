<?php

namespace mywishlist\vue;

use Slim\Slim;

class VueUtilisateur
{

    private $title;
    private $html;

    public function render() {
        $app = Slim::getInstance();
        $road = "/S3A_Wishlist_Lichacz_Kieffer_Brullard/web/css/style.css";
        $ins = $app->urlFor('inscription_uti');
        $con = $app->urlFor('connexion_uti');
        $lsp = $app->urlFor('liste_publique');
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
                        <li><a href="#">Projet PHP MyWishList</a></li>
                        <li ><a href="$lsp">Liste </a></li>
                        <li class = "connect"><a href="$con">Se connecter </a></li>
                        <li class = "connect"><a href="$ins"> S'inscrire </a></li>
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

    public function logInForm() {
        $app = Slim::getInstance();
        $url = $app->urlFor('inscription_uti');
        $this->html .= <<<FIN
        <h3>Connectez-vous</h3>
        <form action="" method="post">
        Nom: <input type="text" name="nom">
        <p>Mot de passe: <input type="password" name="password"></p>
        <input type="submit" name="i" class="submit" value="Se connecter">
        </form>
        FIN;
        /*
        <h3>Pas encore enregistré ?</h3>
        <a href=$url>Enregistrez-vous ici</a>
        */
        $this->title = "Connexion";
        $this->render();
    }

    public function logOut() {
        $this->html .= "<h2>Vous avez bien été déconnecté.</h2>";
        $this->logInForm();
    }

    public function afterRegisterForm(){
        $app = Slim::getInstance();
        $url = $app->urlFor('connexion_uti');
        $this->html = <<<FIN
        <h3>Votre enregistrement a été réalisé avec succès</h3>
        <p>Vous pouvez maintenant vous connecter en utilisant vos identifiants </p>
        <a href=$url>Page de connexion</a>
        FIN;
        $this->title ="Enregistrement validé";

        $this->render();
    }


    public function connected(){
        $name = $_SESSION['profile']['username'];
        $this->html = <<<FIN
        <h3>Bonjour $name ! Vous êtes connecté.</h3>
        FIN;
        $this->title = "Connexion";
        $this->render();
    }

    public function notConnected(){
        $app = Slim::getInstance();
        $url = $app->urlFor('connexion_uti');
        $this->html = <<<FIN
        <h3>Vous n'êtes pas connecté.</h3>
        <p>Identifiant ou mot de passe incorrect.</p>
        <a href=$url>réessayer</a>
        FIN;
        $this->title = "Connexion";
        $this->render();
    }
}
