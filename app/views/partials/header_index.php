<header class="relative w-full bg-black flex flex-col">
    <div class="relative w-full aspect-video md:h-[80vh]">
        <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop src="videos-header/elden-ring-header.mp4"></video>

        <div class="absolute inset-x-0 top-0 flex justify-between items-center p-3 md:p-8 bg-gradient-to-b from-black/90 to-transparent z-50">
            <div class="w-1/3 md:w-1/4">
                <a href="?action=home">
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

                <nav class="fixed inset-0 h-screen w-full bg-black backdrop-blur-2xl flex flex-col items-center justify-center gap-6 translate-x-full peer-checked:translate-x-0 transition-transform duration-300 md:static md:h-auto md:w-auto md:bg-transparent md:translate-x-0 md:flex-row md:gap-8 z-50">
                    <a href="?action=catalogue" class="text-white text-xl md:text-xs uppercase font-black tracking-widest hover:text-blue-500 transition">Catalogue</a>
                    <a href="?action=contact" class="text-white text-xl md:text-xs uppercase font-black tracking-widest hover:text-blue-500 transition">Assistance</a>

                    <?php if (isset($_SESSION['id_user'])): ?>
                        <a href="?action=profil" class="md:hidden text-white text-xl uppercase font-black tracking-widest">Mon Profil</a>
                        <a href="?action=settings" class="md:hidden text-white text-xl uppercase font-black tracking-widest">⚙️ Paramètres</a>
                        <?php if ($_SESSION['role'] === 'super_admin'): ?>
                            <a href="?action=super_admin" class="md:hidden text-purple-500 text-xl uppercase font-black tracking-widest">⚡ Super Admin</a>
                        <?php endif; ?>
                        <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'super_admin'): ?>
                            <a href="?action=admin" class="md:hidden text-purple-500 text-xl uppercase font-black tracking-widest">🛠️ Dashboard Admin</a>
                        <?php endif; ?>
                        <a href="?action=logout" class="md:hidden text-red-500 text-xl uppercase font-black tracking-widest">Déconnexion</a>

                        <div class="relative group hidden md:block">
                            <button class="flex items-center gap-3 bg-white/5 p-1 pr-4 rounded-full border border-white/10 group-hover:border-blue-500 transition-all">
                                <?php
                                $headerAvatar = !empty($_SESSION['profile_picture'])
                                    ? 'uploads/avatars/' . $_SESSION['profile_picture']
                                    : 'images/default-avatar.png';
                                ?>
                                <img src="<?= htmlspecialchars($headerAvatar) ?>" class="w-8 h-8 rounded-full object-cover border border-blue-500" alt="Profil">
                                <span class="text-white text-[10px] font-black uppercase tracking-widest italic hidden md:inline">
                                    <?= htmlspecialchars($_SESSION['firstname'] ?? 'Profil') ?>
                                </span>
                            </button>

                            <div class="absolute right-0 mt-2 w-56 bg-gray-900 border border-white/10 rounded-2xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 overflow-hidden z-[100]">
                                <a href="?action=profil" class="block px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-300 hover:bg-blue-600 hover:text-white transition">👤 Mon Profil</a>
                                <a href="?action=settings" class="block px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-300 hover:bg-blue-600 hover:text-white transition">⚙️ Paramètres</a>
                                <?php if ($_SESSION['role'] === 'super_admin'): ?>
                                    <a href="?action=super_admin" class="block px-6 py-4 text-[10px] font-black uppercase tracking-widest text-purple-400 bg-purple-500/5 hover:bg-purple-600 hover:text-white transition border-t border-white/5">⚡ Super Admin</a>
                                <?php endif; ?>
                                <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'super_admin'): ?>
                                    <a href="?action=admin" class="block px-6 py-4 text-[10px] font-black uppercase tracking-widest text-blue-400 hover:bg-blue-600 hover:text-white transition border-t border-white/5">🛠️ Dashboard Admin</a>
                                <?php endif; ?>
                                <a href="?action=logout" class="block px-6 py-4 text-[10px] font-black uppercase tracking-widest text-red-500 hover:bg-red-600 hover:text-white transition border-t border-white/5">🚀 Déconnexion</a>
                            </div>
                        </div>

                    <?php else: ?>
                        <div class="flex flex-col md:flex-row items-center gap-4">
                            <a href="?action=login" class="text-white text-xl md:text-xs uppercase font-black tracking-widest hover:text-blue-500 transition">Connexion</a>
                            <a href="?action=register" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full text-xs font-black uppercase tracking-widest transition-all">S'inscrire</a>
                        </div>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </div>

    <div class="relative md:absolute md:bottom-0 md:left-0 bg-black md:bg-black/70 p-4 md:p-10 text-center w-full md:w-auto md:min-w-[300px] border-t border-white/10 md:border-r backdrop-blur-md">
        <h1 class="text-lg md:text-5xl font-black text-white mb-2 md:mb-4 uppercase italic tracking-tighter">Elden Ring</h1>
        <div class="flex flex-row items-center justify-center gap-4">
            <p class="text-xl md:text-2xl font-bold text-blue-500">59.99€</p>
            <a href="?action=detail&id=47" class="rounded-full border border-white text-white px-4 py-1.5 hover:bg-white hover:text-black transition-all font-bold text-[10px] md:text-base uppercase tracking-widest">
                En savoir plus
            </a>
        </div>
    </div>
</header>