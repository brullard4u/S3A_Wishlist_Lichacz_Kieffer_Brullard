<?php

require_once __DIR__ . "/vendor/autoload.php";

use \mywishlist\controleur\ControleurParticipant_test;
use mywishlist\controleur\ControleurUtilisateur;

confBDD\Eloquent::start(__DIR__ . '/conf/db.config.ini');

$app = new Slim\Slim;

session_start();

$app->get('/enregistrement', function() {
	$ctrl = new ControleurUtilisateur();
	$ctrl->registerForm();
})->name('inscription_uti');

$app->post('/enregistrement', function() use ($app) {
	$ctrl = new ControleurUtilisateur();
	$ctrl->createUser(filter_var($app->request->post('nom'), FILTER_SANITIZE_STRING), $app->request->post('password'));
});



/*
$config = ['settings' => [
	'displayErrorDetails' => true,
	'dbconf' => '/conf/db.conf.ini',
]];

$container = new \Slim\Container($config);
$app = new \Slim\App($container);

$app->get('/', ControleurParticipant_test::class . ':accueil')->setName('racine');
$app->get('/listes', ControleurParticipant::class . ':afficherListes')->setName('aff_listes');
$app->get('/liste/{no}', ControleurParticipant::class . ':afficherListe')->setName('aff_liste');
$app->get('/item/{id}', ControleurParticipant::class . ':afficherItem')->setName('aff_item');
*/
$app->run();
