<?php
/* ═══════════════════════════════════════════════════════════
   DEVELOP IT — index.php  (futuristic AI agency design)
   ═══════════════════════════════════════════════════════════ */
$success_message = '';
$error_message   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_contact'])) {
    $name    = htmlspecialchars(strip_tags(trim($_POST['name']    ?? '')));
    $email   = filter_var(trim($_POST['email']   ?? ''), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(strip_tags(trim($_POST['subject'] ?? '')));
    $message = htmlspecialchars(strip_tags(trim($_POST['message'] ?? '')));
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error_message = 'Veuillez remplir tous les champs obligatoires.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Adresse email invalide.';
    } else {
        $to = 'contact@develop-it.tech';
        $subject_mail = '=?UTF-8?B?' . base64_encode('📩 Nouveau message - ' . $subject . ' | develop-it.tech') . '?=';
        $body  = "Nouveau message via develop-it.tech\n" . str_repeat('─',50) . "\n\n";
        $body .= "👤 Nom     : $name\n📧 Email   : $email\n📝 Sujet   : $subject\n\n💬 Message :\n$message\n\n";
        $body .= str_repeat('─',50) . "\nEnvoyé le : " . date('d/m/Y à H:i') . "\nIP : " . ($_SERVER['REMOTE_ADDR'] ?? 'N/A');
        $headers = "From: no-reply@develop-it.tech\r\nReply-To: $email\r\nX-Mailer: PHP/".phpversion()."\r\nContent-Type: text/plain; charset=UTF-8\r\n";
        if (mail($to, $subject_mail, $body, $headers)) {
            $success_message = 'Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.';
        } else {
            $error_message = "Une erreur est survenue. Veuillez réessayer ou nous contacter directement par email.";
        }
    }
}
$blogs = []; $featured = null;
try {
    require_once __DIR__ . '/config.php';
    $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (!$db->connect_error) {
        $db->set_charset('utf8mb4');
        $r = $db->query("SELECT id,title,slug,excerpt,cover_image,created_at FROM blogs WHERE status='published' ORDER BY created_at DESC LIMIT 5");
        $all = $r ? $r->fetch_all(MYSQLI_ASSOC) : [];
        $featured = array_shift($all); $blogs = $all;
    }
} catch(Exception $e){}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DEVELOP IT | Agence de Développement Informatique & IA | Transformation Digitale</title>
<meta name="description" content="DEVELOP IT - Agence de développement informatique avec plus de 10 ans d'expérience au Maroc. Transformation digitale, solutions web, mobiles et IA sur mesure.">
<meta name="keywords" content="develop-it, agence digitale maroc, développement informatique, intelligence artificielle, transformation digitale, ERP, automatisation IA">
<meta name="author" content="DEVELOP IT"><meta name="robots" content="index, follow">
<link rel="canonical" href="https://develop-it.tech">
<meta property="og:type" content="website"><meta property="og:url" content="https://develop-it.tech">
<meta property="og:title" content="DEVELOP IT | Agence Digitale & IA au Maroc">
<meta property="og:description" content="Agence marocaine de développement informatique avec +10 ans d'expérience.">
<meta property="og:image" content="https://develop-it.tech/logo.jfif">
<meta name="twitter:card" content="summary_large_image">
<link rel="icon" type="image/jpeg" href="/logo.jfif">
<link rel="apple-touch-icon" href="/logo.jfif">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500&display=swap" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500&display=swap"></noscript>
<script src="https://cdn.tailwindcss.com" defer></script>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-RRH1J9XH1W"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','G-RRH1J9XH1W');</script>
<script type="application/ld+json">
{"@context":"https://schema.org","@graph":[{"@type":"Organization","@id":"https://develop-it.tech/#organization","name":"DEVELOP IT","url":"https://develop-it.tech","logo":{"@type":"ImageObject","url":"https://develop-it.tech/logo.jfif"},"description":"Agence de développement informatique et intelligence artificielle au Maroc.","foundingDate":"2014","contactPoint":{"@type":"ContactPoint","telephone":"+212-06-11-19-19-26","contactType":"customer service","email":"contact@develop-it.tech"}},{"@type":"WebSite","url":"https://develop-it.tech","name":"DEVELOP IT","publisher":{"@id":"https://develop-it.tech/#organization"}}]}
</script>
<style>
*,::before,::after{box-sizing:border-box}
html,body{overflow-x:hidden;max-width:100vw;margin:0}
body{font-family:'Inter','Inter fallback',system-ui,sans-serif;background:#050510;color:#e2e8f0}
.font-mono{font-family:'JetBrains Mono',monospace}
html{scroll-behavior:smooth}
/* Prevent CLS from font swap */
@font-face{font-family:'Inter fallback';src:local('Arial');ascent-override:90%;descent-override:22%;line-gap-override:0%;size-adjust:107%}
/* Font fallback sizing to prevent CLS */
@font-face{font-family:'Inter fallback';src:local('Arial');ascent-override:90%;descent-override:22%;line-gap-override:0%;size-adjust:107%}

/* ── Futuristic core ── */
:root{--neon:#6366f1;--neon2:#06b6d4;--glow:rgba(99,102,241,.4);--dark:#050510;--card:#0a0a1a}
@keyframes gridMove{from{transform:translate3d(0,0,0)}to{transform:translate3d(72px,72px,0)}}
.grid-bg{background-image:linear-gradient(rgba(99,102,241,.06) 1px,transparent 1px),linear-gradient(90deg,rgba(99,102,241,.06) 1px,transparent 1px);background-size:72px 72px;animation:gridMove 8s linear infinite;will-change:transform}
@keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-12px)}}
@keyframes pulse-ring{0%{box-shadow:0 0 0 0 rgba(99,102,241,.5)}70%{box-shadow:0 0 0 12px rgba(99,102,241,0)}100%{box-shadow:0 0 0 0 rgba(99,102,241,0)}}
.card-glass{background:rgba(15,15,35,.6);backdrop-filter:blur(16px);border:1px solid rgba(99,102,241,.12);transition:transform .3s,box-shadow .3s,border-color .3s}
.card-glass:hover{border-color:rgba(99,102,241,.35);transform:translateY(-4px);box-shadow:0 20px 60px rgba(99,102,241,.1)}
.glow-text{background:linear-gradient(135deg,#818cf8,#06b6d4,#a78bfa);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.glow-border{border:1px solid rgba(99,102,241,.2);box-shadow:0 0 20px rgba(99,102,241,.08)}
.btn-neon{background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;transition:transform .2s,box-shadow .2s;box-shadow:0 4px 20px rgba(99,102,241,.3)}
.btn-neon:hover{box-shadow:0 8px 30px rgba(99,102,241,.5);transform:translateY(-2px)}
.btn-ghost{border:1px solid rgba(255,255,255,.15);color:#fff;transition:background-color .2s,border-color .2s}
.btn-ghost:hover{background:rgba(255,255,255,.05);border-color:rgba(99,102,241,.4)}
.eyebrow{font-family:'JetBrains Mono',monospace;font-size:11px;letter-spacing:.2em;text-transform:uppercase;color:#818cf8}
.section-dark{background:#050510}.section-darker{background:#030308}
.section-glass{background:linear-gradient(180deg,rgba(10,10,26,.95),rgba(5,5,16,.98))}

/* ── Scrollbar ── */
::-webkit-scrollbar{width:6px}::-webkit-scrollbar-track{background:#050510}
::-webkit-scrollbar-thumb{background:#6366f1;border-radius:3px}

/* ── Lang switcher ── */
.lang-switcher{display:flex;align-items:center;background:rgba(255,255,255,.08);border-radius:9999px;padding:3px;gap:2px}
.lang-btn{padding:6px 12px;border-radius:9999px;font-size:12px;font-weight:700;cursor:pointer;transition-property:background-color,color;transition-duration:.2s;border:none;background:transparent;color:#e2e8f0}
.lang-btn.active{background:#4f46e5;color:#fff;box-shadow:0 1px 8px rgba(79,70,229,.5)}
.lang-btn:hover:not(.active){color:#a5b4fc}

/* ── FAQ ── */
.faq-filter-btn{background:rgba(255,255,255,.04);color:#94a3b8;border:1px solid rgba(255,255,255,.08);transition:background-color .2s,color .2s,border-color .2s}
.faq-filter-btn.active{background:#6366f1;color:#fff;border-color:#6366f1}
.faq-filter-btn:hover:not(.active){border-color:#6366f1;color:#a5b4fc}
@keyframes slideDown{from{opacity:0;transform:translateY(-8px)}to{opacity:1;transform:translateY(0)}}
.faq-answer{animation:slideDown .3s ease-out}
.faq-item.active .faq-icon{transform:rotate(180deg)}

/* ── Mobile ── */
@media(max-width:767px){
  .nav-links{display:none!important}
  .hero-h1{font-size:2.5rem!important;line-height:1.15!important}
  .about-grid{grid-template-columns:repeat(2,1fr)!important}
  .services-grid{grid-template-columns:1fr!important}
  .contact-grid{grid-template-columns:1fr!important}
  .footer-grid{grid-template-columns:repeat(2,1fr)!important}
}
</style>
</head>
<body>

<!-- ── NAV ── -->
<nav class="fixed top-0 left-0 right-0 z-50 border-b border-white/5" style="background:rgba(5,5,16,.85);backdrop-filter:blur(20px)" role="navigation" aria-label="Navigation principale">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 sm:py-4">
    <div class="flex items-center justify-between gap-3">
      <a href="/" class="flex items-center gap-2 sm:gap-3 min-w-0">
        <img src="/logo.jfif" alt="DEVELOP IT logo" width="40" height="40" class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg object-cover flex-shrink-0 ring-1 ring-indigo-500/30">
        <span class="text-lg sm:text-xl font-bold text-white truncate">DEVELOP IT</span>
      </a>
      <div class="nav-links hidden md:flex items-center gap-5 lg:gap-7">
        <a href="#about"     class="text-slate-400 hover:text-white text-sm" data-i18n="nav_about">À propos</a>
        <a href="#solutions" class="text-slate-400 hover:text-white text-sm" data-i18n="nav_solutions">Solutions</a>
        <a href="blog/"      class="text-slate-400 hover:text-white text-sm" data-i18n="nav_blog">Blog</a>
        <a href="#faq"       class="text-slate-400 hover:text-white text-sm" data-i18n="nav_faq">FAQ</a>
        <a href="#contact"   class="btn-neon px-5 py-2 rounded-lg text-sm font-semibold" data-i18n="nav_contact">Contact</a>
      </div>
      <div class="lang-switcher">
        <button class="lang-btn active" onclick="setLang('fr',this)" aria-label="Français">🇫🇷 FR</button>
        <button class="lang-btn"        onclick="setLang('en',this)" aria-label="English">🇬🇧 EN</button>
      </div>
    </div>
  </div>
</nav>

<main id="main-content">

<!-- ── HERO ── -->
<section class="relative min-h-screen flex items-center pt-16 sm:pt-20 overflow-hidden section-dark" aria-label="Hero">
  <!-- Grid background -->
  <div class="absolute inset-0 grid-bg" aria-hidden="true"></div>
  <!-- Glow orbs -->
  <div class="absolute inset-0 overflow-hidden" aria-hidden="true">
    <div class="absolute top-1/4 left-1/4 w-[500px] h-[500px] rounded-full opacity-20" style="background:radial-gradient(circle,#6366f1,transparent 70%);filter:blur(80px)"></div>
    <div class="absolute bottom-1/4 right-1/4 w-[400px] h-[400px] rounded-full opacity-15" style="background:radial-gradient(circle,#06b6d4,transparent 70%);filter:blur(80px)"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full opacity-10" style="background:radial-gradient(circle,#8b5cf6,transparent 60%);filter:blur(100px)"></div>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 py-16 sm:py-28 relative z-10 w-full">
    <div class="max-w-4xl mx-auto text-center">
      <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs sm:text-sm mb-6 glow-border" style="background:rgba(99,102,241,.08)">
        <span class="relative flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span></span>
        <span class="text-indigo-300 font-mono text-xs tracking-wider" data-i18n="hero_badge">✨ Innovation & Excellence depuis 2014</span>
      </div>
      <h1 class="hero-h1 text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-black leading-[1.05] mb-6 tracking-tight">
        <span class="text-white" data-i18n="hero_h1_line">Votre partenaire en</span><br>
        <span class="glow-text" data-i18n="hero_h1_gradient">Transformation Digitale & IA</span>
      </h1>
      <p class="text-base sm:text-xl text-slate-400 leading-relaxed max-w-2xl mx-auto mb-8" data-i18n="hero_desc">
        Depuis plus de <strong class="text-indigo-300">10 ans</strong>, <strong class="text-indigo-300">DEVELOP IT</strong> accompagne les entreprises dans la conception de solutions informatiques innovantes, performantes et évolutives au Maroc et à l'international.
      </p>
      <div class="flex flex-wrap justify-center gap-4 mb-12">
        <a href="#contact" class="btn-neon px-7 sm:px-10 py-3.5 sm:py-4 rounded-xl font-semibold text-sm sm:text-base" data-i18n="hero_cta1">🚀 Démarrer un projet</a>
        <a href="#solutions" class="btn-ghost px-7 sm:px-10 py-3.5 sm:py-4 rounded-xl font-semibold text-sm sm:text-base" data-i18n="hero_cta2">Découvrir nos solutions</a>
      </div>
      <div class="flex justify-center gap-8 sm:gap-14">
        <div class="text-center"><div class="text-3xl sm:text-4xl font-black text-white">50+</div><div class="text-xs text-slate-500 font-mono uppercase tracking-wider mt-1" data-i18n="stat1">Projets réalisés</div></div>
        <div class="w-px bg-white/10"></div>
        <div class="text-center"><div class="text-3xl sm:text-4xl font-black text-white">98%</div><div class="text-xs text-slate-500 font-mono uppercase tracking-wider mt-1" data-i18n="stat2">Satisfaction client</div></div>
        <div class="w-px bg-white/10"></div>
        <div class="text-center"><div class="text-3xl sm:text-4xl font-black text-white">24/7</div><div class="text-xs text-slate-500 font-mono uppercase tracking-wider mt-1" data-i18n="stat3">Support disponible</div></div>
      </div>
    </div>
  </div>
  <div class="absolute bottom-6 left-1/2 -translate-x-1/2 animate-bounce w-6 h-6">
    <a href="#about" class="text-indigo-400 opacity-60 hover:opacity-100" aria-label="Défiler vers la section À propos">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
    </a>
  </div>
</section>

<!-- ── ABOUT ── -->
<section id="about" class="py-20 sm:py-28 section-darker">
  <div class="max-w-6xl mx-auto px-4 sm:px-6">
    <div class="text-center mb-14" data-aos="fade-up">
      <div class="eyebrow mb-4" data-i18n="about_label">Notre expertise</div>
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-6" data-i18n="about_title">DEVELOP IT: Une expertise solide, orientée résultats</h2>
      <p class="text-slate-400 text-base sm:text-lg max-w-3xl mx-auto leading-relaxed" data-i18n="about_desc">
        <strong class="text-indigo-400">DEVELOP IT</strong> est une agence de développement informatique spécialisée dans la création de solutions digitales sur mesure. Notre mission est d'aider les entreprises à réussir leur transformation digitale en intégrant les technologies modernes, y compris l'<strong class="text-indigo-400">Intelligence Artificielle</strong>.
      </p>
    </div>
    <div class="about-grid grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
      <div class="card-glass p-5 sm:p-7 rounded-2xl text-center" data-aos="fade-up">
        <div class="text-3xl sm:text-5xl font-black glow-text mb-2">10+</div>
        <h3 class="font-bold text-white text-sm sm:text-base mb-1" data-i18n="about_years">Années</h3>
        <p class="text-xs text-slate-500" data-i18n="about_experience">d'expérience dans le développement</p>
      </div>
      <div class="card-glass p-5 sm:p-7 rounded-2xl text-center" data-aos="fade-up" data-aos-delay="80">
        <div class="text-3xl sm:text-4xl mb-2">🌐</div>
        <h3 class="font-bold text-white text-sm sm:text-base mb-1" data-i18n="about_web_mobile">Web & Mobile</h3>
        <p class="text-xs text-slate-500" data-i18n="about_web_mobile_desc">Applications modernes et performantes</p>
      </div>
      <div class="card-glass p-5 sm:p-7 rounded-2xl text-center" data-aos="fade-up" data-aos-delay="160">
        <div class="text-3xl sm:text-4xl mb-2">🤖</div>
        <h3 class="font-bold text-white text-sm sm:text-base mb-1" data-i18n="about_ai_data">IA & Data</h3>
        <p class="text-xs text-slate-500" data-i18n="about_ai_data_desc">Automatisation intelligente</p>
      </div>
      <div class="card-glass p-5 sm:p-7 rounded-2xl text-center" data-aos="fade-up" data-aos-delay="240">
        <div class="text-3xl sm:text-4xl mb-2">⚡</div>
        <h3 class="font-bold text-white text-sm sm:text-base mb-1" data-i18n="about_custom">Sur mesure</h3>
        <p class="text-xs text-slate-500" data-i18n="about_custom_desc">Adapté à vos besoins spécifiques</p>
      </div>
    </div>
  </div>
</section>

<!-- ── SERVICES ── -->
<section class="py-20 sm:py-28 section-dark relative">
  <div class="absolute inset-0 grid-bg opacity-50" aria-hidden="true"></div>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
    <div class="text-center mb-14" data-aos="fade-up">
      <div class="eyebrow mb-4" data-i18n="services">Services</div>
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white" data-i18n="expertise">Nos domaines d'expertise</h2>
    </div>
    <div class="services-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
      <?php
      $svcs=[
        ['🌐','service_4_title','Développement Web','service_4_description','Applications PHP, Laravel, Node.js, React, Vue.js. Plateformes SaaS évolutives et performantes développées par DEVELOP IT.'],
        ['📱','service_5_title','Applications Mobile','service_5_description','Solutions Android & iOS natives et multiplateformes. Expériences utilisateur exceptionnelles.'],
        ['🤖','service_6_title','Intelligence Artificielle','service_6_description','Analyse de données, automatisation intelligente, machine learning, IA métier sur mesure.'],
        ['☁️','service_7_title','Cloud & DevOps','service_7_description','Déploiement, infrastructure cloud, CI/CD, monitoring, sécurité et optimisation des performances.'],
        ['🔐','service_8_title','Cybersécurité','service_8_description','Protection des données, audits de sécurité, conformité RGPD, tests d\'intrusion.'],
        ['📊','service_9_title','ERP & Logiciels métiers','service_9_description','Solutions internes sur mesure, digitalisation des processus, automatisation métier.'],
      ];
      foreach($svcs as $i=>$s): ?>
      <div class="card-glass p-6 sm:p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="<?=$i*60?>">
        <div class="text-3xl sm:text-4xl mb-4"><?=$s[0]?></div>
        <h3 class="text-lg sm:text-xl font-bold text-white mb-2" data-i18n="<?=$s[1]?>"><?=$s[2]?></h3>
        <p class="text-slate-400 text-sm leading-relaxed" data-i18n="<?=$s[3]?>"><?=$s[4]?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── SOLUTIONS IA ── -->
<section id="solutions" class="py-20 sm:py-28 section-darker relative">
  <div class="absolute inset-0 overflow-hidden" aria-hidden="true">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] rounded-full opacity-10" style="background:radial-gradient(ellipse,#6366f1,transparent 70%);filter:blur(80px)"></div>
  </div>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
    <div class="text-center mb-12" data-aos="fade-up">
      <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs mb-4 glow-border" style="background:rgba(99,102,241,.06)">
        <span class="relative flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span></span>
        <span class="text-indigo-300 font-mono text-xs tracking-wider" data-i18n="ai_section_badge">Propulsé par l'Intelligence Artificielle</span>
      </div>
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4" data-i18n="ai_solutions_title">Nos solutions IA</h2>
      <p class="text-slate-400 text-base sm:text-lg max-w-3xl mx-auto" data-i18n="ai_solutions_desc">Agents intelligents, automatisation et génération de contenu — l'IA au service de votre croissance</p>
    </div>
    <?php
    $ai_sols=[
      ['🤖','from-purple-600 to-pink-600','sol3_title','Auto-Post AI Studio','sol3_badge','IA','sol3_desc','Génération de contenu IA, publication multi-réseaux sociaux et planification intelligente.','auto_post_ai.php','sol3_cta','En savoir plus'],
      ['🔥','from-red-600 to-orange-600','trenddrop_title','TrendDrop','trenddrop_badge','IA Drop','trenddrop_desc','Détection produits gagnants via Google Trends & TikTok. Génération pubs, scripts vidéo et pages Shopify.','trenddrop.php','trenddrop_cta','Découvrir TrendDrop'],
      ['⚽','from-red-700 to-rose-600','malab_title','Malab Live','malab_badge','IA Sports','malab_desc','Agent IA qui collecte matchs, scrape les liens streaming et publie sur Facebook toutes les 15 min.','stream_agent.php','malab_cta','Découvrir Malab Live'],
      ['🧠','from-yellow-600 to-amber-600','sol_sa_title','Strategic Architect','sol_sa_badge','IA Coach','sol_sa_desc','Coach IA qui identifie vos blocages via diagnostic 5 rounds et construit un plan d\'action 90 jours.','strategic_architect.php','sol_sa_cta','Démarrer le diagnostic'],
      ['⚡','from-violet-600 to-indigo-600','repurzel_title','Repurzel','repurzel_badge','IA Creator','repurzel_desc','Transformez un contenu en 5 posts prêts pour Twitter, TikTok, Instagram, Email et LinkedIn.','repurzle.php','repurzel_cta','Découvrir Repurzel'],
      ['🎯','from-green-600 to-emerald-600','leadhunter_title','Lead Hunter','leadhunter_badge','Lead Gen IA','leadhunter_desc','Pipeline IA qui scrape Facebook, qualifie l\'intention d\'achat et livre les leads scorés sur Telegram.','leads_generator.php','leadhunter_cta','Découvrir Lead Hunter'],
      ['📊','from-rose-600 to-pink-600','recovpro_title','RecovPro','recovpro_badge','FinTech IA','recovpro_desc','Réduisez vos impayés de 25% à moins de 5% du CA grâce au scoring IA et relances automatiques.','recovpro.php','recovpro_cta','Découvrir RecovPro'],
      ['✈️','from-sky-600 to-cyan-600','wandrly_title','Wandrly','wandrly_badge','IA Travel','wandrly_desc','Planificateur de voyages IA : itinéraires personnalisés, budget optimisé, réservations et recommandations intelligentes.','wandrly.php','wandrly_cta','Découvrir Wandrly'],
      ['✨','from-pink-500 to-fuchsia-600','glowai_title','GlowAI','glowai_badge','IA Beauty','glowai_desc','Diagnostic beauté par IA : analyse de peau, routines personnalisées, recommandations produits et suivi des progrès.','glowai.php','glowai_cta','Découvrir GlowAI'],
    ];
    ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
      <?php foreach($ai_sols as $i=>$s): ?>
      <div class="card-glass rounded-2xl overflow-hidden" data-aos="fade-up" data-aos-delay="<?=$i*50?>">
        <div class="p-5 sm:p-6 flex flex-col gap-3">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br <?=$s[1]?> rounded-xl flex items-center justify-center text-lg flex-shrink-0 shadow-lg"><?=$s[0]?></div>
            <div>
              <h3 class="font-bold text-white text-sm sm:text-base" data-i18n="<?=$s[2]?>"><?=$s[3]?></h3>
              <span class="text-[10px] font-semibold text-indigo-400 uppercase tracking-wider font-mono" data-i18n="<?=$s[4]?>"><?=$s[5]?></span>
            </div>
          </div>
          <p class="text-slate-400 text-xs sm:text-sm leading-relaxed flex-1" data-i18n="<?=$s[6]?>"><?=$s[7]?></p>
          <a href="<?=$s[8]?>" class="inline-flex items-center gap-1 text-indigo-400 font-semibold text-xs hover:text-white hover:gap-2 transition-all" data-i18n="<?=$s[9]?>">
            <?=$s[10]?> <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
          </a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── SOLUTIONS MÉTIER ── -->
<section class="py-20 sm:py-28 section-dark">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">
    <div class="text-center mb-12" data-aos="fade-up">
      <div class="eyebrow mb-4" data-i18n="business_section_badge">Solutions Métier</div>
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4" data-i18n="business_solutions_title">ERP & logiciels de gestion</h2>
      <p class="text-slate-400 text-base sm:text-lg max-w-3xl mx-auto" data-i18n="business_solutions_desc">Des outils robustes pour piloter votre activité au quotidien</p>
    </div>
    <?php
    $biz_sols=[
      ['https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=400&q=50&fm=webp','sol1_title','GESCOM ERP','sol1_badge','ERP','sol1_desc','Solution ERP complète : comptabilité multi-devises, stocks, CRM, finances et Business Intelligence.','ges_com.php','sol1_cta','Découvrir la solution'],
      ['https://images.unsplash.com/photo-1553877522-43269d4ea984?w=400&q=50&fm=webp','sol2_title','HR Manager','sol2_badge','RH','sol2_desc','Pointage GPS et gestion RH : présence temps réel, congés, rapports et tableaux de bord analytiques.','solution_pointage.php','sol2_cta','Découvrir la solution'],
      ['https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=400&q=50&fm=webp','sol4_title','BTP Manager','sol4_badge','BTP','sol4_desc','ERP sectoriel BTP : gestion de projets, stocks, finances, personnel et comptabilité temps réel.','btp_manager.php','sol4_cta','Découvrir la solution'],
    ];
    ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
      <?php foreach($biz_sols as $i=>$s): ?>
      <div class="card-glass rounded-2xl overflow-hidden" data-aos="fade-up" data-aos-delay="<?=$i*80?>">
        <div class="relative"><img src="<?=$s[0]?>" loading="lazy" width="400" height="176" class="w-full h-40 object-cover opacity-60" alt="<?=htmlspecialchars($s[2])?>"><div class="absolute inset-0 bg-gradient-to-t from-[#0a0a1a] to-transparent"></div><span class="absolute top-3 right-3 text-[10px] font-semibold px-2.5 py-1 rounded-full bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 font-mono uppercase tracking-wider" data-i18n="<?=$s[3]?>"><?=$s[4]?></span><h3 class="absolute bottom-3 left-4 text-white font-bold text-sm" data-i18n="<?=$s[1]?>"><?=$s[2]?></h3></div>
        <div class="p-5 flex flex-col gap-2">
          <p class="text-slate-400 text-xs sm:text-sm leading-relaxed" data-i18n="<?=$s[5]?>"><?=$s[6]?></p>
          <a href="<?=$s[7]?>" class="inline-flex items-center gap-1 text-indigo-400 font-semibold text-xs hover:text-white hover:gap-2 transition-all" data-i18n="<?=$s[8]?>"><?=$s[9]?> →</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="mt-10 card-glass rounded-2xl p-8 sm:p-10 text-center" data-aos="fade-up">
      <div class="text-4xl mb-3">💡</div>
      <h3 class="text-lg font-bold text-white mb-2" data-i18n="sol5_title">Votre projet sur mesure</h3>
      <p class="text-slate-400 text-sm mb-5 max-w-md mx-auto" data-i18n="sol5_desc">Nous développons des solutions personnalisées adaptées à vos besoins spécifiques</p>
      <a href="#contact" class="btn-neon px-6 py-3 rounded-xl font-semibold text-sm inline-block" data-i18n="sol5_cta">Discutons de votre projet</a>
    </div>
  </div>
</section>

<!-- ── BLOG ── -->
<section class="py-20 sm:py-28 section-darker" id="blog">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">
    <div class="text-center mb-10" data-aos="fade-up">
      <div class="eyebrow mb-4">Blog</div>
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4">Actualités & Insights</h2>
      <p class="text-slate-400 text-base sm:text-lg max-w-2xl mx-auto">Tendances tech, IA et transformation digitale — par l'équipe DEVELOP IT</p>
    </div>
    <div class="grid md:grid-cols-3 gap-5" data-aos="fade-up" data-aos-delay="100">
      <?php if($featured): ?>
      <div class="md:col-span-2 card-glass rounded-2xl overflow-hidden flex flex-col">
        <div class="relative"><img src="<?=htmlspecialchars($featured['cover_image']?:'https://images.unsplash.com/photo-1677442135703-1787eea5ce01?w=800&q=60')?>" loading="lazy" width="800" height="256" class="w-full h-48 sm:h-64 object-cover opacity-70" alt="<?=htmlspecialchars($featured['title'])?>"><span class="absolute top-4 left-4 bg-indigo-600 text-white text-xs font-semibold px-3 py-1 rounded-full font-mono">À la une</span></div>
        <div class="p-5 sm:p-7 flex flex-col flex-1">
          <p class="text-xs text-slate-500 font-mono mb-2"><?=date('d M Y',strtotime($featured['created_at']))?></p>
          <h3 class="text-xl sm:text-2xl font-bold text-white mb-3 leading-tight"><?=htmlspecialchars($featured['title'])?></h3>
          <p class="text-slate-400 leading-relaxed flex-1 text-sm"><?=htmlspecialchars(mb_substr($featured['excerpt'],0,180))?>...</p>
          <a href="blog/post.php?slug=<?=urlencode($featured['slug'])?>" class="mt-4 inline-flex items-center gap-2 text-indigo-400 font-semibold text-sm hover:gap-3 transition-all">Lire l'article →</a>
        </div>
      </div>
      <?php endif; ?>
      <div class="flex flex-col gap-4">
        <?php foreach($blogs as $post): ?>
        <div class="card-glass rounded-xl flex gap-3 p-3 sm:p-4">
          <img src="<?=htmlspecialchars($post['cover_image']?:'https://images.unsplash.com/photo-1677442135703-1787eea5ce01?w=200&q=60')?>" loading="lazy" width="80" height="80" class="w-16 h-16 object-cover rounded-lg flex-shrink-0 opacity-70" alt="<?=htmlspecialchars($post['title'])?>">
          <div class="flex flex-col justify-center gap-1 min-w-0">
            <p class="text-[10px] text-slate-500 font-mono"><?=date('d M Y',strtotime($post['created_at']))?></p>
            <h4 class="font-bold text-xs text-white leading-snug line-clamp-2"><?=htmlspecialchars($post['title'])?></h4>
            <a href="blog/post.php?slug=<?=urlencode($post['slug'])?>" class="text-indigo-400 text-xs font-semibold hover:underline">Lire →</a>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="text-center mt-8" data-aos="fade-up">
      <a href="blog/" class="btn-ghost px-7 py-3 rounded-xl font-semibold text-sm inline-flex items-center gap-2">Voir tous les articles →</a>
    </div>
  </div>
</section>

<?php if (defined('ADSENSE_CLIENT_ID') && ADSENSE_CLIENT_ID && defined('ADSENSE_SLOT_HOME') && ADSENSE_SLOT_HOME): ?>
<!-- AdSense — homepage mid-page -->
<div class="bg-white py-4 px-4">
    <div class="max-w-7xl mx-auto">
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="<?= htmlspecialchars(ADSENSE_CLIENT_ID) ?>"
             data-ad-slot="<?= htmlspecialchars(ADSENSE_SLOT_HOME) ?>"
             data-ad-format="auto"
             data-full-width-responsive="true"></ins>
        <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    </div>
</div>
<?php endif; ?>

<!-- ── TECH STACK ── -->
<section class="py-20 sm:py-28 section-dark relative">
  <div class="absolute inset-0 grid-bg opacity-30" aria-hidden="true"></div>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
    <div class="text-center mb-12" data-aos="fade-up">
      <div class="eyebrow mb-4" data-i18n="tech_label">Stack Technologique</div>
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white" data-i18n="tech_title">Technologies maîtrisées par DEVELOP IT</h2>
    </div>
    <div class="grid grid-cols-3 md:grid-cols-6 gap-4 sm:gap-6">
      <?php foreach([['⚛️','React','react'],['📱','Node.js','nodejs'],['🐘','PHP/Laravel','php'],['🐍','Python','python'],['🎯','TypeScript','typescript'],['☁️','AWS/Azure','aws']] as $i=>$t): ?>
      <div class="card-glass flex flex-col items-center gap-2 p-4 sm:p-6 rounded-xl text-center" data-aos="zoom-in" data-aos-delay="<?=$i*60?>">
        <div class="text-2xl sm:text-3xl"><?=$t[0]?></div>
        <span class="font-semibold text-xs sm:text-sm text-white" data-i18n="<?=$t[2]?>"><?=$t[1]?></span>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── TESTIMONIALS ── -->
<section class="py-20 sm:py-28 section-darker">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">
    <div class="text-center mb-12" data-aos="fade-up">
      <div class="eyebrow mb-4" data-i18n="testi_label">Témoignages</div>
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white" data-i18n="testi_title">Ce que disent nos clients de DEVELOP IT</h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
      <?php
      $ts=[
        ['AM','testi1_name','Ahmed M.','testi1_title','CEO, TechStart','testi1_text','"Une équipe exceptionnelle qui a transformé notre vision en réalité. Le projet a été livré dans les temps avec une qualité irréprochable."'],
        ['SK','testi2_name','Sarah K.','testi2_title','Directrice Marketing','testi2_text','"Professionnalisme et expertise technique au rendez-vous. Notre application mobile a dépassé toutes nos attentes."'],
        ['YB','testi3_name','Youssef B.','testi3_title','COO, InnovCorp','testi3_text','"L\'intégration de l\'IA dans nos processus a révolutionné notre productivité. Un investissement qui en valait vraiment la peine."'],
      ];
      foreach($ts as $i=>$t): ?>
      <div class="card-glass p-6 sm:p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="<?=$i*100?>">
        <div class="flex gap-1 mb-4 text-sm">⭐⭐⭐⭐⭐</div>
        <p class="text-slate-300 mb-5 italic leading-relaxed text-sm" data-i18n="<?=$t[5]?>"><?=$t[6]?></p>
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 bg-indigo-500/20 rounded-full flex items-center justify-center text-indigo-400 font-bold text-xs ring-1 ring-indigo-500/30"><?=$t[0]?></div>
          <div>
            <div class="font-semibold text-white text-sm" data-i18n="<?=$t[1]?>"><?=$t[2]?></div>
            <div class="text-xs text-slate-500" data-i18n="<?=$t[3]?>"><?=$t[4]?></div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── FAQ ── -->
<section id="faq" class="py-20 sm:py-28 section-dark">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">
    <div class="text-center mb-12" data-aos="fade-up">
      <div class="eyebrow mb-4" data-i18n="faq_label">FAQ</div>
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4" data-i18n="faq_title">Questions fréquemment posées</h2>
      <p class="text-slate-400 text-base sm:text-lg max-w-3xl mx-auto" data-i18n="faq_desc">Trouvez rapidement les réponses aux questions les plus courantes sur DEVELOP IT</p>
    </div>
    <div class="flex flex-wrap justify-center gap-2 mb-10" data-aos="fade-up">
      <button onclick="filterFAQ('all',event)"         class="faq-filter-btn active px-4 sm:px-5 py-2 rounded-full font-semibold text-xs" data-i18n="faq_filter_all">Tout</button>
      <button onclick="filterFAQ('produits',event)"    class="faq-filter-btn px-4 sm:px-5 py-2 rounded-full font-semibold text-xs" data-i18n="faq_filter_products">Produits</button>
      <button onclick="filterFAQ('deploiement',event)" class="faq-filter-btn px-4 sm:px-5 py-2 rounded-full font-semibold text-xs" data-i18n="faq_filter_deployment">Déploiement</button>
      <button onclick="filterFAQ('securite',event)"    class="faq-filter-btn px-4 sm:px-5 py-2 rounded-full font-semibold text-xs" data-i18n="faq_filter_security">Sécurité</button>
      <button onclick="filterFAQ('tarification',event)"class="faq-filter-btn px-4 sm:px-5 py-2 rounded-full font-semibold text-xs" data-i18n="faq_filter_pricing">Tarification</button>
    </div>
    <div class="max-w-4xl mx-auto space-y-3">
      <?php
      $faqs=[
        ['produits','faq_q1','Quels modules propose DEVELOP IT?','faq_a1','DEVELOP IT couvre l\'ensemble de vos besoins : ERP complet, gestion commerciale, facturation, CRM, gestion RH, automatisation des workflows, et intégrations natives avec vos outils existants.'],
        ['produits','faq_q2','Puis-je utiliser seulement certains modules ?','faq_a2','Vous êtes libre de choisir les modules dont vous avez besoin. Notre approche modulaire vous permet de commencer petit et d\'ajouter des fonctionnalités au fur et à mesure.'],
        ['produits','faq_q3','Comment DEVELOP IT aide à automatiser les processus ?','faq_a3','Notre moteur d\'automatisation vous permet de créer des workflows personnalisés sans code. Vous gagnez des heures chaque semaine en éliminant les tâches manuelles.'],
        ['deploiement','faq_q4','Combien de temps dure la mise en place ?','faq_a4','Pour une PME/TPE, 2 à 4 semaines. Pour une moyenne entreprise, 6 à 12 semaines selon la complexité.'],
        ['deploiement','faq_q5','Faut-il arrêter l\'activité durant l\'implémentation ?','faq_a5','Non. Nous déployons en parallèle : vos anciens systèmes continuent pendant que nous paramétrons DEVELOP IT.'],
        ['deploiement','faq_q6','Peut-on intégrer DEVELOP IT avec nos outils actuels ?','faq_a6','Oui. DEVELOP IT s\'intègre nativement avec 500+ applications via APIs ou connecteurs pré-construits.'],
        ['securite','faq_q7','DEVELOP IT est-il conforme RGPD ?','faq_a7','Oui, totalement. Nous respectons toutes les obligations RGPD : consentement, portabilité, droit à l\'oubli, audit trails.'],
        ['securite','faq_q8','Où sont hébergées mes données ?','faq_a8','Sur des datacenters européens certifiés ISO 27001 et SOC 2. Géo-redondance et sauvegardes quotidiennes incluses.'],
        ['securite','faq_q9','Comment gérez-vous les droits d\'accès ?','faq_a9','Contrôle granulaire par utilisateur, rôle, département. Traçabilité complète des actions.'],
        ['tarification','faq_q10','Quel est le modèle tarifaire ?','faq_a10','Abonnement sur mesure. Vous payez seulement pour ce que vous utilisez. Prix transparents, sans frais cachés.'],
        ['tarification','faq_q11','Puis-je tester DEVELOP IT avant de m\'engager ?','faq_a11','Oui, démo gratuite personnalisée selon vos besoins. Contactez-nous pour planifier une session.'],
        ['tarification','faq_q12','Comment calcule-t-on le ROI ?','faq_a12','Moyenne observée : 4-6 mois pour une TPE/PME. Nous fournissons un outil de calcul ROI personnalisé.'],
      ];
      foreach($faqs as $f): ?>
      <div class="faq-item" data-category="<?=$f[0]?>" data-aos="fade-up">
        <button class="faq-question w-full text-left p-4 sm:p-5 rounded-xl flex items-center justify-between gap-4" style="background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)" aria-expanded="false">
          <span class="font-semibold text-white text-sm sm:text-base" data-i18n="<?=$f[1]?>"><?=$f[2]?></span>
          <svg class="w-5 h-5 text-indigo-400 flex-shrink-0 transition-transform faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </button>
        <div class="faq-answer hidden p-4 sm:p-5 rounded-b-xl border-l-2 border-indigo-500" style="background:rgba(99,102,241,.04)">
          <p class="text-slate-400 leading-relaxed text-sm" data-i18n="<?=$f[3]?>"><?=$f[4]?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-12" data-aos="fade-up">
      <p class="text-slate-500 mb-4 text-sm" data-i18n="faq_cta_text">Vous ne trouvez pas la réponse à votre question ?</p>
      <a href="#contact" class="btn-neon px-7 py-3 rounded-xl font-semibold text-sm inline-block" data-i18n="faq_cta_button">📞 Contactez-nous</a>
    </div>
  </div>
</section>

<!-- ── CONTACT ── -->
<section id="contact" class="py-20 sm:py-28 section-darker relative">
  <div class="absolute inset-0 overflow-hidden" aria-hidden="true">
    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] rounded-full opacity-10" style="background:radial-gradient(ellipse,#6366f1,transparent 70%);filter:blur(80px)"></div>
  </div>
  <div class="max-w-5xl mx-auto px-4 sm:px-6 relative z-10">
    <div class="text-center mb-10" data-aos="fade-up">
      <div class="eyebrow mb-4" data-i18n="contact_label">Contact</div>
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4" data-i18n="contact_title">Parlons de votre projet avec develop-it</h2>
      <p class="text-slate-400 text-base sm:text-lg max-w-2xl mx-auto" data-i18n="contact_desc">Vous avez un projet digital ou souhaitez intégrer l'IA dans votre entreprise ?<br>Nous sommes là pour vous accompagner.</p>
    </div>
    <div class="contact-grid grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-8">
      <div class="card-glass p-6 rounded-2xl" data-aos="fade-right">
        <div class="text-3xl mb-3">📧</div>
        <h3 class="text-lg font-bold text-white mb-1">Email</h3>
        <p class="text-slate-500 text-sm mb-2" data-i18n="contact_email_desc">Contactez-nous par email</p>
        <a href="mailto:contact@develop-it.tech" class="text-indigo-400 hover:text-indigo-300 font-semibold text-sm break-all">contact@develop-it.tech</a>
      </div>
      <div class="card-glass p-6 rounded-2xl" data-aos="fade-left">
        <div class="text-3xl mb-3">📞</div>
        <h3 class="text-lg font-bold text-white mb-1">Téléphone</h3>
        <p class="text-slate-500 text-sm mb-2" data-i18n="contact_phone_desc">Appelez-nous directement</p>
        <a href="tel:+2120611191926" class="text-indigo-400 hover:text-indigo-300 font-semibold text-sm">+212 06 11 19 19 26</a>
      </div>
    </div>
    <div class="card-glass p-6 sm:p-10 rounded-2xl" data-aos="fade-up">
      <h3 class="text-xl font-bold text-white mb-6 text-center" data-i18n="contact_form_title">Envoyez-nous un message</h3>
      <?php if(!empty($success_message)): ?>
      <div class="mb-6 bg-green-500/10 border border-green-500/30 text-green-300 px-5 py-4 rounded-xl text-sm" role="alert"><?=htmlspecialchars($success_message)?></div>
      <script>gtag('event','conversion',{'send_to':'AW-18017749346/k91ZCOqjjYkcEOKSxI9D'});</script>
      <?php endif; ?>
      <?php if(!empty($error_message)): ?>
      <div class="mb-6 bg-red-500/10 border border-red-500/30 text-red-300 px-5 py-4 rounded-xl text-sm" role="alert"><?=htmlspecialchars($error_message)?></div>
      <?php endif; ?>
      <form method="POST" action="#contact" class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div><label for="f_name" class="block text-xs font-semibold text-slate-400 mb-1.5" data-i18n="contact_name_label">Nom complet *</label><input id="f_name" type="text" name="name" required autocomplete="name" value="<?=htmlspecialchars($_POST['name']??'')?>" class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white placeholder-slate-600 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500/30 transition-colors text-sm" placeholder="Votre nom" data-i18n-placeholder="contact_name_ph"></div>
          <div><label for="f_email" class="block text-xs font-semibold text-slate-400 mb-1.5" data-i18n="contact_email_label">Email *</label><input id="f_email" type="email" name="email" required autocomplete="email" value="<?=htmlspecialchars($_POST['email']??'')?>" class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white placeholder-slate-600 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500/30 transition-colors text-sm" placeholder="votre@email.com"></div>
        </div>
        <div><label for="f_subject" class="block text-xs font-semibold text-slate-400 mb-1.5" data-i18n="contact_subject_label">Sujet *</label><input id="f_subject" type="text" name="subject" required value="<?=htmlspecialchars($_POST['subject']??'')?>" class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white placeholder-slate-600 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500/30 transition-colors text-sm" placeholder="Comment pouvons-nous vous aider?" data-i18n-placeholder="contact_subject_ph"></div>
        <div><label for="f_message" class="block text-xs font-semibold text-slate-400 mb-1.5" data-i18n="contact_msg_label">Message *</label><textarea id="f_message" name="message" rows="5" required class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white placeholder-slate-600 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500/30 transition-colors resize-none text-sm" placeholder="Décrivez votre projet..." data-i18n-placeholder="contact_msg_ph"><?=htmlspecialchars($_POST['message']??'')?></textarea></div>
        <div class="text-center pt-2"><button type="submit" name="submit_contact" class="btn-neon px-8 py-3.5 rounded-xl font-semibold text-sm" data-i18n="contact_submit">🚀 Envoyer le message</button></div>
      </form>
    </div>
  </div>
</section>
</main>

<!-- ── FOOTER ── -->
<footer class="py-10 sm:py-12 border-t border-white/5" style="background:#0a0a14" role="contentinfo">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">
    <div class="footer-grid grid grid-cols-2 md:grid-cols-4 gap-6 sm:gap-8 mb-8">
      <div class="col-span-2 md:col-span-1">
        <div class="flex items-center gap-2 mb-4"><img src="/logo.jfif" alt="DEVELOP IT" width="32" height="32" class="w-7 h-7 rounded-lg object-cover ring-1 ring-indigo-500/30"><span class="text-white font-bold">DEVELOP IT</span></div>
        <p class="text-sm text-slate-300 leading-relaxed" data-i18n="footer_desc">Agence de développement informatique et intelligence artificielle basée au Maroc.</p>
      </div>
      <div>
        <h4 class="text-white font-semibold mb-3 text-sm" data-i18n="footer_services">Services</h4>
        <ul class="space-y-2 text-sm text-slate-300">
          <li><a href="#about" class="hover:text-indigo-400 transition-colors py-1 inline-block" data-i18n="footer_svc1">Développement Web</a></li>
          <li><a href="#about" class="hover:text-indigo-400 transition-colors py-1 inline-block" data-i18n="footer_svc2">Applications Mobile</a></li>
          <li><a href="#about" class="hover:text-indigo-400 transition-colors py-1 inline-block" data-i18n="footer_svc3">Intelligence Artificielle</a></li>
          <li><a href="#about" class="hover:text-indigo-400 transition-colors py-1 inline-block" data-i18n="footer_svc4">Cloud & DevOps</a></li>
        </ul>
      </div>
      <div>
        <h4 class="text-white font-semibold mb-3 text-sm" data-i18n="footer_solutions">Solutions</h4>
        <ul class="space-y-2 text-sm text-slate-300">
          <li><a href="ges_com.php" class="hover:text-indigo-400 transition-colors py-1 inline-block">GESCOM ERP</a></li>
          <li><a href="solution_pointage.php" class="hover:text-indigo-400 transition-colors py-1 inline-block">HR Manager</a></li>
          <li><a href="auto_post_ai.php" class="hover:text-indigo-400 transition-colors py-1 inline-block">Auto-Post AI</a></li>
          <li><a href="btp_manager.php" class="hover:text-indigo-400 transition-colors py-1 inline-block">BTP Manager</a></li>
          <li><a href="wandrly.php" class="hover:text-indigo-400 transition-colors py-1 inline-block">Wandrly</a></li>
          <li><a href="glowai.php" class="hover:text-indigo-400 transition-colors py-1 inline-block">GlowAI</a></li>
        </ul>
      </div>
      <div>
        <h4 class="text-white font-semibold mb-3 text-sm" data-i18n="footer_follow">Suivez-nous</h4>
        <div class="flex gap-3">
          <a href="https://web.facebook.com/developitwithus" target="_blank" rel="noopener" class="w-11 h-11 bg-white/5 rounded-lg flex items-center justify-center hover:bg-indigo-600 ring-1 ring-white/10" aria-label="Facebook"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
          <a href="https://www.instagram.com/developit_/" target="_blank" rel="noopener" class="w-11 h-11 bg-white/5 rounded-lg flex items-center justify-center hover:bg-indigo-600 ring-1 ring-white/10" aria-label="Instagram"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>
          <a href="https://www.linkedin.com/in/developit-/" target="_blank" rel="noopener" class="w-11 h-11 bg-white/5 rounded-lg flex items-center justify-center hover:bg-indigo-600 ring-1 ring-white/10" aria-label="LinkedIn"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg></a>
        </div>
      </div>
    </div>
    <div class="border-t border-white/5 pt-6 text-center text-sm text-slate-400">
      <p data-i18n="footer_copy">© 2026 <strong class="text-white">DEVELOP IT</strong> | Développement Informatique & Intelligence Artificielle | Tous droits réservés</p>
    </div>
  </div>
</footer>

<script>
// Lazy-load AOS only after page is interactive (desktop only)
if(window.innerWidth>767){
  window.addEventListener('load',function(){
    var l=document.createElement('link');l.rel='stylesheet';l.href='https://unpkg.com/aos@2.3.1/dist/aos.css';document.head.appendChild(l);
    var s=document.createElement('script');s.src='https://unpkg.com/aos@2.3.1/dist/aos.js';
    s.onload=function(){AOS.init({duration:700,once:true,offset:50})};
    document.body.appendChild(s);
  });
}
</script>
<script>
document.addEventListener('DOMContentLoaded',function(){
  document.querySelectorAll('.faq-question').forEach(btn=>{
    btn.addEventListener('click',()=>{
      const item=btn.parentElement,ans=btn.nextElementSibling,wasActive=item.classList.contains('active');
      document.querySelectorAll('.faq-item').forEach(i=>{i.classList.remove('active');i.querySelector('.faq-answer').classList.add('hidden');i.querySelector('.faq-question').setAttribute('aria-expanded','false');});
      if(!wasActive){item.classList.add('active');ans.classList.remove('hidden');btn.setAttribute('aria-expanded','true');}
    });
  });
  const saved=localStorage.getItem('lang');
  if(saved&&saved!=='fr'){const btn=document.querySelector('.lang-btn[onclick="setLang(\''+saved+'\',this)"]');if(btn)setLang(saved,btn);}else{setLang('fr',document.querySelector('.lang-btn.active'));}
});
function filterFAQ(cat,e){
  document.querySelectorAll('.faq-filter-btn').forEach(b=>b.classList.remove('active'));
  if(e&&e.target)e.target.classList.add('active');
  document.querySelectorAll('.faq-item').forEach(item=>{const show=cat==='all'||item.dataset.category===cat;item.style.display=show?'block':'none';if(!show){item.classList.remove('active');item.querySelector('.faq-answer').classList.add('hidden');}});
}
const T={
fr:{
  nav_about:'À propos',nav_solutions:'Solutions',nav_blog:'Blog',nav_faq:'FAQ',nav_contact:'Contact',
  hero_badge:'✨ Innovation & Excellence depuis 2014',hero_h1_line:'Votre partenaire en',hero_h1_gradient:'Transformation Digitale & IA',
  hero_desc:'Depuis plus de <strong class="text-indigo-300">10 ans</strong>, <strong class="text-indigo-300">DEVELOP IT</strong> accompagne les entreprises dans la conception de solutions informatiques innovantes, performantes et évolutives au Maroc et à l\'international.',
  hero_cta1:'🚀 Démarrer un projet',hero_cta2:'Découvrir nos solutions',
  stat1:'Projets réalisés',stat2:'Satisfaction client',stat3:'Support disponible',
  about_label:'Notre expertise',about_title:'DEVELOP IT: Une expertise solide, orientée résultats',
  about_desc:'<strong class="text-indigo-400">DEVELOP IT</strong> est une agence de développement informatique spécialisée dans la création de solutions digitales sur mesure. Notre mission est d\'aider les entreprises à réussir leur transformation digitale en intégrant les technologies modernes, y compris l\'<strong class="text-indigo-400">Intelligence Artificielle</strong>.',
  about_years:'Années',about_experience:'d\'expérience dans le développement',about_web_mobile:'Web & Mobile',about_web_mobile_desc:'Applications modernes et performantes',about_ai_data:'IA & Data',about_ai_data_desc:'Automatisation intelligente',about_custom:'Sur mesure',about_custom_desc:'Adapté à vos besoins spécifiques',
  faq_label:'FAQ',faq_title:'Questions fréquemment posées',faq_desc:'Trouvez rapidement les réponses aux questions les plus courantes sur DEVELOP IT',
  faq_filter_all:'Tout',faq_filter_products:'Produits',faq_filter_deployment:'Déploiement',faq_filter_security:'Sécurité',faq_filter_pricing:'Tarification',
  faq_cta_text:'Vous ne trouvez pas la réponse à votre question ?',faq_cta_button:'📞 Contactez-nous',
  faq_q1:'Quels modules propose DEVELOP IT?',faq_a1:'DEVELOP IT couvre l\'ensemble de vos besoins : ERP complet, gestion commerciale, facturation, CRM, gestion RH, automatisation des workflows, et intégrations natives avec vos outils existants.',
  faq_q2:'Puis-je utiliser seulement certains modules ?',faq_a2:'Vous êtes libre de choisir les modules dont vous avez besoin. Notre approche modulaire vous permet de commencer petit et d\'ajouter des fonctionnalités au fur et à mesure.',
  faq_q3:'Comment DEVELOP IT aide à automatiser les processus ?',faq_a3:'Notre moteur d\'automatisation vous permet de créer des workflows personnalisés sans code. Vous gagnez des heures chaque semaine en éliminant les tâches manuelles.',
  faq_q4:'Combien de temps dure la mise en place ?',faq_a4:'Pour une PME/TPE, 2 à 4 semaines. Pour une moyenne entreprise, 6 à 12 semaines selon la complexité.',
  faq_q5:'Faut-il arrêter l\'activité durant l\'implémentation ?',faq_a5:'Non. Nous déployons en parallèle : vos anciens systèmes continuent pendant que nous paramétrons DEVELOP IT.',
  faq_q6:'Peut-on intégrer DEVELOP IT avec nos outils actuels ?',faq_a6:'Oui. DEVELOP IT s\'intègre nativement avec 500+ applications via APIs ou connecteurs pré-construits.',
  faq_q7:'DEVELOP IT est-il conforme RGPD ?',faq_a7:'Oui, totalement. Nous respectons toutes les obligations RGPD : consentement, portabilité, droit à l\'oubli, audit trails.',
  faq_q8:'Où sont hébergées mes données ?',faq_a8:'Sur des datacenters européens certifiés ISO 27001 et SOC 2. Géo-redondance et sauvegardes quotidiennes incluses.',
  faq_q9:'Comment gérez-vous les droits d\'accès ?',faq_a9:'Contrôle granulaire par utilisateur, rôle, département. Traçabilité complète des actions.',
  faq_q10:'Quel est le modèle tarifaire ?',faq_a10:'Abonnement sur mesure. Vous payez seulement pour ce que vous utilisez. Prix transparents, sans frais cachés.',
  faq_q11:'Puis-je tester DEVELOP IT avant de m\'engager ?',faq_a11:'Oui, démo gratuite personnalisée selon vos besoins. Contactez-nous pour planifier une session.',
  faq_q12:'Comment calcule-t-on le ROI ?',faq_a12:'Moyenne observée : 4-6 mois pour une TPE/PME. Nous fournissons un outil de calcul ROI personnalisé.',
  services:'Services',expertise:'Nos domaines d\'expertise',
  service_4_title:'Développement Web',service_4_description:'Applications PHP, Laravel, Node.js, React, Vue.js. Plateformes SaaS évolutives et performantes développées par DEVELOP IT.',
  service_5_title:'Applications Mobile',service_5_description:'Solutions Android & iOS natives et multiplateformes. Expériences utilisateur exceptionnelles.',
  service_6_title:'Intelligence Artificielle',service_6_description:'Analyse de données, automatisation intelligente, machine learning, IA métier sur mesure.',
  service_7_title:'Cloud & DevOps',service_7_description:'Déploiement, infrastructure cloud, CI/CD, monitoring, sécurité et optimisation des performances.',
  service_8_title:'Cybersécurité',service_8_description:'Protection des données, audits de sécurité, conformité RGPD, tests d\'intrusion.',
  service_9_title:'ERP & Logiciels métiers',service_9_description:'Solutions internes sur mesure, digitalisation des processus, automatisation métier.',
  ai_section_badge:'Propulsé par l\'Intelligence Artificielle',ai_solutions_title:'Nos solutions IA',ai_solutions_desc:'Agents intelligents, automatisation et génération de contenu — l\'IA au service de votre croissance',
  business_section_badge:'Solutions Métier',business_solutions_title:'ERP & logiciels de gestion',business_solutions_desc:'Des outils robustes pour piloter votre activité au quotidien',
  sol1_badge:'ERP',sol1_title:'GESCOM ERP',sol1_desc:'Solution ERP complète : comptabilité multi-devises, gestion des stocks, CRM, finances et Business Intelligence.',sol1_cta:'Découvrir la solution',
  sol2_badge:'RH',sol2_title:'HR Manager',sol2_desc:'Pointage GPS et gestion RH : présence temps réel, congés, rapports et tableaux de bord analytiques.',sol2_cta:'Découvrir la solution',
  sol3_badge:'IA',sol3_title:'Auto-Post AI Studio',sol3_desc:'Génération de contenu IA, publication multi-réseaux sociaux et planification intelligente.',sol3_cta:'En savoir plus',
  sol4_badge:'BTP',sol4_title:'BTP Manager',sol4_desc:'ERP sectoriel BTP : gestion de projets, stocks, finances, personnel et comptabilité temps réel.',sol4_cta:'Découvrir la solution',
  sol5_title:'Votre projet sur mesure',sol5_desc:'Nous développons des solutions personnalisées adaptées à vos besoins spécifiques',sol5_cta:'Discutons de votre projet',
  trenddrop_badge:'IA Drop',trenddrop_title:'TrendDrop',trenddrop_desc:'Détection produits gagnants via Google Trends & TikTok. Génération pubs, scripts vidéo et pages Shopify.',trenddrop_cta:'Découvrir TrendDrop',
  malab_badge:'IA Sports',malab_title:'Malab Live',malab_desc:'Agent IA qui collecte matchs, scrape les liens streaming et publie sur Facebook toutes les 15 min.',malab_cta:'Découvrir Malab Live',
  sol_sa_badge:'IA Coach',sol_sa_title:'Strategic Architect',sol_sa_desc:'Coach IA qui identifie vos blocages via diagnostic 5 rounds et construit un plan d\'action 90 jours.',sol_sa_cta:'Démarrer le diagnostic',
  repurzel_badge:'IA Creator',repurzel_title:'Repurzel',repurzel_desc:'Transformez un contenu en 5 posts prêts pour Twitter, TikTok, Instagram, Email et LinkedIn.',repurzel_cta:'Découvrir Repurzel',
  leadhunter_badge:'Lead Gen IA',leadhunter_title:'Lead Hunter',leadhunter_desc:'Pipeline IA qui scrape Facebook, qualifie l\'intention d\'achat et livre les leads scorés sur Telegram.',leadhunter_cta:'Découvrir Lead Hunter',
  recovpro_badge:'FinTech IA',recovpro_title:'RecovPro',recovpro_desc:'Réduisez vos impayés de 25% à moins de 5% du CA grâce au scoring IA et relances automatiques.',recovpro_cta:'Découvrir RecovPro',
  wandrly_badge:'IA Travel',wandrly_title:'Wandrly',wandrly_desc:'Planificateur de voyages IA : itinéraires personnalisés, budget optimisé, réservations et recommandations intelligentes.',wandrly_cta:'Découvrir Wandrly',
  glowai_badge:'IA Beauty',glowai_title:'GlowAI',glowai_desc:'Diagnostic beauté par IA : analyse de peau, routines personnalisées, recommandations produits et suivi des progrès.',glowai_cta:'Découvrir GlowAI',
  tech_label:'Stack Technologique',tech_title:'Technologies maîtrisées par DEVELOP IT',
  react:'React',nodejs:'Node.js',php:'PHP/Laravel',python:'Python',typescript:'TypeScript',aws:'AWS/Azure',
  testi_label:'Témoignages',testi_title:'Ce que disent nos clients de DEVELOP IT',
  testi1_text:'"Une équipe exceptionnelle qui a transformé notre vision en réalité. Le projet a été livré dans les temps avec une qualité irréprochable."',testi1_name:'Ahmed M.',testi1_title:'CEO, TechStart',
  testi2_text:'"Professionnalisme et expertise technique au rendez-vous. Notre application mobile a dépassé toutes nos attentes."',testi2_name:'Sarah K.',testi2_title:'Directrice Marketing',
  testi3_text:'"L\'intégration de l\'IA dans nos processus a révolutionné notre productivité. Un investissement qui en valait vraiment la peine."',testi3_name:'Youssef B.',testi3_title:'COO, InnovCorp',
  contact_label:'Contact',contact_title:'Parlons de votre projet avec develop-it',
  contact_desc:'Vous avez un projet digital ou souhaitez intégrer l\'IA dans votre entreprise ?<br>Nous sommes là pour vous accompagner.',
  contact_email_desc:'Contactez-nous par email',contact_phone_desc:'Appelez-nous directement',contact_form_title:'Envoyez-nous un message',
  contact_name_label:'Nom complet *',contact_name_ph:'Votre nom',contact_email_label:'Email *',contact_subject_label:'Sujet *',contact_subject_ph:'Comment pouvons-nous vous aider?',contact_msg_label:'Message *',contact_msg_ph:'Décrivez votre projet...',contact_submit:'🚀 Envoyer le message',
  footer_desc:'Agence de développement informatique et intelligence artificielle basée au Maroc.',footer_services:'Services',footer_solutions:'Solutions',footer_follow:'Suivez-nous',
  footer_svc1:'Développement Web',footer_svc2:'Applications Mobile',footer_svc3:'Intelligence Artificielle',footer_svc4:'Cloud & DevOps',
  footer_copy:'© 2026 <strong class="text-white">DEVELOP IT</strong> | Développement Informatique & Intelligence Artificielle | Tous droits réservés',
},
en:{
  nav_about:'About',nav_solutions:'Solutions',nav_blog:'Blog',nav_faq:'FAQ',nav_contact:'Contact',
  hero_badge:'✨ Innovation & Excellence since 2014',hero_h1_line:'Your partner in',hero_h1_gradient:'Digital Transformation & AI',
  hero_desc:'For over <strong class="text-indigo-300">10 years</strong>, <strong class="text-indigo-300">DEVELOP IT</strong> has been helping companies design innovative, high-performance and scalable IT solutions in Morocco and internationally.',
  hero_cta1:'🚀 Start a project',hero_cta2:'Discover our solutions',stat1:'Projects completed',stat2:'Client satisfaction',stat3:'Support available',
  about_label:'Our expertise',about_title:'DEVELOP IT: Solid expertise, results-oriented',
  about_desc:'<strong class="text-indigo-400">DEVELOP IT</strong> is a software development agency specializing in custom digital solutions. Our mission is to help businesses succeed in their digital transformation by integrating modern technologies, including <strong class="text-indigo-400">Artificial Intelligence</strong>.',
  about_years:'Years',about_experience:'of development experience',about_web_mobile:'Web & Mobile',about_web_mobile_desc:'Modern and high-performance applications',about_ai_data:'AI & Data',about_ai_data_desc:'Intelligent automation',about_custom:'Custom',about_custom_desc:'Adapted to your specific needs',
  faq_label:'FAQ',faq_title:'Frequently Asked Questions',faq_desc:'Quickly find answers to the most common questions about DEVELOP IT',
  faq_filter_all:'All',faq_filter_products:'Products',faq_filter_deployment:'Deployment',faq_filter_security:'Security',faq_filter_pricing:'Pricing',
  faq_cta_text:"Can't find the answer to your question?",faq_cta_button:'📞 Contact us',
  faq_q1:'What modules does DEVELOP IT offer?',faq_a1:'DEVELOP IT covers all your needs: full ERP, sales management, invoicing, CRM, HR management, workflow automation, and native integrations with your existing tools.',
  faq_q2:'Can I use only certain modules?',faq_a2:'You are free to choose the modules you need. Our modular approach lets you start small and add features as your needs grow.',
  faq_q3:'How does DEVELOP IT help automate processes?',faq_a3:'Our automation engine lets you create custom workflows without code. You save hours every week by eliminating manual tasks.',
  faq_q4:'How long does the setup take?',faq_a4:'For a small business, 2 to 4 weeks. For a medium-sized company, 6 to 12 weeks depending on complexity.',
  faq_q5:'Do I need to halt operations during implementation?',faq_a5:'No. We deploy in parallel: your old systems continue while we configure DEVELOP IT.',
  faq_q6:'Can DEVELOP IT integrate with our current tools?',faq_a6:'Yes. DEVELOP IT integrates natively with 500+ applications via APIs or pre-built connectors.',
  faq_q7:'Is DEVELOP IT GDPR compliant?',faq_a7:'Yes, fully. We comply with all GDPR obligations: consent, data portability, right to erasure, audit trails.',
  faq_q8:'Where is my data hosted?',faq_a8:'On ISO 27001 and SOC 2 certified European data centers. Geo-redundancy and daily backups included.',
  faq_q9:'How do you manage access rights?',faq_a9:'Granular control by user, role, department. Complete audit trail of all actions.',
  faq_q10:'What is the pricing model?',faq_a10:'Custom subscription. You only pay for what you use. Transparent pricing, no hidden fees.',
  faq_q11:'Can I try DEVELOP IT before committing?',faq_a11:'Yes, free personalized demo. Contact us to schedule a session.',
  faq_q12:'How is ROI calculated?',faq_a12:'Average: 4–6 months for SMBs. We provide a personalized ROI calculator.',
  services:'Services',expertise:'Our areas of expertise',
  service_4_title:'Web Development',service_4_description:'PHP, Laravel, Node.js, React, Vue.js. Scalable SaaS platforms by DEVELOP IT.',
  service_5_title:'Mobile Applications',service_5_description:'Native and cross-platform Android & iOS solutions.',
  service_6_title:'Artificial Intelligence',service_6_description:'Data analysis, intelligent automation, machine learning, custom business AI.',
  service_7_title:'Cloud & DevOps',service_7_description:'Deployment, cloud infrastructure, CI/CD, monitoring, security.',
  service_8_title:'Cybersecurity',service_8_description:'Data protection, security audits, GDPR compliance, penetration testing.',
  service_9_title:'ERP & Business Software',service_9_description:'Custom internal solutions, process digitization, business automation.',
  ai_section_badge:'Powered by Artificial Intelligence',ai_solutions_title:'Our AI solutions',ai_solutions_desc:'Intelligent agents, automation and content generation — AI at the service of your growth',
  business_section_badge:'Business Solutions',business_solutions_title:'ERP & management software',business_solutions_desc:'Robust tools to manage your daily operations',
  sol1_badge:'ERP',sol1_title:'GESCOM ERP',sol1_desc:'Complete ERP: multi-currency accounting, inventory, CRM, finance, BI.',sol1_cta:'Discover',
  sol2_badge:'HR',sol2_title:'HR Manager',sol2_desc:'GPS time-tracking, leave management, analytical dashboards.',sol2_cta:'Discover',
  sol3_badge:'AI',sol3_title:'Auto-Post AI Studio',sol3_desc:'AI content generation, multi-social publishing, intelligent scheduling.',sol3_cta:'Learn more',
  sol4_badge:'BTP',sol4_title:'BTP Manager',sol4_desc:'Construction ERP: projects, inventory, finance, real-time accounting.',sol4_cta:'Discover',
  sol5_title:'Your custom project',sol5_desc:'We develop personalized solutions adapted to your specific needs',sol5_cta:'Discuss your project',
  trenddrop_badge:'AI Drop',trenddrop_title:'TrendDrop',trenddrop_desc:'Winning product detection via Google Trends & TikTok.',trenddrop_cta:'Discover TrendDrop',
  malab_badge:'AI Sports',malab_title:'Malab Live',malab_desc:'AI agent collecting matches and auto-posting to Facebook.',malab_cta:'Discover Malab Live',
  sol_sa_badge:'AI Coach',sol_sa_title:'Strategic Architect',sol_sa_desc:'AI coach with 5-round diagnostic and 90-day action plan.',sol_sa_cta:'Start diagnosis',
  repurzel_badge:'AI Creator',repurzel_title:'Repurzel',repurzel_desc:'Turn one content into 5 posts for all platforms.',repurzel_cta:'Discover Repurzel',
  leadhunter_badge:'AI Lead Gen',leadhunter_title:'Lead Hunter',leadhunter_desc:'AI pipeline scraping Facebook, delivering scored leads on Telegram.',leadhunter_cta:'Discover Lead Hunter',
  recovpro_badge:'AI FinTech',recovpro_title:'RecovPro',recovpro_desc:'Reduce unpaid invoices using AI scoring and automated follow-ups.',recovpro_cta:'Discover RecovPro',
  wandrly_badge:'AI Travel',wandrly_title:'Wandrly',wandrly_desc:'AI travel planner: personalized itineraries, optimized budgets.',wandrly_cta:'Discover Wandrly',
  glowai_badge:'AI Beauty',glowai_title:'GlowAI',glowai_desc:'AI beauty diagnostic: skin analysis, personalized routines.',glowai_cta:'Discover GlowAI',
  tech_label:'Tech Stack',tech_title:'Technologies mastered by DEVELOP IT',
  react:'React',nodejs:'Node.js',php:'PHP/Laravel',python:'Python',typescript:'TypeScript',aws:'AWS/Azure',
  testi_label:'Testimonials',testi_title:'What our clients say about DEVELOP IT',
  testi1_text:'"An exceptional team that turned our vision into reality."',testi1_name:'Ahmed M.',testi1_title:'CEO, TechStart',
  testi2_text:'"Professionalism and technical expertise at their finest."',testi2_name:'Sarah K.',testi2_title:'Marketing Director',
  testi3_text:'"Integrating AI revolutionized our productivity."',testi3_name:'Youssef B.',testi3_title:'COO, InnovCorp',
  contact_label:'Contact',contact_title:"Let's talk about your project",
  contact_desc:'Have a digital project or want to integrate AI?<br>We are here to help.',
  contact_email_desc:'Contact us by email',contact_phone_desc:'Call us directly',contact_form_title:'Send us a message',
  contact_name_label:'Full name *',contact_name_ph:'Your name',contact_email_label:'Email *',contact_subject_label:'Subject *',contact_subject_ph:'How can we help?',contact_msg_label:'Message *',contact_msg_ph:'Describe your project...',contact_submit:'🚀 Send message',
  footer_desc:'Software development and AI agency based in Morocco.',footer_services:'Services',footer_solutions:'Solutions',footer_follow:'Follow us',
  footer_svc1:'Web Development',footer_svc2:'Mobile Apps',footer_svc3:'Artificial Intelligence',footer_svc4:'Cloud & DevOps',
  footer_copy:'© 2026 <strong class="text-white">DEVELOP IT</strong> | Software Development & AI | All rights reserved',
}};
function setLang(lang,btn){
  document.querySelectorAll('.lang-btn').forEach(b=>b.classList.remove('active'));
  if(btn)btn.classList.add('active');document.documentElement.lang=lang;
  const t=T[lang]||T.fr;
  document.querySelectorAll('[data-i18n]').forEach(el=>{const k=el.getAttribute('data-i18n');if(t[k]!==undefined)el.innerHTML=t[k];});
  document.querySelectorAll('[data-i18n-placeholder]').forEach(el=>{const k=el.getAttribute('data-i18n-placeholder');if(t[k]!==undefined)el.placeholder=t[k];});
  localStorage.setItem('lang',lang);
}
</script>
</body>
</html>
