<?php 
require_once 'config.php';

$idCategory = null;

if (isset($_GET['SelectionnerGenre']) && $_GET['SelectionnerGenre'] !== 'tout') {
    $idCategory = (int)$_GET['SelectionnerGenre'];
}

// CORRECTION : Ta colonne s'appelle name_category dans la table category
$stmtCategories = $pdo->query("SELECT id_category, name_category FROM category ORDER BY name_category ASC");
$categories = $stmtCategories->fetchAll();

$conditions = [];
$params = [];

if ($idCategory) {
    $conditions[] = "p.id_category = ?";
    $params[] = $idCategory;
}

// CORRECTION : Sélection de name_category
$sql = "SELECT p.*, c.name_category AS category_name FROM product p 
        JOIN category c ON p.id_category = c.id_category";

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$resultats = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Catalogue - Master Gaming</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans">

    <?php require_once 'header.php'; ?>

    <main class="max-w-7xl mx-auto px-4 py-12">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-6">
            <h2 class="text-4xl font-black uppercase italic tracking-tighter border-l-8 border-blue-600 pl-6">
                Le Catalogue
            </h2>

            <form method="get" class="flex items-center gap-2 bg-gray-800 p-2 rounded-2xl border border-white/10 shadow-xl">
                <select name="SelectionnerGenre" id="genre" class="bg-transparent text-white px-4 py-2 outline-none cursor-pointer font-bold uppercase text-xs tracking-widest">
                    <option value="tout" class="bg-gray-800" <?= !$idCategory ? 'selected' : '' ?>>Tous les genres</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id_category'] ?>" class="bg-gray-800"
                            <?= $idCategory === (int)$cat['id_category'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name_category']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl font-black uppercase text-xs transition-all">
                    Filtrer
                </button>
            </form>
        </div>

        <?php if (count($resultats) > 0): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                <?php foreach ($resultats as $produit): ?>
                    <div class="group bg-gray-800 rounded-3xl overflow-hidden border border-white/5 hover:border-blue-500/50 transition-all duration-300 shadow-2xl flex flex-col">
                        
                        <div class="relative aspect-[4/3] overflow-hidden">
                            <img src="<?= htmlspecialchars($produit['picture']) ?>" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                 alt="<?= htmlspecialchars($produit['name']) ?>">
                            <div class="absolute top-4 right-4">
                                <span class="bg-black/60 backdrop-blur-md text-blue-400 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border border-white/10">
                                    <?= htmlspecialchars($produit['category_name']) ?>
                                </span>
                            </div>
                        </div>

                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold mb-2 group-hover:text-blue-500 transition-colors uppercase italic truncate">
                                <?= htmlspecialchars($produit['name']) ?>
                            </h3>
                            
                            <div class="mt-auto flex justify-between items-center pt-4">
                                <p class="text-2xl font-black text-white">
                                    <?= number_format($produit['price'], 2) ?> <span class="text-blue-500 text-sm">€</span>
                                </p>
                                <a href="detail.php?id=<?= $produit['id_product'] ?>" 
                                   class="bg-white text-black hover:bg-blue-600 hover:text-white px-4 py-2 rounded-xl font-black uppercase text-[10px] tracking-widest transition-all">
                                    Détails
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-20 bg-gray-800 rounded-3xl border border-dashed border-white/10">
                <p class="text-gray-400 text-xl font-bold italic uppercase">Aucun jeu trouvé dans cette catégorie.</p>
                <a href="catalogue.php" class="text-blue-500 hover:underline mt-4 inline-block">Voir tout le catalogue</a>
            </div>
        <?php endif; ?>

    </main>

    <?php require_once 'footer.php'; ?>
</body>
</html>