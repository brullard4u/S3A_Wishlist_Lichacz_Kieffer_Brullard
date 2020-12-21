<?php

namespace mywishlist\vue;

class VueUtilisateur
{

    public function registerForm()
    {
        echo <<<FIN
        <h3>Enregistrez-vous</h3>
        <form action="" method="post">
        Nom: <input type="text" name="nom">
        <p>Mot de passe: <input type="password" name="password"></p>
        <input type="submit" name="i" value="S'Enregistrer">
        </form>
        FIN;
    }
}
