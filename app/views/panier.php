

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="icon" href="image-favicon/favicon-master-gaming.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier - Master Gaming</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/output.css">
    <meta name="description" content="Découvrez votre panier sur Master Gaming. Vérifiez les jeux sélectionnés, le total de votre commande et procédez à l'achat en toute sécurité.">
</head>
<body class="bg-gray-900 text-white font-sans">
<?php require_once ROOT . 'app/views/partials/header.php'; ?>
<main class="max-w-6xl mx-auto px-4 py-24 min-h-screen bg-gray-900">
    <h2 class="text-4xl font-black uppercase italic tracking-tighter border-l-8 border-blue-600 pl-6 mb-12 text-white">
        Mon <span class="text-blue-500">Panier</span>
    </h2>

    <?php $total = 0; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <div class="lg:col-span-2 space-y-6">
            <?php if (!empty($_SESSION['panier'])): ?>
                <?php foreach ($_SESSION['panier'] as $id => $jeu):
                    $total += $jeu['price'];
                ?>
                    <div class="bg-white/5 backdrop-blur-md border border-white/10 p-6 rounded-[30px] flex items-center justify-between group hover:border-blue-500/50 transition-all duration-300 shadow-xl">
                        <div class="flex items-center gap-6">
                            <img src="<?= htmlspecialchars($jeu['picture']) ?>" class="w-24 h-24 object-cover rounded-2xl shadow-lg border-2 border-transparent group-hover:border-blue-500 transition-all">
                            <div>
                                <h3 class="text-xl font-black text-white uppercase italic tracking-wide"><?= htmlspecialchars($jeu['name']) ?></h3>
                                <p class="text-blue-500 font-black text-2xl mt-1"><?= number_format($jeu['price'], 2) ?> €</p>
                            </div>
                        </div>
                        <a href="?action=panier_remove&id=<?= $id ?>" class="bg-red-500/10 hover:bg-red-600 text-red-500 hover:text-white p-4 rounded-2xl transition-all duration-300 shadow-lg shadow-red-900/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="bg-white/5 border-2 border-dashed border-white/10 p-20 rounded-[40px] text-center">
                    <p class="text-gray-500 font-bold uppercase tracking-widest italic text-lg">Ton panier est vide</p>
                    <a href="?action=catalogue" class="inline-block mt-8 bg-blue-600 hover:bg-blue-700 px-10 py-4 rounded-full font-black uppercase text-xs tracking-widest text-white shadow-lg shadow-blue-600/30 transition-all transform hover:scale-105">
                        Découvrir les jeux
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-blue-600 p-8 rounded-[40px] shadow-2xl shadow-blue-900/50 sticky top-32 transform hover:-translate-y-1 transition-transform border border-white/20">
                <h3 class="text-2xl font-black text-white uppercase italic mb-6 tracking-tight">Résumé</h3>

                <div class="flex justify-between items-center mb-8 pb-6 border-b border-white/20">
                    <span class="text-white/80 font-bold uppercase text-xs tracking-widest">Total TTC</span>
                    <span class="text-4xl font-black text-white drop-shadow-md"><?= number_format($total, 2) ?> €</span>
                </div>

                <?php if (!empty($_SESSION['panier'])): ?>
                    <?php if (isset($_SESSION['id_user'])): ?>
                        <a href="?action=valider_commande" class="block text-center w-full bg-white text-blue-600 font-black py-5 rounded-2xl uppercase tracking-widest hover:bg-gray-100 transition-all shadow-xl transform active:scale-95">
                            Confirmer l'achat
                        </a>
                    <?php else: ?>
                        <a href="?action=login" class="block text-center w-full bg-gray-900 text-white font-black py-5 rounded-2xl uppercase tracking-widest hover:bg-black transition-all shadow-xl border border-white/10">
                            Se connecter
                        </a>
                    <?php endif; ?>
                <?php endif; ?>

                <p class="text-[10px] text-white/60 text-center mt-6 uppercase font-bold tracking-tighter italic">
                    Paiement 100% sécurisé via Master Gaming Cloud
                </p>
            </div>
        </div>
    </div>
</main>

<?php require_once ROOT . 'app/views/partials/footer.php'; ?>
</body>
</html>