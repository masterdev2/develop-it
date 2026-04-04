<?php
/* ─── Shared Navigation — develop-it.tech ─────────────────── */
$current = $_SERVER['REQUEST_URI'] ?? '/';
$is_blog = strpos($current, '/blog') !== false;
$base    = $is_blog ? '/' : '';
?>
<nav class="fixed top-0 left-0 right-0 bg-white/95 backdrop-blur-sm shadow-md z-50"
     role="navigation" aria-label="Navigation principale">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 sm:py-4">
    <div class="flex items-center justify-between gap-3">
      <a href="<?= $base ?>/" class="flex items-center gap-2 sm:gap-3 min-w-0">
        <img src="<?= $base ?>/logo.jfif" alt="DEVELOP IT logo" width="40" height="40"
             class="w-8 h-8 sm:w-10 sm:h-10 rounded-sm object-cover flex-shrink-0">
        <span class="text-lg sm:text-2xl font-bold text-slate-800 truncate">DEVELOP IT</span>
      </a>
      <div class="hidden md:flex items-center gap-4 lg:gap-6">
        <a href="<?= $base ?>/#about"     class="text-slate-600 hover:text-blue-600 transition text-sm lg:text-base">À propos</a>
        <a href="<?= $base ?>/#solutions" class="text-slate-600 hover:text-blue-600 transition text-sm lg:text-base">Solutions</a>
        <a href="<?= $base ?>/blog/"      class="text-slate-600 hover:text-blue-600 transition text-sm lg:text-base <?= $is_blog ? 'text-blue-600 font-semibold' : '' ?>">Blog</a>
        <a href="<?= $base ?>/#faq"       class="text-slate-600 hover:text-blue-600 transition text-sm lg:text-base">FAQ</a>
        <a href="<?= $base ?>/#contact"   class="bg-blue-600 text-white px-4 lg:px-6 py-2 rounded-lg hover:bg-blue-700 transition text-sm">Contact</a>
      </div>
      <!-- Mobile hamburger -->
      <button id="nav-toggle" class="md:hidden p-2 rounded-lg hover:bg-slate-100 transition"
              aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="nav-mobile">
        <svg class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
    </div>
    <!-- Mobile menu -->
    <div id="nav-mobile" class="hidden md:hidden mt-3 pb-3 border-t border-slate-100 pt-3 space-y-1">
      <a href="<?= $base ?>/#about"     class="block px-3 py-2 rounded-lg text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition text-sm">À propos</a>
      <a href="<?= $base ?>/#solutions" class="block px-3 py-2 rounded-lg text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition text-sm">Solutions</a>
      <a href="<?= $base ?>/blog/"      class="block px-3 py-2 rounded-lg text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition text-sm">Blog</a>
      <a href="<?= $base ?>/#faq"       class="block px-3 py-2 rounded-lg text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition text-sm">FAQ</a>
      <a href="<?= $base ?>/#contact"   class="block px-3 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition text-sm text-center mt-2">Contact</a>
    </div>
  </div>
</nav>
<script>
(function(){
  var btn=document.getElementById('nav-toggle'),menu=document.getElementById('nav-mobile');
  if(!btn||!menu)return;
  btn.addEventListener('click',function(){
    var open=menu.classList.toggle('hidden');
    btn.setAttribute('aria-expanded', open?'false':'true');
  });
})();
</script>
