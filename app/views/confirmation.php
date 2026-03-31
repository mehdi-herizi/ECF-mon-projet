<?php
require_once 'config.php';

if (!isset($_SESSION['id_user'])) {
    header('Location: connexion.php');
    exit;
}

$id_order = isset($_GET['order']) ? (int)$_GET['order'] : 0;

if ($id_order <= 0) {
    header('Location: index.php');
    exit;
}

// Récupérer les jeux de la commande
$stmt = $pdo->prepare("
    SELECT p.name, p.price, p.picture
    FROM order_product op
    JOIN product p ON op.id_product = p.id_product
    WHERE op.id_order = ?
");
$stmt->execute([$id_order]);
$jeux = $stmt->fetchAll();

$total = array_sum(array_column($jeux, 'price'));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande confirmée - Master Gaming</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans min-h-screen">

    <?php require_once 'header.php'; ?>

    <main class="max-w-3xl mx-auto px-4 py-24 text-center">

        <div class="text-6xl mb-6">🎮</div>
        <h1 class="text-4xl font-black uppercase italic tracking-tighter mb-2">
            Commande <span class="text-blue-500">Confirmée !</span>
        </h1>
        <p class="text-gray-400 text-sm uppercase tracking-widest mb-12">
            Commande n°<?= $id_order ?> — Merci pour votre achat
        </p>

        <div class="bg-gray-800 rounded-[30px] border border-white/10 p-8 text-left space-y-4 mb-10">
            <?php foreach ($jeux as $jeu): ?>
                <div class="flex items-center justify-between gap-4 border-b border-white/5 pb-4 last:border-0 last:pb-0">
                    <div class="flex items-center gap-4">
                        <img src="<?= htmlspecialchars($jeu['picture']) ?>" class="w-14 h-14 rounded-xl object-cover">
                        <span class="font-black uppercase italic text-white"><?= htmlspecialchars($jeu['name']) ?></span>
                    </div>
                    <span class="text-blue-500 font-black text-lg"><?= number_format($jeu['price'], 2) ?>€</span>
                </div>
            <?php endforeach; ?>

            <div class="flex justify-between items-center pt-4 border-t border-white/10">
                <span class="text-gray-400 uppercase font-bold text-xs tracking-widest">Total payé</span>
                <span class="text-3xl font-black text-white"><?= number_format($total, 2) ?>€</span>
            </div>
        </div>

        <a href="catalogue.php" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-black px-10 py-4 rounded-full uppercase tracking-widest transition-all shadow-lg shadow-blue-900/40">
            Continuer mes achats
        </a>

    </main>

    <?php require_once 'footer.php'; ?>
</body>
</html>