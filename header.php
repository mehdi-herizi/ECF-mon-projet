<?php
// On s'assure que la session est démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="">

  
<header class="fixed top-4 left-1/2 -translate-x-1/2 w-[95%] max-w-5xl z-[9999]">
    <div class="bg-black/80 backdrop-blur-xl border border-white/10 px-6 py-2 rounded-full flex justify-between items-center shadow-2xl overflow-visible">
        
        <a href="index.php" class="flex-shrink-0">
            <img src="images/logo-master-gaming.png" alt="logo" class="h-8 md:h-10 w-auto hover:scale-105 transition-transform">
        </a>

        <nav class="hidden md:flex items-center gap-8">
            <a href="catalogue.php" class="text-[10px] font-black uppercase tracking-widest text-white hover:text-blue-500 transition-colors">Catalogue</a>
            <a href="contact.php" class="text-[10px] font-black uppercase tracking-widest text-white hover:text-blue-500 transition-colors">Assistance</a>
        </nav>

        <div class="flex items-center gap-4">
            
            <a href="panier.php" class="relative p-2 text-white hover:text-blue-500 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <?php if(!empty($_SESSION['panier'])): ?>
                    <span class="absolute -top-1 -right-1 bg-red-600 text-[9px] font-black w-5 h-5 flex items-center justify-center rounded-full border-2 border-black">
                        <?= count($_SESSION['panier']) ?>
                    </span>
                <?php endif; ?>
            </a>

            <?php if (isset($_SESSION['email'])): ?>
                <div class="relative group">
                    <button class="flex items-center gap-3 bg-white/5 p-1 pr-4 rounded-full border border-white/10 group-hover:border-blue-500 transition-all">
                        <?php 
                        // On vérifie le chemin de l'avatar
                        $headerAvatar = (!empty($_SESSION['profile_picture'])) ? 'uploads/avatars/' . $_SESSION['profile_picture'] : 'images/default-avatar.png'; 
                        ?>
                        <img src="<?= $headerAvatar ?>" class="w-8 h-8 rounded-full object-cover border border-blue-500 shadow-lg shadow-blue-500/20">
                        <span class="text-[10px] font-black uppercase text-white italic tracking-widest"><?= htmlspecialchars($_SESSION['firstname']) ?></span>
                        <span class="text-[8px] text-blue-500">▼</span>
                    </button>

                    <div class="absolute right-0 mt-2 w-56 bg-[#0f172a] border border-white/10 rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.5)] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-[10000] overflow-hidden">
                        
                        <div class="px-5 py-3 border-b border-white/5 bg-white/5 text-left">
                            <p class="text-[8px] text-gray-500 uppercase font-bold">Compte</p>
                            <p class="text-[10px] text-blue-400 font-black truncate"><?= htmlspecialchars($_SESSION['email']) ?></p>
                        </div>

                        <a href="profil.php" class="block px-5 py-4 text-[10px] font-black uppercase text-gray-300 hover:bg-blue-600 hover:text-white transition-all border-b border-white/5 text-left">
                            👤 Mon Profil
                        </a>
                        
                        <a href="settings.php" class="block px-5 py-4 text-[10px] font-black uppercase text-gray-300 hover:bg-blue-600 hover:text-white transition-all border-b border-white/5 text-left">
                            ⚙️ Paramètres
                        </a>

                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <a href="admin.php" class="block px-5 py-4 text-[10px] font-black uppercase text-yellow-500 hover:bg-yellow-600 hover:text-white transition-all border-b border-white/5 text-left">
                                🛠️ Dashboard Admin
                            </a>
                        <?php endif; ?>

                        <a href="logout.php" class="block px-5 py-4 text-[10px] font-black uppercase text-red-500 hover:bg-red-600 hover:text-white transition-all text-left">
                            🚀 Déconnexion
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <a href="connexion.php" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-full text-[10px] font-black uppercase tracking-widest transition-all shadow-lg shadow-blue-600/30">Login</a>
            <?php endif; ?>
        </div>
    </div>
</header>
<div class="h-28"></div>

</body>
</html>