<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="icon" href="image-favicon/favicon-master-gaming.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Gaming - Inscription</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/output.css">
    <meta name="description" content="Rejoignez Master Gaming aujourd'hui ! Inscrivez-vous pour accéder à des offres exclusives, suivre vos commandes et profiter de votre bibliothèque de jeux.">
</head>

<body class="bg-gray-900 text-white font-sans min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-gray-800 rounded-3xl shadow-2xl border border-white/10 p-8">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-black uppercase italic tracking-tighter text-blue-500">Master Gaming</h1>
            <p class="text-gray-400 text-sm uppercase tracking-widest mt-2">Rejoins la communauté</p>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/50 rounded-xl">
                <?php foreach ($errors as $error): ?>
                    <p class="text-red-500 text-xs font-bold">⚠️ <?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="?action=register" method="post" class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] uppercase font-bold text-gray-500 ml-2 mb-1">Nom</label>
                    <input name="name" type="text" placeholder="Geralt"
                        class="w-full bg-gray-700 border-none rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-[10px] uppercase font-bold text-gray-500 ml-2 mb-1">Prénom</label>
                    <input name="firstname" type="text" placeholder="De Riv"
                        class="w-full bg-gray-700 border-none rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
            </div>

            <div>
                <label class="block text-[10px] uppercase font-bold text-gray-500 ml-2 mb-1">Téléphone</label>
                <input name="telephone" type="tel" placeholder="06..."
                    class="w-full bg-gray-700 border-none rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div>
                <label class="block text-[10px] uppercase font-bold text-gray-500 ml-2 mb-1">Date de naissance</label>
                <input type="date" name="datedenaissance"
                    class="w-full bg-gray-700 border-none rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div>
                <label class="block text-[10px] uppercase font-bold text-gray-500 ml-2 mb-1">Email</label>
                <input type="email" name="mail" placeholder="gaming@master.com"
                    class="w-full bg-gray-700 border-none rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div>
                <label class="block text-[10px] uppercase font-bold text-gray-500 ml-2 mb-1">Mot de passe</label>
                <input type="password" name="motDePasse"
                    class="w-full bg-gray-700 border-none rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-[10px] uppercase font-bold text-gray-500 ml-2 mb-1">Confirmation</label>
                <input type="password" name="confirmationMotDePasse"
                    class="w-full bg-gray-700 border-none rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-xl uppercase tracking-widest transition-all shadow-lg shadow-blue-900/40 mt-6">
                S'inscrire
            </button>
        </form>
        <div>
            <p class="text-center text-xs text-gray-500 mt-6">
                Déjà membre ? <a href="?action=login" class="text-blue-500 hover:underline">Connecte-toi</a>
            </p>
            <p class="text-center text-xs mt-2">
                <a href="?action=home" class="text-gray-600 hover:text-gray-400">Retour à l'accueil</a>
            </p>
        </div>
    </div>
</body>

</html>