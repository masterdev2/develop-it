<?php
/* ─── Shared Footer — develop-it.tech ─────────────────────── */
$current  = $_SERVER['REQUEST_URI'] ?? '/';
$is_blog  = strpos($current, '/blog') !== false;
$base     = $is_blog ? '/' : '';
?>
<footer class="bg-black text-slate-400 py-10 sm:py-12" role="contentinfo">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 sm:gap-8 mb-6 sm:mb-8">
      <div class="col-span-2 md:col-span-1">
        <div class="flex items-center gap-2 mb-4">
          <img src="<?= $base ?>/logo.jfif" alt="DEVELOP IT" width="32" height="32" class="w-7 h-7 sm:w-8 sm:h-8 rounded-sm object-cover">
          <span class="text-white font-bold text-base sm:text-lg">DEVELOP IT</span>
        </div>
        <p class="text-xs sm:text-sm leading-relaxed">Agence de développement informatique et intelligence artificielle basée au Maroc.</p>
      </div>
      <div>
        <h4 class="text-white font-semibold mb-3 sm:mb-4 text-sm sm:text-base">Services</h4>
        <ul class="space-y-1 sm:space-y-2 text-xs sm:text-sm">
          <li><a href="<?= $base ?>/#about" class="hover:text-white transition">Développement Web</a></li>
          <li><a href="<?= $base ?>/#about" class="hover:text-white transition">Applications Mobile</a></li>
          <li><a href="<?= $base ?>/#about" class="hover:text-white transition">Intelligence Artificielle</a></li>
          <li><a href="<?= $base ?>/#about" class="hover:text-white transition">Cloud & DevOps</a></li>
        </ul>
      </div>
      <div>
        <h4 class="text-white font-semibold mb-3 sm:mb-4 text-sm sm:text-base">Solutions</h4>
        <ul class="space-y-1 sm:space-y-2 text-xs sm:text-sm">
          <li><a href="<?= $base ?>/ges_com.php"             class="hover:text-white transition">GESCOM ERP</a></li>
          <li><a href="<?= $base ?>/solution_pointage.php"   class="hover:text-white transition">HR Manager</a></li>
          <li><a href="<?= $base ?>/auto_post_ai.php"        class="hover:text-white transition">Auto-Post AI</a></li>
          <li><a href="<?= $base ?>/btp_manager.php"         class="hover:text-white transition">BTP Manager</a></li>
          <li><a href="<?= $base ?>/blog/"                   class="hover:text-white transition">Blog</a></li>
          <li><a href="<?= $base ?>/wandrly.php"              class="hover:text-white transition">Wandrly</a></li>
          <li><a href="<?= $base ?>/glowai.php"               class="hover:text-white transition">GlowAI</a></li>
        </ul>
      </div>
      <div>
        <h4 class="text-white font-semibold mb-3 sm:mb-4 text-sm sm:text-base">Suivez-nous</h4>
        <div class="flex gap-3 sm:gap-4">
          <a href="#" class="w-9 h-9 sm:w-10 sm:h-10 bg-slate-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition" aria-label="Facebook">
            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
          </a>
          <a href="#" class="w-9 h-9 sm:w-10 sm:h-10 bg-slate-800 rounded-full flex items-center justify-center hover:bg-blue-700 transition" aria-label="LinkedIn">
            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
          </a>
        </div>
        <div class="mt-4">
          <a href="<?= $base ?>/blog/" class="text-xs text-blue-400 hover:text-blue-300 transition">📝 Notre Blog →</a>
        </div>
      </div>
    </div>
    <div class="border-t border-slate-800 pt-6 sm:pt-8 text-center text-xs sm:text-sm">
      <p>© <?= date('Y') ?> <strong class="text-white">DEVELOP IT</strong> | Développement Informatique & Intelligence Artificielle | Tous droits réservés</p>
    </div>
  </div>
</footer>
