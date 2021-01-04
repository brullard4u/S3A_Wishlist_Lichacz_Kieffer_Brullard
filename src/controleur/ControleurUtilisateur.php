<?php

namespace mywishlist\controleur;

use mywishlist\modele\Utilisateur;
use mywishlist\vue\VueUtilisateur;
use mywishlist\modele\Liste;

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
        $v = new VueUtilisateur();
        $v->afterRegisterForm();
    }

    public function logInForm()
    {
        $v = new VueUtilisateur();
        $v->logInForm();
    }

    public function authenticateUser(string $nom, string $password): Utilisateur
    {
        $utilisateur = Utilisateur::where('nom', '=', $nom)->first();
        if (!is_null($utilisateur)) {
            if (password_verify($password, $utilisateur->password)) {
                $role = "";
                $liste = Liste::where('user_id', '=', $utilisateur->user_id)->first();
                if (is_null($liste))
                    $role = "participant";
                else
                    $role = "createur";
                $_SESSION['profile'] = array('username' => $utilisateur->nom, 'userid' => $utilisateur->user_id, 'role' => $role);
                setcookie('user_id', $utilisateur->user_id, 0);
                $v = new VueUtilisateur();
                $v->connected();
            } else {
                $v = new VueUtilisateur();
                $v->notConnected();
            }
        } else {
            $v = new VueUtilisateur();
            $v->notConnected();
        }
        return $utilisateur;
    }
}
