<?php
require_once 'config.php';

// Accès réservé aux super_admin uniquement
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'super_admin') {
    header('Location: index.php');
    exit;
}

$query = "SELECT 
            u.id_user, 
            u.firstname, 
            u.name, -- Correction ici : 'name' au lieu de 'name_user'
            u.email,
            -- Compte des jeux achetés (via pb_order et order_product)
            (SELECT COUNT(DISTINCT op.id_product) 
             FROM pb_order o 
             JOIN order_product op ON o.id_order = op.id_order 
             WHERE o.id_user = u.id_user) as total_achats,
            -- Compte des jeux aimés (via wishlist)
            (SELECT COUNT(*) 
             FROM wishlist 
             WHERE id_user = u.id_user) as total_likes
          FROM pb_user u 
          WHERE u.role != 'super_admin'
          ORDER BY total_achats DESC";

$stmt = $pdo->prepare($query);
$stmt->execute();
$users_stats = $stmt->fetchAll(PDO::FETCH_ASSOC);


$stmt = $pdo->prepare("
    SELECT * FROM pb_user
    WHERE name_user LIKE ? OR firstname LIKE ? OR email LIKE ?
    ORDER BY id_user ASC
");

// Recherche utilisateurs
// --- CORRECTION RECHERCHE ---
$recherche = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($recherche !== '') {
    $stmt = $pdo->prepare("
        SELECT * FROM pb_user
        WHERE name LIKE ? OR firstname LIKE ? OR email LIKE ?
        ORDER BY id_user ASC
    ");
    $stmt->execute(['%' . $recherche . '%', '%' . $recherche . '%', '%' . $recherche . '%']);
} else {
    $stmt = $pdo->query("SELECT * FROM pb_user ORDER BY id_user ASC");
}
$users = $stmt->fetchAll();
$messages = [
    'role_updated'   => ['✅ Rôle mis à jour avec succès.',       'green'],
    'user_deleted'   => ['✅ Utilisateur supprimé.',               'green'],
    'user_added'     => ['✅ Utilisateur créé avec succès.',       'green'],
    'cannot_self'    => ['⚠️ Vous ne pouvez pas modifier votre propre compte.', 'yellow'],
    'email_exists'   => ['⚠️ Cet email est déjà utilisé.',        'yellow'],
    'missing_fields' => ['⚠️ Tous les champs obligatoires sont requis.', 'yellow'],
    'error'          => ['❌ Une erreur est survenue.',            'red'],
];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin — Gestion Utilisateurs</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#09090b] text-white font-sans min-h-screen">

    <?php require_once 'header.php'; ?>

    <section class="p-4 md:p-12 min-h-screen">
        <div class="max-w-7xl mx-auto space-y-8">

            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-4xl font-black uppercase italic tracking-tighter border-l-8 border-purple-600 pl-6">
                        Super Admin
                    </h1>
                    <p class="text-gray-500 text-xs uppercase tracking-widest mt-2 pl-8">Gestion des utilisateurs</p>
                </div>
                <div class="flex gap-3">
                    <a href="admin.php" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-full transition-all text-sm border border-white/10">
                        ← Panel Admin
                    </a>
                    <button onclick="document.getElementById('modal-add').classList.remove('hidden')"
                        class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-full transition-all shadow-lg shadow-purple-900/30 text-sm">
                        + Ajouter un utilisateur
                    </button>
                </div>
            </div>

            <!-- Notification -->
            <?php
            $msg = isset($_GET['msg']) ? $_GET['msg'] : null;
            if ($msg && isset($messages[$msg])):
            ?>
                <div class="bg-<?= $messages[$msg][1] ?>-500/10 border border-<?= $messages[$msg][1] ?>-500 text-<?= $messages[$msg][1] ?>-400 p-4 rounded-2xl font-bold text-sm">
                    <?= $messages[$msg][0] ?>
                </div>
            <?php endif; ?>

            <!-- Stats rapides -->
            <?php
            $stats = $pdo->query("SELECT role, COUNT(*) as nb FROM pb_user GROUP BY role")->fetchAll(PDO::FETCH_KEY_PAIR);
            $total = array_sum($stats);
            ?>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-gray-800/80 p-6 rounded-2xl border border-white/10 text-center">
                    <p class="text-3xl font-black text-white"><?= $total ?></p>
                    <p class="text-gray-500 text-[10px] uppercase tracking-widest mt-1">Total</p>
                </div>
                <div class="bg-gray-800/80 p-6 rounded-2xl border border-white/10 text-center">
                    <p class="text-3xl font-black text-blue-400"><?= $stats['user'] ?? 0 ?></p>
                    <p class="text-gray-500 text-[10px] uppercase tracking-widest mt-1">Users</p>
                </div>
                <div class="bg-gray-800/80 p-6 rounded-2xl border border-white/10 text-center">
                    <p class="text-3xl font-black text-yellow-400"><?= $stats['admin'] ?? 0 ?></p>
                    <p class="text-gray-500 text-[10px] uppercase tracking-widest mt-1">Admins</p>
                </div>
                <div class="bg-gray-800/80 p-6 rounded-2xl border border-white/10 text-center">
                    <p class="text-3xl font-black text-purple-400"><?= $stats['super_admin'] ?? 0 ?></p>
                    <p class="text-gray-500 text-[10px] uppercase tracking-widest mt-1">Super Admins</p>
                </div>
            </div>

            <!-- Barre de recherche -->
            <form method="get" class="flex items-center gap-2 bg-gray-800 border border-white/10 rounded-2xl px-4 py-3 shadow-xl focus-within:border-purple-500 transition-all max-w-xl">
                <svg class="w-5 h-5 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
                </svg>
                <input type="text" name="q"
                    value="<?= htmlspecialchars($recherche) ?>"
                    placeholder="Rechercher par nom, prénom ou email..."
                    class="flex-1 bg-transparent text-white placeholder-gray-500 outline-none font-bold text-sm">
                <?php if ($recherche !== ''): ?>
                    <a href="super_admin.php" class="text-gray-500 hover:text-red-500 transition-colors text-xs font-black">✕</a>
                <?php endif; ?>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-xl font-black uppercase text-xs transition-all">
                    Rechercher
                </button>
            </form>

            <!-- Tableau utilisateurs -->
            <div class="bg-gray-800 rounded-3xl overflow-hidden shadow-2xl border border-white/10">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-black/50 text-purple-400 uppercase text-xs tracking-widest">
                                <th class="p-5">Avatar</th>
                                <th class="p-5">Utilisateur</th>
                                <th class="p-5">Email</th>
                                <th class="p-5">Rôle</th>
                                <th class="p-5 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            <?php foreach ($users as $user): ?>
                                <?php
                                $isSelf   = $user['id_user'] === $_SESSION['id_user'];
                                $roleColors = [
                                    'user'        => 'blue',
                                    'admin'       => 'yellow',
                                    'super_admin' => 'purple',
                                ];
                                $color = $roleColors[$user['role']] ?? 'gray';
                                $avatar = !empty($user['profile_picture'])
                                    ? 'uploads/avatars/' . $user['profile_picture']
                                    : 'images/default-avatar.png';
                                ?>
                                <tr class="hover:bg-white/5 transition-colors <?= $isSelf ? 'bg-purple-900/10' : '' ?>">
                                    <td class="p-4">
                                        <img src="<?= htmlspecialchars($avatar) ?>"
                                            class="w-10 h-10 rounded-full object-cover border-2 border-<?= $color ?>-500/50"
                                            alt="Avatar">
                                    </td>
                                    <td class="p-4">
                                        <span class="text-sm font-bold text-white">
                                            <?= htmlspecialchars($user['firstname'] . ' ' . $user['name']) ?>
                                        </span>
                                        <div class="text-gray-500 text-xs">ID #<?= $user['id_user'] ?><?= $isSelf ? ' · <span class="text-purple-400">Vous</span>' : '' ?></div>
                                    </td>
                                    <td class="p-4 text-gray-300 text-sm"><?= htmlspecialchars($user['email']) ?></td>
                                    <td class="p-4">
                                        <span class="bg-<?= $color ?>-500/20 text-<?= $color ?>-300 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border border-<?= $color ?>-500/30">
                                            <?= str_replace('_', ' ', $user['role']) ?>
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex justify-center items-center gap-2">
                                            <?php if (!$isSelf): ?>
                                                <!-- Changer le rôle -->
                                                <form action="super_admin_action.php" method="POST" class="flex items-center gap-2">
                                                    <input type="hidden" name="action" value="change_role">
                                                    <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                                                    <select name="role"
                                                        class="bg-gray-700 text-white text-xs font-bold rounded-xl px-3 py-2 border border-white/10 outline-none focus:border-purple-500 cursor-pointer">
                                                        <?php foreach (['user', 'admin', 'super_admin'] as $r): ?>
                                                            <option value="<?= $r ?>" <?= $user['role'] === $r ? 'selected' : '' ?> class="bg-gray-800">
                                                                <?= ucfirst(str_replace('_', ' ', $r)) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <button type="submit"
                                                        class="p-2 bg-purple-500/10 text-purple-400 rounded-xl hover:bg-purple-500 hover:text-white transition-all"
                                                        title="Appliquer">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </button>
                                                </form>

                                                <!-- Supprimer -->
                                                <form action="super_admin_action.php" method="POST"
                                                    onsubmit="return confirm('Supprimer définitivement <?= htmlspecialchars(addslashes($user['firstname'] . ' ' . $user['name'])) ?> ?')">
                                                    <input type="hidden" name="action" value="delete_user">
                                                    <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                                                    <button type="submit"
                                                        class="p-2 bg-red-500/10 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition-all"
                                                        title="Supprimer">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-gray-600 text-xs italic">Votre compte</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <?php if (empty($users)): ?>
                                <tr>
                                    <td colspan="5" class="p-12 text-center text-gray-500 italic">Aucun utilisateur trouvé.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
    <section class="mt-12 bg-gray-900/50 rounded-3xl border border-white/5 overflow-hidden shadow-2xl">
        <div class="p-6 border-b border-white/5 bg-white/5 flex justify-between items-center">
            <h2 class="text-xl font-black uppercase italic tracking-tighter text-purple-500">Activité des Utilisateurs</h2>
            <span class="text-[10px] bg-purple-500/20 text-purple-400 px-3 py-1 rounded-full font-bold uppercase tracking-widest">Analytics</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-black/20">
                        <th class="p-4 text-[10px] font-black uppercase tracking-widest text-gray-500">Utilisateur</th>
                        <th class="p-4 text-[10px] font-black uppercase tracking-widest text-gray-500 text-center">Jeux Achetés</th>
                        <th class="p-4 text-[10px] font-black uppercase tracking-widest text-gray-500 text-center">Favoris ❤️</th>
                        <th class="p-4 text-[10px] font-black uppercase tracking-widest text-gray-500 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php foreach ($users_stats as $user): ?>
                        <tr class="hover:bg-white/[0.02] transition-colors group">
                            <td class="p-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-white">
                                       <?= htmlspecialchars($user['firstname'] . ' ' . $user['name']) ?>
                                    </span>
                                    <span class="text-[10px] text-gray-500 italic"><?= htmlspecialchars($user['email']) ?></span>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <div class="inline-flex items-center justify-center bg-green-500/10 px-3 py-1 rounded-full">
                                    <span class="text-xs font-black text-green-400"><?= $user['total_achats'] ?></span>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <div class="inline-flex items-center justify-center bg-pink-500/10 px-3 py-1 rounded-full">
                                    <span class="text-xs font-black text-pink-500"><?= $user['total_likes'] ?> ❤️</span>
                                </div>
                            </td>
                            <td class="p-4 text-right">
                                <a href="super_admin_view_user.php?id=<?= $user['id_user'] ?>"
                                    class="bg-purple-600 hover:bg-purple-500 text-white text-[9px] font-black uppercase px-4 py-2 rounded-lg transition-all shadow-lg shadow-purple-900/20">
                                    Détails
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <!-- MODAL : Ajouter un utilisateur -->
    <div id="modal-add" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-gray-900 border border-white/10 rounded-3xl p-8 w-full max-w-lg shadow-2xl relative">
            <button onclick="document.getElementById('modal-add').classList.add('hidden')"
                class="absolute top-4 right-4 text-gray-500 hover:text-white text-xl font-black">✕</button>

            <h2 class="text-2xl font-black uppercase italic tracking-tighter mb-8 border-l-4 border-purple-600 pl-4">
                Nouvel utilisateur
            </h2>

            <div class="mt-20 max-w-xl mx-auto p-4 bg-gray-900/50 rounded-3xl border border-white/5 shadow-2xl overflow-y-auto max-h-[90vh]">

                <div class="mb-4 text-center">
                    <h2 class="text-xl font-black uppercase italic tracking-tighter text-purple-500">Nouvel Utilisateur</h2>
                    <p class="text-[9px] text-gray-500 uppercase tracking-[0.2em]">Remplissez les champs obligatoires (*)</p>
                </div>

                <form action="super_admin_action.php" method="POST" class="space-y-3">
                    <input type="hidden" name="action" value="add_user">

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 block mb-1">Prénom *</label>
                            <input type="text" name="firstname" required
                                class="w-full bg-gray-800/50 rounded-lg p-2.5 outline-none focus:ring-1 focus:ring-purple-500 text-white text-sm border border-white/5">
                        </div>
                        <div>
                            <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 block mb-1">Nom *</label>
                            <input type="text" name="name" required
                                class="w-full bg-gray-800/50 rounded-lg p-2.5 outline-none focus:ring-1 focus:ring-purple-500 text-white text-sm border border-white/5">
                        </div>
                    </div>

                    <div>
                        <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 block mb-1">Email *</label>
                        <input type="email" name="email" required
                            class="w-full bg-gray-800/50 rounded-lg p-2.5 outline-none focus:ring-1 focus:ring-purple-500 text-white text-sm border border-white/5">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 block mb-1">Naissance *</label>
                            <input type="date" name="birthdate" required
                                class="w-full bg-gray-800/50 rounded-lg p-2.5 outline-none focus:ring-1 focus:ring-purple-500 text-white text-sm border border-white/5">
                        </div>
                        <div>
                            <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 block mb-1">Téléphone</label>
                            <input type="text" name="phone"
                                class="w-full bg-gray-800/50 rounded-lg p-2.5 outline-none focus:ring-1 focus:ring-purple-500 text-white text-sm border border-white/5">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 block mb-1">Rôle</label>
                            <select name="role" class="w-full bg-gray-800/50 rounded-lg p-2.5 outline-none focus:ring-1 focus:ring-purple-500 text-white text-sm border border-white/5 cursor-pointer">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                                <option value="super_admin">Super Admin</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 block mb-1">Mot de passe *</label>
                            <input type="password" name="password" required minlength="8"
                                class="w-full bg-gray-800/50 rounded-lg p-2.5 outline-none focus:ring-1 focus:ring-purple-500 text-white text-sm border border-white/5">
                        </div>
                    </div>

                    <div class="flex gap-2 pt-2">
                        <button type="submit"
                            class="flex-[2] bg-purple-600 hover:bg-purple-700 text-white font-black py-2.5 rounded-xl text-[10px] uppercase tracking-widest transition-all">
                            Confirmer
                        </button>
                        <button type="button" onclick="document.getElementById('modal-add').classList.add('hidden')"
                            class="flex-1 bg-gray-800 hover:bg-gray-700 text-white font-black py-2.5 rounded-xl text-[10px] uppercase tracking-widest transition-all border border-white/10">
                            Fermer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>