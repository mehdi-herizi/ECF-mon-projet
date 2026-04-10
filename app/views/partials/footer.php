<footer class="w-full bg-transparent pt-20 pb-10">
    <button id="backToTop"
        class="fixed bottom-8 right-8 z-[9999] p-4 bg-blue-600/20 backdrop-blur-md border border-blue-500/50 text-blue-500 rounded-2xl shadow-[0_0_20px_rgba(37,99,235,0.3)] opacity-0 translate-y-10 invisible transition-all duration-500 hover:bg-blue-600 hover:text-white hover:shadow-[0_0_30px_rgba(37,99,235,0.6)] group"
        onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
        <svg class="w-6 h-6 transform group-hover:-translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7"></path>
        </svg>
    </button>

    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-[#0f172a] backdrop-blur-xl border border-white/10 rounded-[40px] p-8 md:p-12 shadow-2xl relative overflow-hidden">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-blue-600/20 blur-[100px] rounded-full"></div>

            <div class="max-w-7xl mx-auto px-4 pb-12">
                <div class="bg-black/80 backdrop-blur-xl border border-white/10 rounded-[40px] p-8 md:p-12 shadow-2xl relative overflow-hidden">
                    <div class="absolute -top-24 -right-24 w-64 h-64 bg-blue-600/10 blur-[100px] rounded-full"></div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-12 relative z-10">
                        <div class="col-span-1 md:col-span-1">
                            <img src="images/logo-master-gaming.png" alt="Master Gaming" class="h-10 mb-6">
                            <p class="text-gray-400 text-xs font-medium leading-relaxed italic">
                                La destination ultime pour les passionnés de gaming. Accédez aux meilleurs titres PC avec une expérience fluide et sécurisée.
                            </p>
                        </div>

                        <div>
                            <h4 class="text-white text-sm font-black uppercase italic mb-6 tracking-widest border-l-4 border-blue-600 pl-3">Navigation</h4>
                            <ul class="space-y-4">
                                <li><a href="?action=home" class="text-gray-400 text-xs hover:text-blue-500 transition-colors uppercase font-bold">Accueil</a></li>
                                <li><a href="?action=catalogue" class="text-gray-400 text-xs hover:text-blue-500 transition-colors uppercase font-bold">Catalogue</a></li>
                                <li><a href="?action=contact" class="text-gray-400 text-xs hover:text-blue-500 transition-colors uppercase font-bold">Assistance</a></li>
                            </ul>
                        </div>

                        <div>
                            <h4 class="text-white text-sm font-black uppercase italic mb-6 tracking-widest border-l-4 border-blue-600 pl-3">Légal</h4>
                            <ul class="space-y-4">
                                <li><a href="#" class="text-gray-400 text-xs hover:text-blue-500 transition-colors uppercase font-bold">Mentions Légales</a></li>
                                <li><a href="#" class="text-gray-400 text-xs hover:text-blue-500 transition-colors uppercase font-bold">CGV</a></li>
                                <li><a href="#" class="text-gray-400 text-xs hover:text-blue-500 transition-colors uppercase font-bold">Confidentialité</a></li>
                            </ul>
                        </div>

                        <div>
                            <h4 class="text-white text-sm font-black uppercase italic mb-6 tracking-widest border-l-4 border-blue-600 pl-3">Restez connecté</h4>
                            <div class="flex gap-4">
                                <a href="#" class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center hover:bg-blue-600 transition-all border border-white/5 font-bold text-white">X</a>
                                <a href="#" class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center hover:bg-blue-600 transition-all border border-white/5 font-bold text-white">IG</a>
                                <a href="#" class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center hover:bg-blue-600 transition-all border border-white/5 font-bold text-white">FB</a>
                            </div>
                        </div>
                    </div>

                    <div class="mt-16 pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-4 text-center md:text-left">
                        <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">
                            &copy; <?= date('Y') ?> Master Gaming. All rights reserved.
                        </p>
                        <div class="flex items-center gap-6">
                          <img src="https://cdn.jsdelivr.net/npm/payment-icons@1.1.0/min/flat/visa.svg" class="h-4 opacity-30 grayscale hover:grayscale-0 transition-all cursor-pointer">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" class="h-6 opacity-30 grayscale hover:grayscale-0 transition-all cursor-pointer">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" class="h-4 opacity-30 grayscale hover:grayscale-0 transition-all cursor-pointer">
                        </div>
                    </div>
                </div>
            </div>

            <script>
                const backToTopBtn = document.getElementById('backToTop');
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 400) {
                        backToTopBtn.classList.remove('opacity-0', 'translate-y-10', 'invisible');
                        backToTopBtn.classList.add('opacity-100', 'translate-y-0', 'visible');
                    } else {
                        backToTopBtn.classList.add('opacity-0', 'translate-y-10', 'invisible');
                        backToTopBtn.classList.remove('opacity-100', 'translate-y-0', 'visible');
                    }
                });
            </script>
        </div>
    </div>
</footer>