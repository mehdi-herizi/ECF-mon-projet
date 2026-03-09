<?php
// 1. Inclure ta connexion (Vérifie si c'est config.php ou config/db.php)
require_once 'config.php'; 

// 2. Correction : "product" au singulier pour correspondre à ta capture SQL
$query = $pdo->query("
    SELECT p.*, c.name_category 
    FROM product p 
    LEFT JOIN category c ON p.id_category = c.id_category
    ORDER BY p.id_product DESC
");
$allProducts = $query->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Master Gaming</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans">
<?php require 'header.php'; ?>
    <section class="p-4 md:p-12 min-h-screen">
        <div class="max-w-7xl mx-auto">
            
            <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-6">
                <h2 class="text-4xl font-black uppercase italic tracking-tighter border-l-8 border-blue-600 pl-6">
                    Gestion du Catalogue
                </h2>
                <a href="admin_messages.php" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-full transition-all shadow-lg shadow-green-900/20">
                    Messages reçus
                </a>
                <a href="add_product.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-full transition-all shadow-lg shadow-blue-900/20">
                    + Ajouter un nouveau jeu
                </a>
            </div>

            <div class="bg-gray-800 rounded-3xl overflow-hidden shadow-2xl border border-white/10">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-black/50 text-blue-400 uppercase text-sm tracking-widest">
                                <th class="p-6">Image</th>
                                <th class="p-6">Nom du jeu</th>
                                <th class="p-6">Prix</th>
                                <th class="p-6">Tag</th> <th class="p-6 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            <?php foreach ($allProducts as $p): ?>
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="p-4">
                                    <img src="<?= htmlspecialchars($p['picture']) ?>" class="w-20 h-12 object-cover rounded-lg shadow-md border border-white/10">
                                </td>
                                <td class="p-4">
                                    <div class="font-bold text-lg"><?= htmlspecialchars($p['name']) ?></div>
                                    <div class="text-xs text-gray-400 uppercase"><?= htmlspecialchars($p['name_category'] ?? 'Général') ?></div>
                                </td>
                                <td class="p-4 text-blue-400 font-bold"><?= number_format($p['price'], 2) ?>€</td>
                                <td class="p-4">
                                    <span class="bg-blue-500/20 text-blue-300 px-2 py-1 rounded text-[10px] font-bold uppercase">
                                        <?= htmlspecialchars($p['tag'] ?? 'Aucun') ?>
                                    </span>
                                </td>
                                <td class="p-4">
                                    <div class="flex justify-center gap-3">
                                        <a href="edit_product.php?id=<?= $p['id_product'] ?>" class="p-2 bg-yellow-500/10 text-yellow-500 rounded-xl hover:bg-yellow-500 hover:text-black transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <a href="delete_product.php?id=<?= $p['id_product'] ?>" onclick="return confirm('Supprimer définitivement ce jeu ?')" class="p-2 bg-red-500/10 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

</body>
</html>