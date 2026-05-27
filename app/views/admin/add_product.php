
<?php
if (!defined('APP_RUNNING')) { header('Location: /master-gaming/?action=home'); exit; }
$recherche    = $recherche    ?? '';
$idCategory   = $idCategory   ?? null;
$categories   = $categories   ?? [];
$resultats    = $resultats    ?? [];
$total        = $total        ?? 0;
$totalPages   = $totalPages   ?? 1;
$pageCourante = $pageCourante ?? 1;
$queryString  = $queryString  ?? '';
$success = $success ?? false;
$error   = $error   ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="icon" href="image-favicon/favicon-master-gaming.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin - Ajouter un jeu sur Master Gaming. Remplissez le formulaire pour ajouter un nouveau jeu à votre catalogue. Définissez le nom, le prix, les catégories, l'image et la description pour offrir la meilleure expérience à vos clients gamers.">
    <title>Ajouter un Jeu - Master Gaming</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white p-10">
<?php require_once ROOT . 'app/views/partials/header.php'; ?>
    <div class="max-w-2xl mx-auto bg-gray-800 p-8 rounded-3xl border border-white/10">
        <h2 class="text-3xl font-black mb-6 uppercase">Ajouter un produit</h2>

        <?php if (!empty($errors)): ?>
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/50 rounded-xl">
                <?php foreach ($errors as $error): ?>
                    <p class="text-red-500 text-xs font-bold">⚠️ <?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="?action=add_product" class="flex flex-col gap-4">
            <input type="text" name="name" placeholder="Nom du jeu"
                class="bg-gray-700 p-3 rounded-xl border-none outline-none focus:ring-2 focus:ring-blue-500" required>

            <div class="flex gap-4">
                <input type="number" step="0.01" name="price" placeholder="Prix (ex: 59.99)"
                    class="bg-gray-700 p-3 rounded-xl flex-1 outline-none" required>
                <select name="tag" class="bg-gray-700 p-3 rounded-xl flex-1 outline-none">
                    <option value="new">Nouveau (New)</option>
                    <option value="trending">Tendance (Trending)</option>
                    <option value="coming_soon">Bientôt (Coming Soon)</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 block mb-3">
                    Catégories <span class="text-gray-600 normal-case">(plusieurs possibles)</span>
                </label>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                    <?php foreach ($categories as $cat): ?>
                        <label class="flex items-center gap-3 bg-gray-700 hover:bg-gray-600 p-3 rounded-xl cursor-pointer border border-white/5 hover:border-blue-500 transition-all group">
                            <input type="checkbox" name="categories[]"
                                value="<?= $cat['id_category'] ?>"
                                class="w-4 h-4 accent-blue-600 cursor-pointer">
                            <span class="text-xs font-bold text-gray-300 group-hover:text-white transition-colors">
                                <?= htmlspecialchars($cat['name_category']) ?>
                            </span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <input type="text" name="picture" placeholder="Lien de l'image (images/monjeu.jpg)"
                class="bg-gray-700 p-3 rounded-xl outline-none">

            <div class="md:col-span-2">
                <label class="block text-[10px] uppercase font-bold text-gray-500 ml-2 mb-1">Lien du Trailer (YouTube ou MP4)</label>
                <input type="text" name="video" placeholder="Ex: https://www.youtube.com/watch?v=..."
                    class="w-full bg-gray-700 border-none rounded-xl p-4 focus:ring-2 focus:ring-blue-500 outline-none transition-all text-white">
                <p class="text-[10px] text-gray-500 mt-1 ml-2 italic">Laissez vide si aucun trailer n'est disponible.</p>
            </div>

            <textarea name="description" placeholder="Description du jeu..."
                class="bg-gray-700 p-3 rounded-xl h-32 outline-none"></textarea>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl transition-all">
                Enregistrer le produit
            </button>
            <a href="?action=admin" class="text-center text-gray-400 hover:text-white mt-2">Annuler</a>
        </form>
    </div>

<?php require_once ROOT . 'app/views/partials/footer.php'; ?>
</body>
</html>