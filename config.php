<?php
session_start();

$dsn = "mysql:host=mysql-server;dbname=Mastergaming;charset=utf8";
$user = "root";
$password = "root";

// ANCHOR  connexion

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
