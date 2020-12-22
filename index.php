<?php

use confBDD\Eloquent;
use mywishlist\controleur\ControleurItem;
use mywishlist\controleur\ControleurParticipant;
use mywishlist\controleur\ControleurUtilisateur;

require_once __DIR__ . "/vendor/autoload.php";


Eloquent::start(__DIR__ . '/conf/db.config.ini');

$app = new Slim\Slim;

session_start();

// Affichage de la page permettant l'enregistrement de l'utilisateur
$app->get('/enregistrement', function () {
	$c = new ControleurUtilisateur();
	$c->registerForm();
})->name('inscription_uti');

// Enregistrement du nouvel utilisateur dans la BDD
$app->post('/enregistrement', function () use ($app) {
	$c = new ControleurUtilisateur();
	$c->createUser(filter_var($app->request->post('nom'), FILTER_SANITIZE_STRING), $app->request->post('password'));
});

// Affichage de la page permettant de creer/ajouter un nouvel item dans la liste de souhait donnee
$app->get('/createur/:name/nouvel_item', function ($name) {
	$c = new ControleurItem($name);
	$c->itemCreation();
})->name('formulaire_item');

// Enregistrement du nouvel item dans la BDD
$app->post('/createur/:name/nouvel_item', function ($name) {
	$c = new ControleurItem($name);
	$c->ajouterItem();
});

// Affichage de la page avec les informations sur un item donne (point de vue du createur de la liste)
$app->get('/createur/:name/:id', function (string $name, $id) {
	$c = new ControleurItem($name);
	$c->afficheritem($id);
})->name('voir_item');

// Affichage de la page avec les informations sur un item donne (point de vue du participaznt a la liste)
$app->get('/participant/:name/:id', function (string $name, $id) {
	$c = new ControleurParticipant();
	$c->afficherItem($name, $id);
})->name('consulter_item');

// Affichage de la page permettant a un participant d'acheter un item de la liste
$app->post('participant/:name/:id', function (string $name, $id) {
	$c = new ControleurParticipant();
	$c->acquerirItem($name, $id);
});

$app->run();
