<?php
error_reporting(0);

require_once '../includes/MysqliDb.php';
$db_config = ['host' => "localhost",
    'username' => "root",
    'password' => "",
    'database' => "cours"
    //'port'=> "8080,
    //'charset'=> "utf8"
];

$db = new MysqliDb ($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);

