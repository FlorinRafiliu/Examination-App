<?php

$server = "mysql:host=localhost;dbname=phpAppDB";
$username = "root";
$password = "";

try {
    $pdo = new PDO($server, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully!";
} catch(PDOException $e) {
    echo "Connection failed " . $e->getMessage();
}