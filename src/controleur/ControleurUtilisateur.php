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
        echo $v->render();
    }

    public function createUser(string $nom, string $password)
    {
        $utilisateur = new Utilisateur();
        $utilisateur->nom = $nom;
        $utilisateur->password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
        $utilisateur->save();
        $v = new VueUtilisateur();
        $v->afterRegisterForm();
        echo $v->render();
    }

    public function logInForm()
    {
        $v = new VueUtilisateur();
        $v->logInForm();
        echo $v->render();
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
                $_SESSION['profile'] = array('username' => $utilisateur->nom, 'userid' => $utilisateur->user_id, 'role' => 'createur');
                $v = new VueUtilisateur();
                /*
                $v->role = $_SESSION['profile']['role'];
                $v->user_id = $_SESSION['profile']['userid'];
                */
                $v->connected();
            } else {
                $v = new VueUtilisateur();
                $v->notConnected();
            }
        } else {
            $v = new VueUtilisateur();
            $v->notConnected();
        }
        echo $v->render();
    }

    public function pageAccueil()
    {
        $v = new VueUtilisateur();
        $v->affichageAccueil();
        echo $v->render();
    }

    public function affichageEspacePerso()
    {
        $v = new VueUtilisateur();
        $v->affEsP();
        echo $v->render();
    }

    public function supprimerCompte()
    {
        $usr = $_SESSION['profile']['userid'];
        $utilisateur = Utilisateur::where('user_id', '=', $usr)->first();
        if (!is_null($utilisateur)) {
            $utilisateur->delete();
            $this->logOut();
        } else {
            $v = new VueUtilisateur();
            $v->affichageNotSup();
        }
        echo $v->render();
    }

    public function suppressionCompte()
    {
        $v = new VueUtilisateur();
        $v->affichageSuppressionCompte();
        echo $v->render();
    }

    public function modifierCompte()
    {
        $app = \Slim\Slim::getInstance();
        $nom = $_SESSION['profile']['username'];
        $password = filter_var($app->request->post('password'), FILTER_SANITIZE_STRING);
        Utilisateur::where('nom', '=', $nom)->update(['password' => password_hash($password, PASSWORD_DEFAULT, ['cost' => 12])]);
        $v = new VueUtilisateur();
        $this->logOut();
        echo $v->render();
    }

    public function modificationCompte()
    {
        if (isset($_SESSION['profile'])) {
            $nom = $_SESSION['profile']['username'];
            $utilisateur = Utilisateur::where('nom', '=', $nom)->first();
            $v = new VueUtilisateur();
            $v->modifierCompte();
            echo $v->render();
        } else {
            $this->logInForm();
        }
        echo $v->render();
    }

    public function afficherCreateursPubliques(){
        $v = new VueUtilisateur();
        $v->afficherCreateursPubliques();
        echo $v->render();
    }
}
