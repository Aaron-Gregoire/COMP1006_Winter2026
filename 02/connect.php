<?php

declare(strict_types=1);

$host = "locahost";
$db = "test_connection";
$user = "root";
$pass = "";

$dsn = "mysql:host=$host;dbname=$db";

try{
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    echo "connected to the databse yay!!!";
}
catch (PDOException $e) {
    die("Databse connection failed: " , $e->getMessage());
}