<?php

namespace mywishlist\vue;

abstract class VueGenerale
{

    protected $html, $menu, $role;

    public function __construct($role)
    {
        $this->role = $role;
    }

    public function render()
    {
        if ($this->role == "createur")
            $title = "Création de liste de souhaits";
        else
            $title = "Participation à une liste de cadeaux";
        return <<<FIN
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="utf-8">
            <meta name="description" content="">
            <link rel="stylesheet" href="../../web/css/style.css">
            <title>$title</title>
        </head>
        <body>
            <header>Projet PHP MyWishList</header>
            <h1>$title</h1>
            <div>{$this->menu}</div>
            <div class='contenu'
            {$this->html}
            </div>
            <footer>Sarah Lichacz | Charlie Kieffer | Baptiste Brullard</footer>
        </body>
        </html>
        FIN;
    }
}
