<?php
$solutions = [
    [
        'name'  => 'GESCOM ERP',
        'badge' => 'ERP',
        'desc'  => 'Gestion complète : comptabilité, stocks, CRM et BI.',
        'url'   => '/ges_com.php',
        'color' => 'from-teal-900 to-slate-900',
        'text'  => 'text-teal-300'
    ],
    [
        'name'  => 'HR Manager',
        'badge' => 'RH',
        'desc'  => 'Pointage GPS, congés et tableaux de bord RH.',
        'url'   => '/solution_pointage.php',
        'color' => 'from-blue-900 to-slate-900',
        'text'  => 'text-blue-300'
    ],
    [
        'name'  => 'Auto-Post AI Studio',
        'badge' => 'IA',
        'desc'  => 'Contenu IA généré et publié automatiquement.',
        'url'   => '/auto_post_ai.php',
        'color' => 'from-purple-900 to-blue-900',
        'text'  => 'text-purple-300'
    ],
    [
        'name'  => 'BTP Manager',
        'badge' => 'BTP',
        'desc'  => 'ERP sectoriel pour projets construction et immobilier.',
        'url'   => '/btp_manager.php',
        'color' => 'from-orange-900 to-slate-900',
        'text'  => 'text-orange-300'
    ],
    [
        'name'  => 'TrendDrop',
        'badge' => 'Dropshipping IA',
        'desc'  => 'Détecte les produits gagnants via Google Trends & TikTok.',
        'url'   => '/trenddrop.php',
        'color' => 'from-red-900 to-slate-900',
        'text'  => 'text-red-300'
    ],
    [
        'name'  => 'Malab Live',
        'badge' => 'Sports IA',
        'desc'  => 'Matchs en direct, pages arabes et publication Facebook auto.',
        'url'   => '/stream_agent.php',
        'color' => 'from-red-950 to-slate-900',
        'text'  => 'text-red-400'
    ],
    [
        'name'  => 'Strategic Architect',
        'badge' => 'IA Coach',
        'desc'  => 'Diagnostic 5 rounds + plan d\'action personnalisé 90 jours.',
        'url'   => '/strategic_architect.php',
        'color' => 'from-yellow-900 to-slate-900',
        'text'  => 'text-yellow-300'
    ],
    [
        'name'  => 'Repurzel',
        'badge' => 'Content IA',
        'desc'  => '1 contenu → 5 posts prêts pour toutes vos plateformes.',
        'url'   => '/repurzle.php',
        'color' => 'from-violet-900 to-slate-900',
        'text'  => 'text-violet-300'
    ],
    [
        'name'  => 'Lead Hunter',
        'badge' => 'Lead Gen IA',
        'desc'  => 'Scraping FB + scoring IA + alertes Telegram en temps réel.',
        'url'   => '/leads_generator.php',
        'color' => 'from-green-900 to-slate-900',
        'text'  => 'text-green-300'
    ],
    [
        'name'  => 'RecovPro',
        'badge' => 'FinTech IA',
        'desc'  => 'Réduisez vos impayés à moins de 5% grâce au scoring IA.',
        'url'   => '/recovpro.php',
        'color' => 'from-rose-900 to-slate-900',
        'text'  => 'text-rose-300'
    ],
    [
        'name'  => 'Wandrly',
        'badge' => 'IA Travel',
        'desc'  => 'Planificateur de voyages IA : itinéraires et budget optimisé.',
        'url'   => '/wandrly.php',
        'color' => 'from-sky-900 to-slate-900',
        'text'  => 'text-sky-300'
    ],
    [
        'name'  => 'GlowAI',
        'badge' => 'IA Beauty',
        'desc'  => 'Diagnostic beauté IA : analyse de peau et routines personnalisées.',
        'url'   => '/glowai.php',
        'color' => 'from-pink-900 to-slate-900',
        'text'  => 'text-pink-300'
    ],
];

// Pick 2 random solutions to feature prominently
$featured = array_splice($solutions, array_rand($solutions), 1);
shuffle($solutions);
$featured[] = $solutions[0];
?>

<aside class="space-y-6 sticky top-28">

  <!-- Featured promo cards (2 random) -->
  <?php foreach ($featured as $sol): ?>
  <div class="bg-gradient-to-br <?= $sol['color'] ?> rounded-2xl p-5 text-white">
    <span class="text-xs font-semibold uppercase tracking-wider <?= $sol['text'] ?>"><?= $sol['badge'] ?></span>
    <h4 class="text-lg font-bold mt-1 mb-2"><?= $sol['name'] ?></h4>
    <p class="text-slate-300 text-sm leading-relaxed mb-4"><?= $sol['desc'] ?></p>
    <a href="<?= $sol['url'] ?>"
       class="block text-center bg-white/10 hover:bg-white/20 border border-white/20 text-white font-semibold py-2 rounded-xl transition text-sm">
      Découvrir →
    </a>
  </div>
  <?php endforeach; ?>

  <!-- All solutions compact list -->
  <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm">
    <h4 class="font-bold text-slate-800 mb-4 text-sm uppercase tracking-wider">Toutes nos solutions</h4>
    <div class="space-y-2">
      <?php foreach ($solutions as $sol): ?>
      <a href="<?= $sol['url'] ?>"
         class="flex items-center justify-between group py-2 border-b border-slate-50 last:border-0">
        <div class="flex items-center gap-2">
          <span class="text-xs font-semibold px-2 py-0.5 rounded-md bg-slate-100 text-slate-500 group-hover:bg-blue-50 group-hover:text-blue-600 transition">
            <?= $sol['badge'] ?>
          </span>
          <span class="text-sm font-semibold text-slate-700 group-hover:text-blue-600 transition">
            <?= $sol['name'] ?>
          </span>
        </div>
        <svg class="w-3 h-3 text-slate-300 group-hover:text-blue-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
      </a>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Recent posts -->
  <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm">
    <h4 class="font-bold text-slate-800 mb-4 text-sm uppercase tracking-wider">Articles récents</h4>
    <div class="space-y-3">
      <?php
      $recent = $db->query("SELECT title, slug, created_at FROM blogs WHERE status='published' ORDER BY created_at DESC LIMIT 4");
      while ($r = $recent->fetch_assoc()):
      ?>
      <a href="/blog/post.php?slug=<?= urlencode($r['slug']) ?>" class="flex gap-3 group">
        <div class="w-1 rounded-full bg-slate-100 group-hover:bg-blue-500 transition flex-shrink-0"></div>
        <div>
          <p class="text-sm font-semibold text-slate-700 group-hover:text-blue-600 transition leading-snug">
            <?= htmlspecialchars($r['title']) ?>
          </p>
          <p class="text-xs text-slate-400 mt-0.5"><?= date('d M Y', strtotime($r['created_at'])) ?></p>
        </div>
      </a>
      <?php endwhile; ?>
    </div>
  </div>

  <!-- Contact CTA -->
  <div class="bg-blue-600 rounded-2xl p-5 text-white text-center">
    <div class="text-2xl mb-2">💬</div>
    <h4 class="font-bold mb-1">Un projet en tête ?</h4>
    <p class="text-blue-100 text-sm mb-4">Parlons de votre transformation digitale.</p>
    <a href="/#contact"
       class="block bg-white text-blue-600 font-semibold py-2 rounded-xl hover:bg-blue-50 transition text-sm">
      Nous contacter →
    </a>
  </div>

</aside>