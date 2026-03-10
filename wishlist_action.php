<?php
require_once 'config.php';

if (!isset($_SESSION['id_user']) || !isset($_GET['id'])) {
    header('Location: catalogue.php');
    exit;
}

$id_user = $_SESSION['id_user'];
$id_product = (int)$_GET['id'];

// Vérifier si le jeu est déjà dans la liste
$check = $pdo->prepare("SELECT * FROM wishlist WHERE id_user = ? AND id_product = ?");
$check->execute([$id_user, $id_product]);

if ($check->fetch()) {
    // Si il y est, on le retire (Toggle)
    $stmt = $pdo->prepare("DELETE FROM wishlist WHERE id_user = ? AND id_product = ?");
} else {
    // Sinon, on l'ajoute
    $stmt = $pdo->prepare("INSERT INTO wishlist (id_user, id_product) VALUES (?, ?)");
}

$stmt->execute([$id_user, $id_product]);

// Retour à la page précédente
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;