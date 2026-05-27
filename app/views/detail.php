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
$game        = $game        ?? [];
$dejaAchete  = $dejaAchete  ?? false;
$dejaAuPanier = $dejaAuPanier ?? false;
$inWishlist  = $inWishlist  ?? false;
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="icon" href="image-favicon/favicon-master-gaming.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($game['description'] ?? 'Découvrez ce jeu vidéo exceptionnel sur Master Gaming.') ?>">
    <title><?= htmlspecialchars($game['name']) ?>jeu - Master Gaming</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans min-h-screen">
<?php require_once ROOT . 'app/views/partials/header.php'; ?>
    <div class="relative h-[60vh] w-full overflow-hidden">
        <img src="<?= htmlspecialchars($game['picture']) ?>" class="absolute inset-0 w-full h-full object-cover blur-sm opacity-30 scale-110">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent"></div>
        <div class="relative max-w-7xl mx-auto px-4 h-full flex flex-col justify-end pb-12">
            <span class="bg-blue-600 self-start px-4 py-1 rounded-full text-xs font-black uppercase tracking-widest mb-4 shadow-lg shadow-blue-600/20">
                <?= htmlspecialchars($game['name_category'] ?? 'Action') ?>
            </span>
            <h1 class="text-5xl md:text-7xl font-black uppercase italic tracking-tighter mb-4 drop-shadow-2xl">
                <?= htmlspecialchars($game['name']) ?>
            </h1>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

            <div class="lg:col-span-2 space-y-8">
                <div class="aspect-video rounded-[40px] overflow-hidden border border-white/10 shadow-2xl">
                    <?php if (!empty($game['video'])): ?>
                        <?php if (str_contains($game['video'], 'youtube.com') || str_contains($game['video'], 'youtu.be')): ?>
                            <?php
                            preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $game['video'], $matches);
                            $videoId = $matches[1] ?? '';
                            ?>
                            <?php if ($videoId): ?>
                                <iframe
                                    src="https://www.youtube.com/embed/<?= $videoId ?>?autoplay=1&mute=1&loop=1&playlist=<?= $videoId ?>"
                                    class="w-full h-full"
                                    frameborder="0"
                                    allow="autoplay; fullscreen"
                                    allowfullscreen>
                                </iframe>
                            <?php endif; ?>
                        <?php else: ?>
                            <video src="<?= htmlspecialchars($game['video']) ?>" class="w-full h-full object-cover" autoplay muted loop></video>
                        <?php endif; ?>
                    <?php else: ?>
                        <img src="<?= htmlspecialchars($game['picture']) ?>" class="w-full h-full object-cover">
                    <?php endif; ?>
                </div>

                <div class="bg-gray-800/50 p-8 rounded-[40px] border border-white/5 backdrop-blur-sm">
                    <h2 class="text-2xl font-black mb-6 text-blue-500 uppercase italic tracking-widest">À propos du jeu</h2>
                    <p class="text-gray-300 leading-relaxed italic text-lg">
                        <?= nl2br(htmlspecialchars($game['description'] ?? 'Aucune description disponible pour le moment.')) ?>
                    </p>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-gray-800/80 backdrop-blur-md p-8 rounded-[40px] border border-white/10 shadow-2xl sticky top-28">

                    <div class="flex justify-between items-center mb-8">
                        <span class="text-gray-500 font-bold uppercase text-[10px] tracking-widest">Prix Digital</span>
                        <span class="text-4xl font-black text-white"><?= number_format($game['price'], 2) ?>€</span>
                    </div>

                    <?php if ($dejaAchete): ?>
                        <div class="bg-gray-700 p-4 rounded-2xl text-center text-gray-400 font-bold text-sm mb-4">
                            🎮 Vous possédez déjà ce titre.
                        </div>
                    <?php elseif ($dejaAuPanier): ?>
                        <a href="?action=panier"
                            class="block text-center w-full bg-green-600 hover:bg-green-700 text-white font-black py-5 rounded-2xl uppercase tracking-widest transition-all shadow-lg mb-4">
                            ✅ Voir mon panier
                        </a>
                    <?php elseif (isset($_SESSION['id_user'])): ?>
                        <a href="?action=panier_add&id=<?= $game['id_product'] ?>"
                            class="block text-center w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-5 rounded-2xl uppercase tracking-widest transition-all shadow-lg transform hover:scale-105 mb-4">
                            Ajouter au panier
                        </a>
                    <?php else: ?>
                        <a href="?action=login"
                            class="block text-center w-full bg-gray-700 hover:bg-gray-600 text-white font-black py-5 rounded-2xl uppercase tracking-widest transition-all mb-4">
                            Se connecter pour acheter
                        </a>
                    <?php endif; ?>

                    <a href="?action=wishlist_toggle&id=<?= $game['id_product'] ?>"
                        class="block text-center w-full <?= $inWishlist ? 'bg-pink-600' : 'bg-white/5' ?> hover:bg-pink-500 text-white font-bold py-4 rounded-2xl uppercase text-[10px] tracking-widest transition-all border border-white/10">
                        <?= $inWishlist ? '❤️ Dans la liste de souhaits' : '🤍 Ajouter à la liste de souhaits' ?>
                    </a>

                    <div class="mt-8 pt-8 border-t border-white/5 space-y-4">
                        <div class="flex justify-between text-[10px] uppercase font-bold tracking-widest">
                            <span class="text-gray-500">Plateforme</span>
                            <span class="text-white italic">PC / Windows</span>
                        </div>
                        <div class="flex justify-between text-[10px] uppercase font-bold tracking-widest">
                            <span class="text-gray-500">Disponibilité</span>
                            <span class="text-green-400 italic">En Stock</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

<?php require_once ROOT . 'app/views/partials/footer.php'; ?>
</body>
</html>