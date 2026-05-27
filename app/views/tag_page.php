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
$titreePage = $titreePage ?? '';
$tag        = $tag        ?? '';
$jeux       = $jeux       ?? [];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="icon" href="image-favicon/favicon-master-gaming.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Découvrez les jeux avec le tag <?= htmlspecialchars($tag) ?> sur Master Gaming.">
    <title><?= htmlspecialchars($titreePage) ?> - Master Gaming</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans min-h-screen">
<?php require_once ROOT . 'app/views/partials/header.php'; ?>
    <main class="max-w-7xl mx-auto px-4 py-12">

        <div class="flex items-center justify-between mb-12">
            <h1 class="text-4xl md:text-6xl font-black uppercase italic tracking-tighter border-l-8 border-blue-600 pl-6">
                <?= htmlspecialchars($titreePage) ?>
            </h1>
            <a href="?action=home" class="text-gray-500 hover:text-white text-xs font-black uppercase tracking-widest transition-colors">
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
                                <a href="?action=detail&id=<?= (int)$product['id_product'] ?>"
                                    class="bg-white text-black hover:bg-blue-600 hover:text-white px-4 py-2 rounded-xl font-black uppercase text-[10px] tracking-widest transition-all">
                                    Détails
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if ($totalPages > 1): ?>
                <div class="flex justify-center items-center gap-2 mt-16">
                    <?php if ($pageCourante > 1): ?>
                        <a href="?action=<?= $tag ?>&page=<?= $pageCourante - 1 ?>"
                            class="px-4 py-2 bg-gray-800 hover:bg-blue-600 rounded-xl font-black text-xs uppercase tracking-widest transition-all border border-white/10">
                            ← Précédent
                        </a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?action=<?= $tag ?>&page=<?= $i ?>"
                            class="w-10 h-10 flex items-center justify-center rounded-xl font-black text-xs transition-all border
                            <?= $i === $pageCourante ? 'bg-blue-600 border-blue-600 text-white' : 'bg-gray-800 border-white/10 text-gray-400 hover:bg-blue-600 hover:text-white hover:border-blue-600' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($pageCourante < $totalPages): ?>
                        <a href="?action=<?= $tag ?>&page=<?= $pageCourante + 1 ?>"
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
                <a href="?action=home" class="text-blue-500 hover:underline mt-4 inline-block text-sm">← Retour à l'accueil</a>
            </div>
        <?php endif; ?>

    </main>

<?php require_once ROOT . 'app/views/partials/footer.php'; ?>
</body>
</html>