<?php require_once ROOT . 'app/views/partials/header.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Assistance - Master Gaming</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans min-h-screen flex flex-col">

    <main class="flex-grow flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-2xl bg-gray-800 rounded-3xl shadow-2xl border border-white/10 overflow-hidden relative">

            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-blue-500 to-transparent"></div>

            <form class="p-8 md:p-12 space-y-6" action="?action=contact" method="post">
                <div class="text-center mb-10">
                    <h2 class="text-4xl font-black uppercase italic tracking-tighter text-white">
                        Contactez le <span class="text-blue-500">Support</span>
                    </h2>
                    <p class="text-gray-400 text-sm mt-2 uppercase tracking-widest">Une question ? Une quête buggée ? On est là.</p>
                </div>

                <?php if ($success): ?>
                    <div class="bg-green-500/10 border border-green-500 text-green-500 p-4 rounded-xl text-center font-bold mb-6">
                        ✅ Votre message a été transmis à l'équipe technique !
                    </div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="bg-red-500/10 border border-red-500 text-red-500 p-4 rounded-xl text-center font-bold mb-6">
                        ❌ <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase font-bold text-gray-500 ml-2">Prénom</label>
                        <input name="firstname" type="text" required
                            class="w-full bg-gray-700 border-none rounded-2xl p-4 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase font-bold text-gray-500 ml-2">Nom</label>
                        <input name="name" type="text" required
                            class="w-full bg-gray-700 border-none rounded-2xl p-4 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase font-bold text-gray-500 ml-2">Email</label>
                        <input name="mail" type="email" required
                            class="w-full bg-gray-700 border-none rounded-2xl p-4 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase font-bold text-gray-500 ml-2">Téléphone (Optionnel)</label>
                        <input name="numero" type="tel"
                            class="w-full bg-gray-700 border-none rounded-2xl p-4 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] uppercase font-bold text-gray-500 ml-2">Votre Message</label>
                    <textarea name="Message" rows="5" required
                        class="w-full bg-gray-700 border-none rounded-2xl p-4 focus:ring-2 focus:ring-blue-500 outline-none transition-all resize-none"></textarea>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-5 rounded-2xl uppercase tracking-widest transition-all shadow-lg shadow-blue-900/40">
                    Envoyer le message
                </button>
            </form>
        </div>
    </main>

<?php require_once ROOT . 'app/views/partials/footer.php'; ?>
</body>
</html>