<?php

namespace mywishlist\vue;

class VueParticipant
{

	private $tab;

	public function __construct($tab)
	{
		$this->tab = $tab;
	}

	private function lesListes()
	{
		$html = '';
		foreach ($this->tab as $liste) {
			$html .= "<li>{$liste['titre']}</li>";
		}
		return "<h1>Affichage des listes :</h1><ul>$html</ul>";
	}

	private function unItem()
	{
		foreach ($this->tab as $item) {
			$html = "<h1>Affichage des informations sur l'item n°$item->id ($item->nom):</h1>";
			$html .= "<p>$item->descr</p>";
			$html .= "<p><img src=/wishlist/web/img/$item->img alt=\"Photo de l'item\" height=500px width=auto></p>";
		}
		return $html;
	}

	private function uneListe()
	{
		$html = '';
		$items = '';
		foreach ($this->tab as $liste) {
			$title = "<h1>Affichage des items de la liste n°$liste->no :</h1><p>$liste->description</p>";
			$html .= "<li>{$liste->titre}</li>";
			foreach ($liste->items()->get() as $item) {
				$items .= '<li>' . $item['nom'] . '</li>';
			}
			$html .= "<ul>$items</ul>";
		}
		return "$title<ul>$html</ul>";
	}

	public function render($select)
	{

		switch ($select) {
			case 1: { // liste des listes
					$content = $this->lesListes();
					break;
				}
			case 2: { // une liste
					$content = $this->uneListe();
					break;
				}
			case 3: { // un item
					$content = $this->unItem();
					break;
				}
		}

		$html = <<<FIN
<!DOCTYPE html>
<html>
  <head>
	<title>MyWishList</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/wishlist/web/css/style.css">
  </head>
  <body>
		<header>Projet PHP MyWishList</header>
		<div class='contenu'>$content</div>
		<footer>Sarah Lichacz | Charlie Kieffer | Baptiste Brullard</footer>
  </body>
</html>
FIN;
		echo $html;
	}
}
