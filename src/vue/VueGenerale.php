<?php

namespace mywishlist\vue;

use Slim\Slim;

abstract class VueGenerale
{

    protected $html, $menu, $title;
    protected $role, $user_id;

    public function __construct()
    {
        if (isset($_SESSION['profile'])) {
            $this->role = $_SESSION['profile']['role'];
            $this->user_id = $_SESSION['profile']['userid'];
        } else {
            $this->role = "participant";
        }
    }

    public function render()
    {
        $app = Slim::getInstance();
        $lsp = $app->urlFor('aff_liste');
        $cls = $app->urlFor('creation_liste');
        $ac = $app->urlFor('accueil');
        $ls = $app->urlFor('cons_liste');
        $cp = $app->urlFor('aff_createurs');
        $ins = $app->urlFor('inscription_uti');
        $con = $app->urlFor('connexion_uti');
        $deco = $app->urlFor('deconnexion_uti');
        $esp = $app->urlFor('es_p');
        $road = "/S3A_Wishlist_Lichacz_Kieffer_Brullard/web/css/style.css";
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
                    </ul>
            </li>
            <li class = "connect"><a href="$deco">Se déconnecter </a></li>
            FIN;
        }
        return <<<FIN
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
                <li><a href=$ac>Projet PHP MyWishList</a></li>
                <li><a href="$lsp">Consulter les listes</a></li>
                <li><a href="$cp">Consulter les créateurs</a> </li>
                $connect
            </ul>
        </nav>
        </header>
            <div>{$this->menu}</div> 
            <div class='contenu'>
            <h1>{$this->title}</h1>
            {$this->html}
            </div>
            <footer>Sarah Lichacz | Charlie Kieffer | Baptiste Brullard</footer>
        </body>
        </html>
        FIN;
    }
}
