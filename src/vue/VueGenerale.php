<?php

namespace mywishlist\vue;

abstract class VueGenerale
{

    protected $html, $menu, $role;

    public function __construct($role)
    {
        $this->role = $role;
    }

    public function render()
    {
        if ($this->role == "createur")
            $title = "Création de liste de souhaits";
        else
            $title = "Participation à une liste de cadeaux";
        return <<<FIN
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="utf-8">
            <meta name="description" content="">
            <meta name="author" content="Ivan Gazeau">
            <title>$title</title>
        </head>
        <body>
            <h1>$title</h1>
            <div>{$this->menu}</div>
            {$this->html}
        </body>
        </html>
        FIN;
    }
}
