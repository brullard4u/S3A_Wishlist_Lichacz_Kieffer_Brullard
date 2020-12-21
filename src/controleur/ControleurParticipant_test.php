<?php

namespace mywishlist\controleur;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

use mywishlist\vue\VueErreur;

class ControleurParticipant_test
{
	private $app;

	public function __construct($app)
	{
		$this->app = $app;
	}
	public function accueil(Request $rq, Response $rs, $args)
	{
		$rs->getBody()->write('accueil racine du site');
		return $rs;
	}
	public function afficherListes(Request $rq, Response $rs, $args)
	{
		$listl = \mywishlist\models\Liste::all();
		$vue = new \mywishlist\vue\VueParticipant($listl->toArray());
		$vue->render(1);
		return $rs;
	}
	public function afficherListe(Request $rq, Response $rs, $args)
	{
		$no = $args['no'];
		$liste = \mywishlist\models\Liste::find($no);
		if (!is_null($liste)) {
			$vue = new \mywishlist\vue\VueParticipant([$liste]);
			$vue->render(2);
		} else {
			VueErreur::displayError();
		}
		return $rs;
	}
	public function afficherItem(Request $rq, Response $rs, $args)
	{
		$id = $args['id'];
		$item = \mywishlist\models\Item::find($id);
		if (!is_null($item)) {
			$vue = new \mywishlist\vue\VueParticipant([$item]);
			$vue->render(3);
		} else {
			VueErreur::displayError();
		}
		return $rs;
	}
}
