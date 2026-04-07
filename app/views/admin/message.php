<?php require_once ROOT . 'app/views/partials/header.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Messages Reçus</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans min-h-screen">

    <main class="max-w-6xl mx-auto px-4 py-12">
        <h2 class="text-4xl font-black uppercase italic tracking-tighter border-l-8 border-blue-600 pl-6 mb-12">
            Boîte de <span class="text-blue-500">Réception</span>
        </h2>

        <div class="space-y-6">
            <?php if (count($messages) > 0): ?>
                <?php foreach ($messages as $msg): ?>
                    <div class="bg-gray-800 rounded-3xl p-6 border border-white/10 shadow-xl hover:border-blue-500/50 transition-all">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 gap-4">
                            <div>
                                <h3 class="text-xl font-bold text-blue-400">
                                    <?= htmlspecialchars($msg['firstname']) ?> <?= htmlspecialchars($msg['name']) ?>
                                </h3>
                                <p class="text-gray-400 text-sm italic">
                                    <?= htmlspecialchars($msg['email']) ?> • <?= htmlspecialchars($msg['phone'] ?? 'Pas de numéro') ?>
                                </p>
                            </div>
                            <span class="bg-gray-700 text-gray-400 px-4 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest">
                                Reçu le <?= date('d/m/Y à H:i', strtotime($msg['created_at'])) ?>
                            </span>
                        </div>

                        <div class="bg-gray-900/50 rounded-2xl p-4 text-gray-300 leading-relaxed border border-white/5 mb-4">
                            <?= nl2br(htmlspecialchars($msg['message'])) ?>
                        </div>

                        <form method="post" action="?action=admin_messages" onsubmit="return confirm('Supprimer ce message ?');">
                            <input type="hidden" name="delete_id" value="<?= $msg['id_message'] ?>">
                            <button type="submit" class="text-red-500 hover:text-white border border-red-500 hover:bg-red-500 px-3 py-1 rounded-lg text-xs font-bold transition-all">
                                Supprimer
                            </button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center py-20 bg-gray-800 rounded-3xl border border-dashed border-white/10">
                    <p class="text-gray-500 uppercase font-bold italic">Aucun message pour le moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

<?php require_once ROOT . 'app/views/partials/footer.php'; ?>
</body>
</html>