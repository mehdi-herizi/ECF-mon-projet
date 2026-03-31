<?php
require_once 'config.php';

// --- CONFIG DE LA PAGE ---
$tag        = 'trending';
$titreePage = 'Jeux Tendance';
$couleur    = 'blue'; // pour personnaliser si besoin
// -------------------------

$parPage  = 12;
$pageCourante = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset   = ($pageCourante - 1) * $parPage;

// Total pour la pagination
$stmtTotal = $pdo->prepare("SELECT COUNT(*) FROM product WHERE tag = ?");
$stmtTotal->execute([$tag]);
$total      = $stmtTotal->fetchColumn();
$totalPages = ceil($total / $parPage);

// Jeux de la page courante
$stmt = $pdo->prepare("
    SELECT p.*,
           GROUP_CONCAT(c.name_category ORDER BY c.name_category SEPARATOR ', ') AS name_category
    FROM product p
    LEFT JOIN product_category pc ON p.id_product = pc.id_product
    LEFT JOIN category c ON pc.id_category = c.id_category
    WHERE p.tag = ?
    GROUP BY p.id_product
    LIMIT ? OFFSET ?
");
$stmt->bindValue(1, $tag,    PDO::PARAM_STR);
$stmt->bindValue(2, $parPage, PDO::PARAM_INT);
$stmt->bindValue(3, $offset,  PDO::PARAM_INT);
$stmt->execute();
$jeux = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titreePage ?> - Master Gaming</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans min-h-screen">

    <?php require_once 'header.php'; ?>

    <main class="max-w-7xl mx-auto px-4 py-12">

        <div class="flex items-center justify-between mb-12">
            <h1 class="text-4xl md:text-6xl font-black uppercase italic tracking-tighter border-l-8 border-blue-600 pl-6">
                <?= htmlspecialchars($titreePage) ?>
            </h1>
            <a href="index.php" class="text-gray-500 hover:text-white text-xs font-black uppercase tracking-widest transition-colors">
                ← Retour
            </a>
        </div>

        <?php if (!empty($jeux)): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                <?php foreach ($jeux as $product): ?>
                    <div class="group bg-gray-800 rounded-3xl overflow-hidden border border-white/5 hover:border-blue-500/50 transition-all duration-300 shadow-2xl flex flex-col">
                        <div class="relative aspect-[4/3] overflow-hidden">
                            <img src="<?= htmlspecialchars($product['picture']) ?>"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                 alt="<?= htmlspecialchars($product['name']) ?>">
                            <div class="absolute top-4 right-4">
                                <span class="bg-black/60 backdrop-blur-md text-blue-400 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border border-white/10">
                                    <?= htmlspecialchars($product['name_category'] ?? 'Jeu') ?>
                                </span>
                            </div>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-lg font-bold mb-2 group-hover:text-blue-500 transition-colors uppercase italic truncate">
                                <?= htmlspecialchars($product['name']) ?>
                            </h3>
                            <div class="mt-auto flex justify-between items-center pt-4">
                                <p class="text-2xl font-black text-white">
                                    <?= number_format($product['price'], 2) ?> <span class="text-blue-500 text-sm">€</span>
                                </p>
                                <a href="detail.php?id=<?= (int)$product['id_product'] ?>"
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
                        <a href="?page=<?= $pageCourante - 1 ?>"
                           class="px-4 py-2 bg-gray-800 hover:bg-blue-600 rounded-xl font-black text-xs uppercase tracking-widest transition-all border border-white/10">
                            ← Précédent
                        </a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i ?>"
                           class="w-10 h-10 flex items-center justify-center rounded-xl font-black text-xs transition-all border
                           <?= $i === $pageCourante
                               ? 'bg-blue-600 border-blue-600 text-white'
                               : 'bg-gray-800 border-white/10 text-gray-400 hover:bg-blue-600 hover:text-white hover:border-blue-600' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($pageCourante < $totalPages): ?>
                        <a href="?page=<?= $pageCourante + 1 ?>"
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
                <p class="text-gray-400 text-xl font-bold italic uppercase">Aucun jeu disponible pour le moment.</p>
                <a href="index.php" class="text-blue-500 hover:underline mt-4 inline-block text-sm">← Retour à l'accueil</a>
            </div>
        <?php endif; ?>

    </main>

    <?php require_once 'footer.php'; ?>
</body>
</html>