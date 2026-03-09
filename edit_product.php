<?php
require_once 'config.php';

// 1. Vérification de l'ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: admin.php");
    exit();
}

$id = $_GET['id'];

// 2. Récupération des données du produit actuel
$query = $pdo->prepare("SELECT * FROM product WHERE id_product = ?");
$query->execute([$id]);
$product = $query->fetch();

if (!$product) {
    header("Location: admin.php");
    exit();
}

// 3. Récupération des catégories pour le menu déroulant
$categories = $pdo->query("SELECT * FROM category")->fetchAll();

// 4. Traitement de la modification (UPDATE)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $desc = $_POST['description'];
    $cat = $_POST['id_category'];
    $tag = $_POST['tag'];
    $img = $_POST['picture'];
    $video = $_POST['video'];

    $sql = "UPDATE product SET 
            name = ?, 
            price = ?, 
            description = ?, 
            id_category = ?, 
            tag = ?, 
            picture = ?, 
            video = ? 
            WHERE id_product = ?";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $price, $desc, $cat, $tag, $img, $video, $id]);

    header("Location: admin.php?msg=updated");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier <?= htmlspecialchars($product['name']) ?> - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white p-6 md:p-12">
    <div class="max-w-3xl mx-auto bg-gray-800 p-8 rounded-3xl border border-white/10 shadow-2xl">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-black uppercase italic tracking-tighter">Modifier le jeu</h2>
            <span class="text-blue-500 font-mono text-sm">ID: #<?= $id ?></span>
        </div>
        
        <form method="POST" class="grid grid-cols-1 md:grid-