<?php 

require 'config.php';

// Fonction réutilisable pour éviter de répéter le code SQL
function getGamesByTag($pdo, $tag) {
    $query = "SELECT p.*, c.name_category 
              FROM product p
              LEFT JOIN category c ON p.id_category = c.id_category 
              WHERE p.tag = :tag";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['tag' => $tag]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$jeuxTendance = getGamesByTag($pdo, 'trending');
$jeuxQuiVontSortir = getGamesByTag($pdo, 'coming_soon');
$nouveauxJeux = getGamesByTag($pdo, 'new');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="mon site sert a achete des jeux video ,c'est un e-commerce">
    <title>Master gaming</title>
    
<link rel="stylesheet" href="css/output.css">
<style>
  #menu-toggle:checked ~ label span:nth-child(1) {
    transform: translateY(10px) rotate(45deg);
}
#menu-toggle:checked ~ label span:nth-child(2) {
    opacity: 0;
}
#menu-toggle:checked ~ label span:nth-child(3) {
    transform: translateY(-10px) rotate(-45deg);
}
</style>
  </head>
  <body class="bg-[#09090b] text-white">
  <header class="relative w-full bg-black flex flex-col">
    <div class="relative w-full aspect-video md:h-[80vh]">
        <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop src="videos-header/elden-ring-header.mp4"></video>

        <div class="absolute inset-x-0 top-0 flex justify-between items-center p-3 md:p-8 bg-gradient-to-b from-black/90 to-transparent z-50">
            <div class="w-1/3 md:w-1/4">
                <a href="index.php">
                    <img src="images/logo-master-gaming.png" alt="logo" class="w-full max-w-[100px] md:max-w-[200px]">
                </a>
            </div>

            <div class="relative">
                <input type="checkbox" id="menu-toggle" class="peer hidden">
                <label for="menu-toggle" class="md:hidden flex flex-col gap-1 cursor-pointer z-[60] relative">
                    <span class="w-6 h-0.5 bg-white rounded-full transition-all"></span>
                    <span class="w-6 h-0.5 bg-white rounded-full transition-all"></span>
                    <span class="w-6 h-0.5 bg-white rounded-full transition-all"></span>
                </label>
                
                <nav class="fixed inset-0 h-screen w-full bg-black/98 backdrop-blur-2xl flex flex-col items-center justify-center gap-6 translate-x-full peer-checked:translate-x-0 transition-transform duration-300 md:static md:h-auto md:w-auto md:bg-transparent md:translate-x-0 md:flex-row md:gap-8 md:p-0 z-50">
                    
                    <a href="catalogue.php" class="text-white text-xl md:text-xs uppercase font-black tracking-widest hover:text-blue-500 transition">Catalogue</a>
                    <a href="contact.php" class="text-white text-xl md:text-xs uppercase font-black tracking-widest hover:text-blue-500 transition">Assistance</a>

                    <?php if (isset($_SESSION['id_user'])): ?>
                       <div class="relative group">
                            <button class="flex items-center gap-3 bg-white/5 p-1 pr-4 rounded-full border border-white/10 group-hover:border-blue-500 transition-all">
                                <?php
                                // On définit le chemin de l'image
                                $headerAvatar = (!empty($_SESSION['profile_picture'])) ? 'uploads/avatars/' . $_SESSION['profile_picture'] : 'images/default-avatar.png';
                                ?>
                                <img src="<?= $headerAvatar ?>?t=<?= time() ?>"
                                    class="w-8 h-8 rounded-full object-cover border border-blue-500"
                                    alt="Profil">

                                <span class="text-white text-[10px] font-black uppercase tracking-widest italic hidden md:inline">
                                    <?= htmlspecialchars($_SESSION['firstname'] ?? 'Profil') ?>
                                </span>
                            </button>
                        

                            <div class="absolute right-0 mt-2 w-48 bg-gray-900 border border-white/10 rounded-2xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 overflow-hidden">
                                <a href="profil.php" class="block px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-300 hover:bg-blue-600 hover:text-white transition">👤 Mon Profil</a>
                                <a href="settings.php" class="block px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-300 hover:bg-blue-600 hover:text-white transition border-t border-white/5">⚙️ Paramètres</a>
                                <?php if ($_SESSION['role'] === 'admin'): ?>
                                    <a href="admin_messages.php" class="block px-6 py-4 text-[10px] font-black uppercase tracking-widest text-blue-400 hover:bg-blue-600 hover:text-white transition border-t border-white/5">🛠️ Dashboard Admin</a>
                                <?php endif; ?>
                                <a href="logout.php" class="block px-6 py-4 text-[10px] font-black uppercase tracking-widest text-red-500 hover:bg-red-600 hover:text-white transition border-t border-white/5">🚀 Déconnexion</a>
                            </div>
                        </div>

                    <?php else: ?>
                        <div class="flex flex-col md:flex-row items-center gap-4">
                            <a href="connexion.php" class="text-white text-xl md:text-xs uppercase font-black tracking-widest hover:text-blue-500 transition">Connexion</a>
                            <a href="inscription.php" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-blue-900/40">S'inscrire</a>
                        </div>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </div>
      <div class="absolute bottom-10 right-12 z-20 max-w-[300px] bg-black/80 p-6 rounded-[30px] border border-white/10 backdrop-blur-md shadow-2xl">
    <h1 class="text-4xl font-black uppercase italic text-white tracking-tighter mb-4 leading-none">
        ELDEN RING
    </h1>
    <div class="flex flex-col gap-3">
        <span class="text-2xl font-black text-blue-500 italic">59.99€</span>
        <a href="detail.php?id=..." class="text-center px-5 py-2 border border-white/20 hover:border-blue-500 hover:bg-blue-600 rounded-full text-[10px] font-black uppercase tracking-widest text-white transition-all">
            En savoir plus
        </a>
    </div>
</div>
    </div>
    </header>
    <!-- pas fini -->
  <main id="contenent" class="p-4 md:p-12 space-y-32 bg-gray-900">
    <?php 
    $sections = [
        "Nos jeux les plus populaires" => $jeuxTendance ?? [],
        "Nos jeux à venir" => $jeuxQuiVontSortir ?? [],
        "Nouveaux jeux" => $nouveauxJeux ?? []
    ];

    foreach ($sections as $titre => $listeJeux): 
        if (empty($listeJeux) || !is_array($listeJeux)) continue; 
    ?>
       <section class="max-w-7xl mx-auto w-full">
            <h2 class="text-3xl md:text-5xl font-black text-right mb-12 text-white border-r-8 border-blue-600 pr-6 uppercase italic tracking-tighter">
                <?php echo $titre; ?>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 justify-items-center">
                <?php foreach ($listeJeux as $product): ?>
                    
                    <article class="w-full max-w-[600px] group">
    <a href="detail.php?id=<?php echo $product['id_product']; ?>" 
       class="relative block aspect-video overflow-hidden rounded-3xl bg-black shadow-2xl">
        
        <img src="<?php echo $product['picture']; ?>" 
             class="absolute inset-0 h-full w-full object-cover transition-all duration-700 group-hover:scale-110 group-hover:opacity-40">

        <div class="absolute inset-0 z-10 flex flex-col items-center justify-center p-6 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-center">
            
            <h3 class="text-xl md:text-2xl font-black text-white mb-2 uppercase tracking-widest">
                <?php echo $product['name']; ?>
            </h3>
            
            <div class="flex flex-wrap justify-center gap-2 text-white">
                <span class="bg-blue-600 px-3 py-1 rounded-full font-bold text-xs">
                    <?php echo $product['price']; ?>€
                </span>
                <span class="bg-white/20 backdrop-blur-md px-3 py-1 rounded-full text-[10px] uppercase">
                    <?php echo $product['name_category'] ?? 'Jeu'; ?>
                </span>
            </div>
        </div>
    </a>
</article>

                <?php endforeach; ?>
            </div>
        </section>
    <?php endforeach; ?>
</main>
    <?php 
   require_once 'footer.php';
   ?>
    <!-- <script src="js/index.js"></script> -->
  </body>
</html>
