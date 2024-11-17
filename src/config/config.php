<?php
try {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db_name = "projetevenements";

    $dsn = "mysql:host=$host;dbname=$db_name;charset=utf8";

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    global $db;
    $db = new PDO($dsn, $user, $pass, $options);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

require_once SRC . '/config/customConfig.php';
