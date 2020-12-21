<?php

namespace confBDD;

use Illuminate\Database\Capsule\Manager as DB;

class Eloquent {

    public static function start(string $file) {

        $db = new DB();
        $config = parse_ini_file($file);

        if ($config)
            $db->addConnection($config);

        $db->setAsGlobal();
        $db->bootEloquent();
    }
}