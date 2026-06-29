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
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="icon" href="image-favicon/favicon-master-gaming.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Gaming - Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/output.css">
    <meta name="description" content="Connectez-vous à votre compte Master Gaming pour accéder à votre bibliothèque de jeux, suivre vos commandes et profiter d'offres exclusives.">
</head>
<body class="bg-gray-900 text-white font-sans min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-gray-800 rounded-3xl shadow-2xl border border-white/10 p-8">

        <div class="text-center mb-10">
            <h1 class="text-3xl font-black uppercase italic tracking-tighter text-blue-500">Master Gaming</h1>
            <p class="text-gray-400 text-sm uppercase tracking-widest mt-2">Bon retour, soldat</p>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/50 rounded-xl">
                <?php foreach ($errors as $error): ?>
                    <p class="text-red-500 text-xs font-bold text-center">⚠️ <?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="?action=login" method="post" class="space-y-6">
            <div>
                <label class="block text-[10px] uppercase font-bold text-gray-500 ml-2 mb-1">Email</label>
                <input type="email" name="mail" placeholder="votre@email.com"
                    class="w-full bg-gray-700 border-none rounded-xl p-4 focus:ring-2 focus:ring-blue-500 outline-none transition-all placeholder:text-gray-500">
            </div>

            <div>
                <label class="block text-[10px] uppercase font-bold text-gray-500 ml-2 mb-1">Mot de passe</label>
                <input type="password" name="motDePasse" placeholder="••••••••"
                    class="w-full bg-gray-700 border-none rounded-xl p-4 focus:ring-2 focus:ring-blue-500 outline-none transition-all placeholder:text-gray-500">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-xl uppercase tracking-widest transition-all shadow-lg shadow-blue-900/40">
                Se connecter
            </button>
        </form>

        <div class="text-center mt-8 space-y-2">
            <p class="text-xs text-gray-500">
                Pas encore de compte ? <a href="?action=register" class="text-blue-500 hover:underline">Inscris-toi ici</a>
            </p>
            <p class="text-xs">
                <a href="?action=home" class="text-gray-600 hover:text-gray-400">Retour à l'accueil</a>
            </p>
        </div>
    </div>
</body>
</html>