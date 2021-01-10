<?php

namespace mywishlist\vue;
use Slim\Slim;
abstract class VueGenerale
{

    protected $html, $menu, $role, $user_id;

    public function __construct()
    {
        if (isset($_SESSION['profile'])) {
            $this->role = $_SESSION['profile']['role'];
            $this->user_id = $_SESSION['profile']['userid'];
        }
    }

    public function render()
    {
        $app = Slim::getInstance();
        $lsp = $app->urlFor('aff_liste');
        $cls = $app->urlFor('creation_liste');
        $ac = $app->urlFor('accueil');
        if ($this->role == "createur")
            $title = "Création de liste de souhaits";
        else
            $title = "Participation à une liste de cadeaux";
        $road = "/S3A_Wishlist_Lichacz_Kieffer_Brullard/web/css/style.css";
        return <<<FIN
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="utf-8">
            <meta name="description" content="">
            <link rel="stylesheet" href=$road>
            <title>$title</title>
        </head>
        <body>
        <header>
        <nav class ="menu">
            <ul>
                <li><a href=$ac>Projet PHP MyWishList</a></li>
                <li><a href="$lsp">Liste</a></li>
                <li >
                    <a href="#">Mon compte </a>
                        <ul class ="sous" > 
                            <li><a href="$cls">Créer une liste</a></li>
                            <li><a href="#">Mes listes</a></li>
                        </ul>
                </li>
                <li class = "connect"><a href="#">Se déconnecter </a></li>
               
            </ul>
        </nav>
        </header>
            
            <div>{$this->menu}</div> 
            <div class='contenu'>
            <h1>$title</h1>
            {$this->html}
            </div>
            <footer>Sarah Lichacz | Charlie Kieffer | Baptiste Brullard</footer>
        </body>
        </html>
        FIN;
    }

    public function __get($at)
    {
        if (property_exists($this, $at)) {
            return $this->$at;
        } else throw new \Exception("$at : invalid property");
    }
}
