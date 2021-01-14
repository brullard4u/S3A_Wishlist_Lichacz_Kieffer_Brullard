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

    public function logOut()
    {
        session_unset();
        $this->pageAccueil();
    }

    public function authenticateUser(string $nom, string $password)
    {
        $utilisateur = Utilisateur::where('nom', '=', $nom)->first();
        if (!is_null($utilisateur)) {
            if (password_verify($password, $utilisateur->password)) {
                $role = "createur";
                $_SESSION['profile'] = array('username' => $utilisateur->nom, 'userid' => $utilisateur->user_id, 'role' => $role);
                $v = new VueUtilisateur();
                $v->role = $_SESSION['profile']['role'];
                $v->user_id = $_SESSION['profile']['userid'];
                $v->connected();
            } else {
                $v = new VueUtilisateur();
                $v->notConnected();
            }
        } else {
            $v = new VueUtilisateur();
            $v->notConnected();
        }
    }

    public function pageAccueil()
    {
        $v = new VueUtilisateur();
        $v->affichageAccueil();
    }
}
