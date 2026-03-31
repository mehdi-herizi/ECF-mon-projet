<?php
require_once 'config.php';

// Sécurité : redirection si pas connecté
if (!isset($_SESSION['email'])) {
    header('Location: connexion.php');
    exit;
}

$success = false;
$error = null;
$id_user = $_SESSION['id_user'];

// 1. Récupération des informations fraîches de l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM pb_user WHERE id_user = ?");
$stmt->execute([$id_user]);
$user = $stmt->fetch();

// --- TRAITEMENT DU POST (Infos & Avatar) ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Maj Nom/Prénom
    if (isset($_POST['firstname'], $_POST['name'])) {
        $firstname = htmlspecialchars($_POST['firstname']);
        $name = htmlspecialchars($_POST['name']);
        $updateInfo = $pdo->prepare("UPDATE pb_user SET firstname = ?, name = ? WHERE id_user = ?");
        $updateInfo->execute([$firstname, $name, $id_user]);
        $user['firstname'] = $firstname;
        $user['name'] = $name;
        $success = "Informations mises à jour !";
    }

    // Maj Avatar
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $upload_dir = "uploads/avatars/";
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
            $new_name = "avatar_" . $id_user . "_" . time() . "." . $ext;
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $upload_dir . $new_name)) {
                $updatePic = $pdo->prepare("UPDATE pb_user SET profile_picture = ? WHERE id_user = ?");
                $updatePic->execute([$new_name, $id_user]);
                $_SESSION['profile_picture'] = $new_name;
                $user['profile_picture'] = $new_name;
                $success = "Photo de profil mise à jour !";
            }
        }
    }
}

// 2. Récupération de la Wishlist
$queryWish = $pdo->prepare("
    SELECT p.*, c.name_category 
    FROM wishlist w
    JOIN product p ON w.id_product = p.id_product
    LEFT JOIN category c ON p.id_category = c.id_category
    WHERE w.id_user = ?
    ORDER BY w.added_at DESC
");
$queryWish->execute([$id_user]);
$wishlistItems = $queryWish->fetchAll(PDO::FETCH_ASSOC);

// 3. Récupération des Commandes
$stmtCmd = $pdo->prepare("
    SELECT o.id_order, o.order_date, o.status, p.name, p.price, p.picture
    FROM pb_order o
    JOIN order_product op ON o.id_order = op.id_order
    JOIN product p ON op.id_product = p.id_product
    WHERE o.id_user = ?
    ORDER BY o.order_date DESC
");
$stmtCmd->execute([$id_user]);
$mesCommandes = $stmtCmd->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil - Master Gaming</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans min-h-screen">

    <?php require_once 'header.php'; ?>

    <main class="max-w-7xl mx-auto px-4 py-12 space-y-16">

        <section class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="space-y-6">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center text-3xl font-black italic shadow-lg shadow-blue-900/40">
                        <?= strtoupper(substr($user['firstname'], 0, 1)) ?>
                    </div>
                    <div>
                        <h2 class="text-3xl font-black uppercase italic tracking-tighter">Mon <span class="text-blue-500">Profil</span></h2>
                        <p class="text-gray-400 text-xs uppercase tracking-widest">Compte <?= htmlspecialchars($user['role']) ?></p>
                    </div>
                </div>
                <div class="bg-gray-800 p-6 rounded-3xl border border-white/10 shadow-xl">
                    <p class="text-gray-500 text-[10px] font-bold uppercase mb-1">Email</p>
                    <p class="text-sm font-bold text-gray-300 truncate mb-4"><?= htmlspecialchars($user['email']) ?></p>
                    <hr class="border-white/5 mb-4">
                    <a href="logout.php" class="text-red-400 text-[10px] font-black uppercase hover:text-red-300">Se déconnecter</a>
                </div>
            </div>

            <div class="lg:col-span-2 bg-gray-800 p-8 rounded-3xl border border-white/10 shadow-xl">
                <?php if ($success): ?>
                    <div class="mb-6 p-4 bg-green-500/10 border border-green-500 text-green-500 rounded-xl text-sm font-bold text-center">✅ <?= $success ?></div>
                <?php endif; ?>

                <form action="" method="post" enctype="multipart/form-data" class="space-y-6">
                    <div class="flex flex-col items-center sm:flex-row gap-8 mb-8">
                        <div class="relative group">
                            <?php $avatarPath = !empty($user['profile_picture']) ? 'uploads/avatars/' . $user['profile_picture'] : 'images/default-avatar.png'; ?>
                            <img src="<?= $avatarPath ?>" class="w-32 h-32 rounded-3xl object-cover border-4 border-blue-600 shadow-2xl shadow-blue-900/40">
                            <label for="avatar-upload" class="absolute inset-0 flex items-center justify-center bg-black/60 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer text-[10px] font-black uppercase text-white p-2 text-center">Changer</label>
                            <input type="file" id="avatar-upload" name="avatar" class="hidden" onchange="this.form.submit()">
                        </div>
                        <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                            <div>
                                <label class="text-[10px] uppercase font-bold text-gray-500 ml-2">Prénom</label>
                                <input name="firstname" type="text" value="<?= htmlspecialchars($user['firstname']) ?>" class="w-full bg-gray-700 border-none rounded-2xl p-4 text-white outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="text-[10px] uppercase font-bold text-gray-500 ml-2">Nom</label>
                                <input name="name" type="text" value="<?= htmlspecialchars($user['name']) ?>" class="w-full bg-gray-700 border-none rounded-2xl p-4 text-white outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl uppercase tracking-widest transition-all">Mettre à jour</button>
                </form>
            </div>
        </section>

        <section>
            <h2 class="text-3xl font-black uppercase italic tracking-tighter mb-8 border-l-4 border-pink-600 pl-4">
                Ma Liste de Souhaits <span class="text-pink-600">(<?= count($wishlistItems) ?>)</span>
            </h2>
            <?php if (empty($wishlistItems)): ?>
                <div class="bg-gray-800/50 p-12 rounded-[40px] text-center border border-white/5 italic text-gray-500">Votre liste est vide.</div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($wishlistItems as $item): ?>
                        <div class="bg-gray-800/80 rounded-[30px] overflow-hidden border border-white/10 transition-all hover:border-pink-500/50">
                            <img src="<?= $item['picture'] ?>" class="w-full h-40 object-cover">
                            <div class="p-6">
                                <h3 class="font-black uppercase truncate"><?= htmlspecialchars($item['name']) ?></h3>
                                <div class="flex justify-between items-center my-4">
                                    <span class="text-xl font-black"><?= number_format($item['price'], 2) ?>€</span>
                                    <a href="wishlist_action.php?id=<?= $item['id_product'] ?>" class="text-red-500 text-xs font-bold uppercase">Retirer</a>
                                </div>
                                <a href="panier_action.php?add=<?= $item['id_product'] ?>" class="block w-full bg-blue-600 text-center py-3 rounded-xl text-[10px] font-black uppercase">Acheter</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <section>
            <h2 class="text-3xl font-black uppercase italic tracking-tighter mb-8 border-l-4 border-blue-600 pl-4">Ma Bibliothèque</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach ($mesCommandes as $co): ?>
                    <div class="bg-gray-800 p-4 rounded-2xl border border-white/5 flex items-center gap-4 transition-all hover:bg-gray-700/50">
                        <img src="<?= $co['picture'] ?>" class="w-16 h-16 rounded-xl object-cover shadow-lg">
                        <div class="flex-1">
                            <p class="text-[10px] text-gray-500 font-bold uppercase"><?= date('d/m/Y', strtotime($co['order_date'])) ?></p>
                            <p class="text-white font-bold italic"><?= htmlspecialchars($co['name']) ?></p>
                        </div>
                        <div class="text-right">
                            <span class="text-[8px] bg-green-500/20 text-green-500 px-2 py-1 rounded-full uppercase"><?= $co['status'] ?></span>
                            <p class="text-blue-500 font-black text-sm mt-1">Acquis</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

    </main>

    <?php require_once 'footer.php'; ?>
</body>
</html>