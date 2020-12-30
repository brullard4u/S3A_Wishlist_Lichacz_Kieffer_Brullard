<?php

namespace mywishlist\vue;

class VueUtilisateur
{

    private $title;
    private $html;

    public function render() {
        echo <<<END
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="utf-8">
            <meta name="description" content="">
            <link rel="stylesheet" href="./web/css/style.css">
            <title>{$this->title}</title>
        </head>
        <body>
            <header>Projet PHP MyWishList</header>
            <h1>{$this->title}</h1>
            <div class='contenu'>{$this->html}</div>
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
        <input type="submit" name="i" value="S'enregistrer">
        </form>
        FIN;
        $this->title = "Enregistrement";

        $this->render();
    }

    public function logInForm() {
        $this->html = <<<FIN
        <h3>Connectez-vous</h3>
        <form action="" method="post">
        Nom: <input type="text" name="nom">
        <p>Mot de passe: <input type="password" name="password"></p>
        <input type="submit" name="i" value="Se connecter">
        </form>
        FIN;
        $this->title = "Connexion";

        $this->render();
    }

    public function afterRegisterForm(){
        $this->html = <<<FIN
        <h3>Votre enregistrement a été réaslisé avec succès</h3>
        <p>Vous pouvez maintenant vous connectez en utilisant vos identifiants </p>
        FIN;
        $this->title ="Enregistrement validé";

        $this->render();
    }
}
