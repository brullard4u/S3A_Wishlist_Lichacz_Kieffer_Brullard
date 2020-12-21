<?php

namespace mywishlist\controleur;

use mywishlist\modele\Utilisateur;
use mywishlist\vue\VueUtilisateur;

class ControleurUtilisateur
{

    public function registerForm()
    {
        $v = new VueUtilisateur();
        $v->registerForm();
    }

    public function createUser(string $nom, string $password)
    {
        $utilisateur = new Utilisateur();
        $utilisateur->nom = $nom;
        $utilisateur->password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
        $utilisateur->save();
    }

    public function authenticateUser(string $nom, string $password): Utilisateur
    {
        $utilisateur = Utilisateur::where('nom', '=', $nom)->first();
        if (!is_null($utilisateur)) {
            if (password_verify($password, $utilisateur->password));
            return $utilisateur;
        }
    }
}
