<?php

namespace mywishlist\controleur;

use mywishlist\modele\Item;
use mywishlist\modele\Liste;
use mywishlist\modele\Cagnotte;
use mywishlist\modele\Participation;
use mywishlist\vue\VueListe;
use mywishlist\vue\VueItem;

class ControleurItem
{

    protected $liste;

    public function __construct($name)
    {
        $this->liste = Liste::where('token', '=', $name)->first();
    }

    public function itemCreation()
    {
        $aff = new VueListe($this->liste);
        $aff->afficherListeNvItem();
        echo $aff->render();
    }

    public function ajouterItem()
    {
        $app = \Slim\Slim::getInstance();
        $item = new Item();
        $title = filter_var($app->request->post('titre'), FILTER_SANITIZE_STRING);
        $descr = filter_var($app->request->post('descr'), FILTER_SANITIZE_STRING);
        $url = filter_var($app->request->post('url'), FILTER_SANITIZE_STRING);
        $tarif = $app->request->post('prix');
        $item->liste_id = $this->liste->no;
        $item->nom = $title;
        $item->descr = $descr;
        $item->tarif = $tarif;
        $item->url = $url;
        $item->save();
        $aff = new VueListe($this->liste);
        $aff->afficherListe();
        echo $aff->render();
    }

    public function modifierItem($id) {
        $item = Item::where('liste_id', '=', $this->liste->no)->where('id', '=', $id)->first();
        $app = \Slim\Slim::getInstance();
        $nom = $app->request->post('nom');
        $descr = $app->request->post('descr');
        $prix = $app->request->post('prix');
        $url = $app->request->post('url');
        Item::where('id', '=', $id)->update(['nom' => $nom, 'descr' => $descr, 'tarif' => $prix, 'url' => $url]);
        $item = Item::where('id', '=', $id)->first();
        $v = new VueItem($this->liste,$item);
        $v->afficherItemCreateur();
        echo $v->render();
    }

    public function modificationItem($id) {
        $item = Item::where('liste_id', '=', $this->liste->no)->where('id', '=', $id)->first();
         $v = new VueItem($this->liste,$item);
         $v->modifierItem();
         echo $v->render();
    }

    public function afficherItem($id)
    {
        $item = Item::where('liste_id', '=', $this->liste->no)->where('id', '=', $id)->first();
        $aff = new VueItem($this->liste, $item);
        $aff->afficherItemCreateur();
        echo $aff->render(); // methode render de la vue item
    }

    public function ajouterImage($id)
    {
        $item = Item::where('liste_id', '=', $this->liste->no)->where('id', '=', $id)->first();
        $aff = new VueItem($this->liste, $item);
        $aff->ajouterImageItem();
        echo $aff->render();
    }

    public function enregistrerImage($id)
    {
        $app = \Slim\Slim::getInstance();
        $item = Item::where('liste_id', '=', $this->liste->no)->where('id', '=', $id)->first();
        $img = filter_var( $app->request->post('URL'), FILTER_SANITIZE_STRING);
        if (empty($img)) 
            $img = filter_var( $app->request->post('fichier'), FILTER_SANITIZE_STRING);
        
        Item::where('id', '=', $id)->update(['img' => $img]);
        $item = Item::where('liste_id', '=', $this->liste->no)->where('id', '=', $id)->first();
        $v = new VueItem($this->liste, $item);
        $v->afficherItemCreateur();
        echo $v->render();
    }

    public function modifierImage($id)
    {
        $app = \Slim\Slim::getInstance();
        $item = Item::where('liste_id', '=', $this->liste->no)->where('id', '=', $id)->first();
        $aff = new VueItem($this->liste, $item);
        $aff->modifierImage();
        echo $aff->render();
    }

    public function supprimerImage($id)
    {
        $app = \Slim\Slim::getInstance();
        $item = Item::where('liste_id', '=', $this->liste->no)->where('id', '=', $id)->first();
        $aff = new VueItem($this->liste, $item);
        $aff->supprimerImage();
        echo $aff->render();
    }

    public function suppressionImage($id)
    {
        $app = \Slim\Slim::getInstance();
        Item::where('id', '=', $id)->update(['img' => '']);
        $item = Item::where('liste_id', '=', $this->liste->no)->where('id', '=', $id)->first();
        $aff = new VueItem($this->liste, $item);
        $aff->afficherItemCreateur();
        echo $aff->render();
    }

    public function supprimerItem($id){
        $item = Item::where('liste_id', '=', $this->liste->no)->where('id', '=', $id)->first();
        if (!is_null($item)) {
            $item->delete();
        }
       $aff = new VueItem($this->liste, $item);
        $aff->affSuppression();
        echo $aff->render();
    }

    public function suppressionItem($id){
        $item = Item::where('liste_id', '=', $this->liste->no)->where('id', '=', $id)->first();
        $aff = new VueItem($this->liste, $item);
        $aff->affSupprimer();
        echo $aff->render();
    }

    public function afficherParticipation($id){
        $item = Item::where('liste_id', '=', $this->liste->no)->where('id', '=', $id)->first();
        $cagnotte = Cagnotte::where('id_item' , '=' , $id)->first();
        $id_c = $cagnotte->cagnotte_id;
        $participant = Participation::where('id_cagnotte','=',$id_c)->get();
        $montant =0;
        foreach($participant as $p){
            $montant= $montant + $p->montant;
        }
        if($montant < $item->tarif){
        $aff = new VueItem($this->liste, $item);
        $max = $item->tarif - $montant;
        $aff->affParticipation($max);
        echo $aff->render();
        }else{
            $aff = new VueItem($this->liste, $item);
        $aff->affPasParticipation();
        echo $aff->render();
        }
    }

    public function Participation($id){
        $app = \Slim\Slim::getInstance();
        $item = Item::where('liste_id', '=', $this->liste->no)->where('id', '=', $id)->first();
        $nom = $app->request->post('nom');
        $montant = $app->request->post('montant');
        $cagnotte= Cagnotte::where('id_item', '=', $id)->first();
        $id_c = $cagnotte->cagnotte_id;
        $participation = new Participation();
        $participation->id_cagnotte = $id_c;
        $participation->nom_participant =$nom;
        $participation->montant=$montant;
        $participation->save();
        $aff = new VueItem($this->liste, $item);
        $aff->afterparticipation();
        echo $aff->render();

    }

    public function creerCagnotte($id){
        
        $app = \Slim\Slim::getInstance();
        $cagnotte = new Cagnotte();
        $cagnotte->id_item = $id;
        $cagnotte->save();
        $cagnotte= Cagnotte::where('id_item', '=', $id)->first();
        $id_c = $cagnotte->cagnotte_id;
        Item::where('id', '=', $id)->update( ['id_cagnotte' => $id_c]);
        $item = Item::where('id', '=', $id)->first();
        $aff = new VueItem($this->liste, $item);
        $aff->afficherItemCreateur();
        echo $aff->render();
    }

    public function affCreerCagnotte($id){
        $item = Item::where('liste_id', '=', $this->liste->no)->where('id', '=', $id)->first();
        $aff = new VueItem($this->liste, $item);
        $aff->affCreaParti();
        echo $aff->render();
    }

    public function uploaderImage($id){
        // Affichage de la page permettant de donner l'image à upload
    }

    public function postUploadImage($id){
        // Enregistrement de l'image dans le repertoire
    }

}
