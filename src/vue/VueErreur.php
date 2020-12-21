<?php

namespace mywishlist\vue;

class VueErreur
{

    public static function displayError()
	{

		$html = <<<FIN
<!DOCTYPE html>
<html>
  <head>
	<title>MyWishList</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/wishlist/www/css/style.css">
  </head>
  <body>
		<header>Projet PHP MyWishList</header>
        <div class='contenu'>
            <h1>La ressource demandée est indisponible...</h1>
        </div>
		<footer>Sarah Lichacz | Charlie Kieffer | Baptiste Brullard</footer>
  </body>
</html>
FIN;
		echo $html;
	}
}
