<?php
require_once 'config.php';

// Sécurité : Super Admin uniquement
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'super_admin') {
    header('Location: index.php');
    exit;
}

$id_user = $_GET['id'] ?? null;

if (!$id_user) {
    header('Location: super_admin.php');
    exit;
}

// 1. Récupérer les infos de l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM pb_user WHERE id_user = ?");
$stmt->execute([$id_user]);
$user = $stmt->fetch();

if (!$user) {
    header('Location: super_admin.php');
    exit;
}

// 2. Récupérer l'historique des commandes (Colonnes corrigées : p.name et o.order_date)
// 2. Récupérer l'historique des commandes avec calcul du prix total
$stmt = $pdo->prepare("
    SELECT 
        o.id_order, 
        o.order_date, 
        o.status,
        GROUP_CONCAT(p.name SEPARATOR ', ') as produits,
        SUM(p.price) as total_calcule
    FROM pb_order o
    JOIN order_product op ON o.id_order = op.id_order
    JOIN product p ON op.id_product = p.id_product
    WHERE o.id_user = ?
    GROUP BY o.id_order
    ORDER BY o.order_date DESC
");
$stmt->execute([$id_user]);
$orders = $stmt->fetchAll();
// 3. Récupérer la Wishlist (Colonnes corrigées : p.* utilise les noms réels)
$stmt = $pdo->prepare("
    SELECT p.* FROM wishlist w
    JOIN product p ON w.id_product = p.id_product
    WHERE w.id_user = ?
");
$stmt->execute([$id_user]);
$wishlist = $stmt->fetchAll();

$avatar = !empty($user['profile_picture']) ? 'uploads/avatars/' . $user['profile_picture'] : 'images/default-avatar.png';

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Détails Utilisateur — <?= htmlspecialchars($user['firstname']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#09090b] text-white min-h-screen">

    <?php require_once 'header.php'; ?>

    <main class="max-w-7xl mx-auto p-6 md:p-12 space-y-8">

        <a href="super_admin.php" class="inline-flex items-center text-gray-500 hover:text-purple-400 transition-colors font-bold text-sm uppercase tracking-widest">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M15 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Retour à la liste
        </a>

        <div class="bg-gray-900 border border-white/10 rounded-3xl p-8 flex flex-col md:flex-row items-center gap-8 shadow-2xl">
            <img src="<?= $avatar ?>" class="w-32 h-32 rounded-full object-cover border-4 border-purple-600/30 shadow-lg shadow-purple-500/10">
            <div class="flex-1 text-center md:text-left">
                <div class="flex flex-col md:flex-row items-center gap-3">
                    <h1 class="text-4xl font-black uppercase italic tracking-tighter"><?= htmlspecialchars($user['firstname'] . ' ' . $user['name']) ?></h1>
                    <span class="bg-purple-600/20 text-purple-400 px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border border-purple-600/30">
                        <?= strtoupper($user['role']) ?>
                    </span>
                </div>
                <p class="text-gray-500 mt-2 font-medium"><?= htmlspecialchars($user['email']) ?></p>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-6">
                    <div>
                        <p class="text-[10px] text-gray-500 uppercase tracking-widest">ID Utilisateur</p>
                        <p class="font-bold">#<?= $user['id_user'] ?></p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-500 uppercase tracking-widest">Téléphone</p>
                        <p class="font-bold"><?= htmlspecialchars($user['phone'] ?: 'Non renseigné') ?></p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-500 uppercase tracking-widest">Date de Naissance</p>
                        <p class="font-bold"><?= htmlspecialchars($user['birthdate']) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-8">

            <div class="bg-gray-900/50 border border-white/10 rounded-3xl overflow-hidden shadow-xl">
                <div class="p-6 border-b border-white/5 bg-white/5 flex justify-between items-center">
                    <h2 class="text-xl font-black uppercase italic tracking-tighter text-green-500">Historique Achats</h2>
                    <span class="text-[10px] font-bold text-gray-500 uppercase"><?= count($orders) ?> Commandes</span>
                </div>
                <div class="p-4 space-y-4">
                    <?php if (empty($orders)): ?>
                        <p class="p-8 text-center text-gray-500 italic text-sm">Aucun achat effectué.</p>
                    <?php else: ?>
                        <?php foreach ($orders as $order): ?>

                            <div class="bg-black/40 p-4 rounded-2xl border border-white/5">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-xs font-black text-white italic">CMD #<?= $order['id_order'] ?></span>
                                    <span class="text-[10px] text-gray-500"><?= date('d/m/Y', strtotime($order['order_date'])) ?></span>
                                </div>
                                <p class="text-sm text-gray-400 line-clamp-1"><?= htmlspecialchars($order['produits']) ?></p>
                                <p class="text-right text-green-400 font-black mt-2">
                                    <?= number_format($order['total_calcule'], 2) ?> €
                                </p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="bg-gray-900/50 border border-white/10 rounded-3xl overflow-hidden shadow-xl">
                <div class="p-6 border-b border-white/5 bg-white/5 flex justify-between items-center">
                    <h2 class="text-xl font-black uppercase italic tracking-tighter text-pink-500">Wishlist ❤️</h2>
                    <span class="text-[10px] font-bold text-gray-500 uppercase"><?= count($wishlist) ?> Favoris</span>
                </div>
                <div class="p-4 grid grid-cols-2 gap-3">
                    <?php if (empty($wishlist)): ?>
                        <p class="col-span-2 p-8 text-center text-gray-500 italic text-sm">La liste est vide.</p>
                    <?php else: ?>
                        <?php foreach ($wishlist as $item): ?>
                            <div class="bg-black/40 p-3 rounded-2xl border border-white/5 flex flex-col items-center text-center">
                                <img src="<?= htmlspecialchars($item['picture']) ?>"
                                    class="w-full h-20 object-cover rounded-xl mb-2"
                                    alt="<?= htmlspecialchars($item['name']) ?>">
                                <span class="text-[10px] font-bold text-white line-clamp-1"><?= htmlspecialchars($item['name']) ?></span>
                            </div>
                            
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

        </div>

    </main>
</body>

</html>