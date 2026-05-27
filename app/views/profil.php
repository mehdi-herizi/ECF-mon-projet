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
$user          = $user          ?? [];
$wishlistItems = $wishlistItems ?? [];
$mesCommandes  = $mesCommandes  ?? [];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="icon" href="image-favicon/favicon-master-gaming.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="description" content="Gérez votre profil sur Master Gaming. Modifiez vos informations personnelles et suivez vos commandes.">
    <title>Mon Profil - Master Gaming</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white font-sans min-h-screen">
<?php require_once ROOT . 'app/views/partials/header.php'; ?>
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
                    <a href="?action=logout" class="text-red-400 text-[10px] font-black uppercase hover:text-red-300">Se déconnecter</a>
                </div>
            </div>

            <div class="lg:col-span-2 bg-gray-800 p-8 rounded-3xl border border-white/10 shadow-xl">
                <?php if ($success): ?>
                    <div class="mb-6 p-4 bg-green-500/10 border border-green-500 text-green-500 rounded-xl text-sm font-bold text-center">✅ <?= $success ?></div>
                <?php endif; ?>

                <form action="?action=profil" method="post" enctype="multipart/form-data" class="space-y-6">
                    <div class="flex flex-col items-center sm:flex-row gap-8 mb-8">
                        <div class="relative group">
                            <?php $avatarPath = !empty($user['profile_picture'])
                                ? '/master-gaming/public/uploads/avatars/' . $user['profile_picture']
                                : '/master-gaming/public/images/default-avatar.png'; ?>
                            <img src="<?= $avatarPath ?>" class="w-32 h-32 rounded-3xl object-cover border-4 border-blue-600 shadow-2xl shadow-blue-900/40">
                            <label for="avatar-upload" class="absolute inset-0 flex items-center justify-center bg-black/60 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer text-[10px] font-black uppercase text-white p-2 text-center">Changer</label>
                            <input type="file" id="avatar-upload" name="avatar" class="hidden" onchange="this.form.submit()">
                        </div>
                        <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                            <div>
                                <label class="text-[10px] uppercase font-bold text-gray-500 ml-2">Prénom</label>
                                <input name="firstname" type="text" value="<?= htmlspecialchars($user['firstname']) ?>"
                                    class="w-full bg-gray-700 border-none rounded-2xl p-4 text-white outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="text-[10px] uppercase font-bold text-gray-500 ml-2">Nom</label>
                                <input name="name" type="text" value="<?= htmlspecialchars($user['name']) ?>"
                                    class="w-full bg-gray-700 border-none rounded-2xl p-4 text-white outline-none focus:ring-2 focus:ring-blue-500">
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
                            <img src="<?= htmlspecialchars($item['picture']) ?>" class="w-full h-40 object-cover">
                            <div class="p-6">
                                <h3 class="font-black uppercase truncate"><?= htmlspecialchars($item['name']) ?></h3>
                                <div class="flex justify-between items-center my-4">
                                    <span class="text-xl font-black"><?= number_format($item['price'], 2) ?>€</span>
                                    <a href="?action=wishlist_toggle&id=<?= $item['id_product'] ?>" class="text-red-500 text-xs font-bold uppercase">Retirer</a>
                                </div>
                                <a href="?action=panier_add&id=<?= $item['id_product'] ?>" class="block w-full bg-blue-600 text-center py-3 rounded-xl text-[10px] font-black uppercase">Acheter</a>
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
                    <div class="bg-gray-800 p-4 rounded-2xl border border-white/5 flex items-center gap-4 transition-all hover:hover:bg-gray-700/50">
                        <img src="<?= htmlspecialchars($co['picture']) ?>" class="w-16 h-16 rounded-xl object-cover shadow-lg">
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

    <?php require_once ROOT . 'app/views/partials/footer.php'; ?>
</body>

</html>