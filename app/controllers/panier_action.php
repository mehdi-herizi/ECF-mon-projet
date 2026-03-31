<?php
require_once 'config.php';

// Sécurité : Si l'utilisateur n'a pas de panier en session, on le crée
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// ACTION : AJOUTER UN PRODUIT
if (isset($_GET['add'])) {
    $id = (int)$_GET['add'];
    
    // On vérifie si le produit existe en base de données
    $stmt = $pdo->prepare("SELECT id_product, name, price, picture FROM product WHERE id_product = ?");
    $stmt->execute([$id]);
    $game = $stmt->fetch();

    if ($game) {
        // On stocke les infos essentielles dans la session pour éviter de refaire des requêtes SQL sur la page panier
        $_SESSION['panier'][$id] = [
            'name'    => $game['name'],
            'price'   => $game['price'],
            'picture' => $game['picture'],
            'qty'     => 1 // Optionnel si tu ne gères pas les quantités multiples
        ];
    }
    
    // Redirection vers le panier pour voir le résultat
    header('Location: panier.php');
    exit;
}

// ACTION : SUPPRIMER UN PRODUIT
if (isset($_GET['remove'])) {
    $id = (int)$_GET['remove'];
    
    if (isset($_SESSION['panier'][$id])) {
        unset($_SESSION['panier'][$id]);
    }
    
    header('Location: panier.php');
    exit;
}

// ACTION : VIDER TOUT LE PANIER (Optionnel)
if (isset($_GET['clear'])) {
    unset($_SESSION['panier']);
    header('Location: panier.php');
    exit;
}

// Si on arrive ici sans action précise, on retourne à l'index
header('Location: index.php');
exit;