<?php
/**
 * BTP Manager - Contact Form Handler
 * develop-it
 */

$success_message = '';
$error_message   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_contact'])) {

    $name         = htmlspecialchars(strip_tags(trim($_POST['name']         ?? '')));
    $email        = filter_var(trim($_POST['email']        ?? ''), FILTER_SANITIZE_EMAIL);
    $company      = htmlspecialchars(strip_tags(trim($_POST['company']      ?? '')));
    $phone        = htmlspecialchars(strip_tags(trim($_POST['phone']        ?? '')));
    $project_type = htmlspecialchars(strip_tags(trim($_POST['project_type'] ?? '')));
    $employees    = htmlspecialchars(strip_tags(trim($_POST['employees']    ?? '')));
    $message      = htmlspecialchars(strip_tags(trim($_POST['message']      ?? '')));

    if (empty($name) || empty($email)) {
        $error_message = 'Veuillez remplir tous les champs obligatoires.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Adresse email invalide.';
    } else {
        $to           = 'contact@develop-it.tech';
        $subject_mail = '📩 Demande démo BTP Manager - ' . $name . ' | develop-it.tech';

        $body  = "Nouvelle demande de démonstration BTP Manager\n";
        $body .= str_repeat('─', 50) . "\n\n";
        $body .= "👤 Nom           : $name\n";
        $body .= "📧 Email         : $email\n";
        $body .= "🏢 Entreprise    : " . ($company      ?: 'Non renseigné') . "\n";
        $body .= "📞 Téléphone     : " . ($phone        ?: 'Non renseigné') . "\n";
        $body .= "🏗️  Type projets  : " . ($project_type ?: 'Non renseigné') . "\n";
        $body .= "👥 Employés      : " . ($employees    ?: 'Non renseigné') . "\n\n";
        $body .= "💬 Message       :\n" . ($message     ?: 'Aucun message') . "\n\n";
        $body .= str_repeat('─', 50) . "\n";
        $body .= "Envoyé le : " . date('d/m/Y à H:i') . "\n";
        $body .= "IP        : " . ($_SERVER['REMOTE_ADDR'] ?? 'N/A') . "\n";

        $headers  = "From: no-reply@develop-it.tech\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        if (mail($to, $subject_mail, $body, $headers)) {
            $success_message = 'Votre demande a été envoyée avec succès ! Nous vous contacterons rapidement pour planifier votre démonstration.';
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

    <title>BTP Manager | develop-it | Solution Complète de Gestion BTP & Immobilier</title>
    <meta name="description" content="BTP Manager par develop-it - Solution ERP complète pour le secteur BTP et immobilier au Maroc. Gestion de projets, stocks, finances, paie et comptabilité.">
    <meta name="keywords" content="develop-it, btp manager, gestion btp, erp construction, gestion chantier, immobilier maroc, logiciel btp, gestion projet construction">
    <meta name="author" content="develop-it">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://develop-it.tech/btp_manager.php">

    <meta property="og:type" content="website">
    <meta property="og:url" content="https://develop-it.tech/btp_manager.php">
    <meta property="og:title" content="BTP Manager | develop-it - Solution de Gestion BTP Complète">
    <meta property="og:description" content="Solution ERP complète pour le secteur BTP et immobilier développée par develop-it.">
    <meta property="og:site_name" content="develop-it">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="BTP Manager | develop-it">
    <meta name="twitter:description" content="Solution ERP complète pour le secteur BTP et immobilier">

    <link rel="icon" type="image/png" sizes="32x32" href="/logo.jfif">
    <link rel="apple-touch-icon" href="/logo.jfif">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        @keyframes gradient {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .gradient-animate {
            background: linear-gradient(-45deg, #1e40af, #3b82f6, #0ea5e9, #1e40af);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.15); }
        html { scroll-behavior: smooth; }

        /* Language Switcher */
        .lang-switcher { display:flex; align-items:center; background:#f1f5f9; border-radius:9999px; padding:3px; gap:2px; }
        .lang-btn { padding:4px 12px; border-radius:9999px; font-size:13px; font-weight:600; cursor:pointer; transition:all 0.2s; border:none; background:transparent; color:#64748b; }
        .lang-btn.active { background:#3b82f6; color:white; box-shadow:0 1px 4px rgba(59,130,246,0.4); }
        .lang-btn:hover:not(.active) { color:#3b82f6; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">

<!-- NAVIGATION -->
<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-8">
            <a href="/" class="flex items-center gap-2 text-slate-600 hover:text-blue-600 transition">
                <img src="/logo.jfif" alt="develop-it" class="w-6 h-6">
                <span class="font-semibold">develop-it</span>
            </a>
            <div class="hidden md:block w-px h-6 bg-slate-300"></div>
            <a href="#" class="flex items-center gap-2 text-xl font-bold text-blue-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                BTP Manager
            </a>
        </div>
        <div class="hidden md:flex items-center gap-6">
            <a href="#features" class="text-slate-600 hover:text-blue-600 transition" data-i18n="nav_features">Fonctionnalités</a>
            <a href="#modules"  class="text-slate-600 hover:text-blue-600 transition" data-i18n="nav_modules">Modules</a>
            <a href="#contact"  class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition" data-i18n="nav_contact">Contact</a>
            <div class="lang-switcher">
                <button class="lang-btn active" onclick="setLang('fr', this)">🇫🇷 FR</button>
                <button class="lang-btn"        onclick="setLang('en', this)">🇬🇧 EN</button>
            </div>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="relative gradient-animate text-white overflow-hidden min-h-[90vh] flex items-center">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-20 left-20 w-72 h-72 bg-blue-500 rounded-full filter blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-20 w-96 h-96 bg-cyan-500 rounded-full filter blur-3xl animate-pulse" style="animation-delay:1s;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-24 grid md:grid-cols-2 gap-12 items-center relative z-10">
        <div data-aos="fade-right" data-aos-duration="1000">
            <div class="inline-block bg-blue-500/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm mb-4 border border-blue-400/30" data-i18n="hero_badge">
                ✨ Solution N°1 pour le secteur BTP au Maroc
            </div>
            <h1 class="text-5xl md:text-6xl font-bold leading-tight mb-4">BTP Manager</h1>
            <p class="text-xl mb-4 text-blue-100">par <strong class="text-white">develop-it</strong></p>
            <h2 class="text-3xl md:text-4xl font-bold mb-6">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-200 via-cyan-200 to-blue-200" data-i18n="hero_subtitle">
                    Gestion Complète BTP & Immobilier
                </span>
            </h2>
            <p class="mt-6 text-xl text-blue-100 leading-relaxed" data-i18n="hero_desc">
                Solution ERP complète pour gérer vos projets de construction, stocks, finances,
                personnel et comptabilité en temps réel.
            </p>
            <div class="mt-8 flex flex-wrap gap-4">
                <a href="#contact" class="bg-white text-blue-900 px-8 py-4 rounded-xl font-semibold hover:bg-blue-50 transition transform hover:scale-105 shadow-lg" data-i18n="hero_cta1">
                    🚀 Demander une démo
                </a>
                <a href="#features" class="border-2 border-white/40 backdrop-blur-sm px-8 py-4 rounded-xl hover:bg-white/10 transition" data-i18n="hero_cta2">
                    Découvrir les modules
                </a>
            </div>
            <div class="mt-12 grid grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="text-4xl font-bold">10+</div>
                    <div class="text-sm text-blue-200" data-i18n="stat1">Modules intégrés</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold">100%</div>
                    <div class="text-sm text-blue-200" data-i18n="stat2">Cloud & Sécurisé</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold">24/7</div>
                    <div class="text-sm text-blue-200" data-i18n="stat3">Support</div>
                </div>
            </div>
        </div>
        <div data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
            <img src="https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&w=900&q=80"
                 alt="BTP Manager Dashboard - develop-it" class="rounded-2xl shadow-2xl">
        </div>
    </div>
</section>

<!-- KEY FEATURES -->
<section id="features" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider" data-i18n="feat_label">Fonctionnalités Principales</span>
            <h2 class="text-4xl md:text-5xl font-bold mt-3 mb-6" data-i18n="feat_title">Une solution complète et intégrée</h2>
            <p class="text-slate-600 text-lg max-w-3xl mx-auto" data-i18n="feat_desc">
                BTP Manager par <strong class="text-blue-600">develop-it</strong> centralise toute la gestion
                de votre entreprise BTP dans une seule plateforme moderne et intuitive.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl p-8 shadow-lg card-hover border border-blue-100" data-aos="fade-up">
                <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center text-white text-3xl mb-6 shadow-lg">🏗️</div>
                <h3 class="font-bold text-2xl mb-3" data-i18n="card1_title">Gestion de Projets</h3>
                <p class="text-slate-600 leading-relaxed mb-4" data-i18n="card1_desc">Pilotez tous vos chantiers avec planning, budgets, journaux de chantier et suivi de rentabilité en temps réel.</p>
                <ul class="space-y-2 text-sm text-slate-700">
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="card1_f1">Planning intégré</span></li>
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="card1_f2">Suivi budgétaire</span></li>
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="card1_f3">Rentabilité par lot</span></li>
                </ul>
            </div>
            <!-- Card 2 -->
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-8 shadow-lg card-hover border border-purple-100" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 bg-purple-600 rounded-2xl flex items-center justify-center text-white text-3xl mb-6 shadow-lg">📊</div>
                <h3 class="font-bold text-2xl mb-3" data-i18n="card2_title">Finances & Comptabilité</h3>
                <p class="text-slate-600 leading-relaxed mb-4" data-i18n="card2_desc">Comptabilité complète, gestion de trésorerie, TVA, et reporting financier en temps réel.</p>
                <ul class="space-y-2 text-sm text-slate-700">
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="card2_f1">Plan comptable</span></li>
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="card2_f2">Balance & Grand Livre</span></li>
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="card2_f3">Trésorerie prévisionnelle</span></li>
                </ul>
            </div>
            <!-- Card 3 -->
            <div class="bg-gradient-to-br from-cyan-50 to-blue-50 rounded-2xl p-8 shadow-lg card-hover border border-cyan-100" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 bg-cyan-600 rounded-2xl flex items-center justify-center text-white text-3xl mb-6 shadow-lg">📦</div>
                <h3 class="font-bold text-2xl mb-3" data-i18n="card3_title">Stocks & Achats</h3>
                <p class="text-slate-600 leading-relaxed mb-4" data-i18n="card3_desc">Gestion complète des stocks, articles, entrepôts, commandes et réceptions de matériaux.</p>
                <ul class="space-y-2 text-sm text-slate-700">
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="card3_f1">Multi-entrepôts</span></li>
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="card3_f2">Inventaires physiques</span></li>
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="card3_f3">Valorisation stock</span></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- ALL MODULES -->
<section id="modules" class="py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl font-bold mb-6" data-i18n="mod_title">10 Modules Intégrés</h2>
            <p class="text-slate-600 text-lg max-w-3xl mx-auto" data-i18n="mod_desc">Une suite complète pour gérer tous les aspects de votre entreprise BTP</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-sm card-hover" data-aos="fade-up">
                <div class="text-4xl mb-3">🏗️</div>
                <h4 class="font-bold mb-2" data-i18n="mod1_title">Projets</h4>
                <p class="text-sm text-slate-600" data-i18n="mod1_desc">Planning, budgets, journaux de chantier</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm card-hover" data-aos="fade-up" data-aos-delay="50">
                <div class="text-4xl mb-3">👥</div>
                <h4 class="font-bold mb-2" data-i18n="mod2_title">Clients</h4>
                <p class="text-sm text-slate-600" data-i18n="mod2_desc">Contrats, factures, règlements</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm card-hover" data-aos="fade-up" data-aos-delay="100">
                <div class="text-4xl mb-3">🚚</div>
                <h4 class="font-bold mb-2" data-i18n="mod3_title">Fournisseurs</h4>
                <p class="text-sm text-slate-600" data-i18n="mod3_desc">Commandes, réceptions, paiements</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm card-hover" data-aos="fade-up" data-aos-delay="150">
                <div class="text-4xl mb-3">📦</div>
                <h4 class="font-bold mb-2" data-i18n="mod4_title">Stocks</h4>
                <p class="text-sm text-slate-600" data-i18n="mod4_desc">Inventaire, mouvements, valorisation</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm card-hover" data-aos="fade-up" data-aos-delay="200">
                <div class="text-4xl mb-3">👨‍💼</div>
                <h4 class="font-bold mb-2" data-i18n="mod5_title">Personnel</h4>
                <p class="text-sm text-slate-600" data-i18n="mod5_desc">Employés, pointage, paie</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm card-hover" data-aos="fade-up" data-aos-delay="250">
                <div class="text-4xl mb-3">💰</div>
                <h4 class="font-bold mb-2" data-i18n="mod6_title">Finances</h4>
                <p class="text-sm text-slate-600" data-i18n="mod6_desc">Caisses, banques, dépenses</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm card-hover" data-aos="fade-up" data-aos-delay="300">
                <div class="text-4xl mb-3">📊</div>
                <h4 class="font-bold mb-2" data-i18n="mod7_title">Comptabilité</h4>
                <p class="text-sm text-slate-600" data-i18n="mod7_desc">Plan comptable, TVA, balance</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm card-hover" data-aos="fade-up" data-aos-delay="350">
                <div class="text-4xl mb-3">🚜</div>
                <h4 class="font-bold mb-2" data-i18n="mod8_title">Immobilisations</h4>
                <p class="text-sm text-slate-600" data-i18n="mod8_desc">Matériel, affectations, reporting</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm card-hover" data-aos="fade-up" data-aos-delay="400">
                <div class="text-4xl mb-3">📈</div>
                <h4 class="font-bold mb-2" data-i18n="mod9_title">Reporting</h4>
                <p class="text-sm text-slate-600" data-i18n="mod9_desc">Tableaux de bord, analyses</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm card-hover" data-aos="fade-up" data-aos-delay="450">
                <div class="text-4xl mb-3">⚙️</div>
                <h4 class="font-bold mb-2" data-i18n="mod10_title">Administration</h4>
                <p class="text-sm text-slate-600" data-i18n="mod10_desc">Utilisateurs, sociétés, paramètres</p>
            </div>
        </div>
    </div>
</section>

<!-- CONTACT -->
<section id="contact" class="bg-slate-900 text-white py-24">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-12" data-aos="fade-up">
            <span class="text-blue-300 font-semibold text-sm uppercase tracking-wider" data-i18n="contact_label">Contact</span>
            <h2 class="text-4xl md:text-5xl font-bold mt-3 mb-6" data-i18n="contact_title">Demandez votre démonstration</h2>
            <p class="text-slate-300 text-lg max-w-2xl mx-auto" data-i18n="contact_desc">
                Découvrez comment BTP Manager par <strong class="text-white">develop-it</strong> peut
                transformer la gestion de votre entreprise BTP
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <div class="bg-white/10 backdrop-blur-sm p-8 rounded-2xl border border-white/20 card-hover" data-aos="fade-right">
                <div class="text-5xl mb-4">📧</div>
                <h3 class="text-2xl font-bold mb-2" data-i18n="email_title">Email</h3>
                <p class="text-slate-300 mb-4" data-i18n="email_desc">Contactez-nous par email</p>
                <a href="mailto:contact@develop-it.tech" class="text-blue-300 hover:text-blue-200 font-semibold text-lg break-all">contact@develop-it.tech</a>
            </div>
            <div class="bg-white/10 backdrop-blur-sm p-8 rounded-2xl border border-white/20 card-hover" data-aos="fade-left">
                <div class="text-5xl mb-4">📞</div>
                <h3 class="text-2xl font-bold mb-2" data-i18n="phone_title">Téléphone</h3>
                <p class="text-slate-300 mb-4" data-i18n="phone_desc">Appelez-nous directement</p>
                <a href="tel:+2120611191926" class="text-blue-300 hover:text-blue-200 font-semibold text-lg">+212 06 11 19 19 26</a>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="bg-white/5 backdrop-blur-sm p-8 md:p-12 rounded-2xl border border-white/20" data-aos="fade-up">
            <h3 class="text-2xl font-bold mb-6 text-center" data-i18n="form_title">Demander une démonstration gratuite</h3>

            <?php if (!empty($success_message)): ?>
            <div class="mb-6 bg-green-500/20 border border-green-400/50 text-green-200 px-6 py-4 rounded-xl flex items-center gap-3">
                <svg class="w-6 h-6 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span><?php echo $success_message; ?></span>
            </div>
            <?php endif; ?>

            <?php if (!empty($error_message)): ?>
            <div class="mb-6 bg-red-500/20 border border-red-400/50 text-red-200 px-6 py-4 rounded-xl flex items-center gap-3">
                <svg class="w-6 h-6 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span><?php echo $error_message; ?></span>
            </div>
            <?php endif; ?>

            <form method="POST" action="#contact" class="space-y-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold mb-2" data-i18n="f_company">Entreprise</label>
                        <input type="text" name="company" value="<?php echo htmlspecialchars($_POST['company'] ?? ''); ?>"
                            class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-slate-400 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400/50 transition"
                            placeholder="Nom de votre entreprise">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2" data-i18n="f_project_type">Type de projets</label>
                        <select name="project_type" class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400/50 transition">
                            <option value="" data-i18n="f_select">Sélectionnez</option>
                            <option value="Construction neuve"    <?php echo (($_POST['project_type'] ?? '') === 'Construction neuve')    ? 'selected' : ''; ?> data-i18n="pt1">Construction neuve</option>
                            <option value="Rénovation"           <?php echo (($_POST['project_type'] ?? '') === 'Rénovation')           ? 'selected' : ''; ?> data-i18n="pt2">Rénovation</option>
                            <option value="Travaux publics"      <?php echo (($_POST['project_type'] ?? '') === 'Travaux publics')      ? 'selected' : ''; ?> data-i18n="pt3">Travaux publics</option>
                            <option value="Promotion immobilière"<?php echo (($_POST['project_type'] ?? '') === 'Promotion immobilière') ? 'selected' : ''; ?> data-i18n="pt4">Promotion immobilière</option>
                            <option value="Autre"                <?php echo (($_POST['project_type'] ?? '') === 'Autre')                ? 'selected' : ''; ?> data-i18n="pt5">Autre</option>
                        </select>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold mb-2" data-i18n="f_name">Nom complet *</label>
                        <input type="text" name="name" required value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
                            class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-slate-400 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400/50 transition"
                            placeholder="Votre nom">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2" data-i18n="f_email">Email *</label>
                        <input type="email" name="email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                            class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-slate-400 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400/50 transition"
                            placeholder="votre@email.com">
                    </div>
                </div>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold mb-2" data-i18n="f_phone">Téléphone</label>
                        <input type="tel" name="phone" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>"
                            class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-slate-400 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400/50 transition"
                            placeholder="+212 XXX XXX XXX">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2" data-i18n="f_employees">Nombre d'employés</label>
                        <select name="employees" class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400/50 transition">
                            <option value="" data-i18n="f_select">Sélectionnez</option>
                            <option value="1-10"  <?php echo (($_POST['employees'] ?? '') === '1-10')   ? 'selected' : ''; ?>>1-10</option>
                            <option value="11-50" <?php echo (($_POST['employees'] ?? '') === '11-50')  ? 'selected' : ''; ?>>11-50</option>
                            <option value="51-100"<?php echo (($_POST['employees'] ?? '') === '51-100') ? 'selected' : ''; ?>>51-100</option>
                            <option value="100+" <?php echo (($_POST['employees'] ?? '') === '100+')   ? 'selected' : ''; ?>>100+</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2" data-i18n="f_message">Message / Besoins spécifiques</label>
                    <textarea name="message" rows="5"
                        class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-slate-400 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400/50 transition resize-none"
                        placeholder="Décrivez vos besoins..."><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" name="submit_contact"
                        class="bg-white text-slate-900 px-8 py-4 rounded-xl font-semibold hover:bg-slate-100 transition transform hover:scale-105 shadow-lg" data-i18n="f_submit">
                        🚀 Demander une démonstration gratuite
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="bg-black text-slate-400 py-12">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-4 gap-8 mb-8">
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <img src="/logo.jfif" alt="develop-it" class="w-6 h-6">
                    <h3 class="text-white font-bold text-lg">develop-it</h3>
                </div>
                <h4 class="text-white font-semibold mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    BTP Manager
                </h4>
                <p class="text-sm leading-relaxed" data-i18n="footer_desc">Solution ERP complète pour le secteur BTP et immobilier.</p>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4" data-i18n="footer_modules">Modules</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-white transition" data-i18n="mod1_title">Projets</a></li>
                    <li><a href="#" class="hover:text-white transition" data-i18n="mod6_title">Finances</a></li>
                    <li><a href="#" class="hover:text-white transition" data-i18n="mod4_title">Stocks</a></li>
                    <li><a href="#" class="hover:text-white transition" data-i18n="mod5_title">Personnel</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4" data-i18n="footer_company">Entreprise</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="/"        class="hover:text-white transition" data-i18n="footer_about">À propos de develop-it</a></li>
                    <li><a href="#contact" class="hover:text-white transition" data-i18n="nav_contact">Contact</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4" data-i18n="footer_follow">Suivez-nous</h4>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 bg-slate-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition" aria-label="Facebook">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" class="w-10 h-10 bg-slate-800 rounded-full flex items-center justify-center hover:bg-blue-700 transition" aria-label="LinkedIn">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="border-t border-slate-800 pt-8 text-center text-sm">
            <p>© 2026 <strong>develop-it</strong> | BTP Manager – Gestion BTP & Immobilier | Tous droits réservés</p>
        </div>
    </div>
</footer>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 1000, once: true, offset: 100 });

    // ─── Language Switcher ────────────────────────────────────────────
    const translations = {
        fr: {
            nav_features: 'Fonctionnalités', nav_modules: 'Modules', nav_contact: 'Contact',
            hero_badge:   '✨ Solution N°1 pour le secteur BTP au Maroc',
            hero_subtitle:'Gestion Complète BTP & Immobilier',
            hero_desc:    'Solution ERP complète pour gérer vos projets de construction, stocks, finances, personnel et comptabilité en temps réel.',
            hero_cta1: '🚀 Demander une démo', hero_cta2: 'Découvrir les modules',
            stat1: 'Modules intégrés', stat2: 'Cloud & Sécurisé', stat3: 'Support',
            feat_label: 'Fonctionnalités Principales',
            feat_title: 'Une solution complète et intégrée',
            feat_desc:  'BTP Manager par <strong class="text-blue-600">develop-it</strong> centralise toute la gestion de votre entreprise BTP dans une seule plateforme moderne et intuitive.',
            card1_title:'Gestion de Projets',     card1_desc:'Pilotez tous vos chantiers avec planning, budgets, journaux de chantier et suivi de rentabilité en temps réel.',
            card1_f1:'Planning intégré',          card1_f2:'Suivi budgétaire',           card1_f3:'Rentabilité par lot',
            card2_title:'Finances & Comptabilité',card2_desc:'Comptabilité complète, gestion de trésorerie, TVA, et reporting financier en temps réel.',
            card2_f1:'Plan comptable',             card2_f2:'Balance & Grand Livre',      card2_f3:'Trésorerie prévisionnelle',
            card3_title:'Stocks & Achats',        card3_desc:'Gestion complète des stocks, articles, entrepôts, commandes et réceptions de matériaux.',
            card3_f1:'Multi-entrepôts',            card3_f2:'Inventaires physiques',      card3_f3:'Valorisation stock',
            mod_title:'10 Modules Intégrés',      mod_desc:'Une suite complète pour gérer tous les aspects de votre entreprise BTP',
            mod1_title:'Projets',    mod1_desc:'Planning, budgets, journaux de chantier',
            mod2_title:'Clients',    mod2_desc:'Contrats, factures, règlements',
            mod3_title:'Fournisseurs',mod3_desc:'Commandes, réceptions, paiements',
            mod4_title:'Stocks',     mod4_desc:'Inventaire, mouvements, valorisation',
            mod5_title:'Personnel',  mod5_desc:'Employés, pointage, paie',
            mod6_title:'Finances',   mod6_desc:'Caisses, banques, dépenses',
            mod7_title:'Comptabilité',mod7_desc:'Plan comptable, TVA, balance',
            mod8_title:'Immobilisations',mod8_desc:'Matériel, affectations, reporting',
            mod9_title:'Reporting',  mod9_desc:'Tableaux de bord, analyses',
            mod10_title:'Administration',mod10_desc:'Utilisateurs, sociétés, paramètres',
            contact_label:'Contact', contact_title:'Demandez votre démonstration',
            contact_desc:'Découvrez comment BTP Manager par <strong class="text-white">develop-it</strong> peut transformer la gestion de votre entreprise BTP',
            email_title:'Email',     email_desc:'Contactez-nous par email',
            phone_title:'Téléphone', phone_desc:'Appelez-nous directement',
            form_title:'Demander une démonstration gratuite',
            f_company:'Entreprise',  f_project_type:'Type de projets', f_select:'Sélectionnez',
            pt1:'Construction neuve',pt2:'Rénovation',pt3:'Travaux publics',pt4:'Promotion immobilière',pt5:'Autre',
            f_name:'Nom complet *',  f_email:'Email *', f_phone:'Téléphone', f_employees:'Nombre d\'employés',
            f_message:'Message / Besoins spécifiques',
            f_submit:'🚀 Demander une démonstration gratuite',
            footer_desc:'Solution ERP complète pour le secteur BTP et immobilier.',
            footer_modules:'Modules', footer_company:'Entreprise',
            footer_about:'À propos de develop-it', footer_follow:'Suivez-nous',
        },
        en: {
            nav_features: 'Features', nav_modules: 'Modules', nav_contact: 'Contact',
            hero_badge:   '✨ #1 Solution for the Construction sector in Morocco',
            hero_subtitle:'Complete Construction & Real Estate Management',
            hero_desc:    'Complete ERP solution to manage your construction projects, inventory, finances, staff and accounting in real time.',
            hero_cta1: '🚀 Request a demo', hero_cta2: 'Discover the modules',
            stat1: 'Integrated modules', stat2: 'Cloud & Secure', stat3: 'Support',
            feat_label: 'Key Features',
            feat_title: 'A complete and integrated solution',
            feat_desc:  'BTP Manager by <strong class="text-blue-600">develop-it</strong> centralises all the management of your construction company in a single modern and intuitive platform.',
            card1_title:'Project Management',  card1_desc:'Manage all your construction sites with scheduling, budgets, site logs and profitability tracking in real time.',
            card1_f1:'Integrated planning',    card1_f2:'Budget tracking',           card1_f3:'Profitability per lot',
            card2_title:'Finance & Accounting',card2_desc:'Full accounting, cash flow management, VAT, and real-time financial reporting.',
            card2_f1:'Chart of accounts',      card2_f2:'Balance & General Ledger',  card2_f3:'Cash flow forecast',
            card3_title:'Inventory & Purchasing',card3_desc:'Complete management of inventory, items, warehouses, orders and material receipts.',
            card3_f1:'Multi-warehouse',         card3_f2:'Physical inventories',     card3_f3:'Stock valuation',
            mod_title:'10 Integrated Modules', mod_desc:'A complete suite to manage all aspects of your construction company',
            mod1_title:'Projects',   mod1_desc:'Planning, budgets, site logs',
            mod2_title:'Clients',    mod2_desc:'Contracts, invoices, settlements',
            mod3_title:'Suppliers',  mod3_desc:'Orders, receipts, payments',
            mod4_title:'Inventory',  mod4_desc:'Stock, movements, valuation',
            mod5_title:'Staff',      mod5_desc:'Employees, attendance, payroll',
            mod6_title:'Finance',    mod6_desc:'Cash registers, banks, expenses',
            mod7_title:'Accounting', mod7_desc:'Chart of accounts, VAT, balance',
            mod8_title:'Fixed Assets',mod8_desc:'Equipment, assignments, reporting',
            mod9_title:'Reporting',  mod9_desc:'Dashboards, analytics',
            mod10_title:'Administration',mod10_desc:'Users, companies, settings',
            contact_label:'Contact', contact_title:'Request your demonstration',
            contact_desc:'Discover how BTP Manager by <strong class="text-white">develop-it</strong> can transform the management of your construction company',
            email_title:'Email',     email_desc:'Contact us by email',
            phone_title:'Phone',     phone_desc:'Call us directly',
            form_title:'Request a free demonstration',
            f_company:'Company',     f_project_type:'Project type', f_select:'Select',
            pt1:'New construction',  pt2:'Renovation', pt3:'Public works', pt4:'Real estate development', pt5:'Other',
            f_name:'Full name *',    f_email:'Email *', f_phone:'Phone', f_employees:'Number of employees',
            f_message:'Message / Specific needs',
            f_submit:'🚀 Request a free demonstration',
            footer_desc:'Complete ERP solution for the construction and real estate sector.',
            footer_modules:'Modules', footer_company:'Company',
            footer_about:'About develop-it', footer_follow:'Follow us',
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
        localStorage.setItem('lang', lang);
    }

    document.addEventListener('DOMContentLoaded', () => {
        const saved = localStorage.getItem('lang');
        if (saved && saved !== 'fr') {
            const btn = document.querySelector(`.lang-btn[onclick="setLang('${saved}', this)"]`);
            if (btn) setLang(saved, btn);
        }
    });
</script>

</body>
</html>