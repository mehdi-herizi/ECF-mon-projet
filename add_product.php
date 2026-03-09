<?php
require_once 'config.php';

// On récupère les catégories pour le menu déroulant
$categories = $pdo->query("SELECT * FROM category")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // On récupère les données du formulaire
    $name = $_POST['name'];
    $price = $_POST['price'];
    $desc = $_POST['description'];
    $cat = $_POST['id_category'];
    $tag = $_POST['tag'];
    $img = $_POST['picture']; // Chemin de l'image (ex: images/fortnite.jpg)
    $date = date('Y-m-d'); // Date du jour pour la colonne date_

    $sql = "INSERT INTO product (name, price, description, id_category, tag, picture, date_, is_active) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 1)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $price, $desc, $cat, $tag, $img, $date]);

    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter un Jeu - Master Gaming</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white p-10">
    <?php require 'header.php'; ?>
    <div class="max-w-2xl mx-auto bg-gray-800 p-8 rounded-3xl border border-white/10">
        <h2 class="text-3xl font-black mb-6 uppercase">Ajouter un produit</h2>

        <form method="POST" class="flex flex-col gap-4">
            <input type="text" name="name" placeholder="Nom du jeu" class="bg-gray-700 p-3 rounded-xl border-none outline-none focus:ring-2 focus:ring-blue-500" required>

            <div class="flex gap-4">
                <input type="number" step="0.01" name="price" placeholder="Prix (ex: 59.99)" class="bg-gray-700 p-3 rounded-xl flex-1 outline-none" required>
                <select name="tag" class="bg-gray-700 p-3 rounded-xl flex-1 outline-none">
                    <option value="new">Nouveau (New)</option>
                    <option value="trending">Tendance (Trending)</option>
                    <option value="coming_soon">Bientôt (Coming Soon)</option>
                </select>
            </div>

            <select name="id_category" class="bg-gray-700 p-3 rounded-xl outline-none">
                <?php foreach ($categories as $c): ?>
                    <option value="<?= $c['id_category'] ?>"><?= $c['name_category'] ?></option>
                <?php endforeach; ?>
            </select>

            <input type="text" name="picture" placeholder="Lien de l'image (images/monjeu.jpg)" class="bg-gray-700 p-3 rounded-xl outline-none">
            <div class="md:col-span-2">
                <label class="block text-[10px] uppercase font-bold text-gray-500 ml-2 mb-1">Lien du Trailer (YouTube Embed ou MP4)</label>
                <input type="text" name="video" placeholder="Ex: https://www.youtube.com/embed/dQw4w9WgXcQ"
                    class="w-full bg-gray-700 border-none rounded-xl p-4 focus:ring-2 focus:ring-blue-500 outline-none transition-all text-white">
                <p class="text-[10px] text-gray-500 mt-1 ml-2 italic">Laissez vide si aucun trailer n'est disponible.</p>
            </div>
            <textarea name="description" placeholder="Description du jeu..." class="bg-gray-700 p-3 rounded-xl h-32 outline-none"></textarea>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl transition-all">
                Enregistrer le produit
            </button>
            <a href="admin.php" class="text-center text-gray-400 hover:text-white mt-2">Annuler</a>
        </form>
    </div>
</body>

</html>