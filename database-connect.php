<?php

    function db_connect(): PDO{

        // Fetch the config values; if, for some reason, they are not available, terminate immediately.
        $config = require ('config.php');
        if (!$config) {die;};

        $pdo = new PDO(
            "mysql:host=".$config["db_host"].";dbname=".$config["db_name"],
            $config["db_user"],
            $config["db_pass"]
        );

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }


?>