<?php

use confBDD\Eloquent;
use mywishlist\controleur\ControleurItem;
use mywishlist\controleur\ControleurListe;
use mywishlist\controleur\ControleurParticipant;
use mywishlist\controleur\ControleurUtilisateur;

require_once __DIR__ . "/vendor/autoload.php";

// Attention, la BDD a été modifié pour convenir aux besoins de certaines fonctionnalités, 
// pour garantir le bon fonctionnement de l'application il faut créer la BDD à l'aide du fichier mywishlist.sql disponible dans le dossier src

Eloquent::start(__DIR__ . '/conf/db.config.ini');

$app = new Slim\Slim;

session_start();

// Affichage de la page d'accueil du site
$app->get('/', function () {
	$c = new ControleurUtilisateur();
	$c->pageAccueil();
})->name('accueil');

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

// Affichage de la page permettant la connexion de l'utilisateur
$app->get('/connexion', function () {
	$c = new ControleurUtilisateur();
	$c->logInForm();
})->name('connexion_uti');

// Connexion de l'utilisateur si les informations renseignees sont verifiees dans la BDD
$app->post('/connexion', function () use ($app) {
	$c = new ControleurUtilisateur();
	$c->authenticateUser(filter_var($app->request->post('nom'), FILTER_SANITIZE_STRING), $app->request->post('password'));
});

// Deconnexion de l'utilisateur
$app->get('/deconnexion', function () {
	$c = new ControleurUtilisateur();
	$c->logOut();
})->name('deconnexion_uti');

// Affichage de la page permettant de creer/ajouter un nouvel item dans la liste de souhait donnee
$app->get('/createur/nouvel_item/:name', function ($name) {
	$c = new ControleurItem($name);
	$c->itemCreation();
})->name('formulaire_item');

// Enregistrement du nouvel item dans la BDD
$app->post('/createur/nouvel_item/:name', function ($name) use ($app) {
	$c = new ControleurItem($name);
	$c->ajouterItem();
});

// Affichage de la page pour modifier un item
$app->get('/createur/modifier_item/:name/:id', function ($name, $id) {
	$c = new ControleurItem($name);
	$c->modificationItem($id);
})->name('modif_item');

// Modification d'un item
$app->post('/createur/modifier_item/:name/:id', function ($name, $id) {
	$c = new ControleurItem($name);
	$c->modifierItem($id);
});

// Affichage de la page pour supprimer un item
$app->post('/createur/supprimer_item/:name/:id', function ($name, $id) {
	$c = new ControleurItem($name);
	$c->supprimerItem($id);
})->name('supp_item');

// Suppression d'un item
$app->get('/createur/supprimer_item/:name/:id', function ( String $name, $id) {
	$c = new ControleurItem($name);
	$c->suppressionItem($id);
});

// Affichage de la page permettant de choisir une liste
$app->get('/participant/aff_liste', function () {
	$c = new ControleurListe();
	$c->choixListe(1);
})->name('aff_liste');

// Affichage de la page permettant de choisir une liste
$app->get('/createur/aff_liste', function () {
	$c = new ControleurListe();
	$c->choixListe(2);
})->name('cons_liste');

// Affichage de la page avec les informations sur un item donne (point de vue du createur de la liste)
$app->get('/createur/aff_liste/:name/:id', function (string $name, $id) {
	$c = new ControleurItem($name);
	$c->afficherItem($id);
})->name('voir_item');

// Affichage de la page avec les informations sur un item donne (point de vue du participant a la liste)
$app->get('/participant/aff_liste/:name/:id', function (string $name, $id) {
	$c = new ControleurParticipant();
	$c->afficherItem($name, $id);
})->name('consulter_item');

// Affichage de la page permettant a un participant d'acheter un item de la liste
$app->post('/participant/aff_liste/:name/:id', function (string $name, $id) {
	$c = new ControleurParticipant();
	$c->acquerirItem($name, $id);
});

// Affichage de la page permettant au participant d'afficher une liste
$app->get('/participant/aff_liste/:name', function ($name) {
	$c = new ControleurListe();
	$c->afficherListe($name);
})->name('voir_liste');

// Enregistrement du message du participant
$app->post('/participant/aff_liste/:name', function ($name) {
	$c = new ControleurListe();
	$c->enregistrerMessage($name);
});

// Affichage de la page permettant au createur d'afficher une liste
$app->get('/createur/aff_liste/:name', function ($name) {
	$c = new ControleurListe();
	$c->afficherListe($name);
})->name('consulter_liste');

// Affichage de la page permettant au createur d'envoyer un lien pour partager sa liste
$app->get('/createur/partager_liste/:name', function ($name) {
	$c = new ControleurListe();
	$c->partagerListe($name);
})->name('partager');

// Affichage de la page permettant au createur de creer une liste
$app->get('/createur/nouvelle_liste', function () {
	$c = new ControleurListe();
	$c->nouvelleListe();
})->name('creation_liste');

// Enregistrement de la nouvelle liste 
$app->post('/createur/nouvelle_liste', function () {
	$c = new ControleurListe();
	$c->enregistrerListe();
});

// Affichage de la page permettant au createur de supprimer sa liste
$app->get('/createur/supprimer_liste/:name', function ($name) {
	$c = new ControleurListe();
	$c->suppressionListe($name);
})->name('supprimer_liste');

// Suppression de la liste
$app->post('/createur/supprimer_liste/:name', function ($name) {
	$c = new ControleurListe();
	$c->supprimerListe($name);
});

// Affichage de la page permettant au createur de modifier sa liste
$app->get('/createur/modifier_liste/:name', function ($name) {
	$c = new ControleurListe();
	$c->modificationListe($name);
})->name('modifier_liste');

// Modification de la liste
$app->post('/createur/modifier_liste/:name', function ($name) {
	$c = new ControleurListe();
	$c->modifierListe($name);
});

// Affichage de la page permettant au createur de rendre une liste publique
$app->get('/createur/rendre_publique/:name', function ($name) {
	$c = new ControleurListe();
	$c->publicationListe($name);
})->name('rendre_publique');

// Modification de la confidentialité de la liste
$app->post('/createur/rendre_publique/:name', function ($name) {
	$c = new ControleurListe();
	$c->publierListe($name);
});

// Affichage d'une page permettant d'ajouter une image à un item
$app->get('/createur/ajouter_image/:name/:id', function ($name, $id) {
	$c = new ControleurItem($name);
	$c->ajouterImage($id);
})->name('ajouter_img');

// Ajout de l'image à l'item
$app->post('/createur/ajouter_image/:name/:id', function ($name, $id) {
	$c = new ControleurItem($name);
	$c->enregistrerImage($id);
});

// Affichage d'une page permettant de modifer l'image d'un item
$app->get('/createur/modifier_image/:name/:id', function ($name, $id) {
	$c = new ControleurItem($name);
	$c->modifierImage($id);
})->name('modifier_img');

// Mise a jour de l'image de l'item
$app->post('/createur/modifier_image/:name/:id', function ($name, $id) {
	$c = new ControleurItem($name);
	$c->enregistrerImage($id);
});

// Affichage d'une page permettant de supprimer l'image d'un item
$app->get('/createur/supprimer_image/:name/:id', function ($name, $id) {
	$c = new ControleurItem($name);
	$c->supprimerImage($id);
})->name('supprimer_img');

// Suppression de l'image de l'item
$app->post('/createur/supprimer_image/:name/:id', function ($name, $id) {
	$c = new ControleurItem($name);
	$c->suppressionImage($id);
});

// Affichage d'une page pour l'espace personnel
$app->get('/createur/espace_personnel', function () {
	$c = new ControleurUtilisateur();
	$c->affichageEspacePerso();
})->name('es_p');

// Suppression du compte
$app->post('/createur/supprimer_compte', function () {
	$c = new ControleurUtilisateur();
	$c->supprimerCompte();
});

// Affichage d'une page pour la suppression du compte
$app->get('/createur/supprimer_compte', function () {
	$c = new ControleurUtilisateur();
	$c->suppressionCompte();
})->name('supprimerCompte');


// Affichage de la page de modification du compte
$app->get('/createur/modifier_compte/', function (){
    $c = new ControleurUtilisateur();
    $c->modificationCompte();
})->name('modifier_compte');

// Modifier le compte
$app->post('/createur/modifier_compte/', function (){
    $c = new ControleurUtilisateur();
    $c->modifierCompte();
});

// Affichage de la page permettant à un utilisateur de participer à une cagnotte
$app->get('/participant/participer_cagnotte/:name/:id', function (String $name, $id) {
	$c = new ControleurItem($name);
	$c->afficherParticipation($id);
})->name('participation_cagnotte');

// Enregistrement de la participation
$app->post('/participant/participer_cagnotte/:name/:id', function (String $name, $id) {
	$c = new ControleurItem($name);
	$c->Participation($id);
});

// Affichage de la page permettant à un createur de creer une cagnotte
$app->get('/createur/creer_cagnotte/:name/:id', function (String $name,$id){
	$c = new ControleurItem($name);
	$c->affCreerCagnotte($id);
})->name('crea_cagnotte');

// Creation d'une cagnotte
$app->post('/createur/creer_cagnotte/:name/:id', function (String $name,$id){
	$c = new ControleurItem($name);
	$c->creerCagnotte($id);
});

// Affichage de la page pour joindre une liste
$app->get('/createur/joindre_liste/:name', function (String $name){
	$c = new ControleurListe();
	$c->affJoindreliste($name);
})->name('joindre_liste');

// Joindre une liste
$app->post('/createur/joindre_liste/:name', function (String $name){
	$c = new ControleurListe();
	$c->JoindreListe($name);
});

// Affichage de la page permettant d'afficher les createurs ayant une liste publique'
$app->get('/participant/aff_createurs', function () {
    $c = new ControleurUtilisateur();
    $c->afficherCreateursPubliques();
})->name('aff_createurs');

// Affichage de la page pour uploader une image
$app->get('/createur/uploader_image/:name/:id', function ($name, $id) {
    $c = new ControleurItem($name);
    $c->uploaderImage($id);
})->name('upload_image');

// Methode pour uploader une image
$app->post('/createur/uploader_image/:name/:id', function ($name, $id) {
    $c = new ControleurItem($name);
    $c->postUploadImage($id);
});

$app->run();
