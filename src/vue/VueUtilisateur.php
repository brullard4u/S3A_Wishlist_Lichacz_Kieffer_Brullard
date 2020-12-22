<?php

namespace mywishlist\vue;

class VueUtilisateur
{

    public function registerForm()
    {
        $html = <<<FIN
        <h3>Enregistrez-vous</h3>
        <form action="" method="post">
        Nom: <input type="text" name="nom">
        <p>Mot de passe: <input type="password" name="password"></p>
        <input type="submit" name="i" value="S'Enregistrer">
        </form>
        FIN;
        $title = "Connexion";

        echo <<<FIN
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="utf-8">
            <meta name="description" content="">
            <link rel="stylesheet" href="./web/css/style.css">
            <title>$title</title>
        </head>
        <body>
            <header>Projet PHP MyWishList</header>
            <h1>$title</h1>
            <div class='contenu'>$html</div>
            <footer>Sarah Lichacz | Charlie Kieffer | Baptiste Brullard</footer>
        </body>
        </html>
        FIN;
    }
}
