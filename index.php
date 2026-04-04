<?php
/* ═══════════════════════════════════════════════════════════
   DEVELOP IT — index.php   (optimized: mobile + perf + a11y)
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
// Blog DB
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
<meta property="og:image" content="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1200&q=80">
<meta name="twitter:card" content="summary_large_image">
<link rel="icon" type="image/jpeg" href="/logo.jfif">
<link rel="apple-touch-icon" href="/logo.jfif">

<!-- ═══ PERF: preconnect critical origins ═══ -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://images.unsplash.com">

<!-- ═══ PERF: preload LCP image ═══ -->
<link rel="preload" as="image" fetchpriority="high"
    href="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=750&q=75">

<!-- ═══ PERF: Google Fonts NON-BLOCKING ═══ -->
<link rel="preload" as="style"
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap"
    onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap"></noscript>

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- ═══ PERF: AOS CSS NON-BLOCKING ═══ -->
<link rel="preload" as="style"
    href="https://unpkg.com/aos@2.3.1/dist/aos.css"
    onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css"></noscript>

<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-RRH1J9XH1W"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','G-RRH1J9XH1W');</script>

<!-- Structured Data: Organization + WebSite -->
<script type="application/ld+json">
{
  "@context":"https://schema.org",
  "@graph":[
    {
      "@type":"Organization",
      "@id":"https://develop-it.tech/#organization",
      "name":"DEVELOP IT",
      "url":"https://develop-it.tech",
      "logo":{"@type":"ImageObject","url":"https://develop-it.tech/logo.jfif","width":200,"height":200},
      "description":"Agence de développement informatique et intelligence artificielle au Maroc, spécialisée en transformation digitale depuis 2014.",
      "foundingDate":"2014",
      "address":{"@type":"PostalAddress","addressCountry":"MA"},
      "contactPoint":{"@type":"ContactPoint","telephone":"+212-06-11-19-19-26","contactType":"customer service","email":"contact@develop-it.tech"},
      "sameAs":["https://www.linkedin.com/company/develop-it"]
    },
    {
      "@type":"WebSite",
      "@id":"https://develop-it.tech/#website",
      "url":"https://develop-it.tech",
      "name":"DEVELOP IT",
      "publisher":{"@id":"https://develop-it.tech/#organization"},
      "potentialAction":{"@type":"SearchAction","target":{"@type":"EntryPoint","urlTemplate":"https://develop-it.tech/blog/?s={search_term_string}"},"query-input":"required name=search_term_string"}
    },
    {
      "@type":"WebPage",
      "@id":"https://develop-it.tech/#webpage",
      "url":"https://develop-it.tech",
      "name":"DEVELOP IT | Agence de Développement Informatique & IA | Transformation Digitale",
      "description":"DEVELOP IT - Agence de développement informatique avec plus de 10 ans d'expérience au Maroc.",
      "isPartOf":{"@id":"https://develop-it.tech/#website"},
      "about":{"@id":"https://develop-it.tech/#organization"},
      "breadcrumb":{"@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"name":"Accueil","item":"https://develop-it.tech"}]}
    }
  ]
}
</script>

<style>
/* ─── Critical CSS (inlined) ───────────────────────────────── */
*,::before,::after{box-sizing:border-box}

/* ═══ MOBILE FIX #1: prevent horizontal overflow ═══ */
html,body{overflow-x:hidden;max-width:100vw;
  font-family:'Inter',system-ui,-apple-system,sans-serif;margin:0}

@keyframes gradient{0%{background-position:0% 50%}50%{background-position:100% 50%}100%{background-position:0% 50%}}
.gradient-animate{background:linear-gradient(-45deg,#0f172a,#1e3a8a,#7c3aed,#0f172a);background-size:400% 400%;animation:gradient 15s ease infinite}
@keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-16px)}}
.float-animation{animation:float 6s ease-in-out infinite}
@keyframes pulse-glow{0%,100%{box-shadow:0 0 20px rgba(59,130,246,.5)}50%{box-shadow:0 0 40px rgba(59,130,246,.8)}}
.pulse-glow{animation:pulse-glow 2s ease-in-out infinite}
.card-hover{transition:transform .3s ease,box-shadow .3s ease}
.card-hover:hover{transform:translateY(-8px);box-shadow:0 20px 40px rgba(0,0,0,.15)}
html{scroll-behavior:smooth}
::-webkit-scrollbar{width:8px}::-webkit-scrollbar-track{background:#1e293b}
::-webkit-scrollbar-thumb{background:#3b82f6;border-radius:4px}

.faq-filter-btn{background:#fff;color:#64748b;border:2px solid #e2e8f0;transition:all .2s}
.faq-filter-btn.active{background:#3b82f6;color:#fff;border-color:#3b82f6}
.faq-filter-btn:hover{border-color:#3b82f6;color:#3b82f6}
.faq-filter-btn.active:hover{color:#fff}
@keyframes slideDown{from{opacity:0;transform:translateY(-8px)}to{opacity:1;transform:translateY(0)}}
.faq-answer{animation:slideDown .3s ease-out}
.faq-item.active .faq-icon{transform:rotate(180deg)}

.lang-switcher{display:flex;align-items:center;background:#f1f5f9;border-radius:9999px;padding:3px;gap:2px;flex-shrink:0}
.lang-btn{padding:4px 10px;border-radius:9999px;font-size:12px;font-weight:600;cursor:pointer;
  transition:all .2s;border:none;background:transparent;color:#64748b;white-space:nowrap}
.lang-btn.active{background:#3b82f6;color:#fff;box-shadow:0 1px 4px rgba(59,130,246,.4)}
.lang-btn:hover:not(.active){color:#3b82f6}

/* ═══ MOBILE FIXES ═══════════════════════════════════════════ */
@media(max-width:767px){
  /* Nav: hide text links on mobile */
  .nav-links{display:none!important}
  /* Hero: stack vertically */
  .hero-grid{grid-template-columns:1fr!important;gap:1.5rem!important}
  /* Hide hero image on mobile (saves LCP bandwidth) */
  .hero-img{display:none!important}
  /* Clip hero headings */
  .hero-h1{font-size:2.25rem!important;line-height:1.2!important}
  /* About: 2 col grid on mobile */
  .about-grid{grid-template-columns:repeat(2,1fr)!important}
  /* Services: 1 col mobile */
  .services-grid{grid-template-columns:1fr!important}
  /* Contact info: 1 col */
  .contact-grid{grid-template-columns:1fr!important}
  /* Footer: 2 col mobile */
  .footer-grid{grid-template-columns:repeat(2,1fr)!important}
}

/* ═══ ACCESSIBILITY: carousel dots — 44px touch targets ═══ */
.sol-dot{
  width:2.75rem;height:2.75rem;border-radius:9999px;
  display:inline-flex;align-items:center;justify-content:center;
  background:transparent;border:none;cursor:pointer;padding:0;flex-shrink:0
}
.sol-dot-pip{
  width:8px;height:8px;border-radius:9999px;background:#cbd5e1;
  transition:all .2s;pointer-events:none
}
.sol-dot.active .sol-dot-pip{background:#1e293b;transform:scale(1.4)}
</style>
</head>

<body class="bg-slate-50 text-slate-800">

<!-- ── NAV ─────────────────────────────────────────────────── -->
<nav class="fixed top-0 left-0 right-0 bg-white/95 backdrop-blur-sm shadow-md z-50"
     role="navigation" aria-label="Navigation principale">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 sm:py-4">
    <div class="flex items-center justify-between gap-3">
      <div class="flex items-center gap-2 sm:gap-3 min-w-0">
        <!-- PERF: explicit width/height stops layout shift -->
        <img src="/logo.jfif" alt="DEVELOP IT logo" width="40" height="40"
             class="w-8 h-8 sm:w-10 sm:h-10 rounded-sm object-cover flex-shrink-0">
        <span class="text-lg sm:text-2xl font-bold text-slate-800 truncate">DEVELOP IT</span>
      </div>
      <!-- Hidden on mobile via .nav-links CSS class -->
      <div class="nav-links hidden md:flex items-center gap-4 lg:gap-6">
        <a href="#about"     class="text-slate-600 hover:text-blue-600 transition text-sm lg:text-base" data-i18n="nav_about">À propos</a>
        <a href="#solutions" class="text-slate-600 hover:text-blue-600 transition text-sm lg:text-base" data-i18n="nav_solutions">Solutions</a>
        <a href="blog/"      class="text-slate-600 hover:text-blue-600 transition text-sm lg:text-base" data-i18n="nav_blog">Blog</a>
        <a href="#faq"       class="text-slate-600 hover:text-blue-600 transition text-sm lg:text-base" data-i18n="nav_faq">FAQ</a>
        <a href="#contact"   class="bg-blue-600 text-white px-4 lg:px-6 py-2 rounded-lg hover:bg-blue-700 transition text-sm" data-i18n="nav_contact">Contact</a>
      </div>
      <div class="lang-switcher">
        <button class="lang-btn active" onclick="setLang('fr',this)" aria-label="Passer en français">🇫🇷 FR</button>
        <button class="lang-btn"        onclick="setLang('en',this)" aria-label="Switch to English">🇬🇧 EN</button>
      </div>
    </div>
  </div>
</nav>

<!-- ════════════════════════════════════════════════════════════
     ACCESSIBILITY FIX: <main> landmark
     ════════════════════════════════════════════════════════════ -->
<main id="main-content">

<!-- ── HERO ────────────────────────────────────────────────── -->
<section class="relative gradient-animate text-white overflow-hidden min-h-screen flex items-center pt-16 sm:pt-20"
         aria-label="Présentation DEVELOP IT">
  <div class="absolute inset-0 opacity-20" aria-hidden="true">
    <div class="absolute top-20 left-10 sm:left-20 w-48 sm:w-72 h-48 sm:h-72 bg-blue-500 rounded-full filter blur-3xl animate-pulse"></div>
    <div class="absolute bottom-20 right-10 sm:right-20 w-64 sm:w-96 h-64 sm:h-96 bg-purple-500 rounded-full filter blur-3xl animate-pulse" style="animation-delay:1s"></div>
    <div class="absolute top-1/2 left-1/2 w-64 sm:w-80 h-64 sm:h-80 bg-cyan-500 rounded-full filter blur-3xl animate-pulse" style="animation-delay:2s"></div>
  </div>

  <!-- MOBILE FIX: hero-grid class controlled by CSS above -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12 sm:py-24 grid md:grid-cols-2 gap-8 sm:gap-12 items-center relative z-10 w-full hero-grid">
    <div data-aos="fade-right" data-aos-duration="1000">
      <div class="inline-block bg-blue-500/20 backdrop-blur-sm px-3 py-2 rounded-full text-xs sm:text-sm mb-4 border border-blue-400/30" data-i18n="hero_badge">
        ✨ Innovation & Excellence depuis 2014
      </div>
      <!-- MOBILE FIX: hero-h1 class for responsive font-size -->
      <h1 class="hero-h1 text-4xl sm:text-5xl md:text-6xl font-bold leading-tight mb-4 sm:mb-6">
        <span class="text-blue-400">DEVELOP IT</span><br>
        <span data-i18n="hero_h1_line">Votre partenaire en</span><br>
        <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 via-purple-400 to-cyan-400" data-i18n="hero_h1_gradient">
          Transformation Digitale & IA
        </span>
      </h1>
      <p class="mt-4 text-base sm:text-xl text-slate-200 leading-relaxed" data-i18n="hero_desc">
        Depuis plus de <strong class="text-blue-300">10 ans</strong>, <strong class="text-blue-300">DEVELOP IT</strong> accompagne les entreprises
        dans la conception de solutions informatiques innovantes, performantes et évolutives au Maroc et à l'international.
      </p>
      <div class="mt-6 sm:mt-8 flex flex-wrap gap-3 sm:gap-4">
        <a href="#contact" class="bg-white text-slate-900 px-5 sm:px-8 py-3 sm:py-4 rounded-xl font-semibold hover:bg-slate-100 transition transform hover:scale-105 shadow-lg text-sm sm:text-base" data-i18n="hero_cta1">
          🚀 Démarrer un projet
        </a>
        <a href="#solutions" class="border-2 border-white/40 backdrop-blur-sm px-5 sm:px-8 py-3 sm:py-4 rounded-xl hover:bg-white/10 transition text-sm sm:text-base" data-i18n="hero_cta2">
          Découvrir nos solutions
        </a>
      </div>
      <div class="mt-8 sm:mt-12 flex items-center gap-6 sm:gap-8">
        <div><div class="text-2xl sm:text-3xl font-bold">50+</div><div class="text-xs sm:text-sm text-slate-300" data-i18n="stat1">Projets réalisés</div></div>
        <div><div class="text-2xl sm:text-3xl font-bold">98%</div><div class="text-xs sm:text-sm text-slate-300" data-i18n="stat2">Satisfaction client</div></div>
        <div><div class="text-2xl sm:text-3xl font-bold">24/7</div><div class="text-xs sm:text-sm text-slate-300" data-i18n="stat3">Support disponible</div></div>
      </div>
    </div>

    <!-- MOBILE FIX: hero-img hides on mobile via CSS -->
    <div class="hero-img hidden md:block float-animation" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
      <!-- PERF: srcset + correct size + fetchpriority=high -->
      <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=750&q=75"
           srcset="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=500&q=70 500w,
                   https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=750&q=75 750w"
           sizes="(max-width:1024px) 500px, 750px"
           width="750" height="500"
           fetchpriority="high"
           alt="DEVELOP IT — Agence digitale et intelligence artificielle"
           class="rounded-2xl shadow-2xl pulse-glow w-full">
    </div>
  </div>

  <!-- ACCESSIBILITY FIX: aria-label on scroll arrow link -->
  <div class="absolute bottom-6 left-1/2 -translate-x-1/2 animate-bounce">
    <a href="#about" class="text-white opacity-70 hover:opacity-100 transition"
       aria-label="Défiler vers la section À propos">
      <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
      </svg>
    </a>
  </div>
</section>

<!-- ── ABOUT ────────────────────────────────────────────────── -->
<section id="about" class="py-16 sm:py-24 bg-white">
  <div class="max-w-6xl mx-auto px-4 sm:px-6">
    <div class="text-center mb-12 sm:mb-16" data-aos="fade-up">
      <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider" data-i18n="about_label">Notre expertise</span>
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mt-3 mb-6" data-i18n="about_title">DEVELOP IT: Une expertise solide, orientée résultats</h2>
      <p class="text-slate-600 text-base sm:text-lg max-w-3xl mx-auto leading-relaxed" data-i18n="about_desc">
        <strong class="text-blue-600">DEVELOP IT</strong> est une agence de développement informatique spécialisée dans la création
        de solutions digitales sur mesure. Notre mission est d'aider les entreprises à réussir leur transformation digitale
        en intégrant les technologies modernes, y compris l'<strong class="text-blue-600">Intelligence Artificielle</strong>.
      </p>
    </div>
    <!-- MOBILE FIX: about-grid — 2 cols mobile, 4 desktop -->
    <div class="about-grid grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-8 mt-8 sm:mt-16">
      <div class="bg-gradient-to-br from-blue-50 to-cyan-50 p-5 sm:p-8 rounded-2xl shadow-lg card-hover border border-blue-100" data-aos="fade-up">
        <div class="text-3xl sm:text-5xl font-bold text-blue-600 mb-2">10+</div>
        <h3 class="font-bold text-base sm:text-xl mb-2" data-i18n="about_years">Années</h3>
        <p class="text-xs sm:text-sm text-slate-600" data-i18n="about_experience">d'expérience dans le développement</p>
      </div>
      <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-5 sm:p-8 rounded-2xl shadow-lg card-hover border border-purple-100" data-aos="fade-up" data-aos-delay="100">
        <div class="text-3xl sm:text-4xl mb-3">🌐</div>
        <h3 class="font-bold text-base sm:text-xl mb-2" data-i18n="about_web_mobile">Web & Mobile</h3>
        <p class="text-xs sm:text-sm text-slate-600" data-i18n="about_web_mobile_desc">Applications modernes et performantes</p>
      </div>
      <div class="bg-gradient-to-br from-cyan-50 to-blue-50 p-5 sm:p-8 rounded-2xl shadow-lg card-hover border border-cyan-100" data-aos="fade-up" data-aos-delay="200">
        <div class="text-3xl sm:text-4xl mb-3">🤖</div>
        <h3 class="font-bold text-base sm:text-xl mb-2" data-i18n="about_ai_data">IA & Data</h3>
        <p class="text-xs sm:text-sm text-slate-600" data-i18n="about_ai_data_desc">Automatisation intelligente</p>
      </div>
      <div class="bg-gradient-to-br from-indigo-50 to-purple-50 p-5 sm:p-8 rounded-2xl shadow-lg card-hover border border-indigo-100" data-aos="fade-up" data-aos-delay="300">
        <div class="text-3xl sm:text-4xl mb-3">⚡</div>
        <h3 class="font-bold text-base sm:text-xl mb-2" data-i18n="about_custom">Sur mesure</h3>
        <p class="text-xs sm:text-sm text-slate-600" data-i18n="about_custom_desc">Adapté à vos besoins spécifiques</p>
      </div>
    </div>
  </div>
</section>

<!-- ── FAQ ──────────────────────────────────────────────────── -->
<section id="faq" class="py-16 sm:py-24 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">
    <div class="text-center mb-12 sm:mb-16" data-aos="fade-up">
      <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider" data-i18n="faq_label">FAQ</span>
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mt-3 mb-6" data-i18n="faq_title">Questions fréquemment posées</h2>
      <p class="text-slate-600 text-base sm:text-lg max-w-3xl mx-auto" data-i18n="faq_desc">Trouvez rapidement les réponses aux questions les plus courantes sur DEVELOP IT</p>
    </div>
    <div class="flex flex-wrap justify-center gap-2 sm:gap-3 mb-8 sm:mb-12" data-aos="fade-up">
      <button onclick="filterFAQ('all',event)"         class="faq-filter-btn active px-4 sm:px-6 py-2 rounded-full font-semibold text-sm transition" data-i18n="faq_filter_all">Tout</button>
      <button onclick="filterFAQ('produits',event)"    class="faq-filter-btn px-4 sm:px-6 py-2 rounded-full font-semibold text-sm transition" data-i18n="faq_filter_products">Produits</button>
      <button onclick="filterFAQ('deploiement',event)" class="faq-filter-btn px-4 sm:px-6 py-2 rounded-full font-semibold text-sm transition" data-i18n="faq_filter_deployment">Déploiement</button>
      <button onclick="filterFAQ('securite',event)"    class="faq-filter-btn px-4 sm:px-6 py-2 rounded-full font-semibold text-sm transition" data-i18n="faq_filter_security">Sécurité</button>
      <button onclick="filterFAQ('tarification',event)"class="faq-filter-btn px-4 sm:px-6 py-2 rounded-full font-semibold text-sm transition" data-i18n="faq_filter_pricing">Tarification</button>
    </div>
    <div class="max-w-4xl mx-auto space-y-3 sm:space-y-4">
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
        <button class="faq-question w-full text-left bg-slate-50 hover:bg-slate-100 p-4 sm:p-6 rounded-xl transition flex items-center justify-between gap-4"
                aria-expanded="false">
          <span class="font-semibold text-base sm:text-lg" data-i18n="<?=$f[1]?>"><?=$f[2]?></span>
          <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600 flex-shrink-0 transition-transform faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div class="faq-answer hidden bg-white p-4 sm:p-6 rounded-b-xl border-l-4 border-blue-600">
          <p class="text-slate-600 leading-relaxed text-sm sm:text-base" data-i18n="<?=$f[3]?>"><?=$f[4]?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-10 sm:mt-16" data-aos="fade-up">
      <p class="text-slate-600 mb-4 sm:mb-6 text-sm sm:text-base" data-i18n="faq_cta_text">Vous ne trouvez pas la réponse à votre question ?</p>
      <a href="#contact" class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-xl font-semibold hover:bg-blue-700 transition" data-i18n="faq_cta_button">📞 Contactez-nous</a>
    </div>
  </div>
</section>

<!-- ── VIDEO ────────────────────────────────────────────────── -->
<section class="py-16 sm:py-24 relative overflow-hidden">
  <div class="absolute inset-0 z-0" aria-hidden="true">
    <img src="/develop-it.gif" alt="" class="w-full h-full object-cover" loading="lazy">
    <div class="absolute inset-0 bg-gradient-to-r from-slate-900/95 via-slate-900/85 to-slate-900/95"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-slate-900/80 via-transparent to-slate-900/80"></div>
  </div>
  <div class="max-w-6xl mx-auto px-4 sm:px-6 relative z-10">
    <div class="text-center mb-8 sm:mb-12" data-aos="zoom-in">
      <div class="inline-block bg-slate-900/90 backdrop-blur-md px-6 sm:px-8 py-4 sm:py-6 rounded-2xl border border-blue-500/30 shadow-2xl mb-6 sm:mb-8">
        <h2 class="text-2xl sm:text-4xl md:text-5xl font-bold mb-3 sm:mb-4 text-white" data-i18n="video_title">L'innovation au service de votre croissance</h2>
        <p class="text-base sm:text-xl text-blue-200 max-w-3xl mx-auto leading-relaxed" data-i18n="video_description">Découvrez comment <strong class="text-white">develop-it</strong> transforme les idées en solutions digitales performantes</p>
      </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mt-8 sm:mt-16">
      <div class="bg-slate-900/90 backdrop-blur-md p-6 sm:p-8 rounded-2xl border border-blue-500/30 shadow-xl" data-aos="fade-up">
        <div class="text-4xl sm:text-5xl mb-3 sm:mb-4">🚀</div>
        <h3 class="text-lg sm:text-xl font-bold mb-2 sm:mb-3 text-white" data-i18n="service_1_title">Innovation Continue</h3>
        <p class="text-blue-200 leading-relaxed text-sm sm:text-base" data-i18n="service_1_description">Technologies de pointe et méthodologies agiles pour des solutions toujours à la hauteur</p>
      </div>
      <div class="bg-slate-900/90 backdrop-blur-md p-6 sm:p-8 rounded-2xl border border-blue-500/30 shadow-xl" data-aos="fade-up" data-aos-delay="100">
        <div class="text-4xl sm:text-5xl mb-3 sm:mb-4">⚡</div>
        <h3 class="text-lg sm:text-xl font-bold mb-2 sm:mb-3 text-white" data-i18n="service_2_title">Performance Optimale</h3>
        <p class="text-blue-200 leading-relaxed text-sm sm:text-base" data-i18n="service_2_description">Applications rapides, sécurisées et évolutives conçues pour durer dans le temps</p>
      </div>
      <div class="bg-slate-900/90 backdrop-blur-md p-6 sm:p-8 rounded-2xl border border-blue-500/30 shadow-xl" data-aos="fade-up" data-aos-delay="200">
        <div class="text-4xl sm:text-5xl mb-3 sm:mb-4">🎯</div>
        <h3 class="text-lg sm:text-xl font-bold mb-2 sm:mb-3 text-white" data-i18n="service_3_title">Accompagnement Expert</h3>
        <p class="text-blue-200 leading-relaxed text-sm sm:text-base" data-i18n="service_3_description">Équipe dédiée à vos côtés du concept à la mise en production et au-delà</p>
      </div>
    </div>
  </div>
</section>

<!-- ── SERVICES ──────────────────────────────────────────────── -->
<section class="bg-slate-50 py-16 sm:py-24">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">
    <div class="text-center mb-12 sm:mb-16" data-aos="fade-up">
      <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider" data-i18n="services">Services</span>
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mt-3 mb-6" data-i18n="expertise">Nos domaines d'expertise</h2>
    </div>
    <!-- MOBILE FIX: services-grid — 1 col mobile, 2 tablet, 3 desktop -->
    <div class="services-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-8">
      <?php
      $svcs=[
        ['🌐','border-blue-500','service_4_title','Développement Web','service_4_description','Applications PHP, Laravel, Node.js, React, Vue.js. Plateformes SaaS évolutives et performantes développées par DEVELOP IT.'],
        ['📱','border-purple-500','service_5_title','Applications Mobile','service_5_description','Solutions Android & iOS natives et multiplateformes. Expériences utilisateur exceptionnelles.'],
        ['🤖','border-cyan-500','service_6_title','Intelligence Artificielle','service_6_description','Analyse de données, automatisation intelligente, machine learning, IA métier sur mesure.'],
        ['☁️','border-green-500','service_7_title','Cloud & DevOps','service_7_description','Déploiement, infrastructure cloud, CI/CD, monitoring, sécurité et optimisation des performances.'],
        ['🔐','border-red-500','service_8_title','Cybersécurité','service_8_description','Protection des données, audits de sécurité, conformité RGPD, tests d\'intrusion.'],
        ['📊','border-indigo-500','service_9_title','ERP & Logiciels métiers','service_9_description','Solutions internes sur mesure, digitalisation des processus, automatisation métier.'],
      ];
      foreach($svcs as $i=>$s): ?>
      <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg card-hover border-t-4 <?=$s[1]?>" data-aos="fade-up" data-aos-delay="<?=$i*50?>">
        <div class="text-4xl sm:text-5xl mb-3 sm:mb-4"><?=$s[0]?></div>
        <h3 class="text-xl sm:text-2xl font-bold mb-2 sm:mb-3" data-i18n="<?=$s[2]?>"><?=$s[3]?></h3>
        <p class="text-slate-600 leading-relaxed text-sm sm:text-base" data-i18n="<?=$s[4]?>"><?=$s[5]?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── SOLUTIONS IA ──────────────────────────────────────────── -->
<section id="solutions" class="py-16 sm:py-24 bg-gradient-to-br from-slate-900 via-blue-950 to-purple-950 text-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">
    <div class="text-center mb-10 sm:mb-14" data-aos="fade-up">
      <div class="inline-flex items-center gap-2 bg-purple-500/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm mb-4 border border-purple-400/30">
        <span class="relative flex h-2.5 w-2.5"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-purple-500"></span></span>
        <span class="text-purple-200" data-i18n="ai_section_badge">Propulsé par l'Intelligence Artificielle</span>
      </div>
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mt-3 mb-4" data-i18n="ai_solutions_title">Nos solutions IA</h2>
      <p class="text-slate-300 text-base sm:text-lg max-w-3xl mx-auto" data-i18n="ai_solutions_desc">Agents intelligents, automatisation et génération de contenu — l'IA au service de votre croissance</p>
    </div>
    <?php
    $ai_sols=[
      ['🤖','from-purple-600 to-pink-600','sol3_title','Auto-Post AI Studio','sol3_badge','IA','sol3_desc','Génération de contenu IA, publication multi-réseaux sociaux et planification intelligente.','auto_post_ai.php','sol3_cta','En savoir plus','border-purple-500/30'],
      ['🔥','from-red-600 to-orange-600','trenddrop_title','TrendDrop','trenddrop_badge','IA Drop','trenddrop_desc','Détection produits gagnants via Google Trends & TikTok. Génération pubs, scripts vidéo et pages Shopify.','trenddrop.php','trenddrop_cta','Découvrir TrendDrop','border-red-500/30'],
      ['⚽','from-red-700 to-rose-600','malab_title','Malab Live','malab_badge','IA Sports','malab_desc','Agent IA qui collecte matchs, scrape les liens streaming et publie sur Facebook toutes les 15 min.','stream_agent.php','malab_cta','Découvrir Malab Live','border-rose-500/30'],
      ['🧠','from-yellow-600 to-amber-600','sol_sa_title','Strategic Architect','sol_sa_badge','IA Coach','sol_sa_desc','Coach IA qui identifie vos blocages via diagnostic 5 rounds et construit un plan d\'action 90 jours.','strategic_architect.php','sol_sa_cta','Démarrer le diagnostic','border-yellow-500/30'],
      ['⚡','from-violet-600 to-indigo-600','repurzel_title','Repurzel','repurzel_badge','IA Creator','repurzel_desc','Transformez un contenu en 5 posts prêts pour Twitter, TikTok, Instagram, Email et LinkedIn.','repurzle.php','repurzel_cta','Découvrir Repurzel','border-violet-500/30'],
      ['🎯','from-green-600 to-emerald-600','leadhunter_title','Lead Hunter','leadhunter_badge','Lead Gen IA','leadhunter_desc','Pipeline IA qui scrape Facebook, qualifie l\'intention d\'achat et livre les leads scorés sur Telegram.','leads_generator.php','leadhunter_cta','Découvrir Lead Hunter','border-green-500/30'],
      ['📊','from-rose-600 to-pink-600','recovpro_title','RecovPro','recovpro_badge','FinTech IA','recovpro_desc','Réduisez vos impayés de 25% à moins de 5% du CA grâce au scoring IA et relances automatiques.','recovpro.php','recovpro_cta','Découvrir RecovPro','border-rose-500/30'],
      ['✈️','from-sky-600 to-cyan-600','wandrly_title','Wandrly','wandrly_badge','IA Travel','wandrly_desc','Planificateur de voyages IA : itinéraires personnalisés, budget optimisé, réservations et recommandations intelligentes.','wandrly.php','wandrly_cta','Découvrir Wandrly','border-sky-500/30'],
      ['✨','from-pink-500 to-fuchsia-600','glowai_title','GlowAI','glowai_badge','IA Beauty','glowai_desc','Diagnostic beauté par IA : analyse de peau, routines personnalisées, recommandations produits et suivi des progrès.','glowai.php','glowai_cta','Découvrir GlowAI','border-pink-500/30'],
    ];
    ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
      <?php foreach($ai_sols as $i=>$s): ?>
      <div class="bg-white/5 backdrop-blur-sm rounded-2xl border <?=$s[11]?> overflow-hidden hover:bg-white/10 hover:-translate-y-1 transition-all duration-300 flex flex-col" data-aos="fade-up" data-aos-delay="<?=$i*60?>">
        <div class="p-5 sm:p-6 flex flex-col flex-1 gap-3">
          <div class="flex items-center gap-3">
            <div class="w-11 h-11 bg-gradient-to-br <?=$s[1]?> rounded-xl flex items-center justify-center text-white text-xl flex-shrink-0 shadow-lg"><?=$s[0]?></div>
            <div>
              <h3 class="font-bold text-base sm:text-lg text-white" data-i18n="<?=$s[2]?>"><?=$s[3]?></h3>
              <span class="text-xs font-semibold text-purple-300 uppercase tracking-wider" data-i18n="<?=$s[4]?>"><?=$s[5]?></span>
            </div>
          </div>
          <p class="text-slate-300 text-xs sm:text-sm leading-relaxed flex-1" data-i18n="<?=$s[6]?>"><?=$s[7]?></p>
          <a href="<?=$s[8]?>" class="inline-flex items-center gap-1 text-purple-300 font-semibold text-xs sm:text-sm hover:text-white hover:gap-2 transition-all" data-i18n="<?=$s[9]?>">
            <?=$s[10]?> <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
          </a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── SOLUTIONS MÉTIER ────────────────────────────────────── -->
<section class="py-16 sm:py-24 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">
    <div class="text-center mb-10 sm:mb-14" data-aos="fade-up">
      <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider" data-i18n="business_section_badge">Solutions Métier</span>
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mt-3 mb-4" data-i18n="business_solutions_title">ERP & logiciels de gestion</h2>
      <p class="text-slate-600 text-base sm:text-lg max-w-3xl mx-auto" data-i18n="business_solutions_desc">Des outils robustes pour piloter votre activité au quotidien</p>
    </div>
    <?php
    $biz_sols=[
      ['https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=400&q=60','border-teal-500','sol1_title','GESCOM ERP','sol1_badge','ERP','sol1_desc','Solution ERP complète : comptabilité multi-devises, stocks, CRM, finances et Business Intelligence.','ges_com.php','sol1_cta','Découvrir la solution'],
      ['https://images.unsplash.com/photo-1553877522-43269d4ea984?w=400&q=60','border-blue-500','sol2_title','HR Manager','sol2_badge','RH','sol2_desc','Pointage GPS et gestion RH : présence temps réel, congés, rapports et tableaux de bord analytiques.','solution_pointage.php','sol2_cta','Découvrir la solution'],
      ['https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=400&q=60','border-orange-500','sol4_title','BTP Manager','sol4_badge','BTP','sol4_desc','ERP sectoriel BTP : gestion de projets, stocks, finances, personnel et comptabilité temps réel.','btp_manager.php','sol4_cta','Découvrir la solution'],
    ];
    ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-8">
      <?php foreach($biz_sols as $i=>$s): ?>
      <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col border-t-4 <?=$s[1]?>" data-aos="fade-up" data-aos-delay="<?=$i*80?>">
        <div class="relative overflow-hidden">
          <img src="<?=$s[0]?>" loading="lazy" width="400" height="176"
               class="w-full h-40 sm:h-44 object-cover brightness-75"
               alt="<?=htmlspecialchars($s[3])?>">
          <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent" aria-hidden="true"></div>
          <span class="absolute top-3 right-3 text-xs font-semibold px-3 py-1 rounded-full bg-white/15 text-white border border-white/25 backdrop-blur-sm" data-i18n="<?=$s[4]?>"><?=$s[5]?></span>
          <h3 class="absolute bottom-3 left-4 text-white font-bold text-sm sm:text-base" data-i18n="<?=$s[2]?>"><?=$s[3]?></h3>
        </div>
        <div class="p-5 flex flex-col flex-1 gap-2 sm:gap-3">
          <p class="text-slate-600 text-xs sm:text-sm leading-relaxed flex-1" data-i18n="<?=$s[6]?>"><?=$s[7]?></p>
          <a href="<?=$s[8]?>" class="inline-flex items-center gap-1 text-blue-600 font-semibold text-xs sm:text-sm hover:gap-2 transition-all" data-i18n="<?=$s[9]?>">
            <?=$s[10]?> <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
          </a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <!-- Custom project CTA -->
    <div class="mt-8 sm:mt-12 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 p-8 sm:p-10 text-center" data-aos="fade-up">
      <div class="text-5xl mb-4">💡</div>
      <h3 class="text-lg sm:text-xl font-bold mb-3 text-slate-700" data-i18n="sol5_title">Votre projet sur mesure</h3>
      <p class="text-slate-500 text-sm mb-6 max-w-lg mx-auto" data-i18n="sol5_desc">Nous développons des solutions personnalisées adaptées à vos besoins spécifiques</p>
      <a href="#contact" class="bg-slate-800 text-white px-6 sm:px-8 py-3 rounded-xl font-semibold hover:bg-slate-700 transition text-sm" data-i18n="sol5_cta">Discutons de votre projet</a>
    </div>
  </div>
</section>

<!-- ── BLOG ─────────────────────────────────────────────────── -->
<section class="py-16 sm:py-24 bg-slate-50" id="blog">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">
    <div class="text-center mb-8 sm:mb-12" data-aos="fade-up">
      <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider">Blog</span>
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mt-3 mb-4">Actualités & Insights</h2>
      <p class="text-slate-600 text-base sm:text-lg max-w-2xl mx-auto">Tendances tech, IA et transformation digitale — par l'équipe DEVELOP IT</p>
    </div>
    <div class="grid md:grid-cols-3 gap-5 sm:gap-8" data-aos="fade-up" data-aos-delay="100">
      <?php if($featured): ?>
      <div class="md:col-span-2 bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-slate-100 flex flex-col">
        <div class="relative overflow-hidden">
          <img src="<?=htmlspecialchars($featured['cover_image']?:'https://images.unsplash.com/photo-1677442135703-1787eea5ce01?w=800&q=60')?>"
               loading="lazy" width="800" height="256"
               class="w-full h-48 sm:h-64 object-cover"
               alt="<?=htmlspecialchars($featured['title'])?>">
          <span class="absolute top-4 left-4 bg-blue-600 text-white text-xs font-semibold px-3 py-1 rounded-full">À la une</span>
        </div>
        <div class="p-5 sm:p-7 flex flex-col flex-1">
          <p class="text-xs text-slate-400 mb-2"><?=date('d M Y',strtotime($featured['created_at']))?></p>
          <h3 class="text-xl sm:text-2xl font-bold mb-3 text-slate-800 leading-tight"><?=htmlspecialchars($featured['title'])?></h3>
          <p class="text-slate-500 leading-relaxed flex-1 text-sm sm:text-base"><?=htmlspecialchars(mb_substr($featured['excerpt'],0,180))?>...</p>
          <a href="blog/post.php?slug=<?=urlencode($featured['slug'])?>" class="mt-4 sm:mt-5 inline-flex items-center gap-2 text-blue-600 font-semibold text-sm hover:gap-3 transition-all">
            Lire l'article <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
          </a>
        </div>
      </div>
      <?php endif; ?>
      <div class="flex flex-col gap-4 sm:gap-5">
        <?php foreach($blogs as $post): ?>
        <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 flex gap-3 sm:gap-4 p-3 sm:p-4">
          <img src="<?=htmlspecialchars($post['cover_image']?:'https://images.unsplash.com/photo-1677442135703-1787eea5ce01?w=200&q=60')?>"
               loading="lazy" width="80" height="80"
               class="w-16 h-16 sm:w-20 sm:h-20 object-cover rounded-xl flex-shrink-0"
               alt="<?=htmlspecialchars($post['title'])?>">
          <div class="flex flex-col justify-center gap-1 min-w-0">
            <p class="text-xs text-slate-400"><?=date('d M Y',strtotime($post['created_at']))?></p>
            <h4 class="font-bold text-xs sm:text-sm text-slate-800 leading-snug line-clamp-2"><?=htmlspecialchars($post['title'])?></h4>
            <a href="blog/post.php?slug=<?=urlencode($post['slug'])?>" class="text-blue-600 text-xs font-semibold hover:underline">Lire →</a>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="text-center mt-8 sm:mt-10" data-aos="fade-up">
      <a href="blog/" class="inline-flex items-center gap-2 border-2 border-slate-800 text-slate-800 px-6 sm:px-8 py-3 rounded-xl font-semibold hover:bg-slate-800 hover:text-white transition text-sm sm:text-base">
        Voir tous les articles <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
      </a>
    </div>
  </div>
</section>

<!-- ── TECH ─────────────────────────────────────────────────── -->
<section class="py-16 sm:py-24 bg-slate-900 text-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">
    <div class="text-center mb-12 sm:mb-16" data-aos="fade-up">
      <span class="text-blue-400 font-semibold text-sm uppercase tracking-wider" data-i18n="tech_label">Stack Technologique</span>
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mt-3 mb-6" data-i18n="tech_title">Technologies maîtrisées par DEVELOP IT</h2>
    </div>
    <div class="grid grid-cols-3 md:grid-cols-6 gap-4 sm:gap-8">
      <?php foreach([['⚛️','React','react'],['📱','Node.js','nodejs'],['🐘','PHP/Laravel','php'],['🐍','Python','python'],['🎯','TypeScript','typescript'],['☁️','AWS/Azure','aws']] as $i=>$t): ?>
      <div class="flex flex-col items-center gap-2 sm:gap-3 p-4 sm:p-6 bg-white/5 rounded-xl hover:bg-white/10 transition" data-aos="zoom-in" data-aos-delay="<?=$i*50?>">
        <div class="text-3xl sm:text-4xl"><?=$t[0]?></div>
        <span class="font-semibold text-xs sm:text-base text-center" data-i18n="<?=$t[2]?>"><?=$t[1]?></span>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── TESTIMONIALS ─────────────────────────────────────────── -->
<section class="py-16 sm:py-24 bg-slate-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">
    <div class="text-center mb-12 sm:mb-16" data-aos="fade-up">
      <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider" data-i18n="testi_label">Témoignages</span>
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mt-3 mb-6" data-i18n="testi_title">Ce que disent nos clients de DEVELOP IT</h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 sm:gap-8">
      <?php
      $ts=[
        ['AM','blue','testi1_name','Ahmed M.','testi1_title','CEO, TechStart','testi1_text','"Une équipe exceptionnelle qui a transformé notre vision en réalité. Le projet a été livré dans les temps avec une qualité irréprochable."'],
        ['SK','purple','testi2_name','Sarah K.','testi2_title','Directrice Marketing','testi2_text','"Professionnalisme et expertise technique au rendez-vous. Notre application mobile a dépassé toutes nos attentes."'],
        ['YB','cyan','testi3_name','Youssef B.','testi3_title','COO, InnovCorp','testi3_text','"L\'intégration de l\'IA dans nos processus a révolutionné notre productivité. Un investissement qui en valait vraiment la peine."'],
      ];
      foreach($ts as $i=>$t): ?>
      <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg card-hover" data-aos="fade-up" data-aos-delay="<?=$i*100?>">
        <div class="flex gap-1 mb-4" aria-label="5 étoiles sur 5" role="img">⭐⭐⭐⭐⭐</div>
        <p class="text-slate-600 mb-5 italic leading-relaxed text-sm sm:text-base" data-i18n="<?=$t[6]?>"><?=$t[7]?></p>
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 sm:w-12 sm:h-12 bg-<?=$t[1]?>-100 rounded-full flex items-center justify-center text-<?=$t[1]?>-600 font-bold text-sm" aria-hidden="true"><?=$t[0]?></div>
          <div>
            <div class="font-semibold text-sm sm:text-base" data-i18n="<?=$t[2]?>"><?=$t[3]?></div>
            <div class="text-xs sm:text-sm text-slate-500" data-i18n="<?=$t[4]?>"><?=$t[5]?></div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── CONTACT ───────────────────────────────────────────────── -->
<section id="contact" class="bg-gradient-to-br from-slate-900 via-blue-900 to-purple-900 text-white py-16 sm:py-24">
  <div class="max-w-5xl mx-auto px-4 sm:px-6">
    <div class="text-center mb-8 sm:mb-12" data-aos="fade-up">
      <span class="text-blue-300 font-semibold text-sm uppercase tracking-wider" data-i18n="contact_label">Contact</span>
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mt-3 mb-6" data-i18n="contact_title">Parlons de votre projet avec develop-it</h2>
      <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto" data-i18n="contact_desc">Vous avez un projet digital ou souhaitez intégrer l'IA dans votre entreprise ?<br>Nous sommes là pour vous accompagner.</p>
    </div>
    <!-- MOBILE FIX: contact-grid — 1 col mobile, 2 desktop -->
    <div class="contact-grid grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-8 mt-8 sm:mt-16">
      <div class="bg-white/10 backdrop-blur-sm p-6 sm:p-8 rounded-2xl border border-white/20 card-hover" data-aos="fade-right">
        <div class="text-4xl mb-3">📧</div>
        <h3 class="text-lg sm:text-xl font-bold mb-2">Email</h3>
        <p class="text-slate-300 mb-3 text-sm sm:text-base" data-i18n="contact_email_desc">Contactez-nous par email</p>
        <a href="mailto:contact@develop-it.tech" class="text-blue-300 hover:text-blue-200 font-semibold break-all text-sm sm:text-base">contact@develop-it.tech</a>
      </div>
      <div class="bg-white/10 backdrop-blur-sm p-6 sm:p-8 rounded-2xl border border-white/20 card-hover" data-aos="fade-left">
        <div class="text-4xl mb-3">📞</div>
        <h3 class="text-lg sm:text-xl font-bold mb-2">Téléphone</h3>
        <p class="text-slate-300 mb-3 text-sm sm:text-base" data-i18n="contact_phone_desc">Appelez-nous directement</p>
        <a href="tel:+2120611191926" class="text-blue-300 hover:text-blue-200 font-semibold text-sm sm:text-base">+212 06 11 19 19 26</a>
      </div>
    </div>

    <div class="mt-8 sm:mt-12 bg-white/5 backdrop-blur-sm p-6 sm:p-12 rounded-2xl border border-white/20" data-aos="fade-up" data-aos-delay="200">
      <h3 class="text-xl sm:text-2xl font-bold mb-5 sm:mb-6 text-center" data-i18n="contact_form_title">Envoyez-nous un message</h3>

      <?php if(!empty($success_message)): ?>
      <div class="mb-6 bg-green-500/20 border border-green-400/50 text-green-200 px-4 sm:px-6 py-4 rounded-xl flex items-center gap-3" role="alert">
        <svg class="w-5 h-5 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span class="text-sm sm:text-base"><?=htmlspecialchars($success_message)?></span>
      </div>
      <script>gtag('event','conversion',{'send_to':'AW-18017749346/k91ZCOqjjYkcEOKSxI9D'});</script>
      <?php endif; ?>
      <?php if(!empty($error_message)): ?>
      <div class="mb-6 bg-red-500/20 border border-red-400/50 text-red-200 px-4 sm:px-6 py-4 rounded-xl flex items-center gap-3" role="alert">
        <svg class="w-5 h-5 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span class="text-sm sm:text-base"><?=htmlspecialchars($error_message)?></span>
      </div>
      <?php endif; ?>

      <!-- ACCESSIBILITY FIX: explicit for/id on labels -->
      <form method="POST" action="#contact" class="space-y-4 sm:space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
          <div>
            <label for="f_name" class="block text-sm font-semibold mb-2" data-i18n="contact_name_label">Nom complet *</label>
            <input id="f_name" type="text" name="name" required autocomplete="name"
                   value="<?=htmlspecialchars($_POST['name']??'')?>"
                   class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-slate-400 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400/50 transition text-sm sm:text-base"
                   placeholder="Votre nom" data-i18n-placeholder="contact_name_ph">
          </div>
          <div>
            <label for="f_email" class="block text-sm font-semibold mb-2" data-i18n="contact_email_label">Email *</label>
            <input id="f_email" type="email" name="email" required autocomplete="email"
                   value="<?=htmlspecialchars($_POST['email']??'')?>"
                   class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-slate-400 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400/50 transition text-sm sm:text-base"
                   placeholder="votre@email.com">
          </div>
        </div>
        <div>
          <label for="f_subject" class="block text-sm font-semibold mb-2" data-i18n="contact_subject_label">Sujet *</label>
          <input id="f_subject" type="text" name="subject" required
                 value="<?=htmlspecialchars($_POST['subject']??'')?>"
                 class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-slate-400 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400/50 transition text-sm sm:text-base"
                 placeholder="Comment pouvons-nous vous aider?" data-i18n-placeholder="contact_subject_ph">
        </div>
        <div>
          <label for="f_message" class="block text-sm font-semibold mb-2" data-i18n="contact_msg_label">Message *</label>
          <textarea id="f_message" name="message" rows="5" required
                    class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-slate-400 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400/50 transition resize-none text-sm sm:text-base"
                    placeholder="Décrivez votre projet..." data-i18n-placeholder="contact_msg_ph"><?=htmlspecialchars($_POST['message']??'')?></textarea>
        </div>
        <div class="text-center">
          <button type="submit" name="submit_contact"
                  class="bg-white text-slate-900 px-6 sm:px-8 py-3 sm:py-4 rounded-xl font-semibold hover:bg-slate-100 transition transform hover:scale-105 shadow-lg text-sm sm:text-base"
                  data-i18n="contact_submit">
            🚀 Envoyer le message
          </button>
        </div>
      </form>
    </div>
  </div>
</section>

</main>

<!-- ── FOOTER ────────────────────────────────────────────────── -->
<footer class="bg-black text-slate-400 py-10 sm:py-12" role="contentinfo">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">
    <!-- MOBILE FIX: footer-grid — 2 col mobile, 4 desktop -->
    <div class="footer-grid grid grid-cols-2 md:grid-cols-4 gap-6 sm:gap-8 mb-6 sm:mb-8">
      <div class="col-span-2 md:col-span-1">
        <div class="flex items-center gap-2 mb-4">
          <img src="/logo.jfif" alt="DEVELOP IT" width="32" height="32" class="w-7 h-7 sm:w-8 sm:h-8 rounded-sm object-cover">
          <h3 class="text-white font-bold text-base sm:text-lg">DEVELOP IT</h3>
        </div>
        <p class="text-xs sm:text-sm leading-relaxed" data-i18n="footer_desc">Agence de développement informatique et intelligence artificielle basée au Maroc.</p>
      </div>
      <div>
        <h4 class="text-white font-semibold mb-3 sm:mb-4 text-sm sm:text-base" data-i18n="footer_services">Services</h4>
        <ul class="space-y-1 sm:space-y-2 text-xs sm:text-sm">
          <li><a href="#" class="hover:text-white transition" data-i18n="footer_svc1">Développement Web</a></li>
          <li><a href="#" class="hover:text-white transition" data-i18n="footer_svc2">Applications Mobile</a></li>
          <li><a href="#" class="hover:text-white transition" data-i18n="footer_svc3">Intelligence Artificielle</a></li>
          <li><a href="#" class="hover:text-white transition" data-i18n="footer_svc4">Cloud & DevOps</a></li>
        </ul>
      </div>
      <div>
        <h4 class="text-white font-semibold mb-3 sm:mb-4 text-sm sm:text-base" data-i18n="footer_solutions">Solutions</h4>
        <ul class="space-y-1 sm:space-y-2 text-xs sm:text-sm">
          <li><a href="ges_com.php"             class="hover:text-white transition">GESCOM ERP</a></li>
          <li><a href="solution_pointage.php"   class="hover:text-white transition">HR Manager</a></li>
          <li><a href="auto_post_ai.php"        class="hover:text-white transition">Auto-Post AI</a></li>
          <li><a href="btp_manager.php"         class="hover:text-white transition">BTP Manager</a></li>
          <li><a href="stream_agent.php"        class="hover:text-white transition">ملعب لايف</a></li>
          <li><a href="strategic_architect.php" class="hover:text-white transition">Strategic Architect</a></li>
          <li><a href="repurzle.php"            class="hover:text-white transition">Repurzel</a></li>
          <li><a href="leads_generator.php"     class="hover:text-white transition">Lead Hunter</a></li>
          <li><a href="recovpro.php"            class="hover:text-white transition">RecovPro</a></li>
        </ul>
      </div>
      <div>
        <h4 class="text-white font-semibold mb-3 sm:mb-4 text-sm sm:text-base" data-i18n="footer_follow">Suivez-nous</h4>
        <div class="flex gap-3 sm:gap-4">
          <a href="#" class="w-9 h-9 sm:w-10 sm:h-10 bg-slate-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition" aria-label="Nous suivre sur Facebook">
            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
          </a>
          <a href="#" class="w-9 h-9 sm:w-10 sm:h-10 bg-slate-800 rounded-full flex items-center justify-center hover:bg-blue-400 transition" aria-label="Nous suivre sur Twitter">
            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
          </a>
          <a href="#" class="w-9 h-9 sm:w-10 sm:h-10 bg-slate-800 rounded-full flex items-center justify-center hover:bg-blue-700 transition" aria-label="Nous suivre sur LinkedIn">
            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
          </a>
        </div>
      </div>
    </div>
    <div class="border-t border-slate-800 pt-6 sm:pt-8 text-center text-xs sm:text-sm">
      <p data-i18n="footer_copy">© 2026 <strong>DEVELOP IT</strong> | Développement Informatique & Intelligence Artificielle | Tous droits réservés</p>
    </div>
  </div>
</footer>

<!-- ═══ PERF: AOS deferred — disable on mobile to eliminate reflow ═══ -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js" defer></script>
<script>
document.addEventListener('DOMContentLoaded',function(){
  if(typeof AOS!=='undefined') AOS.init({duration:800,once:true,offset:60,disable:'mobile'});

  // FAQ Accordion
  document.querySelectorAll('.faq-question').forEach(btn=>{
    btn.addEventListener('click',()=>{
      const item=btn.parentElement,ans=btn.nextElementSibling,wasActive=item.classList.contains('active');
      document.querySelectorAll('.faq-item').forEach(i=>{
        i.classList.remove('active');
        i.querySelector('.faq-answer').classList.add('hidden');
        i.querySelector('.faq-question').setAttribute('aria-expanded','false');
      });
      if(!wasActive){item.classList.add('active');ans.classList.remove('hidden');btn.setAttribute('aria-expanded','true');}
    });
  });

  // Init language
  const saved=localStorage.getItem('lang');
  if(saved&&saved!=='fr'){
    const btn=document.querySelector('.lang-btn[onclick="setLang(\''+saved+'\',this)"]');
    if(btn) setLang(saved,btn);
  } else {
    setLang('fr',document.querySelector('.lang-btn.active'));
  }
});

function filterFAQ(cat,e){
  document.querySelectorAll('.faq-filter-btn').forEach(b=>b.classList.remove('active'));
  if(e&&e.target)e.target.classList.add('active');
  document.querySelectorAll('.faq-item').forEach(item=>{
    const show=cat==='all'||item.dataset.category===cat;
    item.style.display=show?'block':'none';
    if(!show){item.classList.remove('active');item.querySelector('.faq-answer').classList.add('hidden');}
  });
}

/* ─── Translations ─────────────────────────────────────────── */
const T={
fr:{
  nav_about:'À propos',nav_solutions:'Solutions',nav_blog:'Blog',nav_faq:'FAQ',nav_contact:'Contact',
  hero_badge:'✨ Innovation & Excellence depuis 2014',
  hero_h1_line:'Votre partenaire en',hero_h1_gradient:'Transformation Digitale & IA',
  hero_desc:'Depuis plus de <strong class="text-blue-300">10 ans</strong>, <strong class="text-blue-300">DEVELOP IT</strong> accompagne les entreprises dans la conception de solutions informatiques innovantes, performantes et évolutives au Maroc et à l\'international.',
  hero_cta1:'🚀 Démarrer un projet',hero_cta2:'Découvrir nos solutions',
  stat1:'Projets réalisés',stat2:'Satisfaction client',stat3:'Support disponible',
  about_label:'Notre expertise',about_title:'DEVELOP IT: Une expertise solide, orientée résultats',
  about_desc:'<strong class="text-blue-600">DEVELOP IT</strong> est une agence de développement informatique spécialisée dans la création de solutions digitales sur mesure. Notre mission est d\'aider les entreprises à réussir leur transformation digitale en intégrant les technologies modernes, y compris l\'<strong class="text-blue-600">Intelligence Artificielle</strong>.',
  about_years:'Années',about_experience:'d\'expérience dans le développement',
  about_web_mobile:'Web & Mobile',about_web_mobile_desc:'Applications modernes et performantes',
  about_ai_data:'IA & Data',about_ai_data_desc:'Automatisation intelligente',
  about_custom:'Sur mesure',about_custom_desc:'Adapté à vos besoins spécifiques',
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
  video_title:'L\'innovation au service de votre croissance',video_description:'Découvrez comment <strong class="text-white">develop-it</strong> transforme les idées en solutions digitales performantes',
  service_1_title:'Innovation Continue',service_1_description:'Technologies de pointe et méthodologies agiles pour des solutions toujours à la hauteur',
  service_2_title:'Performance Optimale',service_2_description:'Applications rapides, sécurisées et évolutives conçues pour durer dans le temps',
  service_3_title:'Accompagnement Expert',service_3_description:'Équipe dédiée à vos côtés du concept à la mise en production et au-delà',
  services:'Services',expertise:'Nos domaines d\'expertise',
  service_4_title:'Développement Web',service_4_description:'Applications PHP, Laravel, Node.js, React, Vue.js. Plateformes SaaS évolutives et performantes développées par DEVELOP IT.',
  service_5_title:'Applications Mobile',service_5_description:'Solutions Android & iOS natives et multiplateformes. Expériences utilisateur exceptionnelles.',
  service_6_title:'Intelligence Artificielle',service_6_description:'Analyse de données, automatisation intelligente, machine learning, IA métier sur mesure.',
  service_7_title:'Cloud & DevOps',service_7_description:'Déploiement, infrastructure cloud, CI/CD, monitoring, sécurité et optimisation des performances.',
  service_8_title:'Cybersécurité',service_8_description:'Protection des données, audits de sécurité, conformité RGPD, tests d\'intrusion.',
  service_9_title:'ERP & Logiciels métiers',service_9_description:'Solutions internes sur mesure, digitalisation des processus, automatisation métier.',
  portfolio:'Portfolio',solutions_title:'Nos solutions développées par DEVELOP IT',solutions_description:'Découvrez nos produits innovants qui transforment la façon dont les entreprises travaillent',
  ai_section_badge:'Propulsé par l\'Intelligence Artificielle',ai_solutions_title:'Nos solutions IA',ai_solutions_desc:'Agents intelligents, automatisation et génération de contenu — l\'IA au service de votre croissance',
  business_section_badge:'Solutions Métier',business_solutions_title:'ERP & logiciels de gestion',business_solutions_desc:'Des outils robustes pour piloter votre activité au quotidien',
  sol1_badge:'ERP & Gestion',sol1_title:'GESCOM ERP',sol1_desc:'Solution ERP complète : comptabilité multi-devises, gestion des stocks, CRM, finances et Business Intelligence.',sol1_cta:'Découvrir la solution',
  sol2_badge:'RH & Gestion',sol2_title:'HR Manager',sol2_desc:'Pointage GPS et gestion RH : présence temps réel, congés, rapports et tableaux de bord analytiques.',sol2_cta:'Découvrir la solution',
  sol3_badge:'IA & Automatisation',sol3_title:'Auto-Post AI Studio',sol3_desc:'Génération de contenu IA, publication multi-réseaux sociaux et planification intelligente.',sol3_cta:'En savoir plus',
  sol4_badge:'BTP & Immobilier',sol4_title:'BTP Manager',sol4_desc:'ERP sectoriel BTP : gestion de projets, stocks, finances, personnel et comptabilité temps réel.',sol4_cta:'Découvrir la solution',
  sol5_title:'Votre projet sur mesure',sol5_desc:'Nous développons des solutions personnalisées adaptées à vos besoins spécifiques',sol5_cta:'Discutons de votre projet',
  trenddrop_badge:'🔥 IA Dropshipping',trenddrop_title:'TrendDrop',trenddrop_desc:'Détection produits gagnants via Google Trends & TikTok. Génération pubs, scripts vidéo et pages Shopify.',trenddrop_cta:'Découvrir TrendDrop',
  malab_badge:'🤖 IA Sports',malab_title:'Malab Live',malab_desc:'Agent IA qui collecte matchs, scrape les liens streaming et publie sur Facebook toutes les 15 min.',malab_cta:'Découvrir Malab Live',
  sol_sa_badge:'IA Coach',sol_sa_title:'Strategic Architect',sol_sa_desc:'Coach IA qui identifie vos blocages via diagnostic 5 rounds et construit un plan d\'action 90 jours.',sol_sa_cta:'Démarrer le diagnostic',
  repurzel_badge:'⚡ IA Creator',repurzel_title:'Repurzel',repurzel_desc:'Transformez un contenu en 5 posts prêts pour Twitter, TikTok, Instagram, Email et LinkedIn.',repurzel_cta:'Découvrir Repurzel',
  leadhunter_badge:'🎯 IA Lead Gen',leadhunter_title:'Lead Hunter',leadhunter_desc:'Pipeline IA qui scrape Facebook, qualifie l\'intention d\'achat et livre les leads scorés sur Telegram.',leadhunter_cta:'Découvrir Lead Hunter',
  recovpro_badge:'🤖 IA Powered',recovpro_title:'RecovPro',recovpro_desc:'Réduisez vos impayés de 25% à moins de 5% du CA grâce au scoring IA et relances automatiques.',recovpro_cta:'Découvrir RecovPro',
  wandrly_badge:'✈️ IA Travel',wandrly_title:'Wandrly',wandrly_desc:'Planificateur de voyages IA : itinéraires personnalisés, budget optimisé, réservations et recommandations intelligentes.',wandrly_cta:'Découvrir Wandrly',
  glowai_badge:'✨ IA Beauty',glowai_title:'GlowAI',glowai_desc:'Diagnostic beauté par IA : analyse de peau, routines personnalisées, recommandations produits et suivi des progrès.',glowai_cta:'Découvrir GlowAI',
  tech_label:'Stack Technologique',tech_title:'Technologies maîtrisées par DEVELOP IT',
  react:'React',nodejs:'Node.js',php:'PHP/Laravel',python:'Python',typescript:'TypeScript',aws:'AWS/Azure',
  testi_label:'Témoignages',testi_title:'Ce que disent nos clients de DEVELOP IT',
  testi1_text:'"Une équipe exceptionnelle qui a transformé notre vision en réalité. Le projet a été livré dans les temps avec une qualité irréprochable."',testi1_name:'Ahmed M.',testi1_title:'CEO, TechStart',
  testi2_text:'"Professionnalisme et expertise technique au rendez-vous. Notre application mobile a dépassé toutes nos attentes."',testi2_name:'Sarah K.',testi2_title:'Directrice Marketing',
  testi3_text:'"L\'intégration de l\'IA dans nos processus a révolutionné notre productivité. Un investissement qui en valait vraiment la peine."',testi3_name:'Youssef B.',testi3_title:'COO, InnovCorp',
  contact_label:'Contact',contact_title:'Parlons de votre projet avec develop-it',
  contact_desc:'Vous avez un projet digital ou souhaitez intégrer l\'IA dans votre entreprise ?<br>Nous sommes là pour vous accompagner.',
  contact_email_desc:'Contactez-nous par email',contact_phone_desc:'Appelez-nous directement',
  contact_form_title:'Envoyez-nous un message',
  contact_name_label:'Nom complet *',contact_name_ph:'Votre nom',contact_email_label:'Email *',
  contact_subject_label:'Sujet *',contact_subject_ph:'Comment pouvons-nous vous aider?',
  contact_msg_label:'Message *',contact_msg_ph:'Décrivez votre projet...',contact_submit:'🚀 Envoyer le message',
  footer_desc:'Agence de développement informatique et intelligence artificielle basée au Maroc.',
  footer_services:'Services',footer_solutions:'Solutions',footer_follow:'Suivez-nous',
  footer_svc1:'Développement Web',footer_svc2:'Applications Mobile',footer_svc3:'Intelligence Artificielle',footer_svc4:'Cloud & DevOps',
  footer_copy:'© 2026 <strong>DEVELOP IT</strong> | Développement Informatique & Intelligence Artificielle | Tous droits réservés',
},
en:{
  nav_about:'About',nav_solutions:'Solutions',nav_blog:'Blog',nav_faq:'FAQ',nav_contact:'Contact',
  hero_badge:'✨ Innovation & Excellence since 2014',hero_h1_line:'Your partner in',hero_h1_gradient:'Digital Transformation & AI',
  hero_desc:'For over <strong class="text-blue-300">10 years</strong>, <strong class="text-blue-300">DEVELOP IT</strong> has been helping companies design innovative, high-performance and scalable IT solutions in Morocco and internationally.',
  hero_cta1:'🚀 Start a project',hero_cta2:'Discover our solutions',
  stat1:'Projects completed',stat2:'Client satisfaction',stat3:'Support available',
  about_label:'Our expertise',about_title:'DEVELOP IT: Solid expertise, results-oriented',
  about_desc:'<strong class="text-blue-600">DEVELOP IT</strong> is a software development agency specializing in custom digital solutions. Our mission is to help businesses succeed in their digital transformation by integrating modern technologies, including <strong class="text-blue-600">Artificial Intelligence</strong>.',
  about_years:'Years',about_experience:'of development experience',
  about_web_mobile:'Web & Mobile',about_web_mobile_desc:'Modern and high-performance applications',
  about_ai_data:'AI & Data',about_ai_data_desc:'Intelligent automation',
  about_custom:'Custom',about_custom_desc:'Adapted to your specific needs',
  faq_label:'FAQ',faq_title:'Frequently Asked Questions',faq_desc:'Quickly find answers to the most common questions about DEVELOP IT',
  faq_filter_all:'All',faq_filter_products:'Products',faq_filter_deployment:'Deployment',faq_filter_security:'Security',faq_filter_pricing:'Pricing',
  faq_cta_text:"Can't find the answer to your question?",faq_cta_button:'📞 Contact us',
  faq_q1:'What modules does DEVELOP IT offer?',faq_a1:'DEVELOP IT covers all your needs: full ERP, sales management, invoicing, CRM, HR management, workflow automation, and native integrations with your existing tools.',
  faq_q2:'Can I use only certain modules?',faq_a2:'You are free to choose the modules you need. Our modular approach lets you start small and add features as your needs grow.',
  faq_q3:'How does DEVELOP IT help automate processes?',faq_a3:'Our automation engine lets you create custom workflows without code. You save hours every week by eliminating manual tasks and errors.',
  faq_q4:'How long does the setup take?',faq_a4:'For a small business, 2 to 4 weeks. For a medium-sized company, 6 to 12 weeks depending on complexity.',
  faq_q5:'Do I need to halt operations during implementation?',faq_a5:'No. We deploy in parallel: your old systems continue while we configure DEVELOP IT.',
  faq_q6:'Can DEVELOP IT integrate with our current tools?',faq_a6:'Yes. DEVELOP IT integrates natively with 500+ applications via APIs or pre-built connectors.',
  faq_q7:'Is DEVELOP IT GDPR compliant?',faq_a7:'Yes, fully. We comply with all GDPR obligations: consent, data portability, right to erasure, audit trails.',
  faq_q8:'Where is my data hosted?',faq_a8:'On ISO 27001 and SOC 2 certified European data centers. Automatic geo-redundancy and daily backups included.',
  faq_q9:'How do you manage access rights?',faq_a9:'Granular control by user, role, department. Complete audit trail of all actions.',
  faq_q10:'What is the pricing model?',faq_a10:'Custom subscription based on your needs. You only pay for what you use. Transparent pricing, no hidden fees.',
  faq_q11:'Can I try DEVELOP IT before committing?',faq_a11:'Yes, free personalized demo tailored to your needs. Contact us to schedule a session.',
  faq_q12:'How is ROI calculated?',faq_a12:'Average observed: 4–6 months for small/medium businesses. We provide a personalized ROI calculator with your quote.',
  video_title:'Innovation at the service of your growth',video_description:'Discover how <strong class="text-white">develop-it</strong> transforms ideas into high-performance digital solutions',
  service_1_title:'Continuous Innovation',service_1_description:'Cutting-edge technologies and agile methodologies for solutions always up to the challenge',
  service_2_title:'Optimal Performance',service_2_description:'Fast, secure and scalable applications designed to last over time',
  service_3_title:'Expert Support',service_3_description:'Dedicated team by your side from concept to production and beyond',
  services:'Services',expertise:'Our areas of expertise',
  service_4_title:'Web Development',service_4_description:'PHP, Laravel, Node.js, React, Vue.js applications. Scalable and high-performance SaaS platforms developed by DEVELOP IT.',
  service_5_title:'Mobile Applications',service_5_description:'Native and cross-platform Android & iOS solutions. Exceptional user experiences.',
  service_6_title:'Artificial Intelligence',service_6_description:'Data analysis, intelligent automation, machine learning, custom business AI.',
  service_7_title:'Cloud & DevOps',service_7_description:'Deployment, cloud infrastructure, CI/CD, monitoring, security and performance optimization.',
  service_8_title:'Cybersecurity',service_8_description:'Data protection, security audits, GDPR compliance, penetration testing.',
  service_9_title:'ERP & Business Software',service_9_description:'Custom internal solutions, process digitization, business automation.',
  portfolio:'Portfolio',solutions_title:'Our solutions developed by DEVELOP IT',solutions_description:'Discover our innovative products that transform the way businesses work',
  ai_section_badge:'Powered by Artificial Intelligence',ai_solutions_title:'Our AI solutions',ai_solutions_desc:'Intelligent agents, automation and content generation — AI at the service of your growth',
  business_section_badge:'Business Solutions',business_solutions_title:'ERP & management software',business_solutions_desc:'Robust tools to manage your daily operations',
  sol1_badge:'ERP & Management',sol1_title:'GESCOM ERP',sol1_desc:'Complete ERP solution: multi-currency accounting, inventory management, CRM, finance, and Business Intelligence.',sol1_cta:'Discover the solution',
  sol2_badge:'HR & Management',sol2_title:'HR Manager',sol2_desc:'GPS time-tracking and HR management: real-time attendance, leave management, analytical dashboards.',sol2_cta:'Discover the solution',
  sol3_badge:'AI & Automation',sol3_title:'Auto-Post AI Studio',sol3_desc:'AI content generation, multi-social media publishing and intelligent scheduling.',sol3_cta:'Learn more',
  sol4_badge:'Construction & Real Estate',sol4_title:'BTP Manager',sol4_desc:'Construction ERP: project management, inventory, finance, staff and real-time accounting.',sol4_cta:'Discover the solution',
  sol5_title:'Your custom project',sol5_desc:'We develop personalized solutions adapted to your specific needs',sol5_cta:'Discuss your project',
  trenddrop_badge:'🔥 AI Dropshipping',trenddrop_title:'TrendDrop',trenddrop_desc:'Winning product detection via Google Trends & TikTok. Generates ads, video scripts and Shopify pages.',trenddrop_cta:'Discover TrendDrop',
  malab_badge:'🤖 AI Sports',malab_title:'Malab Live',malab_desc:'AI agent collecting matches and auto-posting to Facebook every 15 min.',malab_cta:'Discover Malab Live',
  sol_sa_badge:'AI Coach',sol_sa_title:'Strategic Architect',sol_sa_desc:'AI coach with 5-round diagnostic and 90-day action plan.',sol_sa_cta:'Start diagnosis',
  repurzel_badge:'⚡ AI Creator',repurzel_title:'Repurzel',repurzel_desc:'Turn one content into 5 posts for Twitter, TikTok, Instagram, Email and LinkedIn.',repurzel_cta:'Discover Repurzel',
  leadhunter_badge:'🎯 AI Lead Gen',leadhunter_title:'Lead Hunter',leadhunter_desc:'AI pipeline scraping Facebook and delivering scored leads on Telegram.',leadhunter_cta:'Discover Lead Hunter',
  recovpro_badge:'🤖 AI Powered',recovpro_title:'RecovPro',recovpro_desc:'Reduce unpaid invoices using AI scoring and automated follow-ups.',recovpro_cta:'Discover RecovPro',
  wandrly_badge:'✈️ AI Travel',wandrly_title:'Wandrly',wandrly_desc:'AI travel planner: personalized itineraries, optimized budgets, bookings and smart recommendations.',wandrly_cta:'Discover Wandrly',
  glowai_badge:'✨ AI Beauty',glowai_title:'GlowAI',glowai_desc:'AI beauty diagnostic: skin analysis, personalized routines, product recommendations and progress tracking.',glowai_cta:'Discover GlowAI',
  tech_label:'Tech Stack',tech_title:'Technologies mastered by DEVELOP IT',
  react:'React',nodejs:'Node.js',php:'PHP/Laravel',python:'Python',typescript:'TypeScript',aws:'AWS/Azure',
  testi_label:'Testimonials',testi_title:'What our clients say about DEVELOP IT',
  testi1_text:'"An exceptional team that turned our vision into reality. The project was delivered on time with impeccable quality."',testi1_name:'Ahmed M.',testi1_title:'CEO, TechStart',
  testi2_text:'"Professionalism and technical expertise at their finest. Our mobile app exceeded all our expectations."',testi2_name:'Sarah K.',testi2_title:'Marketing Director',
  testi3_text:'"Integrating AI into our processes revolutionized our productivity. An investment truly worth making."',testi3_name:'Youssef B.',testi3_title:'COO, InnovCorp',
  contact_label:'Contact',contact_title:"Let's talk about your project with develop-it",
  contact_desc:'Do you have a digital project or want to integrate AI into your business?<br>We are here to help you.',
  contact_email_desc:'Contact us by email',contact_phone_desc:'Call us directly',
  contact_form_title:'Send us a message',
  contact_name_label:'Full name *',contact_name_ph:'Your name',contact_email_label:'Email *',
  contact_subject_label:'Subject *',contact_subject_ph:'How can we help you?',
  contact_msg_label:'Message *',contact_msg_ph:'Describe your project...',contact_submit:'🚀 Send message',
  footer_desc:'Software development agency and artificial intelligence based in Morocco.',
  footer_services:'Services',footer_solutions:'Solutions',footer_follow:'Follow us',
  footer_svc1:'Web Development',footer_svc2:'Mobile Applications',footer_svc3:'Artificial Intelligence',footer_svc4:'Cloud & DevOps',
  footer_copy:'© 2026 <strong>DEVELOP IT</strong> | Software Development & Artificial Intelligence | All rights reserved',
}};

function setLang(lang,btn){
  document.querySelectorAll('.lang-btn').forEach(b=>b.classList.remove('active'));
  if(btn)btn.classList.add('active');
  document.documentElement.lang=lang;
  const t=T[lang]||T.fr;
  document.querySelectorAll('[data-i18n]').forEach(el=>{const k=el.getAttribute('data-i18n');if(t[k]!==undefined)el.innerHTML=t[k];});
  document.querySelectorAll('[data-i18n-placeholder]').forEach(el=>{const k=el.getAttribute('data-i18n-placeholder');if(t[k]!==undefined)el.placeholder=t[k];});
  localStorage.setItem('lang',lang);
}
</script>
<script nowprocket data-noptimize="1" data-cfasync="false" data-wpfc-render="false" seraph-accel-crit="1" data-no-defer="1">
  (function () {
      var script = document.createElement("script");
      script.async = 1;
      script.src = 'https://emrldtp.cc/NTExNzA2.js?t=511706';
      document.head.appendChild(script);
  })();
</script>
</body>
</html>