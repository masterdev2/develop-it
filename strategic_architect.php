<?php
/**
 * Strategic Architect - Contact Form Handler
 * develop-it
 */

$success_message = '';
$error_message   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_contact'])) {

    $name       = htmlspecialchars(strip_tags(trim($_POST['name']    ?? '')));
    $email      = filter_var(trim($_POST['email']   ?? ''), FILTER_SANITIZE_EMAIL);
    $goal       = htmlspecialchars(strip_tags(trim($_POST['goal']    ?? '')));
    $situation  = htmlspecialchars(strip_tags(trim($_POST['situation'] ?? '')));
    $blocker    = htmlspecialchars(strip_tags(trim($_POST['blocker'] ?? '')));
    $message    = htmlspecialchars(strip_tags(trim($_POST['message'] ?? '')));

    if (empty($name) || empty($email)) {
        $error_message = 'Veuillez remplir tous les champs obligatoires.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Adresse email invalide.';
    } else {
        $to           = 'contact@develop-it.tech';
        $subject_mail = '🎯 Strategic Architect — Nouvelle demande de ' . $name;

        $body  = "Nouvelle demande — Strategic Architect\n";
        $body .= str_repeat('─', 50) . "\n\n";
        $body .= "👤 Nom           : $name\n";
        $body .= "📧 Email         : $email\n";
        $body .= "🎯 Objectif      : " . ($goal      ?: 'Non renseigné') . "\n";
        $body .= "💼 Situation     : " . ($situation ?: 'Non renseigné') . "\n";
        $body .= "🚧 Blocage       : " . ($blocker   ?: 'Non renseigné') . "\n\n";
        $body .= "💬 Message       :\n" . ($message  ?: 'Aucun message') . "\n\n";
        $body .= str_repeat('─', 50) . "\n";
        $body .= "Envoyé le : " . date('d/m/Y à H:i') . "\n";
        $body .= "IP        : " . ($_SERVER['REMOTE_ADDR'] ?? 'N/A') . "\n";

        $headers  = "From: no-reply@develop-it.tech\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        if (mail($to, $subject_mail, $body, $headers)) {
            $success_message = 'Votre demande a été envoyée avec succès ! Nous vous contacterons sous 24h pour planifier votre session stratégique.';
        } else {
            $error_message = 'Une erreur est survenue. Veuillez réessayer ou nous contacter directement par email.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Strategic Architect | develop-it | Coach IA Personnel — Trouvez Ce Qui Vous Bloque Vraiment</title>
    <meta name="description" content="Strategic Architect par develop-it — Un coach IA qui identifie vos vrais blocages et construit un système d'action personnalisé. Diagnostic en 5 rounds, plan sur 90 jours, rappels email.">
    <meta name="keywords" content="develop-it, strategic architect, coach ia, développement personnel, productivité, coaching stratégique, plan d'action, blocages personnels, intelligence artificielle coaching">
    <meta name="author" content="develop-it">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://develop-it.tech/strategic_architect.php">

    <meta property="og:type"        content="website">
    <meta property="og:url"         content="https://develop-it.tech/strategic_architect.php">
    <meta property="og:title"       content="Strategic Architect | develop-it — Coach IA Brutal & Personnalisé">
    <meta property="og:description" content="Pas de conseils génériques. Pas de motivation vide. Votre vrai blocage, identifié. Un système construit sur mesure pour vous.">
    <meta property="og:image"       content="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=1200&q=80">
    <meta property="og:site_name"   content="develop-it">

    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="Strategic Architect | develop-it">
    <meta name="twitter:description" content="Coach IA qui identifie votre vrai blocage et construit le système pour l'éliminer.">
    <meta name="twitter:image"       content="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=1200&q=80">

    <link rel="icon" type="image/png" sizes="32x32" href="/logo.jfif">
    <link rel="apple-touch-icon" href="/logo.jfif">

    <!-- Schema.org structured data for SEO -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "SoftwareApplication",
      "name": "Strategic Architect",
      "applicationCategory": "Productivity",
      "creator": { "@type": "Organization", "name": "develop-it", "url": "https://develop-it.tech" },
      "description": "AI coaching platform that identifies personal blockers and builds 90-day personalized action systems.",
      "offers": { "@type": "Offer", "price": "0", "priceCurrency": "MAD" },
      "url": "https://develop-it.tech/strategic_architect.php"
    }
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=DM+Mono:wght@300;400;500&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --black:   #080808;
            --gold:    #c8a96e;
            --gold-dim:#7a5f2e;
            --cream:   #f5f2ec;
            --text-m:  #6b6560;
        }

        body { font-family: 'Outfit', sans-serif; background: #ffffff; }

        /* Display headings */
        .font-display { font-family: 'Playfair Display', serif; }
        .font-mono    { font-family: 'DM Mono', monospace; }

        /* Animated dark hero gradient */
        @keyframes gradientShift {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .hero-bg {
            background: linear-gradient(-45deg, #080808, #111111, #0f0b06, #1a1208);
            background-size: 400% 400%;
            animation: gradientShift 18s ease infinite;
        }

        /* Gold accent underline */
        .gold-underline {
            text-decoration: none;
            background-image: linear-gradient(var(--gold), var(--gold));
            background-repeat: no-repeat;
            background-position: 0 100%;
            background-size: 100% 2px;
        }

        /* Card hover */
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-6px); box-shadow: 0 24px 48px rgba(0,0,0,0.12); }

        /* Round card accent bar */
        .round-card { position: relative; overflow: hidden; }
        .round-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 3px;
            background: var(--gold);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }
        .round-card:hover::before { transform: scaleX(1); }

        /* Constraint badge */
        .constraint-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(200,169,110,0.12);
            border: 1px solid rgba(200,169,110,0.3);
            color: var(--gold);
            padding: 5px 14px;
            border-radius: 0;
            font-family: 'DM Mono', monospace;
            font-size: 11px;
            letter-spacing: 0.15em;
            text-transform: uppercase;
        }

        /* Section label */
        .section-eyebrow {
            font-family: 'DM Mono', monospace;
            font-size: 11px;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: var(--gold);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .section-eyebrow::before {
            content: '';
            display: block;
            width: 32px;
            height: 1px;
            background: var(--gold);
        }

        /* Quote block */
        .blockquote-sa {
            border-left: 3px solid var(--gold);
            padding-left: 24px;
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: clamp(18px, 2vw, 24px);
            color: #1a1208;
            line-height: 1.5;
        }

        /* Noise overlay */
        .noise::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            opacity: 0.5;
        }

        /* Stat counter style */
        .stat-num {
            font-family: 'Playfair Display', serif;
            font-weight: 900;
            color: var(--gold);
            line-height: 1;
        }

        /* Form inputs */
        .sa-input {
            width: 100%;
            padding: 14px 18px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.15);
            color: white;
            outline: none;
            transition: border-color 0.2s;
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
        }
        .sa-input:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(200,169,110,0.1); }
        .sa-input::placeholder { color: rgba(255,255,255,0.35); }
        .sa-input option { background: #111; color: white; }

        /* Language Switcher */
        .lang-switcher { display:flex; align-items:center; background:#f1f5f9; border-radius:9999px; padding:3px; gap:2px; }
        .lang-btn { padding:4px 12px; border-radius:9999px; font-size:13px; font-weight:600; cursor:pointer; transition:all 0.2s; border:none; background:transparent; color:#64748b; font-family: 'Outfit', sans-serif; }
        .lang-btn.active { background: var(--gold); color: white; box-shadow: 0 1px 4px rgba(200,169,110,0.4); }
        .lang-btn:hover:not(.active) { color: var(--gold-dim); }

        /* Timeline connector */
        .timeline-item { position: relative; padding-left: 48px; }
        .timeline-item::before {
            content: attr(data-num);
            position: absolute;
            left: 0; top: 0;
            width: 32px; height: 32px;
            background: var(--gold);
            color: #080808;
            font-family: 'DM Mono', monospace;
            font-size: 12px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .timeline-item::after {
            content: '';
            position: absolute;
            left: 15px; top: 32px;
            width: 1px; height: calc(100% + 24px);
            background: #e2e8f0;
        }
        .timeline-item:last-child::after { display: none; }

        html { scroll-behavior: smooth; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-hero { animation: fadeUp 0.9s ease forwards; }
        .animate-hero-2 { animation: fadeUp 0.9s 0.2s ease both; }
        .animate-hero-3 { animation: fadeUp 0.9s 0.4s ease both; }
        .animate-hero-4 { animation: fadeUp 0.9s 0.6s ease both; }

        /* Gold CTA button */
        .btn-gold {
            background: var(--gold);
            color: #080808;
            padding: 16px 40px;
            font-family: 'DM Mono', monospace;
            font-size: 13px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            text-decoration: none;
            display: inline-block;
            transition: background 0.2s, transform 0.15s;
            border: none;
            cursor: pointer;
        }
        .btn-gold:hover { background: var(--cream); transform: scale(1.03); }

        .btn-outline-gold {
            border: 1px solid rgba(200,169,110,0.5);
            color: var(--gold);
            padding: 15px 36px;
            font-family: 'DM Mono', monospace;
            font-size: 12px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
        }
        .btn-outline-gold:hover { background: rgba(200,169,110,0.1); border-color: var(--gold); }

        /* Marquee */
        @keyframes marquee { from { transform: translateX(0); } to { transform: translateX(-50%); } }
        .marquee-track { animation: marquee 28s linear infinite; white-space: nowrap; display: flex; }

        /* Report preview */
        .report-line { border-bottom: 1px solid #1e1e1e; padding-bottom: 16px; margin-bottom: 16px; }
        .report-line:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
        .report-tag { font-family: 'DM Mono', monospace; font-size: 9px; letter-spacing: 0.25em; text-transform: uppercase; color: var(--gold); margin-bottom: 6px; }
    </style>
</head>
<body class="text-slate-900">

<!-- ════════════════════════════════════════
     NAVIGATION
════════════════════════════════════════ -->
<nav class="bg-white shadow-sm sticky top-0 z-50 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-8">
            <a href="/" class="flex items-center gap-2 text-slate-600 hover:text-slate-900 transition">
                <img src="/logo.jfif" alt="develop-it" class="w-6 h-6">
                <span class="font-semibold text-sm">develop-it</span>
            </a>
            <div class="hidden md:block w-px h-5 bg-slate-200"></div>
            <a href="#" class="hidden md:flex items-center gap-2 font-bold text-lg" style="color:#080808;font-family:'Playfair Display',serif;">
                Strategic Architect
            </a>
        </div>
        <div class="hidden md:flex items-center gap-6">
            <a href="#how"     class="text-slate-500 hover:text-slate-900 transition text-sm font-medium" data-i18n="nav_how">Comment ça marche</a>
            <a href="#rounds"  class="text-slate-500 hover:text-slate-900 transition text-sm font-medium" data-i18n="nav_rounds">Le Diagnostic</a>
            <a href="#report"  class="text-slate-500 hover:text-slate-900 transition text-sm font-medium" data-i18n="nav_report">Le Rapport</a>
            <a href="#contact" class="btn-gold text-sm" data-i18n="nav_cta">Commencer →</a>
            <div class="lang-switcher">
                <button class="lang-btn active" onclick="setLang('fr', this)">🇫🇷 FR</button>
                <button class="lang-btn"        onclick="setLang('en', this)">🇬🇧 EN</button>
            </div>
        </div>
    </div>
</nav>

<!-- ════════════════════════════════════════
     HERO
════════════════════════════════════════ -->
<section class="hero-bg noise relative text-white overflow-hidden min-h-screen flex items-center">

    <!-- Background image overlay -->
    <div class="absolute inset-0 opacity-10">
        <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=1920&q=80"
             alt="" class="w-full h-full object-cover">
    </div>

    <!-- Grid pattern -->
    <div class="absolute inset-0" style="background-image: linear-gradient(rgba(200,169,110,0.04) 1px, transparent 1px), linear-gradient(90deg, rgba(200,169,110,0.04) 1px, transparent 1px); background-size: 80px 80px;"></div>

    <div class="max-w-7xl mx-auto px-6 py-32 grid md:grid-cols-2 gap-16 items-center relative z-10">
        <!-- LEFT -->
        <div>
            <div class="constraint-badge animate-hero mb-8" data-i18n="hero_badge">
                ✦ powered by develop-it
            </div>
            <h1 class="font-display text-6xl md:text-8xl font-black leading-none mb-6 animate-hero-2" style="letter-spacing:-0.02em">
                Strategic<br>
                <span style="color: var(--gold);">Architect</span>
            </h1>
            <p class="text-xl md:text-2xl text-slate-300 leading-relaxed mb-8 animate-hero-3 font-display font-bold italic" data-i18n="hero_sub">
                "Trouvez ce qui vous bloque vraiment. Pas ce que vous croyez."
            </p>
            <p class="text-slate-400 leading-relaxed mb-10 animate-hero-3 max-w-lg" data-i18n="hero_desc">
                Un coach IA qui analyse vos blocages en profondeur via 5 rounds de diagnostic, identifie le vrai frein — pas les symptômes — et construit un système d'action personnalisé sur 90 jours.
            </p>
            <div class="flex flex-wrap gap-4 animate-hero-4">
                <a href="#contact" class="btn-gold" data-i18n="hero_cta1">🚀 Démarrer le diagnostic</a>
                <a href="#how"     class="btn-outline-gold" data-i18n="hero_cta2">Découvrir le processus</a>
            </div>
            <div class="mt-12 grid grid-cols-3 gap-6 animate-hero-4">
                <div class="text-center border-r border-white/10 pr-6">
                    <div class="stat-num text-4xl mb-1">5</div>
                    <div class="text-xs font-mono text-slate-400 uppercase tracking-widest" data-i18n="stat1">Rounds<br>Diagnostic</div>
                </div>
                <div class="text-center border-r border-white/10 pr-6">
                    <div class="stat-num text-4xl mb-1">90</div>
                    <div class="text-xs font-mono text-slate-400 uppercase tracking-widest" data-i18n="stat2">Jours<br>de Plan</div>
                </div>
                <div class="text-center">
                    <div class="stat-num text-4xl mb-1">1</div>
                    <div class="text-xs font-mono text-slate-400 uppercase tracking-widest" data-i18n="stat3">Vérité<br>Essentielle</div>
                </div>
            </div>
        </div>

        <!-- RIGHT — Report Preview Card -->
        <div data-aos="fade-left" data-aos-duration="900" data-aos-delay="300">
            <div style="background:#111111; border:1px solid #1e1e1e; padding:40px; position:relative;">
                <div style="font-family:'DM Mono',monospace; font-size:9px; letter-spacing:0.3em; color:var(--gold); margin-bottom:28px; text-transform:uppercase;">
                    Exemple — Rapport Stratégique
                </div>
                <div class="report-line">
                    <div class="report-tag">La Vérité Difficile</div>
                    <div style="font-size:13px;color:#e0dcd4;line-height:1.7;">Vous n'avez pas un problème de <strong style="color:white">temps</strong>. Vous avez un problème d'<strong style="color:white">évitement déguisé en préparation</strong>.</div>
                </div>
                <div class="report-line">
                    <div class="report-tag">Contrainte Principale · C4</div>
                    <div style="font-size:13px;color:#e0dcd4;line-height:1.7;"><strong style="color:var(--gold)">Plafond d'Identité</strong> — Votre concept de vous-même ne peut pas encore contenir le niveau de succès que vous visez.</div>
                </div>
                <div class="report-line">
                    <div class="report-tag">Point de Levier</div>
                    <div style="font-size:13px;color:#e0dcd4;line-height:1.7;">Arrêtez d'optimiser votre système. <strong style="color:white">Faites la seule chose que vous évitez depuis 47 jours.</strong></div>
                </div>
                <div class="report-line">
                    <div class="report-tag">Votre Mission</div>
                    <div style="font-size:13px;color:#e0dcd4;line-height:1.7;">D'ici <strong style="color:var(--gold)">Vendredi 18h</strong> : envoyez le premier message à la personne que vous "contactez bientôt" depuis 2 mois.</div>
                </div>
                <!-- Corner accent -->
                <div style="position:absolute;bottom:0;right:0;width:40px;height:40px;border-bottom:2px solid var(--gold);border-right:2px solid var(--gold);"></div>
                <div style="position:absolute;top:0;left:0;width:40px;height:40px;border-top:2px solid var(--gold);border-left:2px solid var(--gold);"></div>
            </div>
        </div>
    </div>

    <!-- Bottom fade -->
    <div class="absolute bottom-0 left-0 right-0 h-32" style="background: linear-gradient(to bottom, transparent, #ffffff10)"></div>
</section>

<!-- ════════════════════════════════════════
     MARQUEE STRIP
════════════════════════════════════════ -->
<div style="background:var(--gold);padding:12px 0;overflow:hidden;border-top:1px solid var(--gold-dim);border-bottom:1px solid var(--gold-dim);">
    <div class="marquee-track">
        <span style="font-family:'DM Mono',monospace;font-size:13px;letter-spacing:0.15em;color:#080808;padding:0 40px;">ZERO CONSEILS GÉNÉRIQUES</span>
        <span style="font-family:'DM Mono',monospace;font-size:13px;letter-spacing:0.15em;color:#080808;padding:0 40px;">·</span>
        <span style="font-family:'DM Mono',monospace;font-size:13px;letter-spacing:0.15em;color:#080808;padding:0 40px;">HONNÊTETÉ BRUTALE</span>
        <span style="font-family:'DM Mono',monospace;font-size:13px;letter-spacing:0.15em;color:#080808;padding:0 40px;">·</span>
        <span style="font-family:'DM Mono',monospace;font-size:13px;letter-spacing:0.15em;color:#080808;padding:0 40px;">ANALYSE RACINE</span>
        <span style="font-family:'DM Mono',monospace;font-size:13px;letter-spacing:0.15em;color:#080808;padding:0 40px;">·</span>
        <span style="font-family:'DM Mono',monospace;font-size:13px;letter-spacing:0.15em;color:#080808;padding:0 40px;">PLAN 90 JOURS</span>
        <span style="font-family:'DM Mono',monospace;font-size:13px;letter-spacing:0.15em;color:#080808;padding:0 40px;">·</span>
        <span style="font-family:'DM Mono',monospace;font-size:13px;letter-spacing:0.15em;color:#080808;padding:0 40px;">RESSOURCES PERSONNALISÉES</span>
        <span style="font-family:'DM Mono',monospace;font-size:13px;letter-spacing:0.15em;color:#080808;padding:0 40px;">·</span>
        <!-- repeat -->
        <span style="font-family:'DM Mono',monospace;font-size:13px;letter-spacing:0.15em;color:#080808;padding:0 40px;">ZERO CONSEILS GÉNÉRIQUES</span>
        <span style="font-family:'DM Mono',monospace;font-size:13px;letter-spacing:0.15em;color:#080808;padding:0 40px;">·</span>
        <span style="font-family:'DM Mono',monospace;font-size:13px;letter-spacing:0.15em;color:#080808;padding:0 40px;">HONNÊTETÉ BRUTALE</span>
        <span style="font-family:'DM Mono',monospace;font-size:13px;letter-spacing:0.15em;color:#080808;padding:0 40px;">·</span>
        <span style="font-family:'DM Mono',monospace;font-size:13px;letter-spacing:0.15em;color:#080808;padding:0 40px;">ANALYSE RACINE</span>
        <span style="font-family:'DM Mono',monospace;font-size:13px;letter-spacing:0.15em;color:#080808;padding:0 40px;">·</span>
        <span style="font-family:'DM Mono',monospace;font-size:13px;letter-spacing:0.15em;color:#080808;padding:0 40px;">PLAN 90 JOURS</span>
        <span style="font-family:'DM Mono',monospace;font-size:13px;letter-spacing:0.15em;color:#080808;padding:0 40px;">·</span>
        <span style="font-family:'DM Mono',monospace;font-size:13px;letter-spacing:0.15em;color:#080808;padding:0 40px;">RESSOURCES PERSONNALISÉES</span>
        <span style="font-family:'DM Mono',monospace;font-size:13px;letter-spacing:0.15em;color:#080808;padding:0 40px;">·</span>
    </div>
</div>

<!-- ════════════════════════════════════════
     HOW IT WORKS
════════════════════════════════════════ -->
<section id="how" class="py-28 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-20 items-center">
            <!-- LEFT -->
            <div data-aos="fade-right">
                <div class="section-eyebrow mb-6" data-i18n="how_eyebrow">Comment ça fonctionne</div>
                <h2 class="font-display text-5xl md:text-6xl font-black leading-tight mb-8" data-i18n="how_title">
                    Pas de motivation.<br>
                    <span style="color:var(--gold)">Du diagnostic.</span>
                </h2>
                <p class="text-slate-600 text-lg leading-relaxed mb-10" data-i18n="how_desc">
                    La plupart des gens ne sont pas freinés par un manque d'information ou de talent. Ils sont bloqués par un ou deux schémas spécifiques — généralement invisibles à eux-mêmes. Le rôle du Strategic Architect est de trouver ces schémas, de les nommer sans pitié, et de concevoir le système exact qui les brise.
                </p>

                <div class="space-y-8">
                    <div class="timeline-item" data-num="01" data-aos="fade-up">
                        <h3 class="font-bold text-lg mb-2" data-i18n="step1_title">Vous répondez honnêtement</h3>
                        <p class="text-slate-500 text-sm leading-relaxed" data-i18n="step1_desc">5 rounds de questions conçus pour faire émerger contradictions, angles morts et schémas que vous rationalisez depuis des années. Les réponses vagues sont immédiatement challengées.</p>
                    </div>
                    <div class="timeline-item" data-num="02" data-aos="fade-up" data-aos-delay="100">
                        <h3 class="font-bold text-lg mb-2" data-i18n="step2_title">La vraie contrainte est nommée</h3>
                        <p class="text-slate-500 text-sm leading-relaxed" data-i18n="step2_desc">Pas les symptômes. La cause racine. Qu'il s'agisse d'un plafond d'identité, d'une évitement par peur, ou d'une désorientation stratégique — tout est nommé sans ménagement.</p>
                    </div>
                    <div class="timeline-item" data-num="03" data-aos="fade-up" data-aos-delay="200">
                        <h3 class="font-bold text-lg mb-2" data-i18n="step3_title">Un système est construit pour vous</h3>
                        <p class="text-slate-500 text-sm leading-relaxed" data-i18n="step3_desc">Non-négociables quotidiens, 1 métrique, changements environnementaux, plan 90 jours en 3 phases. Construit autour de votre contrainte spécifique, pas d'un template générique.</p>
                    </div>
                    <div class="timeline-item" data-num="04" data-aos="fade-up" data-aos-delay="300">
                        <h3 class="font-bold text-lg mb-2" data-i18n="step4_title">Vous êtes tenu responsable</h3>
                        <p class="text-slate-500 text-sm leading-relaxed" data-i18n="step4_desc">Rappels email personnalisés, ressources adaptées à votre contrainte, check-ins à 7 et 30 jours. La session reprend là où elle s'est arrêtée. Le standard monte avec vous.</p>
                    </div>
                </div>
            </div>

            <!-- RIGHT — image -->
            <div data-aos="fade-left" data-aos-delay="200">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=800&q=80"
                         alt="Strategic coaching session" class="w-full object-cover" style="aspect-ratio:4/5;">
                    <!-- Gold frame accent -->
                    <div class="absolute -bottom-4 -right-4 w-full h-full border-2 border-current -z-10" style="color:var(--gold)"></div>
                    <!-- Stat overlay -->
                    <div class="absolute bottom-8 left-8 right-8" style="background:rgba(8,8,8,0.92); backdrop-filter:blur(10px); padding:20px; border-left:3px solid var(--gold);">
                        <div style="font-family:'DM Mono',monospace;font-size:10px;letter-spacing:0.2em;color:var(--gold);text-transform:uppercase;margin-bottom:8px;" data-i18n="img_overlay_label">Taux de complétion du diagnostic</div>
                        <div style="font-family:'Playfair Display',serif;font-size:32px;color:white;font-weight:900;">87%</div>
                        <div style="font-size:12px;color:#6b6560;margin-top:4px;" data-i18n="img_overlay_sub">des utilisateurs atteignent le rapport complet</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════
     5 DIAGNOSTIC ROUNDS
════════════════════════════════════════ -->
<section id="rounds" class="py-28" style="background:#f8f6f2;">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="section-eyebrow justify-center mb-6" data-i18n="rounds_eyebrow">Le Protocole de Diagnostic</div>
            <h2 class="font-display text-5xl font-black mb-6" data-i18n="rounds_title">5 Rounds. 20 Questions.<br><em style="color:var(--gold)">1 Vérité.</em></h2>
            <p class="text-slate-500 text-lg max-w-2xl mx-auto" data-i18n="rounds_desc">Chaque round sonde une couche plus profonde — de la situation de surface aux schémas d'identité. Le système ne donne aucun conseil pendant le diagnostic. Il questionne, écoute, et construit une image complète.</p>
        </div>

        <div class="grid md:grid-cols-5 gap-4">
            <!-- Round 1 -->
            <div class="round-card bg-white p-8 shadow-sm card-hover" data-aos="fade-up">
                <div style="font-family:'DM Mono',monospace;font-size:10px;letter-spacing:0.2em;color:var(--gold);margin-bottom:16px;text-transform:uppercase;">Round 01</div>
                <div class="font-display font-bold text-xl mb-3 leading-tight" data-i18n="r1_title">Réalité<br>Actuelle</div>
                <p class="text-slate-500 text-sm leading-relaxed" data-i18n="r1_desc">Où vous en êtes, ce que vous voulez, et ce que vous croyez être le problème. L'écart entre votre problème déclaré et le vrai commence ici.</p>
            </div>
            <!-- Round 2 -->
            <div class="round-card bg-white p-8 shadow-sm card-hover" data-aos="fade-up" data-aos-delay="80">
                <div style="font-family:'DM Mono',monospace;font-size:10px;letter-spacing:0.2em;color:var(--gold);margin-bottom:16px;text-transform:uppercase;">Round 02</div>
                <div class="font-display font-bold text-xl mb-3 leading-tight" data-i18n="r2_title">Audit<br>d'Exécution</div>
                <p class="text-slate-500 text-sm leading-relaxed" data-i18n="r2_desc">Le goulot est-il stratégique (mauvaise direction) ou exécutif (pas assez vite) ? La plupart des gens confondent les deux.</p>
            </div>
            <!-- Round 3 -->
            <div class="round-card bg-white p-8 shadow-sm card-hover" data-aos="fade-up" data-aos-delay="160">
                <div style="font-family:'DM Mono',monospace;font-size:10px;letter-spacing:0.2em;color:var(--gold);margin-bottom:16px;text-transform:uppercase;">Round 03</div>
                <div class="font-display font-bold text-xl mb-3 leading-tight" data-i18n="r3_title">Audit<br>Environnement</div>
                <p class="text-slate-500 text-sm leading-relaxed" data-i18n="r3_desc">Votre environnement travaille pour ou contre vous. La volonté ne peut pas durablement compenser un environnement hostile.</p>
            </div>
            <!-- Round 4 -->
            <div class="round-card bg-white p-8 shadow-sm card-hover" data-aos="fade-up" data-aos-delay="240">
                <div style="font-family:'DM Mono',monospace;font-size:10px;letter-spacing:0.2em;color:var(--gold);margin-bottom:16px;text-transform:uppercase;">Round 04</div>
                <div class="font-display font-bold text-xl mb-3 leading-tight" data-i18n="r4_title">Croyances<br>& Identité</div>
                <p class="text-slate-500 text-sm leading-relaxed" data-i18n="r4_desc">L'histoire que vous racontez sur pourquoi vous êtes bloqué est presque toujours un mécanisme de défense. Ce round la met au jour.</p>
            </div>
            <!-- Round 5 -->
            <div class="round-card bg-white p-8 shadow-sm card-hover" data-aos="fade-up" data-aos-delay="320">
                <div style="font-family:'DM Mono',monospace;font-size:10px;letter-spacing:0.2em;color:var(--gold);margin-bottom:16px;text-transform:uppercase;">Round 05</div>
                <div class="font-display font-bold text-xl mb-3 leading-tight" data-i18n="r5_title">Engagement<br>& Enjeux</div>
                <p class="text-slate-500 text-sm leading-relaxed" data-i18n="r5_desc">Êtes-vous vraiment engagé ou vous explorez l'idée ? Les plans construits pour les non-engagés sont inutiles. Ce round le détermine.</p>
            </div>
        </div>

        <!-- Quote -->
        <div class="mt-16 max-w-3xl mx-auto text-center" data-aos="fade-up">
            <blockquote class="blockquote-sa text-center" data-i18n="round_quote">
                "Les gens ne sont pas bloqués par manque d'information. Ils sont bloqués par un ou deux schémas spécifiques — généralement invisibles à eux-mêmes."
            </blockquote>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════
     6 CONSTRAINT CATEGORIES
════════════════════════════════════════ -->
<section class="py-28 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="section-eyebrow justify-center mb-6" data-i18n="cat_eyebrow">Ce que le système identifie</div>
            <h2 class="font-display text-5xl font-black mb-6" data-i18n="cat_title">6 Catégories de Contrainte</h2>
            <p class="text-slate-500 text-lg max-w-2xl mx-auto" data-i18n="cat_desc">Après l'analyse complète, la contrainte principale est nommée avec précision. En retirer une seule débloque tout le reste.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="p-8 bg-slate-50 border border-slate-200 card-hover" data-aos="fade-up">
                <div class="constraint-badge mb-6">C1</div>
                <h3 class="font-bold text-xl mb-3" data-i18n="c1_title">Désorientation Stratégique</h3>
                <p class="text-slate-500 text-sm leading-relaxed" data-i18n="c1_desc">Beaucoup d'effort, mauvais levier. L'objectif est clair mais le chemin choisi n'y mène pas efficacement — ou pas du tout.</p>
            </div>
            <div class="p-8 bg-slate-50 border border-slate-200 card-hover" data-aos="fade-up" data-aos-delay="80">
                <div class="constraint-badge mb-6">C2</div>
                <h3 class="font-bold text-xl mb-3" data-i18n="c2_title">Déficit d'Exécution</h3>
                <p class="text-slate-500 text-sm leading-relaxed" data-i18n="c2_desc">La stratégie est solide mais l'exécution est inconstante. Bon départ, perte de momentum. Les plans s'accumulent, les actions pas.</p>
            </div>
            <div class="p-8 bg-slate-50 border border-slate-200 card-hover" data-aos="fade-up" data-aos-delay="160">
                <div class="constraint-badge mb-6">C3</div>
                <h3 class="font-bold text-xl mb-3" data-i18n="c3_title">Frein Environnemental</h3>
                <p class="text-slate-500 text-sm leading-relaxed" data-i18n="c3_desc">L'environnement (cercle social, espace physique, structure quotidienne) travaille activement contre vos objectifs.</p>
            </div>
            <div class="p-8 bg-slate-50 border border-slate-200 card-hover" data-aos="fade-up" data-aos-delay="0">
                <div class="constraint-badge mb-6">C4</div>
                <h3 class="font-bold text-xl mb-3" data-i18n="c4_title">Plafond d'Identité</h3>
                <p class="text-slate-500 text-sm leading-relaxed" data-i18n="c4_desc">Votre concept actuel de vous-même ne peut pas contenir le niveau de succès que vous visez. À chaque approche du seuil, un comportement inconscient vous ramène en arrière.</p>
            </div>
            <div class="p-8 bg-slate-50 border border-slate-200 card-hover" data-aos="fade-up" data-aos-delay="80">
                <div class="constraint-badge mb-6">C5</div>
                <h3 class="font-bold text-xl mb-3" data-i18n="c5_title">Évitement par la Peur</h3>
                <p class="text-slate-500 text-sm leading-relaxed" data-i18n="c5_desc">Les actions les plus importantes sont constamment déprioritisées. Ce n'est pas de la paresse — c'est la peur du jugement, de l'échec, ou du succès.</p>
            </div>
            <div class="p-8 bg-slate-50 border border-slate-200 card-hover" data-aos="fade-up" data-aos-delay="160">
                <div class="constraint-badge mb-6">C6</div>
                <h3 class="font-bold text-xl mb-3" data-i18n="c6_title">Fossé d'Engagement</h3>
                <p class="text-slate-500 text-sm leading-relaxed" data-i18n="c6_desc">L'objectif est désiré mais pas vraiment engagé. L'utilisateur explore l'idée du succès plutôt que de le poursuivre. Sans engagement réel, aucun système ne tiendra.</p>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════
     REPORT DEEP DIVE
════════════════════════════════════════ -->
<section id="report" class="py-28" style="background:#080808;">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-20 items-start">
            <!-- LEFT -->
            <div data-aos="fade-right">
                <div class="section-eyebrow mb-6" style="color:var(--gold)" data-i18n="rep_eyebrow">Le Rapport Stratégique</div>
                <h2 class="font-display text-5xl font-black leading-tight mb-6 text-white" data-i18n="rep_title">
                    Après le diagnostic,<br>
                    <em style="color:var(--gold)">la vérité.</em>
                </h2>
                <p class="text-slate-400 leading-relaxed mb-10" data-i18n="rep_desc">
                    Une fois les 5 rounds complétés, vous recevez un rapport stratégique complet — pas un discours de motivation, pas un plan générique. Une analyse précise de qui vous êtes, ce qui vous bloque réellement, et le système exact pour y remédier.
                </p>

                <!-- Report sections list -->
                <div class="space-y-4">
                    <?php
                    $sections = [
                        ['01', 'rep_s1', 'La Vérité Difficile', "La chose la plus importante que vous avez évitée d'entendre. Max 4 phrases. Spécifique à vos réponses."],
                        ['02', 'rep_s2', 'Qui Vous Êtes Vraiment', "Pas qui vous voulez être. Qui vos actions révèlent que vous êtes — schéma dominant, force principale, mécanisme de sabotage."],
                        ['03', 'rep_s3', 'Contrainte Principale', "La cause racine unique. Nommée clairement, avec des preuves tirées de vos réponses. Retirez-la, tout le reste se débloque."],
                        ['04', 'rep_s4', 'Angles Morts', "Ce que vous ne pouvez pas voir sur vous-même — dérivé des contradictions entre ce que vous avez dit et ce que vos réponses ont révélé."],
                        ['05', 'rep_s5', 'Le Point de Levier', "L'action ou le changement à plus fort effet de levier disponible pour vous maintenant. Pas une liste de tâches — un point focal."],
                        ['06', 'rep_s6', 'Le Système', "3 non-négociables quotidiens max, structure de revue hebdomadaire, 1 métrique à suivre, changements environnementaux requis."],
                        ['07', 'rep_s7', 'Plan Opérationnel 90 Jours', "3 phases de 30 jours. Chacune avec un objectif primaire, 2-3 actions spécifiques, et une métrique de succès binaire."],
                        ['08', 'rep_s8', 'Votre Mission', "Une tâche spécifique à accomplir avant la prochaine session. Deadline claire. Métrique binaire : fait ou pas fait."],
                    ];
                    foreach ($sections as $s):
                    ?>
                    <div style="display:flex;gap:16px;align-items:flex-start;padding:16px 0;border-bottom:1px solid #1e1e1e;">
                        <div style="font-family:'DM Mono',monospace;font-size:18px;color:var(--gold);min-width:32px;font-weight:900;line-height:1;margin-top:2px;"><?= $s[0] ?></div>
                        <div>
                            <div style="font-size:13px;color:white;font-weight:600;margin-bottom:4px;letter-spacing:0.02em;" data-i18n="<?= $s[1] ?>_title"><?= $s[2] ?></div>
                            <div style="font-size:11px;color:#5a5550;line-height:1.6;" data-i18n="<?= $s[1] ?>_desc"><?= $s[3] ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- RIGHT — features + image -->
            <div data-aos="fade-left" data-aos-delay="200">
                <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=700&q=80"
                     alt="Strategic planning" class="w-full object-cover mb-8" style="aspect-ratio:16/9;">

                <!-- Feature pills -->
                <div class="grid grid-cols-2 gap-4">
                    <?php
                    $features = [
                        ['📧', 'rep_f1', 'Rappels Email', 'Personnalisés selon votre mission et schéma de blocage'],
                        ['📚', 'rep_f2', 'Ressources Adaptées', 'Cours, livres, outils sélectionnés pour votre contrainte spécifique'],
                        ['🔄', 'rep_f3', 'Check-ins 30 Jours', 'Re-diagnostic condensé : qu\'est-ce qui a changé, qu\'est-ce qui n\'a pas changé'],
                        ['⚡', 'rep_f4', 'Accountability', 'Si vous revenez sans avoir complété votre mission, ce sera adressé avant tout le reste'],
                    ];
                    foreach ($features as $f):
                    ?>
                    <div style="background:#111;border:1px solid #1e1e1e;padding:20px;">
                        <div style="font-size:24px;margin-bottom:10px;"><?= $f[0] ?></div>
                        <div style="font-size:12px;color:white;font-weight:600;margin-bottom:6px;letter-spacing:0.05em;" data-i18n="<?= $f[1] ?>_title"><?= $f[2] ?></div>
                        <div style="font-size:11px;color:#5a5550;line-height:1.5;" data-i18n="<?= $f[1] ?>_desc"><?= $f[3] ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════
     TESTIMONIALS / SOCIAL PROOF
════════════════════════════════════════ -->
<section class="py-28 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="section-eyebrow justify-center mb-6" data-i18n="test_eyebrow">Ce que ça révèle</div>
            <h2 class="font-display text-5xl font-black" data-i18n="test_title">La réalité derrière les blocages</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="p-8 border border-slate-200 card-hover" data-aos="fade-up">
                <div style="color:var(--gold);font-size:32px;margin-bottom:16px;font-family:'Playfair Display',serif;">"</div>
                <blockquote class="text-slate-700 text-sm leading-relaxed mb-6" data-i18n="test1_quote">
                    Je croyais que mon problème était le manque de temps. Le diagnostic a révélé que je consacrais 3h/jour à des tâches à faible impact pour éviter la seule action qui comptait vraiment.
                </blockquote>
                <div class="flex items-center gap-3">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=60&h=60&q=80" alt="Utilisateur" class="w-10 h-10 rounded-full object-cover">
                    <div>
                        <div class="font-bold text-sm" data-i18n="test1_name">Karim B.</div>
                        <div class="text-slate-400 text-xs font-mono" data-i18n="test1_role">Entrepreneur, Casablanca</div>
                    </div>
                </div>
            </div>
            <div class="p-8 border border-slate-200 card-hover" data-aos="fade-up" data-aos-delay="100">
                <div style="color:var(--gold);font-size:32px;margin-bottom:16px;font-family:'Playfair Display',serif;">"</div>
                <blockquote class="text-slate-700 text-sm leading-relaxed mb-6" data-i18n="test2_quote">
                    Round 4 m'a complètement déstabilisé. J'ai réalisé que ma peur n'était pas l'échec — c'était le succès et ce qu'il impliquait pour mon identité. Je n'avais jamais vu ça aussi clairement.
                </blockquote>
                <div class="flex items-center gap-3">
                    <img src="https://images.unsplash.com/photo-1494790108755-2616b612b977?auto=format&fit=crop&w=60&h=60&q=80" alt="Utilisateur" class="w-10 h-10 rounded-full object-cover">
                    <div>
                        <div class="font-bold text-sm" data-i18n="test2_name">Sara M.</div>
                        <div class="text-slate-400 text-xs font-mono" data-i18n="test2_role">Manager, Rabat</div>
                    </div>
                </div>
            </div>
            <div class="p-8 border border-slate-200 card-hover" data-aos="fade-up" data-aos-delay="200">
                <div style="color:var(--gold);font-size:32px;margin-bottom:16px;font-family:'Playfair Display',serif;">"</div>
                <blockquote class="text-slate-700 text-sm leading-relaxed mb-6" data-i18n="test3_quote">
                    Le rapport a été brutalement précis. Contrainte C2, déficit d'exécution. Le système de 3 non-négociables quotidiens a changé ma productivité en 2 semaines. Simple, mais impossible à ignorer.
                </blockquote>
                <div class="flex items-center gap-3">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=60&h=60&q=80" alt="Utilisateur" class="w-10 h-10 rounded-full object-cover">
                    <div>
                        <div class="font-bold text-sm" data-i18n="test3_name">Youssef A.</div>
                        <div class="text-slate-400 text-xs font-mono" data-i18n="test3_role">Développeur, Agadir</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════
     CONTACT / CTA
════════════════════════════════════════ -->
<section id="contact" style="background:#080808;color:white;" class="py-28">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="section-eyebrow justify-center mb-6" style="color:var(--gold)" data-i18n="contact_eyebrow">Commencer le diagnostic</div>
            <h2 class="font-display text-5xl md:text-6xl font-black mb-6 text-white" data-i18n="contact_title">
                Arrêtez de théoriser.<br>
                <em style="color:var(--gold)">Diagnostiquez.</em>
            </h2>
            <p class="text-slate-400 text-lg max-w-2xl mx-auto" data-i18n="contact_desc">
                Le schéma qui vous bloque ne se révèle pas par plus de recherches, de planification ou de préparation. Il se révèle par les bonnes questions — posées sans pitié.
            </p>
        </div>

        <!-- Contact info cards -->
        <div class="grid md:grid-cols-2 gap-6 mb-12">
            <div style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);padding:32px;" class="card-hover" data-aos="fade-right">
                <div class="text-4xl mb-4">📧</div>
                <h3 class="text-xl font-bold mb-2" data-i18n="email_title">Email</h3>
                <p class="text-slate-400 text-sm mb-4" data-i18n="email_desc">Contactez-nous directement</p>
                <a href="mailto:contact@develop-it.tech" style="color:var(--gold);font-family:'DM Mono',monospace;font-size:14px;">contact@develop-it.tech</a>
            </div>
            <div style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);padding:32px;" class="card-hover" data-aos="fade-left">
                <div class="text-4xl mb-4">📞</div>
                <h3 class="text-xl font-bold mb-2" data-i18n="phone_title">Téléphone</h3>
                <p class="text-slate-400 text-sm mb-4" data-i18n="phone_desc">Appelez-nous directement</p>
                <a href="tel:+2120611191926" style="color:var(--gold);font-family:'DM Mono',monospace;font-size:14px;">+212 06 11 19 19 26</a>
            </div>
        </div>

        <!-- FORM -->
        <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);padding:48px;" data-aos="fade-up">
            <h3 class="font-display text-3xl font-bold mb-2 text-center" data-i18n="form_title">Démarrer votre session gratuite</h3>
            <p class="text-center text-slate-500 text-sm mb-10 font-mono" data-i18n="form_sub">Les réponses vagues donnent des résultats vagues.</p>

            <?php if (!empty($success_message)): ?>
            <div style="background:rgba(74,140,92,0.1);border:1px solid rgba(74,140,92,0.3);color:#90c09a;padding:18px 24px;margin-bottom:24px;display:flex;align-items:center;gap:12px;">
                <svg style="width:24px;height:24px;color:#4a8c5c;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span><?php echo $success_message; ?></span>
            </div>
            <?php endif; ?>

            <?php if (!empty($error_message)): ?>
            <div style="background:rgba(140,74,74,0.1);border:1px solid rgba(140,74,74,0.3);color:#e09090;padding:18px 24px;margin-bottom:24px;display:flex;align-items:center;gap:12px;">
                <svg style="width:24px;height:24px;color:#8c4a4a;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span><?php echo $error_message; ?></span>
            </div>
            <?php endif; ?>

            <form method="POST" action="#contact" class="space-y-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label style="display:block;font-family:'DM Mono',monospace;font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:rgba(255,255,255,0.4);margin-bottom:10px;" data-i18n="f_name">Nom complet *</label>
                        <input type="text" name="name" required
                               value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
                               class="sa-input" placeholder="Votre nom">
                    </div>
                    <div>
                        <label style="display:block;font-family:'DM Mono',monospace;font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:rgba(255,255,255,0.4);margin-bottom:10px;" data-i18n="f_email">Email *</label>
                        <input type="email" name="email" required
                               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                               class="sa-input" placeholder="votre@email.com">
                    </div>
                </div>
                <div>
                    <label style="display:block;font-family:'DM Mono',monospace;font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:rgba(255,255,255,0.4);margin-bottom:10px;" data-i18n="f_goal">Qu'essayez-vous de construire ou d'accomplir ?</label>
                    <input type="text" name="goal"
                           value="<?php echo htmlspecialchars($_POST['goal'] ?? ''); ?>"
                           class="sa-input" placeholder="Soyez spécifique — pas « liberté financière », mais ce que votre vie ressemble dans 3 ans">
                </div>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label style="display:block;font-family:'DM Mono',monospace;font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:rgba(255,255,255,0.4);margin-bottom:10px;" data-i18n="f_situation">Situation actuelle</label>
                        <select name="situation" class="sa-input">
                            <option value="" data-i18n="f_select">Sélectionnez</option>
                            <option value="Entrepreneur/Fondateur"    <?php echo (($_POST['situation'] ?? '') === 'Entrepreneur/Fondateur')    ? 'selected' : ''; ?> data-i18n="sit1">Entrepreneur / Fondateur</option>
                            <option value="Salarié cherchant à évoluer" <?php echo (($_POST['situation'] ?? '') === 'Salarié cherchant à évoluer') ? 'selected' : ''; ?> data-i18n="sit2">Salarié cherchant à évoluer</option>
                            <option value="Freelance/Consultant"      <?php echo (($_POST['situation'] ?? '') === 'Freelance/Consultant')      ? 'selected' : ''; ?> data-i18n="sit3">Freelance / Consultant</option>
                            <option value="En transition de carrière"  <?php echo (($_POST['situation'] ?? '') === 'En transition de carrière')  ? 'selected' : ''; ?> data-i18n="sit4">En transition de carrière</option>
                            <option value="Étudiant/Jeune diplômé"    <?php echo (($_POST['situation'] ?? '') === 'Étudiant/Jeune diplômé')    ? 'selected' : ''; ?> data-i18n="sit5">Étudiant / Jeune diplômé</option>
                            <option value="Autre"                      <?php echo (($_POST['situation'] ?? '') === 'Autre')                      ? 'selected' : ''; ?> data-i18n="sit6">Autre</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block;font-family:'DM Mono',monospace;font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:rgba(255,255,255,0.4);margin-bottom:10px;" data-i18n="f_blocker">Ce qui vous bloque (selon vous)</label>
                        <select name="blocker" class="sa-input">
                            <option value="" data-i18n="f_select">Sélectionnez</option>
                            <option value="Manque de temps"    <?php echo (($_POST['blocker'] ?? '') === 'Manque de temps')    ? 'selected' : ''; ?> data-i18n="blk1">Manque de temps</option>
                            <option value="Manque de motivation" <?php echo (($_POST['blocker'] ?? '') === 'Manque de motivation') ? 'selected' : ''; ?> data-i18n="blk2">Manque de motivation</option>
                            <option value="Pas de direction claire" <?php echo (($_POST['blocker'] ?? '') === 'Pas de direction claire') ? 'selected' : ''; ?> data-i18n="blk3">Pas de direction claire</option>
                            <option value="Peur de l'échec"    <?php echo (($_POST['blocker'] ?? '') === "Peur de l'échec")    ? 'selected' : ''; ?> data-i18n="blk4">Peur de l'échec</option>
                            <option value="Environnement non-aidant" <?php echo (($_POST['blocker'] ?? '') === 'Environnement non-aidant') ? 'selected' : ''; ?> data-i18n="blk5">Environnement non-aidant</option>
                            <option value="Je ne sais pas"     <?php echo (($_POST['blocker'] ?? '') === 'Je ne sais pas')     ? 'selected' : ''; ?> data-i18n="blk6">Je ne sais pas exactement</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label style="display:block;font-family:'DM Mono',monospace;font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:rgba(255,255,255,0.4);margin-bottom:10px;" data-i18n="f_message">Message / Contexte supplémentaire</label>
                    <textarea name="message" rows="5" class="sa-input" style="resize:none;"
                              placeholder="Qu'avez-vous déjà essayé ? Qu'est-ce qui s'est passé ?"><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                </div>
                <div class="text-center pt-4">
                    <button type="submit" name="submit_contact" class="btn-gold text-base" data-i18n="f_submit">
                        🎯 Démarrer mon diagnostic gratuit
                    </button>
                    <p style="margin-top:16px;font-family:'DM Mono',monospace;font-size:11px;color:#3a3730;letter-spacing:0.05em;" data-i18n="f_note">Réponse sous 24h · Aucun engagement · develop-it</p>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════
     FOOTER
════════════════════════════════════════ -->
<footer class="bg-black text-slate-400 py-16">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-4 gap-10 mb-10">
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <img src="/logo.jfif" alt="develop-it" class="w-6 h-6">
                    <span class="text-white font-bold text-lg">develop-it</span>
                </div>
                <div class="font-display text-white font-bold text-xl mb-3" style="color:var(--gold)">Strategic Architect</div>
                <p class="text-sm leading-relaxed" data-i18n="footer_desc">Coach IA personnel. Diagnostic brutal. Système sur mesure. Plan 90 jours.</p>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider font-mono" data-i18n="footer_process">Processus</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#how"    class="hover:text-white transition" data-i18n="nav_how">Comment ça marche</a></li>
                    <li><a href="#rounds" class="hover:text-white transition" data-i18n="nav_rounds">Les 5 Rounds</a></li>
                    <li><a href="#report" class="hover:text-white transition" data-i18n="nav_report">Le Rapport</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider font-mono" data-i18n="footer_features">Fonctionnalités</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#rounds" class="hover:text-white transition" data-i18n="feat_diag">Diagnostic IA</a></li>
                    <li><a href="#report" class="hover:text-white transition" data-i18n="feat_resources">Ressources Personnalisées</a></li>
                    <li><a href="#contact" class="hover:text-white transition" data-i18n="feat_email">Rappels Email</a></li>
                    <li><a href="#report"  class="hover:text-white transition" data-i18n="feat_plan">Plan 90 Jours</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider font-mono" data-i18n="footer_company">Entreprise</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="/" class="hover:text-white transition" data-i18n="footer_about">À propos de develop-it</a></li>
                    <li><a href="#contact" class="hover:text-white transition" data-i18n="nav_cta">Contact</a></li>
                    <li><a href="mailto:contact@develop-it.tech" class="hover:text-white transition">contact@develop-it.tech</a></li>
                </ul>
                <div class="flex gap-3 mt-6">
                    <a href="#" style="width:36px;height:36px;background:#1a1a1a;display:flex;align-items:center;justify-content:center;transition:background 0.2s;" class="hover:bg-amber-800" aria-label="Facebook">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" style="width:36px;height:36px;background:#1a1a1a;display:flex;align-items:center;justify-content:center;transition:background 0.2s;" class="hover:bg-blue-900" aria-label="LinkedIn">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                </div>
            </div>
        </div>
        <div style="border-top:1px solid #1a1a1a;padding-top:32px;text-align:center;font-size:13px;font-family:'DM Mono',monospace;letter-spacing:0.05em;">
            <p>© 2026 <strong style="color:white">develop-it</strong> · Strategic Architect — Coach IA Personnel · Tous droits réservés</p>
        </div>
    </div>
</footer>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({ duration: 900, once: true, offset: 80 });

// ─── Language Switcher ──────────────────────────────────────────────
const translations = {
    fr: {
        nav_how:'Comment ça marche', nav_rounds:'Le Diagnostic', nav_report:'Le Rapport', nav_cta:'Commencer →',
        hero_badge:'✦ powered by develop-it',
        hero_sub:'"Trouvez ce qui vous bloque vraiment. Pas ce que vous croyez."',
        hero_desc:'Un coach IA qui analyse vos blocages en profondeur via 5 rounds de diagnostic, identifie le vrai frein — pas les symptômes — et construit un système d\'action personnalisé sur 90 jours.',
        hero_cta1:'🚀 Démarrer le diagnostic', hero_cta2:'Découvrir le processus',
        stat1:'Rounds<br>Diagnostic', stat2:'Jours<br>de Plan', stat3:'Vérité<br>Essentielle',
        how_eyebrow:'Comment ça fonctionne',
        how_title:'Pas de motivation.<br><span style="color:var(--gold)">Du diagnostic.</span>',
        how_desc:'La plupart des gens ne sont pas freinés par un manque d\'information ou de talent. Ils sont bloqués par un ou deux schémas spécifiques — généralement invisibles à eux-mêmes.',
        step1_title:'Vous répondez honnêtement', step1_desc:'5 rounds de questions conçus pour faire émerger contradictions et schémas que vous rationalisez depuis des années.',
        step2_title:'La vraie contrainte est nommée', step2_desc:'Pas les symptômes. La cause racine. Qu\'il s\'agisse d\'un plafond d\'identité ou d\'une évitement par peur — tout est nommé sans ménagement.',
        step3_title:'Un système est construit pour vous', step3_desc:'Non-négociables quotidiens, 1 métrique, changements environnementaux, plan 90 jours. Construit autour de votre contrainte spécifique.',
        step4_title:'Vous êtes tenu responsable', step4_desc:'Rappels email personnalisés, ressources adaptées, check-ins à 7 et 30 jours. La session reprend là où elle s\'est arrêtée.',
        img_overlay_label:'Taux de complétion du diagnostic', img_overlay_sub:'des utilisateurs atteignent le rapport complet',
        rounds_eyebrow:'Le Protocole de Diagnostic',
        rounds_title:'5 Rounds. 20 Questions.<br><em style="color:var(--gold)">1 Vérité.</em>',
        rounds_desc:'Chaque round sonde une couche plus profonde — de la situation de surface aux schémas d\'identité.',
        r1_title:'Réalité<br>Actuelle', r1_desc:'Où vous en êtes, ce que vous voulez, et ce que vous croyez être le problème.',
        r2_title:'Audit<br>d\'Exécution', r2_desc:'Le goulot est-il stratégique ou exécutif ? La plupart des gens confondent les deux.',
        r3_title:'Audit<br>Environnement', r3_desc:'Votre environnement travaille pour ou contre vous.',
        r4_title:'Croyances<br>& Identité', r4_desc:'L\'histoire sur pourquoi vous êtes bloqué est presque toujours un mécanisme de défense.',
        r5_title:'Engagement<br>& Enjeux', r5_desc:'Êtes-vous vraiment engagé ou vous explorez l\'idée ?',
        round_quote:'"Les gens ne sont pas bloqués par manque d\'information. Ils sont bloqués par un ou deux schémas spécifiques — généralement invisibles à eux-mêmes."',
        cat_eyebrow:'Ce que le système identifie', cat_title:'6 Catégories de Contrainte', cat_desc:'Après l\'analyse complète, la contrainte principale est nommée avec précision.',
        c1_title:'Désorientation Stratégique', c1_desc:'Beaucoup d\'effort, mauvais levier. Le chemin choisi n\'y mène pas efficacement.',
        c2_title:'Déficit d\'Exécution', c2_desc:'La stratégie est solide mais l\'exécution est inconstante. Les plans s\'accumulent, les actions pas.',
        c3_title:'Frein Environnemental', c3_desc:'L\'environnement (cercle social, espace physique) travaille activement contre vos objectifs.',
        c4_title:'Plafond d\'Identité', c4_desc:'Votre concept de vous-même ne peut pas contenir le niveau de succès que vous visez.',
        c5_title:'Évitement par la Peur', c5_desc:'Les actions les plus importantes sont constamment déprioritisées. Ce n\'est pas de la paresse.',
        c6_title:'Fossé d\'Engagement', c6_desc:'L\'objectif est désiré mais pas vraiment engagé. Sans engagement réel, aucun système ne tiendra.',
        rep_eyebrow:'Le Rapport Stratégique', rep_title:'Après le diagnostic,<br><em style="color:var(--gold)">la vérité.</em>',
        rep_desc:'Une fois les 5 rounds complétés, vous recevez un rapport stratégique complet — pas un discours de motivation, pas un plan générique.',
        rep_s1_title:'La Vérité Difficile', rep_s1_desc:'La chose la plus importante que vous avez évitée d\'entendre.',
        rep_s2_title:'Qui Vous Êtes Vraiment', rep_s2_desc:'Schéma dominant, force principale, mécanisme de sabotage.',
        rep_s3_title:'Contrainte Principale', rep_s3_desc:'La cause racine unique. Retirez-la, tout le reste se débloque.',
        rep_s4_title:'Angles Morts', rep_s4_desc:'Ce que vous ne pouvez pas voir sur vous-même.',
        rep_s5_title:'Le Point de Levier', rep_s5_desc:'L\'action à plus fort effet de levier disponible maintenant.',
        rep_s6_title:'Le Système', rep_s6_desc:'3 non-négociables max, 1 métrique, changements environnementaux.',
        rep_s7_title:'Plan 90 Jours', rep_s7_desc:'3 phases de 30 jours avec objectifs et métriques binaires.',
        rep_s8_title:'Votre Mission', rep_s8_desc:'Une tâche spécifique. Deadline claire. Fait ou pas fait.',
        rep_f1_title:'Rappels Email', rep_f1_desc:'Personnalisés selon votre mission et schéma de blocage',
        rep_f2_title:'Ressources Adaptées', rep_f2_desc:'Cours, livres, outils sélectionnés pour votre contrainte',
        rep_f3_title:'Check-ins 30 Jours', rep_f3_desc:'Re-diagnostic condensé : qu\'est-ce qui a changé',
        rep_f4_title:'Accountability', rep_f4_desc:'Si vous revenez sans avoir complété votre mission, ce sera adressé avant tout',
        test_eyebrow:'Ce que ça révèle', test_title:'La réalité derrière les blocages',
        test1_quote:'Je croyais que mon problème était le manque de temps. Le diagnostic a révélé que je consacrais 3h/jour à des tâches à faible impact pour éviter la seule action qui comptait vraiment.',
        test1_name:'Karim B.', test1_role:'Entrepreneur, Casablanca',
        test2_quote:'Round 4 m\'a complètement déstabilisé. J\'ai réalisé que ma peur n\'était pas l\'échec — c\'était le succès et ce qu\'il impliquait pour mon identité.',
        test2_name:'Sara M.', test2_role:'Manager, Rabat',
        test3_quote:'Le rapport a été brutalement précis. Contrainte C2. Le système de 3 non-négociables quotidiens a changé ma productivité en 2 semaines.',
        test3_name:'Youssef A.', test3_role:'Développeur, Agadir',
        contact_eyebrow:'Commencer le diagnostic',
        contact_title:'Arrêtez de théoriser.<br><em style="color:var(--gold)">Diagnostiquez.</em>',
        contact_desc:'Le schéma qui vous bloque ne se révèle pas par plus de recherches ou de planification. Il se révèle par les bonnes questions — posées sans pitié.',
        email_title:'Email', email_desc:'Contactez-nous directement',
        phone_title:'Téléphone', phone_desc:'Appelez-nous directement',
        form_title:'Démarrer votre session gratuite', form_sub:'Les réponses vagues donnent des résultats vagues.',
        f_name:'Nom complet *', f_email:'Email *', f_goal:'Qu\'essayez-vous de construire ou d\'accomplir ?',
        f_situation:'Situation actuelle', f_blocker:'Ce qui vous bloque (selon vous)', f_select:'Sélectionnez',
        sit1:'Entrepreneur / Fondateur', sit2:'Salarié cherchant à évoluer', sit3:'Freelance / Consultant',
        sit4:'En transition de carrière', sit5:'Étudiant / Jeune diplômé', sit6:'Autre',
        blk1:'Manque de temps', blk2:'Manque de motivation', blk3:'Pas de direction claire',
        blk4:'Peur de l\'échec', blk5:'Environnement non-aidant', blk6:'Je ne sais pas exactement',
        f_message:'Message / Contexte supplémentaire', f_submit:'🎯 Démarrer mon diagnostic gratuit',
        f_note:'Réponse sous 24h · Aucun engagement · develop-it',
        footer_desc:'Coach IA personnel. Diagnostic brutal. Système sur mesure. Plan 90 jours.',
        footer_process:'Processus', footer_features:'Fonctionnalités', footer_company:'Entreprise',
        feat_diag:'Diagnostic IA', feat_resources:'Ressources Personnalisées', feat_email:'Rappels Email', feat_plan:'Plan 90 Jours',
        footer_about:'À propos de develop-it',
    },
    en: {
        nav_how:'How It Works', nav_rounds:'The Diagnosis', nav_report:'The Report', nav_cta:'Get Started →',
        hero_badge:'✦ powered by develop-it',
        hero_sub:'"Find what\'s actually holding you back. Not what you think."',
        hero_desc:'An AI coach that deeply analyzes your blockers through a 5-round diagnostic, identifies the real constraint — not the symptoms — and builds a personalized 90-day action system.',
        hero_cta1:'🚀 Start the diagnosis', hero_cta2:'Discover the process',
        stat1:'Diagnostic<br>Rounds', stat2:'Day<br>Plan', stat3:'Essential<br>Truth',
        how_eyebrow:'How It Works',
        how_title:'No motivation.<br><span style="color:var(--gold)">Diagnosis.</span>',
        how_desc:'Most people are not held back by lack of information or talent. They are held back by one or two specific patterns — usually invisible to themselves.',
        step1_title:'You answer honestly', step1_desc:'5 rounds of questions designed to surface contradictions and patterns you\'ve been rationalizing for years.',
        step2_title:'The real constraint is named', step2_desc:'Not symptoms. The root cause. Whether it\'s an identity ceiling or fear-driven avoidance — named without mercy.',
        step3_title:'A system is built for you', step3_desc:'Daily non-negotiables, 1 metric, environmental changes, 90-day plan. Built around your specific constraint.',
        step4_title:'You are held accountable', step4_desc:'Personalized email reminders, adapted resources, 7-day and 30-day check-ins. The session picks up where it left off.',
        img_overlay_label:'Diagnostic completion rate', img_overlay_sub:'of users reach the full strategic report',
        rounds_eyebrow:'The Diagnostic Protocol',
        rounds_title:'5 Rounds. 20 Questions.<br><em style="color:var(--gold)">1 Truth.</em>',
        rounds_desc:'Each round probes a deeper layer — from surface situation to identity-level patterns.',
        r1_title:'Current<br>Reality', r1_desc:'Where you are, what you want, and what you believe the problem is.',
        r2_title:'Execution<br>Audit', r2_desc:'Is the bottleneck strategic or executional? Most people confuse the two.',
        r3_title:'Environment<br>Audit', r3_desc:'Your environment is working for or against you.',
        r4_title:'Beliefs<br>& Identity', r4_desc:'The story you tell about why you\'re stuck is almost always a defense mechanism.',
        r5_title:'Commitment<br>& Stakes', r5_desc:'Are you genuinely committed or exploring the idea?',
        round_quote:'"People are not held back by lack of information. They are held back by one or two specific, identifiable patterns — usually invisible to themselves."',
        cat_eyebrow:'What the system identifies', cat_title:'6 Constraint Categories', cat_desc:'After the full analysis, the primary constraint is named with precision.',
        c1_title:'Strategic Misdirection', c1_desc:'High effort, wrong leverage. The chosen path won\'t lead there efficiently.',
        c2_title:'Execution Deficit', c2_desc:'The strategy is sound but execution is inconsistent. Plans accumulate, actions don\'t.',
        c3_title:'Environment Drag', c3_desc:'The environment (social circle, physical space) is actively working against your goals.',
        c4_title:'Identity Ceiling', c4_desc:'Your current self-concept cannot hold the level of success you\'re pursuing.',
        c5_title:'Fear-Driven Avoidance', c5_desc:'The most important actions are consistently deprioritized. Not laziness — fear.',
        c6_title:'Commitment Gap', c6_desc:'The goal is desired but not truly committed to. Without real commitment, no system will hold.',
        rep_eyebrow:'The Strategic Report', rep_title:'After the diagnosis,<br><em style="color:var(--gold)">the truth.</em>',
        rep_desc:'Once all 5 rounds are complete, you receive a full strategic report — not a pep talk, not a generic plan.',
        rep_s1_title:'The Hard Truth', rep_s1_desc:'The single most important thing you\'ve been avoiding hearing.',
        rep_s2_title:'Who You Actually Are', rep_s2_desc:'Dominant pattern, primary strength, primary self-sabotage mechanism.',
        rep_s3_title:'Primary Constraint', rep_s3_desc:'The single root cause. Remove it, unlock everything else.',
        rep_s4_title:'Blind Spots', rep_s4_desc:'What you can\'t see about yourself — from answer contradictions.',
        rep_s5_title:'The Leverage Point', rep_s5_desc:'The highest-leverage action available to you right now.',
        rep_s6_title:'The System', rep_s6_desc:'3 daily non-negotiables max, 1 metric, environmental changes.',
        rep_s7_title:'90-Day Operating Plan', rep_s7_desc:'3 phases of 30 days with objectives and binary success metrics.',
        rep_s8_title:'Your Assignment', rep_s8_desc:'One specific task. Clear deadline. Done or not done.',
        rep_f1_title:'Email Reminders', rep_f1_desc:'Personalized based on your mission and blocking pattern',
        rep_f2_title:'Adapted Resources', rep_f2_desc:'Courses, books, tools selected for your specific constraint',
        rep_f3_title:'30-Day Check-ins', rep_f3_desc:'Condensed re-diagnosis: what changed, what didn\'t',
        rep_f4_title:'Accountability', rep_f4_desc:'Return without completing your mission? That gets addressed first',
        test_eyebrow:'What it reveals', test_title:'The reality behind the blockers',
        test1_quote:'I thought my problem was lack of time. The diagnostic revealed I was spending 3h/day on low-impact tasks to avoid the one action that actually mattered.',
        test1_name:'Karim B.', test1_role:'Entrepreneur, Casablanca',
        test2_quote:'Round 4 completely destabilized me. I realized my fear wasn\'t failure — it was success and what it implied for my identity.',
        test2_name:'Sara M.', test2_role:'Manager, Rabat',
        test3_quote:'The report was brutally accurate. Constraint C2. The 3 daily non-negotiables system changed my productivity within 2 weeks.',
        test3_name:'Youssef A.', test3_role:'Developer, Agadir',
        contact_eyebrow:'Start the diagnosis',
        contact_title:'Stop theorizing.<br><em style="color:var(--gold)">Diagnose.</em>',
        contact_desc:'The pattern holding you back won\'t reveal itself through more research or planning. It reveals itself through the right questions — asked without mercy.',
        email_title:'Email', email_desc:'Contact us directly',
        phone_title:'Phone', phone_desc:'Call us directly',
        form_title:'Start your free session', form_sub:'Vague answers get vague results.',
        f_name:'Full name *', f_email:'Email *', f_goal:'What are you trying to build or achieve?',
        f_situation:'Current situation', f_blocker:'What\'s blocking you (in your view)', f_select:'Select',
        sit1:'Entrepreneur / Founder', sit2:'Employee looking to grow', sit3:'Freelance / Consultant',
        sit4:'Career transition', sit5:'Student / Recent graduate', sit6:'Other',
        blk1:'Lack of time', blk2:'Lack of motivation', blk3:'No clear direction',
        blk4:'Fear of failure', blk5:'Unsupportive environment', blk6:'I\'m not sure exactly',
        f_message:'Message / Additional context', f_submit:'🎯 Start my free diagnosis',
        f_note:'Response within 24h · No commitment · develop-it',
        footer_desc:'Personal AI coach. Brutal diagnosis. Tailored system. 90-day plan.',
        footer_process:'Process', footer_features:'Features', footer_company:'Company',
        feat_diag:'AI Diagnosis', feat_resources:'Personalized Resources', feat_email:'Email Reminders', feat_plan:'90-Day Plan',
        footer_about:'About develop-it',
    }
};

function setLang(lang, btn) {
    document.querySelectorAll('.lang-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.documentElement.lang = lang;
    const t = translations[lang];
    document.querySelectorAll('[data-i18n]').forEach(el => {
        const key = el.getAttribute('data-i18n');
        if (t[key] !== undefined) el.innerHTML = t[key];
    });
    localStorage.setItem('sa_lang', lang);
}

document.addEventListener('DOMContentLoaded', () => {
    const saved = localStorage.getItem('sa_lang');
    if (saved && saved !== 'fr') {
        const btn = document.querySelector(`.lang-btn[onclick="setLang('${saved}', this)"]`);
        if (btn) setLang(saved, btn);
    }
});
</script>
</body>
</html>