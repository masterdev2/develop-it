<?php
/**
 * RecovPro - Landing Page
 * Système de Gestion & Recouvrement des Impayés B2B
 * develop-it
 */

$success_message = '';
$error_message   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_contact'])) {

    $name        = htmlspecialchars(strip_tags(trim($_POST['name']        ?? '')));
    $email       = filter_var(trim($_POST['email']       ?? ''), FILTER_SANITIZE_EMAIL);
    $company     = htmlspecialchars(strip_tags(trim($_POST['company']     ?? '')));
    $phone       = htmlspecialchars(strip_tags(trim($_POST['phone']       ?? '')));
    $sector      = htmlspecialchars(strip_tags(trim($_POST['sector']      ?? '')));
    $employees   = htmlspecialchars(strip_tags(trim($_POST['employees']   ?? '')));
    $ca_impaye   = htmlspecialchars(strip_tags(trim($_POST['ca_impaye']   ?? '')));
    $message     = htmlspecialchars(strip_tags(trim($_POST['message']     ?? '')));

    if (empty($name) || empty($email)) {
        $error_message = 'Veuillez remplir tous les champs obligatoires.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Adresse email invalide.';
    } else {
        $to           = 'contact@develop-it.tech';
        $subject_mail = '💰 Demande démo RecovPro - ' . $name . ' | develop-it.tech';

        $body  = "Nouvelle demande de démonstration RecovPro\n";
        $body .= str_repeat('─', 55) . "\n\n";
        $body .= "👤 Nom            : $name\n";
        $body .= "📧 Email          : $email\n";
        $body .= "🏢 Entreprise     : " . ($company   ?: 'Non renseigné') . "\n";
        $body .= "📞 Téléphone      : " . ($phone     ?: 'Non renseigné') . "\n";
        $body .= "🏭 Secteur        : " . ($sector    ?: 'Non renseigné') . "\n";
        $body .= "👥 Employés       : " . ($employees ?: 'Non renseigné') . "\n";
        $body .= "📊 % CA Impayés   : " . ($ca_impaye ?: 'Non renseigné') . "\n\n";
        $body .= "💬 Message        :\n" . ($message  ?: 'Aucun message') . "\n\n";
        $body .= str_repeat('─', 55) . "\n";
        $body .= "Envoyé le : " . date('d/m/Y à H:i') . "\n";
        $body .= "IP        : " . ($_SERVER['REMOTE_ADDR'] ?? 'N/A') . "\n";

        $headers  = "From: no-reply@develop-it.tech\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        if (mail($to, $subject_mail, $body, $headers)) {
            $success_message = 'Votre demande a été envoyée avec succès ! Un expert RecovPro vous contactera sous 24h pour planifier votre démonstration.';
        } else {
            $error_message = 'Une erreur est survenue. Veuillez réessayer ou nous contacter directement.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>RecovPro | Recouvrement des Impayés B2B avec IA | develop-it Maroc</title>
    <meta name="description" content="RecovPro par develop-it — Solution complète de recouvrement des impayés pour entreprises marocaines. Scoring IA, relances automatiques, suivi mobile. Réduisez vos impayés de 25% à moins de 5% du CA.">
    <meta name="keywords" content="recouvrement impayés maroc, gestion impayés b2b, logiciel recouvrement maroc, suivi factures impayées, relance automatique, scoring risque client, develop-it, recovpro, gestion créances maroc">
    <meta name="author" content="develop-it">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://develop-it.tech/recovpro.php">

    <meta property="og:type" content="website">
    <meta property="og:url" content="https://develop-it.tech/recovpro.php">
    <meta property="og:title" content="RecovPro — Recouvrement des Impayés B2B par develop-it">
    <meta property="og:description" content="Réduisez vos impayés avec l'IA. Scoring de risque, relances automatiques, suivi terrain mobile. Solution SaaS pour PME marocaines.">
    <meta property="og:site_name" content="develop-it">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="RecovPro — Recouvrement des Impayés B2B">
    <meta name="twitter:description" content="Réduisez vos impayés avec l'intelligence artificielle. develop-it Maroc.">

    <link rel="icon" type="image/png" sizes="32x32" href="/logo.jfif">
    <link rel="apple-touch-icon" href="/logo.jfif">

    <!-- Schema.org structured data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "SoftwareApplication",
        "name": "RecovPro",
        "applicationCategory": "BusinessApplication",
        "operatingSystem": "Web, iOS, Android",
        "description": "Solution de recouvrement des impayés B2B avec intelligence artificielle pour les PME marocaines",
        "offers": { "@type": "Offer", "priceCurrency": "MAD" },
        "provider": {
            "@type": "Organization",
            "name": "develop-it",
            "url": "https://develop-it.tech",
            "contactPoint": { "@type": "ContactPoint", "telephone": "+212-0611191926", "contactType": "sales" }
        }
    }
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --red:     #dc2626;
            --red-d:   #991b1b;
            --amber:   #f59e0b;
            --green:   #16a34a;
            --dark:    #0a0a0a;
            --dark2:   #111111;
            --card:    #161616;
            --border:  rgba(255,255,255,0.08);
        }

        * { box-sizing: border-box; }
        body { font-family: 'DM Sans', sans-serif; background: var(--dark); color: #e5e7eb; }
        h1, h2, h3, h4, .font-display { font-family: 'Syne', sans-serif; }

        /* ── Noise texture overlay ── */
        body::before {
            content: '';
            position: fixed; inset: 0; z-index: 0; pointer-events: none;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
            opacity: 0.4;
        }

        /* ── Animated gradient orbs ── */
        .orb {
            position: absolute; border-radius: 50%; filter: blur(80px); opacity: 0.15;
            animation: drift 20s ease-in-out infinite alternate;
        }
        .orb-1 { width: 600px; height: 600px; background: var(--red); top: -200px; left: -100px; animation-delay: 0s; }
        .orb-2 { width: 400px; height: 400px; background: var(--amber); bottom: -100px; right: -100px; animation-delay: -8s; }
        .orb-3 { width: 300px; height: 300px; background: #7c3aed; top: 40%; left: 40%; animation-delay: -4s; }

        @keyframes drift {
            0%   { transform: translate(0, 0) scale(1); }
            50%  { transform: translate(40px, -40px) scale(1.05); }
            100% { transform: translate(-20px, 20px) scale(0.95); }
        }

        /* ── Score Ring ── */
        .score-ring {
            width: 120px; height: 120px; border-radius: 50%;
            background: conic-gradient(var(--red) 0%, var(--amber) 40%, var(--green) 80%, #1f2937 80%);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 0 40px rgba(220,38,38,0.3);
        }
        .score-inner {
            width: 88px; height: 88px; border-radius: 50%;
            background: var(--card); display: flex; flex-direction: column;
            align-items: center; justify-content: center;
        }

        /* ── Cards ── */
        .glass-card {
            background: var(--card); border: 1px solid var(--border);
            border-radius: 16px; transition: all 0.3s ease;
        }
        .glass-card:hover {
            border-color: rgba(220,38,38,0.3);
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4), 0 0 40px rgba(220,38,38,0.05);
        }

        /* ── Type badge ── */
        .badge-red    { background: rgba(220,38,38,0.15); color: #fca5a5; border: 1px solid rgba(220,38,38,0.3); }
        .badge-amber  { background: rgba(245,158,11,0.15); color: #fcd34d; border: 1px solid rgba(245,158,11,0.3); }
        .badge-green  { background: rgba(22,163,74,0.15);  color: #86efac; border: 1px solid rgba(22,163,74,0.3); }

        /* ── Progress bars ── */
        .progress-bar {
            height: 6px; border-radius: 3px; background: #1f2937;
            overflow: hidden; position: relative;
        }
        .progress-fill {
            height: 100%; border-radius: 3px;
            animation: fillBar 2s ease forwards;
            transform-origin: left;
        }
        @keyframes fillBar { from { width: 0; } }

        /* ── Stat counter ── */
        .stat-num {
            font-family: 'Syne', sans-serif; font-size: 3.5rem; font-weight: 800;
            background: linear-gradient(135deg, #fff 0%, #9ca3af 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ── Form inputs ── */
        .form-input {
            width: 100%; padding: 12px 16px; border-radius: 10px;
            background: rgba(255,255,255,0.04); border: 1px solid var(--border);
            color: #e5e7eb; font-family: 'DM Sans', sans-serif; font-size: 14px;
            transition: all 0.2s;
            outline: none;
        }
        .form-input:focus {
            border-color: rgba(220,38,38,0.5);
            background: rgba(220,38,38,0.03);
            box-shadow: 0 0 0 3px rgba(220,38,38,0.1);
        }
        .form-input option { background: #1a1a1a; }
        .form-input::placeholder { color: #4b5563; }

        /* ── Nav ── */
        .nav-link { color: #9ca3af; font-size: 14px; font-weight: 500; transition: color 0.2s; }
        .nav-link:hover { color: #fff; }

        /* ── Language Switcher ── */
        .lang-switcher { display: flex; align-items: center; background: rgba(255,255,255,0.05); border-radius: 9999px; padding: 3px; gap: 2px; border: 1px solid var(--border); }
        .lang-btn { padding: 4px 12px; border-radius: 9999px; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s; border: none; background: transparent; color: #6b7280; }
        .lang-btn.active { background: var(--red); color: white; }
        .lang-btn:hover:not(.active) { color: #e5e7eb; }

        /* ── Divider line ── */
        .h-line { height: 1px; background: var(--border); }

        /* ── Timeline ── */
        .timeline-dot {
            width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 13px; font-family: 'Syne', sans-serif;
        }

        /* ── Mobile app mockup ── */
        .phone-frame {
            width: 240px; border: 2px solid rgba(255,255,255,0.1);
            border-radius: 32px; background: #111; padding: 12px;
            box-shadow: 0 40px 80px rgba(0,0,0,0.6), 0 0 80px rgba(220,38,38,0.1);
        }
        .phone-screen {
            border-radius: 22px; background: #0d0d0d; overflow: hidden;
            border: 1px solid rgba(255,255,255,0.05);
        }

        html { scroll-behavior: smooth; }

        @keyframes pulse-red {
            0%, 100% { box-shadow: 0 0 0 0 rgba(220,38,38,0.4); }
            50% { box-shadow: 0 0 0 12px rgba(220,38,38,0); }
        }
        .pulse-red { animation: pulse-red 2.5s infinite; }

        /* ── Section label ── */
        .section-label {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 6px 14px; border-radius: 9999px;
            background: rgba(220,38,38,0.1); border: 1px solid rgba(220,38,38,0.25);
            color: #fca5a5; font-size: 12px; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase;
        }

        /* Stagger animations */
        [data-aos] { opacity: 0; }
    </style>
</head>
<body>

<!-- ══════════════════════════════════════════════
     NAVIGATION
══════════════════════════════════════════════ -->
<nav class="sticky top-0 z-50 border-b border-white/5" style="background: rgba(10,10,10,0.85); backdrop-filter: blur(20px);">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-6">
            <a href="/" class="flex items-center gap-2 nav-link">
                <img src="/logo.jfif" alt="develop-it" class="w-5 h-5 rounded">
                <span class="font-semibold text-white">develop-it</span>
            </a>
            <div class="hidden md:block w-px h-5 bg-white/10"></div>
            <div class="hidden md:flex items-center gap-2">
                <span class="text-red-500 text-lg">◆</span>
                <span class="font-display font-bold text-white text-lg" data-i18n="brand">RecovPro</span>
            </div>
        </div>
        <div class="hidden md:flex items-center gap-8">
            <a href="#solution" class="nav-link" data-i18n="nav_solution">Solution</a>
            <a href="#modules" class="nav-link" data-i18n="nav_modules">Modules</a>
            <a href="#ai" class="nav-link" data-i18n="nav_ai">IA & Analytics</a>
            <a href="#contact" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition" data-i18n="nav_demo">Demander une démo</a>
            <div class="lang-switcher">
                <button class="lang-btn active" onclick="setLang('fr', this)">🇫🇷 FR</button>
                <button class="lang-btn"        onclick="setLang('ar', this)">🇲🇦 AR</button>
            </div>
        </div>
    </div>
</nav>

<!-- ══════════════════════════════════════════════
     HERO
══════════════════════════════════════════════ -->
<section class="relative min-h-screen flex items-center overflow-hidden">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 py-28 grid lg:grid-cols-2 gap-16 items-center">
        <!-- LEFT -->
        <div data-aos="fade-right" data-aos-duration="900">
            <div class="section-label mb-6" data-i18n="hero_badge">
                <span>🇲🇦</span> Solution N°1 Recouvrement B2B au Maroc
            </div>

            <h1 class="text-5xl md:text-6xl lg:text-7xl font-display font-bold leading-tight mb-4">
                <span class="text-white">Recov</span><span class="text-red-500">Pro</span>
            </h1>
            <p class="text-xl text-gray-400 mb-3 font-medium" data-i18n="hero_by">par <strong class="text-white">develop-it</strong></p>
            <h2 class="text-2xl md:text-3xl font-display font-bold text-white mb-6 leading-snug" data-i18n="hero_tagline">
                Transformez vos impayés en<br>
                <span class="text-red-400">trésorerie récupérée</span> — grâce à l'IA
            </h2>
            <p class="text-gray-400 text-lg leading-relaxed max-w-lg mb-10" data-i18n="hero_desc">
                Les PME marocaines perdent jusqu'à <strong class="text-white">25% de leur chiffre d'affaires</strong> en impayés. RecovPro automatise le suivi, classe les risques et relance intelligemment vos clients.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="#contact" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-8 py-4 rounded-xl font-semibold transition pulse-red" data-i18n="hero_cta1">
                    🚀 Demander une démonstration
                </a>
                <a href="#solution" class="inline-flex items-center gap-2 border border-white/15 hover:border-white/30 text-white/80 hover:text-white px-8 py-4 rounded-xl transition" data-i18n="hero_cta2">
                    Voir la solution →
                </a>
            </div>

            <!-- Stats bar -->
            <div class="mt-14 grid grid-cols-3 gap-6 pt-10 border-t border-white/8">
                <div>
                    <div class="stat-num">25%</div>
                    <p class="text-sm text-gray-500 mt-1" data-i18n="stat1">CA perdu en impayés</p>
                </div>
                <div>
                    <div class="stat-num">3×</div>
                    <p class="text-sm text-gray-500 mt-1" data-i18n="stat2">Plus vite recouvré</p>
                </div>
                <div>
                    <div class="stat-num">AI</div>
                    <p class="text-sm text-gray-500 mt-1" data-i18n="stat3">Scoring de risque</p>
                </div>
            </div>
        </div>

        <!-- RIGHT — Dashboard preview card -->
        <div data-aos="fade-left" data-aos-duration="900" data-aos-delay="200">
            <div class="glass-card p-6 max-w-md mx-auto">
                <!-- Mini dashboard header -->
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider" data-i18n="dash_title">Tableau de bord — Impayés</p>
                        <p class="text-white font-display font-bold text-lg mt-1">Société Al Bina SARL</p>
                    </div>
                    <div class="score-ring">
                        <div class="score-inner">
                            <span class="text-white font-display font-bold text-xl">72</span>
                            <span class="text-gray-500 text-xs" data-i18n="score_label">Score</span>
                        </div>
                    </div>
                </div>

                <!-- 3 types impayés -->
                <div class="space-y-4 mb-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-500 flex-shrink-0"></span>
                            <span class="text-sm text-gray-300" data-i18n="type_radie">Radié — Irrécupérable</span>
                        </div>
                        <div class="text-right">
                            <span class="text-red-400 font-bold font-display text-sm">82 400 MAD</span>
                            <div class="progress-bar w-24 mt-1"><div class="progress-fill bg-red-500" style="width:65%"></div></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-400 flex-shrink-0"></span>
                            <span class="text-sm text-gray-300" data-i18n="type_t9adem">T9adem — En cours</span>
                        </div>
                        <div class="text-right">
                            <span class="text-amber-400 font-bold font-display text-sm">154 200 MAD</span>
                            <div class="progress-bar w-24 mt-1"><div class="progress-fill bg-amber-400" style="width:85%"></div></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-2.5 h-2.5 rounded-full bg-green-500 flex-shrink-0"></span>
                            <span class="text-sm text-gray-300" data-i18n="type_recup">Récupérable</span>
                        </div>
                        <div class="text-right">
                            <span class="text-green-400 font-bold font-display text-sm">38 700 MAD</span>
                            <div class="progress-bar w-24 mt-1"><div class="progress-fill bg-green-500" style="width:40%"></div></div>
                        </div>
                    </div>
                </div>

                <div class="h-line mb-6"></div>

                <!-- AI alert -->
                <div class="rounded-xl p-4" style="background: rgba(245,158,11,0.08); border: 1px solid rgba(245,158,11,0.2);">
                    <div class="flex items-start gap-3">
                        <span class="text-amber-400 text-lg">🤖</span>
                        <div>
                            <p class="text-xs font-semibold text-amber-300 mb-1" data-i18n="ai_alert_title">Recommandation IA</p>
                            <p class="text-xs text-gray-400" data-i18n="ai_alert_body">Client "Tazi & Fils" : risque élevé (score 38/100). Relance immédiate recommandée. 3 factures échues depuis 45 jours.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex gap-3">
                    <button class="flex-1 text-xs bg-red-600/20 hover:bg-red-600/40 text-red-300 border border-red-500/20 py-2.5 rounded-lg transition font-semibold" data-i18n="btn_relance">📨 Relancer maintenant</button>
                    <button class="flex-1 text-xs bg-white/5 hover:bg-white/10 text-gray-300 border border-white/10 py-2.5 rounded-lg transition" data-i18n="btn_dossier">📁 Voir dossier</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════
     PROBLEM STATEMENT
══════════════════════════════════════════════ -->
<section class="py-20 border-y border-white/5" style="background: var(--dark2);">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-8 text-center">
        <div data-aos="fade-up">
            <div class="text-5xl mb-4">😰</div>
            <h3 class="font-display font-bold text-xl text-white mb-3" data-i18n="prob1_title">25% du CA bloqué</h3>
            <p class="text-gray-500 leading-relaxed" data-i18n="prob1_desc">Les PME marocaines accumulent des créances impayées qui paralysent leur trésorerie et freinent leur croissance.</p>
        </div>
        <div data-aos="fade-up" data-aos-delay="100">
            <div class="text-5xl mb-4">📋</div>
            <h3 class="font-display font-bold text-xl text-white mb-3" data-i18n="prob2_title">Suivi manuel inefficace</h3>
            <p class="text-gray-500 leading-relaxed" data-i18n="prob2_desc">Excel, post-its, appels téléphoniques : les méthodes traditionnelles font perdre du temps et de l'argent.</p>
        </div>
        <div data-aos="fade-up" data-aos-delay="200">
            <div class="text-5xl mb-4">⚠️</div>
            <h3 class="font-display font-bold text-xl text-white mb-3" data-i18n="prob3_title">Risques non anticipés</h3>
            <p class="text-gray-500 leading-relaxed" data-i18n="prob3_desc">Sans scoring de risque, vous découvrez l'insolvabilité d'un client trop tard — quand il est souvent impossible de récupérer.</p>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════
     SOLUTION — 3 TYPES D'IMPAYÉS
══════════════════════════════════════════════ -->
<section id="solution" class="py-24">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="section-label mb-6" data-i18n="sol_label">Classification Intelligente</div>
            <h2 class="text-4xl md:text-5xl font-display font-bold text-white mb-6" data-i18n="sol_title">
                3 types d'impayés,<br>3 stratégies de recouvrement
            </h2>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto" data-i18n="sol_desc">
                RecovPro classe automatiquement vos créances et adapte la stratégie de relance selon le profil de risque du client.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <!-- Radié -->
            <div class="glass-card p-8" data-aos="fade-up">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold badge-red mb-6" data-i18n="radie_badge">🔴 Radié — Irrécupérable</span>
                <h3 class="font-display font-bold text-2xl text-white mb-4" data-i18n="radie_title">Client Disparu / Insolvable</h3>
                <p class="text-gray-400 text-sm leading-relaxed mb-6" data-i18n="radie_desc">Client en faillite, introuvable ou ayant définitivement cessé ses activités. La créance est provisionnée en perte.</p>
                <div class="space-y-3">
                    <div class="flex items-center gap-3 text-sm text-gray-300">
                        <span class="text-red-400">→</span>
                        <span data-i18n="radie_a1">Alerte préventive IA avant insolvabilité</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-300">
                        <span class="text-red-400">→</span>
                        <span data-i18n="radie_a2">Génération dossier contentieux automatique</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-300">
                        <span class="text-red-400">→</span>
                        <span data-i18n="radie_a3">Provision en perte comptable</span>
                    </div>
                </div>
            </div>

            <!-- T9adem -->
            <div class="glass-card p-8 relative" data-aos="fade-up" data-aos-delay="100" style="border-color: rgba(245,158,11,0.3);">
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-amber-500 text-black text-xs font-bold px-4 py-1 rounded-full" data-i18n="popular_badge">LE PLUS FRÉQUENT</div>
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold badge-amber mb-6" data-i18n="t9adem_badge">🟡 T9adem — En cours</span>
                <h3 class="font-display font-bold text-2xl text-white mb-4" data-i18n="t9adem_title">Paiement Tardif / Litigieux</h3>
                <p class="text-gray-400 text-sm leading-relaxed mb-6" data-i18n="t9adem_desc">Client actif mais qui retarde ses paiements. Il reste récupérable avec la bonne stratégie de relance et de négociation.</p>
                <div class="space-y-3">
                    <div class="flex items-center gap-3 text-sm text-gray-300">
                        <span class="text-amber-400">→</span>
                        <span data-i18n="t9adem_a1">Séquences de relance automatisées (Email/SMS/WhatsApp)</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-300">
                        <span class="text-amber-400">→</span>
                        <span data-i18n="t9adem_a2">Plan de paiement échelonné suggéré par l'IA</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-300">
                        <span class="text-amber-400">→</span>
                        <span data-i18n="t9adem_a3">Escalade automatique selon non-réponse</span>
                    </div>
                </div>
            </div>

            <!-- Récupérable -->
            <div class="glass-card p-8" data-aos="fade-up" data-aos-delay="200">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold badge-green mb-6" data-i18n="recup_badge">🟢 Récupérable</span>
                <h3 class="font-display font-bold text-2xl text-white mb-4" data-i18n="recup_title">Peut-être Récupéré</h3>
                <p class="text-gray-400 text-sm leading-relaxed mb-6" data-i18n="recup_desc">Client avec un historique de paiement mitigé mais des signaux positifs. L'IA calcule la probabilité de recouvrement.</p>
                <div class="space-y-3">
                    <div class="flex items-center gap-3 text-sm text-gray-300">
                        <span class="text-green-400">→</span>
                        <span data-i18n="recup_a1">Score de probabilité de paiement 0–100</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-300">
                        <span class="text-green-400">→</span>
                        <span data-i18n="recup_a2">Stratégie de négociation personnalisée par IA</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-300">
                        <span class="text-green-400">→</span>
                        <span data-i18n="recup_a3">Suivi terrain via application mobile</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════
     MODULES
══════════════════════════════════════════════ -->
<section id="modules" class="py-24 border-t border-white/5" style="background: var(--dark2);">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="section-label mb-6" data-i18n="mod_label">Plateforme Complète</div>
            <h2 class="text-4xl md:text-5xl font-display font-bold text-white mb-6" data-i18n="mod_title">7 modules intégrés</h2>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto" data-i18n="mod_desc">De la détection de risque jusqu'au recouvrement terrain, RecovPro couvre tout le cycle de vie d'une créance.</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            <?php
            $modules = [
                ['icon'=>'🏢','title_key'=>'m1_t','desc_key'=>'m1_d','color'=>'rgba(220,38,38,0.1)','border'=>'rgba(220,38,38,0.2)'],
                ['icon'=>'📄','title_key'=>'m2_t','desc_key'=>'m2_d','color'=>'rgba(245,158,11,0.1)','border'=>'rgba(245,158,11,0.2)'],
                ['icon'=>'🤖','title_key'=>'m3_t','desc_key'=>'m3_d','color'=>'rgba(124,58,237,0.1)','border'=>'rgba(124,58,237,0.2)'],
                ['icon'=>'📨','title_key'=>'m4_t','desc_key'=>'m4_d','color'=>'rgba(22,163,74,0.1)','border'=>'rgba(22,163,74,0.2)'],
                ['icon'=>'📱','title_key'=>'m5_t','desc_key'=>'m5_d','color'=>'rgba(59,130,246,0.1)','border'=>'rgba(59,130,246,0.2)'],
                ['icon'=>'📊','title_key'=>'m6_t','desc_key'=>'m6_d','color'=>'rgba(236,72,153,0.1)','border'=>'rgba(236,72,153,0.2)'],
                ['icon'=>'🔐','title_key'=>'m7_t','desc_key'=>'m7_d','color'=>'rgba(107,114,128,0.1)','border'=>'rgba(107,114,128,0.2)'],
            ];
            foreach ($modules as $i => $m):
            ?>
            <div class="glass-card p-6" data-aos="fade-up" data-aos-delay="<?= $i * 60 ?>" style="background: <?= $m['color'] ?>; border-color: <?= $m['border'] ?>;">
                <div class="text-3xl mb-4"><?= $m['icon'] ?></div>
                <h4 class="font-display font-bold text-white text-lg mb-2" data-i18n="<?= $m['title_key'] ?>">—</h4>
                <p class="text-gray-400 text-sm leading-relaxed" data-i18n="<?= $m['desc_key'] ?>">—</p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════
     IA & ANALYTICS
══════════════════════════════════════════════ -->
<section id="ai" class="py-24">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div data-aos="fade-right">
                <div class="section-label mb-6" data-i18n="ai_label">Intelligence Artificielle</div>
                <h2 class="text-4xl md:text-5xl font-display font-bold text-white mb-8 leading-tight" data-i18n="ai_title">
                    L'IA travaille pour vous <span class="text-red-400">24h/24</span>
                </h2>

                <!-- AI features list -->
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-red-600/20 border border-red-500/20 flex items-center justify-center flex-shrink-0 text-lg">🎯</div>
                        <div>
                            <h4 class="font-display font-semibold text-white mb-1" data-i18n="ai_f1_t">Scoring de Risque Client</h4>
                            <p class="text-gray-400 text-sm leading-relaxed" data-i18n="ai_f1_d">Chaque client reçoit un score 0–100 mis à jour en temps réel selon son comportement de paiement, son secteur et sa taille.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-amber-600/20 border border-amber-500/20 flex items-center justify-center flex-shrink-0 text-lg">✍️</div>
                        <div>
                            <h4 class="font-display font-semibold text-white mb-1" data-i18n="ai_f2_t">Génération de Relances Personnalisées</h4>
                            <p class="text-gray-400 text-sm leading-relaxed" data-i18n="ai_f2_d">L'IA rédige des emails et SMS de relance adaptés au profil de chaque client — ton diplomatique ou ferme selon l'historique.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-green-600/20 border border-green-500/20 flex items-center justify-center flex-shrink-0 text-lg">📈</div>
                        <div>
                            <h4 class="font-display font-semibold text-white mb-1" data-i18n="ai_f3_t">Prévision de Trésorerie</h4>
                            <p class="text-gray-400 text-sm leading-relaxed" data-i18n="ai_f3_d">Prédit les encaissements probables des 30/60/90 prochains jours sur la base des scores de probabilité de paiement.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-purple-600/20 border border-purple-500/20 flex items-center justify-center flex-shrink-0 text-lg">📋</div>
                        <div>
                            <h4 class="font-display font-semibold text-white mb-1" data-i18n="ai_f4_t">Rapport Hebdomadaire Auto-généré</h4>
                            <p class="text-gray-400 text-sm leading-relaxed" data-i18n="ai_f4_d">Chaque semaine, l'IA envoie un rapport exécutif avec les créances prioritaires, les alertes et les recommandations d'action.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: phone mockup + analytics card -->
            <div class="relative" data-aos="fade-left">
                <div class="absolute -inset-4 bg-gradient-radial from-red-900/20 to-transparent rounded-3xl"></div>
                <div class="relative flex justify-center gap-6 items-end">
                    <!-- Phone -->
                    <div class="phone-frame" style="transform: rotate(-4deg);">
                        <div class="phone-screen p-3">
                            <!-- Status bar -->
                            <div class="flex justify-between items-center mb-3 px-1">
                                <span class="text-xs text-gray-500">9:41</span>
                                <div class="flex gap-1">
                                    <div class="w-3 h-1.5 bg-green-400 rounded-sm"></div>
                                    <div class="w-2 h-1.5 bg-gray-600 rounded-sm"></div>
                                </div>
                            </div>
                            <p class="text-xs text-gray-400 mb-1 px-1" data-i18n="app_title">RecovPro Mobile</p>
                            <h5 class="text-sm font-display font-bold text-white mb-3 px-1" data-i18n="app_sub">Mes relances du jour</h5>
                            <!-- Mini cards -->
                            <?php foreach ([
                                ['Société Idrissi','T9adem','amber','3 fac. — 47 800 MAD'],
                                ['BTPH Marrakech','Récupérable','green','1 fac. — 22 300 MAD'],
                                ['Tazi Constructions','Radié','red','2 fac. — 81 200 MAD'],
                            ] as $item): ?>
                            <div class="flex items-center gap-2 bg-white/5 rounded-lg p-2 mb-2">
                                <div class="w-2 h-2 rounded-full bg-<?= $item[2] ?>-400 flex-shrink-0"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-white font-medium truncate"><?= $item[0] ?></p>
                                    <p class="text-xs text-gray-500"><?= $item[3] ?></p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <button class="w-full mt-2 bg-red-600 text-white text-xs py-2 rounded-lg font-semibold" data-i18n="app_btn">📨 Tout relancer</button>
                        </div>
                    </div>

                    <!-- Analytics card -->
                    <div class="glass-card p-5 w-48" style="transform: rotate(3deg);">
                        <p class="text-xs text-gray-500 mb-3" data-i18n="analytics_title">Taux de recouvrement</p>
                        <div class="text-3xl font-display font-bold text-green-400 mb-1">78%</div>
                        <div class="text-xs text-gray-500 mb-4" data-i18n="analytics_sub">↑ +12% ce mois</div>
                        <!-- Mini bars -->
                        <div class="space-y-2">
                            <?php foreach (['60','72','68','85','78'] as $w => $v): ?>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-600 w-4">S<?= $w+1 ?></span>
                                <div class="flex-1 progress-bar">
                                    <div class="progress-fill bg-green-500" style="width:<?= $v ?>%"></div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════
     HOW IT WORKS
══════════════════════════════════════════════ -->
<section class="py-24 border-t border-white/5" style="background: var(--dark2);">
    <div class="max-w-5xl mx-auto px-6">
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="section-label mb-6" data-i18n="how_label">Démarrage Rapide</div>
            <h2 class="text-4xl font-display font-bold text-white mb-4" data-i18n="how_title">Opérationnel en 48h</h2>
        </div>
        <div class="space-y-6">
            <?php
            $steps = [
                ['01','step1_t','step1_d','border-red-500/30','text-red-400'],
                ['02','step2_t','step2_d','border-amber-500/30','text-amber-400'],
                ['03','step3_t','step3_d','border-green-500/30','text-green-400'],
                ['04','step4_t','step4_d','border-blue-500/30','text-blue-400'],
            ];
            foreach ($steps as $i => $s):
            ?>
            <div class="flex gap-6 items-start glass-card p-6" data-aos="fade-up" data-aos-delay="<?= $i * 80 ?>">
                <div class="timeline-dot bg-white/5 border border-white/10 <?= $s[4] ?>"><?= $s[0] ?></div>
                <div>
                    <h4 class="font-display font-bold text-white mb-1" data-i18n="<?= $s[1] ?>">—</h4>
                    <p class="text-gray-400 text-sm leading-relaxed" data-i18n="<?= $s[2] ?>">—</p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════
     CONTACT FORM
══════════════════════════════════════════════ -->
<section id="contact" class="py-24">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-14" data-aos="fade-up">
            <div class="section-label mb-6" data-i18n="form_label">Démonstration Gratuite</div>
            <h2 class="text-4xl md:text-5xl font-display font-bold text-white mb-6" data-i18n="form_title">
                Planifiez votre démonstration
            </h2>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto" data-i18n="form_desc">
                Un expert RecovPro vous présente la solution en 30 minutes et l'adapte à votre secteur.
            </p>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Sidebar info -->
            <div class="space-y-5" data-aos="fade-right">
                <div class="glass-card p-6">
                    <div class="text-3xl mb-3">📧</div>
                    <h4 class="font-display font-bold text-white mb-1" data-i18n="contact_email_t">Email</h4>
                    <a href="mailto:contact@develop-it.tech" class="text-red-400 hover:text-red-300 text-sm break-all transition">contact@develop-it.tech</a>
                </div>
                <div class="glass-card p-6">
                    <div class="text-3xl mb-3">📞</div>
                    <h4 class="font-display font-bold text-white mb-1" data-i18n="contact_phone_t">Téléphone</h4>
                    <a href="tel:+2120611191926" class="text-red-400 hover:text-red-300 text-sm transition">+212 06 11 19 19 26</a>
                </div>
                <div class="glass-card p-6">
                    <div class="text-3xl mb-3">⚡</div>
                    <h4 class="font-display font-bold text-white mb-2" data-i18n="contact_why_t">Pourquoi RecovPro ?</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li class="flex gap-2"><span class="text-green-400">✓</span><span data-i18n="why1">Scoring IA en temps réel</span></li>
                        <li class="flex gap-2"><span class="text-green-400">✓</span><span data-i18n="why2">Multi-tenant & Multi-société</span></li>
                        <li class="flex gap-2"><span class="text-green-400">✓</span><span data-i18n="why3">Application mobile iOS/Android</span></li>
                        <li class="flex gap-2"><span class="text-green-400">✓</span><span data-i18n="why4">Relances Email/SMS/WhatsApp</span></li>
                        <li class="flex gap-2"><span class="text-green-400">✓</span><span data-i18n="why5">Support 24/7 en arabe & français</span></li>
                    </ul>
                </div>
            </div>

            <!-- Form -->
            <div class="lg:col-span-2" data-aos="fade-left">
                <div class="glass-card p-8">
                    <?php if (!empty($success_message)): ?>
                    <div class="mb-6 rounded-xl p-4 flex items-start gap-3" style="background: rgba(22,163,74,0.1); border: 1px solid rgba(22,163,74,0.3);">
                        <span class="text-green-400 text-xl flex-shrink-0">✅</span>
                        <span class="text-green-300 text-sm"><?php echo $success_message; ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($error_message)): ?>
                    <div class="mb-6 rounded-xl p-4 flex items-start gap-3" style="background: rgba(220,38,38,0.1); border: 1px solid rgba(220,38,38,0.3);">
                        <span class="text-red-400 text-xl flex-shrink-0">⚠️</span>
                        <span class="text-red-300 text-sm"><?php echo $error_message; ?></span>
                    </div>
                    <?php endif; ?>

                    <form method="POST" action="#contact" class="space-y-5">
                        <div class="grid md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wider" data-i18n="f_name">Nom complet *</label>
                                <input type="text" name="name" required value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
                                    class="form-input" placeholder="Votre nom complet">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wider" data-i18n="f_email">Email *</label>
                                <input type="email" name="email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                                    class="form-input" placeholder="votre@email.com">
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wider" data-i18n="f_company">Entreprise</label>
                                <input type="text" name="company" value="<?php echo htmlspecialchars($_POST['company'] ?? ''); ?>"
                                    class="form-input" placeholder="Nom de votre société">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wider" data-i18n="f_phone">Téléphone</label>
                                <input type="tel" name="phone" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>"
                                    class="form-input" placeholder="+212 XXX XXX XXX">
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wider" data-i18n="f_sector">Secteur d'activité</label>
                                <select name="sector" class="form-input">
                                    <option value="" data-i18n="f_select">Sélectionnez</option>
                                    <option value="BTP & Immobilier"        <?php echo (($_POST['sector']??'')==='BTP & Immobilier')        ?'selected':''; ?> data-i18n="sec1">BTP & Immobilier</option>
                                    <option value="Commerce & Distribution" <?php echo (($_POST['sector']??'')==='Commerce & Distribution') ?'selected':''; ?> data-i18n="sec2">Commerce & Distribution</option>
                                    <option value="Industrie"               <?php echo (($_POST['sector']??'')==='Industrie')               ?'selected':''; ?> data-i18n="sec3">Industrie</option>
                                    <option value="Services B2B"            <?php echo (($_POST['sector']??'')==='Services B2B')            ?'selected':''; ?> data-i18n="sec4">Services B2B</option>
                                    <option value="Agroalimentaire"         <?php echo (($_POST['sector']??'')==='Agroalimentaire')         ?'selected':''; ?> data-i18n="sec5">Agroalimentaire</option>
                                    <option value="Autre"                   <?php echo (($_POST['sector']??'')==='Autre')                   ?'selected':''; ?> data-i18n="sec6">Autre</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wider" data-i18n="f_ca">% CA en impayés estimé</label>
                                <select name="ca_impaye" class="form-input">
                                    <option value="" data-i18n="f_select">Sélectionnez</option>
                                    <option value="Moins de 5%"  <?php echo (($_POST['ca_impaye']??'')==='Moins de 5%')  ?'selected':''; ?>>Moins de 5%</option>
                                    <option value="5% - 15%"     <?php echo (($_POST['ca_impaye']??'')==='5% - 15%')     ?'selected':''; ?>>5% – 15%</option>
                                    <option value="15% - 25%"    <?php echo (($_POST['ca_impaye']??'')==='15% - 25%')    ?'selected':''; ?>>15% – 25%</option>
                                    <option value="Plus de 25%"  <?php echo (($_POST['ca_impaye']??'')==='Plus de 25%')  ?'selected':''; ?>>Plus de 25%</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wider" data-i18n="f_employees">Nombre de clients actifs</label>
                            <select name="employees" class="form-input">
                                <option value="" data-i18n="f_select">Sélectionnez</option>
                                <option value="Moins de 20"   <?php echo (($_POST['employees']??'')==='Moins de 20')   ?'selected':''; ?> data-i18n="emp1">Moins de 20 clients</option>
                                <option value="20 - 100"      <?php echo (($_POST['employees']??'')==='20 - 100')      ?'selected':''; ?> data-i18n="emp2">20 – 100 clients</option>
                                <option value="100 - 500"     <?php echo (($_POST['employees']??'')==='100 - 500')     ?'selected':''; ?> data-i18n="emp3">100 – 500 clients</option>
                                <option value="Plus de 500"   <?php echo (($_POST['employees']??'')==='Plus de 500')   ?'selected':''; ?> data-i18n="emp4">Plus de 500 clients</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wider" data-i18n="f_message">Décrivez votre problématique</label>
                            <textarea name="message" rows="4" class="form-input resize-none"
                                placeholder="Ex: 3 gros clients en retard de 90 jours, besoin d'automatiser les relances..."><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                        </div>
                        <div class="pt-2">
                            <button type="submit" name="submit_contact"
                                class="w-full bg-red-600 hover:bg-red-700 text-white py-4 rounded-xl font-display font-bold text-lg transition pulse-red" data-i18n="f_submit">
                                🚀 Demander ma démonstration gratuite
                            </button>
                            <p class="text-center text-xs text-gray-600 mt-3" data-i18n="f_note">Réponse sous 24h • Sans engagement • Démo personnalisée</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════
     FOOTER
══════════════════════════════════════════════ -->
<footer class="border-t border-white/5 py-14" style="background: var(--dark2);">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-4 gap-8 mb-10">
            <div class="md:col-span-2">
                <div class="flex items-center gap-3 mb-4">
                    <img src="/logo.jfif" alt="develop-it" class="w-6 h-6 rounded">
                    <span class="text-white font-bold">develop-it</span>
                    <span class="text-gray-600">×</span>
                    <span class="font-display font-bold text-white">Recov<span class="text-red-500">Pro</span></span>
                </div>
                <p class="text-gray-500 text-sm leading-relaxed max-w-xs" data-i18n="footer_desc">
                    Solution SaaS de recouvrement des impayés B2B avec intelligence artificielle, développée par develop-it pour les PME marocaines.
                </p>
            </div>
            <div>
                <h4 class="text-white font-semibold text-sm mb-4 uppercase tracking-wider" data-i18n="footer_product">Produit</h4>
                <ul class="space-y-2 text-sm text-gray-500">
                    <li><a href="#solution" class="hover:text-white transition" data-i18n="nav_solution">Solution</a></li>
                    <li><a href="#modules"  class="hover:text-white transition" data-i18n="nav_modules">Modules</a></li>
                    <li><a href="#ai"       class="hover:text-white transition" data-i18n="nav_ai">IA & Analytics</a></li>
                    <li><a href="#contact"  class="hover:text-white transition" data-i18n="nav_demo">Démo gratuite</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold text-sm mb-4 uppercase tracking-wider" data-i18n="footer_company">develop-it</h4>
                <ul class="space-y-2 text-sm text-gray-500">
                    <li><a href="/"                  class="hover:text-white transition" data-i18n="footer_home">Accueil</a></li>
                    <li><a href="mailto:contact@develop-it.tech" class="hover:text-white transition">contact@develop-it.tech</a></li>
                    <li><a href="tel:+2120611191926" class="hover:text-white transition">+212 06 11 19 19 26</a></li>
                </ul>
            </div>
        </div>
        <div class="h-line mb-6"></div>
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-gray-600">
            <p>© 2026 <strong class="text-gray-400">develop-it</strong> · RecovPro — Tous droits réservés</p>
            <p data-i18n="footer_made">Fait avec ❤️ au Maroc 🇲🇦</p>
        </div>
    </div>
</footer>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({ duration: 800, once: true, offset: 80 });

/* ── Translations ──────────────────────────────────────────── */
const T = {
fr: {
    brand:'RecovPro',
    nav_solution:'Solution', nav_modules:'Modules', nav_ai:'IA & Analytics', nav_demo:'Demander une démo',
    hero_badge:'🇲🇦 Solution N°1 Recouvrement B2B au Maroc',
    hero_by:'par develop-it',
    hero_tagline:'Transformez vos impayés en<br><span class="text-red-400">trésorerie récupérée</span> — grâce à l\'IA',
    hero_desc:'Les PME marocaines perdent jusqu\'à <strong class="text-white">25% de leur chiffre d\'affaires</strong> en impayés. RecovPro automatise le suivi, classe les risques et relance intelligemment vos clients.',
    hero_cta1:'🚀 Demander une démonstration', hero_cta2:'Voir la solution →',
    stat1:'CA perdu en impayés', stat2:'Plus vite recouvré', stat3:'Scoring de risque',
    dash_title:'Tableau de bord — Impayés', score_label:'Score',
    type_radie:'Radié — Irrécupérable', type_t9adem:'T9adem — En cours', type_recup:'Récupérable',
    ai_alert_title:'Recommandation IA',
    ai_alert_body:'Client "Tazi & Fils" : risque élevé (score 38/100). Relance immédiate recommandée. 3 factures échues depuis 45 jours.',
    btn_relance:'📨 Relancer maintenant', btn_dossier:'📁 Voir dossier',
    prob1_title:'25% du CA bloqué', prob1_desc:'Les PME marocaines accumulent des créances impayées qui paralysent leur trésorerie et freinent leur croissance.',
    prob2_title:'Suivi manuel inefficace', prob2_desc:'Excel, post-its, appels téléphoniques : les méthodes traditionnelles font perdre du temps et de l\'argent.',
    prob3_title:'Risques non anticipés', prob3_desc:'Sans scoring de risque, vous découvrez l\'insolvabilité d\'un client trop tard — quand il est souvent impossible de récupérer.',
    sol_label:'Classification Intelligente',
    sol_title:'3 types d\'impayés,<br>3 stratégies de recouvrement',
    sol_desc:'RecovPro classe automatiquement vos créances et adapte la stratégie de relance selon le profil de risque du client.',
    radie_badge:'🔴 Radié — Irrécupérable',
    radie_title:'Client Disparu / Insolvable',
    radie_desc:'Client en faillite, introuvable ou ayant définitivement cessé ses activités. La créance est provisionnée en perte.',
    radie_a1:'Alerte préventive IA avant insolvabilité', radie_a2:'Génération dossier contentieux automatique', radie_a3:'Provision en perte comptable',
    t9adem_badge:'🟡 T9adem — En cours', popular_badge:'LE PLUS FRÉQUENT',
    t9adem_title:'Paiement Tardif / Litigieux',
    t9adem_desc:'Client actif mais qui retarde ses paiements. Il reste récupérable avec la bonne stratégie de relance et de négociation.',
    t9adem_a1:'Séquences de relance automatisées (Email/SMS/WhatsApp)', t9adem_a2:'Plan de paiement échelonné suggéré par l\'IA', t9adem_a3:'Escalade automatique selon non-réponse',
    recup_badge:'🟢 Récupérable',
    recup_title:'Peut-être Récupéré',
    recup_desc:'Client avec un historique de paiement mitigé mais des signaux positifs. L\'IA calcule la probabilité de recouvrement.',
    recup_a1:'Score de probabilité de paiement 0–100', recup_a2:'Stratégie de négociation personnalisée par IA', recup_a3:'Suivi terrain via application mobile',
    mod_label:'Plateforme Complète', mod_title:'7 modules intégrés',
    mod_desc:'De la détection de risque jusqu\'au recouvrement terrain, RecovPro couvre tout le cycle de vie d\'une créance.',
    m1_t:'Gestion Clients & Sociétés',         m1_d:'Fiches clients complètes (ICE, RC), historique des transactions, enrichissement automatique via IA.',
    m2_t:'Suivi Factures & Impayés',            m2_d:'Import CSV ou ERP, classification automatique Radié/T9adem/Récupérable, suivi statut en temps réel.',
    m3_t:'Scoring de Risque (IA)',              m3_d:'Score 0–100 par client, prédiction de paiement sur 30/60/90 jours, alerte proactive avant échéance.',
    m4_t:'Relances Automatiques',               m4_d:'Séquences Email/SMS/WhatsApp configurables, messages personnalisés par IA selon profil client.',
    m5_t:'Application Mobile Terrain',          m5_d:'Encaissement sur place, géolocalisation visites, résumé vocal IA du dossier client avant visite.',
    m6_t:'Dashboard Analytics',                 m6_d:'DSO en temps réel, prévision trésorerie, taux de recouvrement par agent/secteur/période.',
    m7_t:'Multi-Tenant & Sécurité',             m7_d:'Chaque société a son espace isolé, permissions granulaires, chiffrement des données RGPD.',
    ai_label:'Intelligence Artificielle',
    ai_title:'L\'IA travaille pour vous <span class="text-red-400">24h/24</span>',
    ai_f1_t:'Scoring de Risque Client',         ai_f1_d:'Chaque client reçoit un score 0–100 mis à jour en temps réel selon son comportement de paiement, son secteur et sa taille.',
    ai_f2_t:'Génération de Relances Personnalisées', ai_f2_d:'L\'IA rédige des emails et SMS de relance adaptés au profil de chaque client — ton diplomatique ou ferme selon l\'historique.',
    ai_f3_t:'Prévision de Trésorerie',          ai_f3_d:'Prédit les encaissements probables des 30/60/90 prochains jours sur la base des scores de probabilité de paiement.',
    ai_f4_t:'Rapport Hebdomadaire Auto-généré', ai_f4_d:'Chaque semaine, l\'IA envoie un rapport exécutif avec les créances prioritaires, les alertes et les recommandations d\'action.',
    app_title:'RecovPro Mobile', app_sub:'Mes relances du jour', app_btn:'📨 Tout relancer',
    analytics_title:'Taux de recouvrement', analytics_sub:'↑ +12% ce mois',
    how_label:'Démarrage Rapide', how_title:'Opérationnel en 48h',
    step1_t:'Import de vos données clients & factures', step1_d:'Importez votre base clients depuis Excel, votre ERP ou saisissez manuellement. RecovPro analyse immédiatement le portefeuille impayés.',
    step2_t:'Classification IA automatique',            step2_d:'L\'IA classe chaque créance en Radié, T9adem ou Récupérable et attribue un score de risque à chaque client.',
    step3_t:'Activation des relances automatiques',     step3_d:'Configurez vos séquences de relance Email/SMS/WhatsApp. L\'IA rédige les messages adaptés à chaque profil client.',
    step4_t:'Suivi en temps réel & recouvrement',       step4_d:'Dashboard live, notifications push mobile, rapports hebdomadaires IA et encaissement terrain via l\'application mobile.',
    form_label:'Démonstration Gratuite',
    form_title:'Planifiez votre démonstration',
    form_desc:'Un expert RecovPro vous présente la solution en 30 minutes et l\'adapte à votre secteur.',
    contact_email_t:'Email', contact_phone_t:'Téléphone', contact_why_t:'Pourquoi RecovPro ?',
    why1:'Scoring IA en temps réel', why2:'Multi-tenant & Multi-société', why3:'Application mobile iOS/Android',
    why4:'Relances Email/SMS/WhatsApp', why5:'Support 24/7 en arabe & français',
    f_name:'Nom complet *', f_email:'Email *', f_company:'Entreprise', f_phone:'Téléphone',
    f_sector:'Secteur d\'activité', f_select:'Sélectionnez',
    sec1:'BTP & Immobilier', sec2:'Commerce & Distribution', sec3:'Industrie', sec4:'Services B2B', sec5:'Agroalimentaire', sec6:'Autre',
    f_ca:'% CA en impayés estimé', f_employees:'Nombre de clients actifs',
    emp1:'Moins de 20 clients', emp2:'20 – 100 clients', emp3:'100 – 500 clients', emp4:'Plus de 500 clients',
    f_message:'Décrivez votre problématique',
    f_submit:'🚀 Demander ma démonstration gratuite',
    f_note:'Réponse sous 24h • Sans engagement • Démo personnalisée',
    footer_desc:'Solution SaaS de recouvrement des impayés B2B avec intelligence artificielle, développée par develop-it pour les PME marocaines.',
    footer_product:'Produit', footer_company:'develop-it', footer_home:'Accueil',
    footer_made:'Fait avec ❤️ au Maroc 🇲🇦',
},
ar: {
    brand:'ريكوف برو',
    nav_solution:'الحل', nav_modules:'الوحدات', nav_ai:'الذكاء الاصطناعي', nav_demo:'طلب عرض',
    hero_badge:'🇲🇦 الحل الأول لاسترداد الديون بالمغرب',
    hero_by:'من تطوير develop-it',
    hero_tagline:'حوّل ديونك غير المحصّلة إلى<br><span class="text-red-400">سيولة مستردة</span> — بفضل الذكاء الاصطناعي',
    hero_desc:'تخسر المقاولات المغربية ما يصل إلى <strong class="text-white">25٪ من رقم أعمالها</strong> في الديون غير المسددة. ريكوف برو يؤتمت المتابعة، يصنّف المخاطر ويُرسل التذكيرات الذكية.',
    hero_cta1:'🚀 طلب عرض تجريبي', hero_cta2:'اكتشف الحل ←',
    stat1:'من رقم الأعمال ضائع', stat2:'أسرع في الاسترداد', stat3:'تقييم المخاطر',
    dash_title:'لوحة التحكم — الديون', score_label:'نقاط',
    type_radie:'مشطوب — غير قابل للاسترداد', type_t9adem:'تقدّم — قيد التحصيل', type_recup:'قابل للاسترداد',
    ai_alert_title:'توصية الذكاء الاصطناعي',
    ai_alert_body:'العميل "التازي وأبناؤه": خطر مرتفع (38/100). يُوصى بالتذكير الفوري. 3 فواتير متأخرة منذ 45 يوماً.',
    btn_relance:'📨 تذكير الآن', btn_dossier:'📁 عرض الملف',
    prob1_title:'25٪ من الأعمال محتجزة', prob1_desc:'تتراكم الديون في المقاولات المغربية مما يشل السيولة ويعيق النمو.',
    prob2_title:'متابعة يدوية غير فعّالة', prob2_desc:'الاكسيل والمكالمات الهاتفية: الطرق التقليدية تهدر الوقت والمال.',
    prob3_title:'مخاطر غير متوقعة', prob3_desc:'بدون تقييم المخاطر، تكتشف إفلاس العميل متأخراً — حين يصعب الاسترداد.',
    sol_label:'التصنيف الذكي',
    sol_title:'3 أنواع ديون،<br>3 استراتيجيات تحصيل',
    sol_desc:'يصنّف ريكوف برو تلقائياً ديونك ويُكيّف استراتيجية التذكير وفق ملف مخاطر العميل.',
    radie_badge:'🔴 مشطوب — غير قابل للاسترداد', radie_title:'عميل مفقود / معسر',
    radie_desc:'عميل مفلس أو مختفٍ أو أوقف نشاطه نهائياً. يُحوَّل الدين إلى خسارة مُحاسبية.',
    radie_a1:'تنبيه وقائي بالذكاء الاصطناعي قبل الإفلاس', radie_a2:'توليد ملف النزاع القانوني تلقائياً', radie_a3:'مؤونة خسارة محاسبية',
    t9adem_badge:'🟡 تقدّم — قيد التحصيل', popular_badge:'الأكثر شيوعاً',
    t9adem_title:'تأخر في الدفع / نزاع', t9adem_desc:'عميل نشط لكنه يُماطل. لا يزال قابلاً للتحصيل باستراتيجية التذكير والتفاوض المناسبة.',
    t9adem_a1:'سلاسل تذكير آلية (بريد/SMS/واتساب)', t9adem_a2:'خطة سداد مُقترحة بالذكاء الاصطناعي', t9adem_a3:'تصعيد تلقائي عند عدم الرد',
    recup_badge:'🟢 قابل للاسترداد', recup_title:'ربما قابل للتحصيل',
    recup_desc:'عميل بسجل دفع متذبذب مع إشارات إيجابية. يحسب الذكاء الاصطناعي احتمال التحصيل.',
    recup_a1:'نقاط احتمال الدفع 0–100', recup_a2:'استراتيجية تفاوض مخصصة بالذكاء الاصطناعي', recup_a3:'متابعة ميدانية عبر التطبيق',
    mod_label:'منصة متكاملة', mod_title:'7 وحدات متكاملة',
    mod_desc:'من كشف المخاطر إلى التحصيل الميداني، يغطي ريكوف برو كامل دورة حياة الدين.',
    m1_t:'إدارة العملاء والشركات', m1_d:'بطاقات عملاء كاملة، تاريخ المعاملات، إثراء تلقائي بالذكاء الاصطناعي.',
    m2_t:'متابعة الفواتير والديون', m2_d:'استيراد CSV أو ERP، تصنيف تلقائي، متابعة الحالة في الوقت الفعلي.',
    m3_t:'تقييم المخاطر (ذكاء اصطناعي)', m3_d:'نقاط 0–100 لكل عميل، توقع الدفع لـ 30/60/90 يوماً، تنبيه استباقي.',
    m4_t:'التذكير التلقائي', m4_d:'سلاسل بريد/SMS/واتساب قابلة للتخصيص، رسائل مُولَّدة بالذكاء الاصطناعي.',
    m5_t:'التطبيق الميداني', m5_d:'تحصيل في الموقع، تتبع جغرافي، ملخص صوتي للملف قبل الزيارة.',
    m6_t:'لوحة التحليلات', m6_d:'DSO في الوقت الفعلي، توقع السيولة، معدلات التحصيل حسب المندوب.',
    m7_t:'متعدد المستأجرين والأمن', m7_d:'مساحة معزولة لكل شركة، صلاحيات دقيقة، تشفير البيانات.',
    ai_label:'الذكاء الاصطناعي',
    ai_title:'الذكاء الاصطناعي يعمل <span class="text-red-400">24/7</span>',
    ai_f1_t:'تقييم مخاطر العميل', ai_f1_d:'يحصل كل عميل على نقاط 0–100 محدّثة فورياً بحسب سلوك الدفع والقطاع والحجم.',
    ai_f2_t:'توليد تذكيرات مخصصة', ai_f2_d:'يكتب الذكاء الاصطناعي رسائل بريد وSMS ملائمة لكل ملف عميل — أسلوب دبلوماسي أو حازم حسب التاريخ.',
    ai_f3_t:'توقع السيولة', ai_f3_d:'يتنبأ بالتحصيلات المحتملة خلال 30/60/90 يوماً بناءً على نقاط احتمال الدفع.',
    ai_f4_t:'تقرير أسبوعي تلقائي', ai_f4_d:'كل أسبوع، يرسل الذكاء الاصطناعي تقريراً تنفيذياً بأولويات الديون والتنبيهات والتوصيات.',
    app_title:'ريكوف برو موبايل', app_sub:'تذكيرات اليوم', app_btn:'📨 تذكير الكل',
    analytics_title:'معدل التحصيل', analytics_sub:'↑ +12٪ هذا الشهر',
    how_label:'بداية سريعة', how_title:'جاهز في 48 ساعة',
    step1_t:'استيراد بيانات العملاء والفواتير', step1_d:'استورد قاعدة عملائك من Excel أو ERP. يحلل ريكوف برو فوراً محفظة الديون.',
    step2_t:'التصنيف التلقائي بالذكاء الاصطناعي', step2_d:'يصنّف الذكاء الاصطناعي كل دين ويمنح نقاط مخاطر لكل عميل.',
    step3_t:'تفعيل التذكيرات التلقائية', step3_d:'اضبط سلاسل البريد/SMS/واتساب. الذكاء الاصطناعي يكتب الرسائل المناسبة لكل ملف.',
    step4_t:'متابعة فورية وتحصيل', step4_d:'لوحة تحكم مباشرة، إشعارات موبايل، تقارير أسبوعية وتحصيل ميداني عبر التطبيق.',
    form_label:'عرض مجاني', form_title:'احجز عرضك التجريبي',
    form_desc:'يقدم لك خبير ريكوف برو الحل في 30 دقيقة ويكيّفه لقطاعك.',
    contact_email_t:'البريد الإلكتروني', contact_phone_t:'الهاتف', contact_why_t:'لماذا ريكوف برو؟',
    why1:'تقييم مخاطر آني بالذكاء الاصطناعي', why2:'متعدد المستأجرين والشركات',
    why3:'تطبيق iOS/Android', why4:'تذكيرات بريد/SMS/واتساب', why5:'دعم 24/7 بالعربية والفرنسية',
    f_name:'الاسم الكامل *', f_email:'البريد الإلكتروني *', f_company:'الشركة', f_phone:'الهاتف',
    f_sector:'قطاع النشاط', f_select:'اختر',
    sec1:'البناء والعقار', sec2:'التجارة والتوزيع', sec3:'الصناعة', sec4:'خدمات B2B', sec5:'الغذائية', sec6:'أخرى',
    f_ca:'نسبة رقم الأعمال من الديون', f_employees:'عدد العملاء النشطين',
    emp1:'أقل من 20 عميل', emp2:'20 – 100 عميل', emp3:'100 – 500 عميل', emp4:'أكثر من 500 عميل',
    f_message:'اشرح مشكلتك',
    f_submit:'🚀 طلب عرض مجاني',
    f_note:'رد خلال 24 ساعة • بدون التزام • عرض مخصص',
    footer_desc:'حل SaaS لاسترداد الديون B2B بالذكاء الاصطناعي، من تطوير develop-it للمقاولات المغربية.',
    footer_product:'المنتج', footer_company:'develop-it', footer_home:'الرئيسية',
    footer_made:'صُنع بـ ❤️ في المغرب 🇲🇦',
}
};

function setLang(lang, btn) {
    document.querySelectorAll('.lang-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.documentElement.lang = lang;
    document.documentElement.dir  = lang === 'ar' ? 'rtl' : 'ltr';
    const t = T[lang];
    document.querySelectorAll('[data-i18n]').forEach(el => {
        const k = el.getAttribute('data-i18n');
        if (t[k] !== undefined) el.innerHTML = t[k];
    });
    localStorage.setItem('recovpro_lang', lang);
}

document.addEventListener('DOMContentLoaded', () => {
    const saved = localStorage.getItem('recovpro_lang');
    if (saved && saved !== 'fr') {
        const btn = document.querySelector(`.lang-btn[onclick="setLang('${saved}', this)"]`);
        if (btn) setLang(saved, btn);
    }
});
</script>
</body>
</html>