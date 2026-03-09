<?php
require_once 'config.php';

// 1. Récupérer l'ID dans l'URL
$id_game = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_game <= 0) {
    header('Location: catalogue.php');
    exit;
}

// 2. Chercher les infos du jeu et sa catégorie
$query = "SELECT p.*, c.name_category 
          FROM product p 
          LEFT JOIN category c ON p.id_category = c.id_category 
          WHERE p.id_product = :id";
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $id_game]);
$game = $stmt->fetch(PDO::FETCH_ASSOC);

// Si le jeu n'existe pas
if (!$game) {
    die("Jeu introuvable.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($game['name']) ?> - Master Gaming</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans min-h-screen">

    <?php require_once 'header.php'; ?>

    <div class="relative h-[60vh] w-full overflow-hidden">
        <img src="<?= $game['picture'] ?>" class="absolute inset-0 w-full h-full object-cover blur-sm opacity-30 scale-110">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 h-full flex flex-col justify-end pb-12">
            <span class="bg-blue-600 self-start px-4 py-1 rounded-full text-xs font-black uppercase tracking-widest mb-4 shadow-lg shadow-blue-600/20">
                <?= htmlspecialchars($game['name_category'] ?? 'Action') ?>
            </span>
            <h1 class="text-5xl md:text-7xl font-black uppercase italic tracking-tighter mb-4 drop-shadow-2xl">
                <?= htmlspecialchars($game['name']) ?>
            </h1>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <div class="lg:col-span-2 space-y-8">
                <div class="aspect-video rounded-[40px] overflow-hidden border border-white/10 shadow-2xl">
                    <img src="<?= $game['picture'] ?>" class="w-full h-full object-cover">
                </div>
                
                <div class="bg-gray-800/50 p-8 rounded-[40px] border border-white/5 backdrop-blur-sm">
                    <h2 class="text-2xl font-black mb-6 text-blue-500 uppercase italic tracking-widest">À propos du jeu</h2>
                    <p class="text-gray-300 leading-relaxed italic text-lg">
                        <?= nl2br(htmlspecialchars($game['description'] ?? 'Aucune description disponible pour le moment.')) ?>
                    </p>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-gray-800/80 backdrop-blur-md p-8 rounded-[40px] border border-white/10 shadow-2xl sticky top-28">
                    <div class="flex justify-between items-center mb-8">
                        <span class="text-gray-500 font-bold uppercase text-[10px] tracking-widest">Prix Digital</span>
                        <span class="text-4xl font-black text-white"><?= number_format($game['price'], 2) ?>€</span>
                    </div>

                    <a href="panier_action.php?add=<?= $game['id_product'] ?>" 
                       class="block text-center w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-5 rounded-2xl uppercase tracking-widest transition-all shadow-lg shadow-blue-900/40 mb-4 transform hover:scale-105 active:scale-95">
                        Ajouter au panier
                    </a>
                    
                    <button class="w-full bg-white/5 hover:bg-white/10 text-white font-bold py-4 rounded-2xl uppercase text-[10px] tracking-widest transition-all border border-white/10">
                        Ajouter à la liste de souhaits
                    </button>

                    <div class="mt-8 pt-8 border-t border-white/5 space-y-4">
                        <div class="flex justify-between text-[10px] uppercase font-bold tracking-widest">
                            <span class="text-gray-500">Plateforme</span>
                            <span class="text-white italic">PC / Windows</span>
                        </div>
                        <div class="flex justify-between text-[10px] uppercase font-bold tracking-widest">
                            <span class="text-gray-500">Disponibilité</span>
                            <span class="text-green-400 italic">En Stock</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <?php require_once 'footer.php'; ?>
</body>
</html>