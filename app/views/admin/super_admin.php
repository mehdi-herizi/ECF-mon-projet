
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
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="icon" href="image-favicon/favicon-master-gaming.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Espace Super Admin de Master Gaming. Gérez les utilisateurs, modifiez les rôles et surveillez l'activité de votre communauté de gamers.">
    <title>Super Admin — Gestion Utilisateurs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/output.css">
</head>
<body class="bg-[#09090b] text-white font-sans min-h-screen">
<?php require_once ROOT . 'app/views/partials/header.php'; ?>
    <section class="p-4 md:p-12 min-h-screen">
        <div class="max-w-7xl mx-auto space-y-8">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-4xl font-black uppercase italic tracking-tighter border-l-8 border-purple-600 pl-6">Super Admin</h1>
                    <p class="text-gray-500 text-xs uppercase tracking-widest mt-2 pl-8">Gestion des utilisateurs</p>
                </div>
                <div class="flex gap-3">
                    <a href="?action=admin" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-full transition-all text-sm border border-white/10">
                        ← Panel Admin
                    </a>
                    <button onclick="document.getElementById('modal-add').classList.remove('hidden')"
                        class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-full transition-all shadow-lg shadow-purple-900/30 text-sm">
                        + Ajouter un utilisateur
                    </button>
                </div>
            </div>

            <?php
            $msg = $_GET['msg'] ?? null;
            if ($msg && isset($messages[$msg])): ?>
                <div class="bg-<?= $messages[$msg][1] ?>-500/10 border border-<?= $messages[$msg][1] ?>-500 text-<?= $messages[$msg][1] ?>-400 p-4 rounded-2xl font-bold text-sm">
                    <?= $messages[$msg][0] ?>
                </div>
            <?php endif; ?>

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

            <form method="get" class="flex items-center gap-2 bg-gray-800 border border-white/10 rounded-2xl px-4 py-3 shadow-xl focus-within:border-purple-500 transition-all max-w-xl">
                <input type="hidden" name="action" value="super_admin">
                <svg class="w-5 h-5 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
                </svg>
                <input type="text" name="q" value="<?= htmlspecialchars($recherche) ?>"
                    placeholder="Rechercher par nom, prénom ou email..."
                    class="flex-1 bg-transparent text-white placeholder-gray-500 outline-none font-bold text-sm">
                <?php if ($recherche !== ''): ?>
                    <a href="?action=super_admin" class="text-gray-500 hover:text-red-500 transition-colors text-xs font-black">✕</a>
                <?php endif; ?>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-xl font-black uppercase text-xs transition-all">
                    Rechercher
                </button>
            </form>

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
                            <?php foreach ($users as $user):
                                $isSelf = $user['id_user'] === $_SESSION['id_user'];
                                $roleColors = ['user' => 'blue', 'admin' => 'yellow', 'super_admin' => 'purple'];
                                $color  = $roleColors[$user['role']] ?? 'gray';
                                $avatar = !empty($user['profile_picture'])
                                    ? 'public/uploads/avatars/' . $user['profile_picture']
                                    : 'public/images/default-avatar.png';
                            ?>
                                <tr class="hover:bg-white/5 transition-colors <?= $isSelf ? 'bg-purple-900/10' : '' ?>">
                                    <td class="p-4">
                                        <img src="<?= htmlspecialchars($avatar) ?>" class="w-10 h-10 rounded-full object-cover border-2 border-<?= $color ?>-500/50">
                                    </td>
                                    <td class="p-4">
                                        <span class="text-sm font-bold text-white"><?= htmlspecialchars($user['firstname'] . ' ' . $user['name']) ?></span>
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
                                                <form action="?action=super_admin_action" method="POST" class="flex items-center gap-2">
                                                    <input type="hidden" name="action" value="change_role">
                                                    <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                                                    <select name="role" class="bg-gray-700 text-white text-xs font-bold rounded-xl px-3 py-2 border border-white/10 outline-none cursor-pointer">
                                                        <?php foreach (['user', 'admin', 'super_admin'] as $r): ?>
                                                            <option value="<?= $r ?>" <?= $user['role'] === $r ? 'selected' : '' ?> class="bg-gray-800">
                                                                <?= ucfirst(str_replace('_', ' ', $r)) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <button type="submit" class="p-2 bg-purple-500/10 text-purple-400 rounded-xl hover:bg-purple-500 hover:text-white transition-all">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                    </button>
                                                </form>
                                                <form action="?action=super_admin_action" method="POST" onsubmit="return confirm('Supprimer définitivement <?= htmlspecialchars(addslashes($user['firstname'] . ' ' . $user['name'])) ?> ?')">
                                                    <input type="hidden" name="action" value="delete_user">
                                                    <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                                                    <button type="submit" class="p-2 bg-red-500/10 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition-all">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
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
                                <tr><td colspan="5" class="p-12 text-center text-gray-500 italic">Aucun utilisateur trouvé.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Activité utilisateurs -->
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
                                <tr class="hover:bg-white/[0.02] transition-colors">
                                    <td class="p-4">
                                        <span class="text-sm font-bold text-white"><?= htmlspecialchars($user['firstname'] . ' ' . $user['name']) ?></span>
                                        <div class="text-[10px] text-gray-500 italic"><?= htmlspecialchars($user['email']) ?></div>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="bg-green-500/10 text-green-400 text-xs font-black px-3 py-1 rounded-full"><?= $user['total_achats'] ?></span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="bg-pink-500/10 text-pink-500 text-xs font-black px-3 py-1 rounded-full"><?= $user['total_likes'] ?> ❤️</span>
                                    </td>
                                    <td class="p-4 text-right">
                                        <a href="?action=super_admin_view_user&id=<?= $user['id_user'] ?>"
                                            class="bg-purple-600 hover:bg-purple-500 text-white text-[9px] font-black uppercase px-4 py-2 rounded-lg transition-all">
                                            Détails
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    </section>

    <!-- MODAL Ajouter utilisateur -->
    <div id="modal-add" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-gray-900 border border-white/10 rounded-3xl p-8 w-full max-w-lg shadow-2xl relative">
            <button onclick="document.getElementById('modal-add').classList.add('hidden')"
                class="absolute top-4 right-4 text-gray-500 hover:text-white text-xl font-black">✕</button>
            <h2 class="text-2xl font-black uppercase italic tracking-tighter mb-8 border-l-4 border-purple-600 pl-4">Nouvel utilisateur</h2>
            <form action="?action=super_admin_action" method="POST" class="space-y-3">
                <input type="hidden" name="action" value="add_user">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 block mb-1">Prénom *</label>
                        <input type="text" name="firstname" required class="w-full bg-gray-800/50 rounded-lg p-2.5 outline-none focus:ring-1 focus:ring-purple-500 text-white text-sm border border-white/5">
                    </div>
                    <div>
                        <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 block mb-1">Nom *</label>
                        <input type="text" name="name" required class="w-full bg-gray-800/50 rounded-lg p-2.5 outline-none focus:ring-1 focus:ring-purple-500 text-white text-sm border border-white/5">
                    </div>
                </div>
                <div>
                    <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 block mb-1">Email *</label>
                    <input type="email" name="email" required class="w-full bg-gray-800/50 rounded-lg p-2.5 outline-none focus:ring-1 focus:ring-purple-500 text-white text-sm border border-white/5">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 block mb-1">Naissance *</label>
                        <input type="date" name="birthdate" required class="w-full bg-gray-800/50 rounded-lg p-2.5 outline-none focus:ring-1 focus:ring-purple-500 text-white text-sm border border-white/5">
                    </div>
                    <div>
                        <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 block mb-1">Téléphone</label>
                        <input type="text" name="phone" class="w-full bg-gray-800/50 rounded-lg p-2.5 outline-none focus:ring-1 focus:ring-purple-500 text-white text-sm border border-white/5">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 block mb-1">Rôle</label>
                        <select name="role" class="w-full bg-gray-800/50 rounded-lg p-2.5 outline-none text-white text-sm border border-white/5 cursor-pointer">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                            <option value="super_admin">Super Admin</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 block mb-1">Mot de passe *</label>
                        <input type="password" name="password" required minlength="8" class="w-full bg-gray-800/50 rounded-lg p-2.5 outline-none focus:ring-1 focus:ring-purple-500 text-white text-sm border border-white/5">
                    </div>
                </div>
                <div class="flex gap-2 pt-2">
                    <button type="submit" class="flex-[2] bg-purple-600 hover:bg-purple-700 text-white font-black py-2.5 rounded-xl text-[10px] uppercase tracking-widest transition-all">Confirmer</button>
                    <button type="button" onclick="document.getElementById('modal-add').classList.add('hidden')"
                        class="flex-1 bg-gray-800 hover:bg-gray-700 text-white font-black py-2.5 rounded-xl text-[10px] uppercase tracking-widest transition-all border border-white/10">Fermer</button>
                </div>
            </form>
        </div>
    </div>

<?php require_once ROOT . 'app/views/partials/footer.php'; ?>
</body>
</html>