<?php
require_once 'config.php';

// Sécurité : utilisateur connecté obligatoire
if (!isset($_SESSION['id_user'])) {
    header('Location: connexion.php');
    exit;
}

// Panier vide = retour au panier
if (empty($_SESSION['panier'])) {
    header('Location: panier.php');
    exit;
}

$id_user = $_SESSION['id_user'];
$panier  = $_SESSION['panier'];

try {
    // 1. Créer la commande
    $stmt = $pdo->prepare("INSERT INTO pb_order (id_user, order_date, status) VALUES (?, NOW(), 'termine')");
    $stmt->execute([$id_user]);
    $id_order = $pdo->lastInsertId();

    // 2. Insérer chaque jeu du panier dans order_product
    $stmtProduct = $pdo->prepare("INSERT INTO order_product (id_order, id_product) VALUES (?, ?)");

    foreach ($panier as $id_product => $jeu) {
        $stmtProduct->execute([$id_order, (int)$id_product]);
    }

    // 3. Vider le panier
    unset($_SESSION['panier']);

    // 4. Redirection vers confirmation
    header('Location: confirmation.php?order=' . $id_order);
    exit;
} catch (PDOException $e) {
    die("Erreur SQL : " . $e->getMessage());
}
