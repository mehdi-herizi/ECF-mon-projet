<?php 
require_once 'config.php';

$idCategory = null;
if (isset($_GET['SelectionnerGenre']) && $_GET['SelectionnerGenre'] !== 'tout') {
    $idCategory = (int)$_GET['SelectionnerGenre'];
}

$recherche = isset($_GET['q']) ? trim($_GET['q']) : '';

$stmtCategories = $pdo->query("SELECT id_category, name_category FROM category ORDER BY name_category ASC");
$categories = $stmtCategories->fetchAll();

$parPage      = 12;
$pageCourante = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset       = ($pageCourante - 1) * $parPage;

// Conditions filtre + recherche
$conditions = [];
$params     = [];

if ($idCategory) {
    $conditions[] = "p.id_category = ?";
    $params[]     = $idCategory;
}
if ($recherche !== '') {
    $conditions[] = "p.name LIKE ?";
    $params[]     = '%' . $recherche . '%';
}

$whereClause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";

// Total pour pagination
$stmtTotal = $pdo->prepare("SELECT COUNT(*) FROM product p $whereClause");
$stmtTotal->execute($params);
$total      = $stmtTotal->fetchColumn();
$totalPages = ceil($total / $parPage);

// Jeux paginés
$sql = "SELECT p.*, c.name_category AS category_name 
        FROM product p 
        JOIN category c ON p.id_category = c.id_category
        $whereClause
        LIMIT ? OFFSET ?";

$stmtJeux = $pdo->prepare($sql);
$paramIndex = 1;
foreach ($params as $p) {
    $stmtJeux->bindValue($paramIndex++, $p, is_int($p) ? PDO::PARAM_INT : PDO::PARAM_STR);
}
$stmtJeux->bindValue($paramIndex++, $parPage, PDO::PARAM_INT);
$stmtJeux->bindValue($paramIndex,   $offset,  PDO::PARAM_INT);
$stmtJeux->execute();
$resultats = $stmtJeux->fetchAll();

// Conserver filtres dans l'URL de pagination
$queryParams = [];
if ($idCategory)      $queryParams['SelectionnerGenre'] = $idCategory;
if ($recherche !== '') $queryParams['q']                 = $recherche;
$queryString = !empty($queryParams) ? '&' . http_build_query($queryParams) : '';
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

        <div class="flex flex-col gap-6 mb-12">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <h1 class="text-4xl font-black uppercase italic tracking-tighter border-l-8 border-blue-600 pl-6">
                    Le Catalogue
                    <?php if ($total > 0): ?>
                        <span class="text-blue-500 text-2xl ml-3">(<?= $total ?>)</span>
                    <?php endif; ?>
                </h1>

                <!-- Filtre genre -->
                <form method="get" class="flex items-center gap-2 bg-gray-800 p-2 rounded-2xl border border-white/10 shadow-xl">
                    <?php if ($recherche !== ''): ?>
                        <input type="hidden" name="q" value="<?= htmlspecialchars($recherche) ?>">
                    <?php endif; ?>
                    <select name="SelectionnerGenre" id="genre" onchange="this.form.submit()"
                            class="bg-transparent text-white px-4 py-2 outline-none cursor-pointer font-bold uppercase text-xs tracking-widest">
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

            <!-- Barre de recherche -->
            <form method="get" class="w-full">
                <?php if ($idCategory): ?>
                    <input type="hidden" name="SelectionnerGenre" value="<?= $idCategory ?>">
                <?php endif; ?>
                <div class="flex items-center gap-2 bg-gray-800 border border-white/10 rounded-2xl px-4 py-3 shadow-xl focus-within:border-blue-500 transition-all">
                    <svg class="w-5 h-5 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                    </svg>
                    <input type="text" name="q"
                           value="<?= htmlspecialchars($recherche) ?>"
                           placeholder="Rechercher un jeu..."
                           class="flex-1 bg-transparent text-white placeholder-gray-500 outline-none font-bold text-sm tracking-wide">
                    <?php if ($recherche !== ''): ?>
                        <a href="catalogue.php<?= $idCategory ? '?SelectionnerGenre=' . $idCategory : '' ?>"
                           class="text-gray-500 hover:text-red-500 transition-colors text-xs font-black uppercase">
                            ✕ Effacer
                        </a>
                    <?php endif; ?>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl font-black uppercase text-xs transition-all flex-shrink-0">
                        Rechercher
                    </button>
                </div>
            </form>

            <!-- Résultat de recherche actif -->
            <?php if ($recherche !== ''): ?>
                <p class="text-gray-400 text-sm">
                    Résultats pour <span class="text-white font-black italic">"<?= htmlspecialchars($recherche) ?>"</span>
                    — <?= $total ?> jeu<?= $total > 1 ? 'x' : '' ?> trouvé<?= $total > 1 ? 's' : '' ?>
                </p>
            <?php endif; ?>

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

            <!-- PAGINATION -->
            <?php if ($totalPages > 1): ?>
                <div class="flex justify-center items-center gap-2 mt-16">
                    <?php if ($pageCourante > 1): ?>
                        <a href="?page=<?= $pageCourante - 1 . $queryString ?>"
                           class="px-4 py-2 bg-gray-800 hover:bg-blue-600 rounded-xl font-black text-xs uppercase tracking-widest transition-all border border-white/10">
                            ← Précédent
                        </a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i . $queryString ?>"
                           class="w-10 h-10 flex items-center justify-center rounded-xl font-black text-xs transition-all border
                           <?= $i === $pageCourante
                               ? 'bg-blue-600 border-blue-600 text-white'
                               : 'bg-gray-800 border-white/10 text-gray-400 hover:bg-blue-600 hover:text-white hover:border-blue-600' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($pageCourante < $totalPages): ?>
                        <a href="?page=<?= $pageCourante + 1 . $queryString ?>"
                           class="px-4 py-2 bg-gray-800 hover:bg-blue-600 rounded-xl font-black text-xs uppercase tracking-widest transition-all border border-white/10">
                            Suivant →
                        </a>
                    <?php endif; ?>
                </div>
                <p class="text-center text-gray-600 text-xs mt-4 uppercase tracking-widest">
                    Page <?= $pageCourante ?> / <?= $totalPages ?> — <?= $total ?> jeux
                </p>
            <?php endif; ?>

        <?php else: ?>
            <div class="text-center py-20 bg-gray-800 rounded-3xl border border-dashed border-white/10">
                <p class="text-gray-400 text-xl font-bold italic uppercase">
                    <?= $recherche !== '' ? 'Aucun jeu ne correspond à votre recherche.' : 'Aucun jeu trouvé dans cette catégorie.' ?>
                </p>
                <a href="catalogue.php" class="text-blue-500 hover:underline mt-4 inline-block">Voir tout le catalogue</a>
            </div>
        <?php endif; ?>

    </main>

    <?php require_once 'footer.php'; ?>
</body>
</html>