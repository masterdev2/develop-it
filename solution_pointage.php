<?php
/**
 * HR Manager - Contact Form Handler
 * develop-it
 */

$success_message = '';
$error_message   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_demo'])) {

    $name     = htmlspecialchars(strip_tags(trim($_POST['name']    ?? '')));
    $email    = filter_var(trim($_POST['email']   ?? ''), FILTER_SANITIZE_EMAIL);
    $company  = htmlspecialchars(strip_tags(trim($_POST['company'] ?? '')));
    $phone    = htmlspecialchars(strip_tags(trim($_POST['phone']   ?? '')));
    $employees= htmlspecialchars(strip_tags(trim($_POST['employees'] ?? '')));
    $message  = htmlspecialchars(strip_tags(trim($_POST['message'] ?? '')));

    if (empty($name) || empty($email)) {
        $error_message = 'Veuillez remplir tous les champs obligatoires.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Adresse email invalide.';
    } else {
        $to           = 'contact@develop-it.tech';
        $subject_mail = '📩 Demande démo HR Manager - ' . $name . ' | develop-it.tech';

        $body  = "Nouvelle demande de démonstration HR Manager\n";
        $body .= str_repeat('─', 50) . "\n\n";
        $body .= "👤 Nom          : $name\n";
        $body .= "📧 Email        : $email\n";
        $body .= "🏢 Entreprise   : " . ($company   ?: 'Non renseigné') . "\n";
        $body .= "📞 Téléphone    : " . ($phone     ?: 'Non renseigné') . "\n";
        $body .= "👥 Employés     : " . ($employees ?: 'Non renseigné') . "\n\n";
        $body .= "💬 Message      :\n" . ($message  ?: 'Aucun message') . "\n\n";
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
    <title>HR Manager | develop-it | Pointage GPS & Gestion RH</title>

    <!-- SEO -->
    <meta name="description" content="HR Manager par develop-it - Solution de pointage GPS et gestion RH complète au Maroc. Suivi des présences, congés, rapports RH et tableaux de bord. Application Laravel moderne et personnalisable.">
    <meta name="keywords" content="develop-it, hr manager, pointage GPS maroc, gestion RH, logiciel RH maroc, time tracking, Laravel, pointage employés, solution rh">
    <meta name="author" content="develop-it">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <meta name="language" content="French">
    <link rel="canonical" href="https://develop-it.tech/solution_pointage.php">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://develop-it.tech/solution_pointage.php">
    <meta property="og:title" content="HR Manager | develop-it – Pointage GPS & Gestion RH">
    <meta property="og:description" content="Solution complète de pointage GPS et gestion RH développée par develop-it.">
    <meta property="og:image" content="https://images.unsplash.com/photo-1553877522-43269d4ea984">
    <meta property="og:site_name" content="develop-it">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="HR Manager | develop-it">
    <meta name="twitter:description" content="Solution de pointage GPS et gestion RH complète">
    <meta name="twitter:image" content="https://images.unsplash.com/photo-1553877522-43269d4ea984">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="/logo.jfif">
    <link rel="apple-touch-icon" href="/logo.jfif">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
        @keyframes gradient {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .gradient-animate {
            background: linear-gradient(-45deg, #1e3a8a, #3b82f6, #06b6d4, #1e3a8a);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-20px); }
        }
        .float-animation { animation: float 6s ease-in-out infinite; }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(59,130,246,0.5); }
            50%       { box-shadow: 0 0 40px rgba(59,130,246,0.8); }
        }
        .pulse-glow  { animation: pulse-glow 2s ease-in-out infinite; }
        .card-hover  { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.15); }
        html { scroll-behavior: smooth; }
        ::-webkit-scrollbar       { width: 10px; }
        ::-webkit-scrollbar-track { background: #1e293b; }
        ::-webkit-scrollbar-thumb { background: #3b82f6; border-radius: 5px; }
        ::-webkit-scrollbar-thumb:hover { background: #2563eb; }

        /* Language Switcher */
        .lang-switcher { display:flex; align-items:center; background:#f1f5f9; border-radius:9999px; padding:3px; gap:2px; }
        .lang-btn { padding:4px 12px; border-radius:9999px; font-size:13px; font-weight:600; cursor:pointer; transition:all 0.2s; border:none; background:transparent; color:#64748b; }
        .lang-btn.active { background:#3b82f6; color:white; box-shadow:0 1px 4px rgba(59,130,246,0.4); }
        .lang-btn:hover:not(.active) { color:#3b82f6; }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">

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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                HR Manager
            </a>
        </div>
        <div class="hidden md:flex items-center gap-6">
            <a href="#solution"  class="text-slate-600 hover:text-blue-600 transition" data-i18n="nav_solution">Solution</a>
            <a href="#features"  class="text-slate-600 hover:text-blue-600 transition" data-i18n="nav_features">Fonctionnalités</a>
            <a href="#pricing"   class="text-slate-600 hover:text-blue-600 transition" data-i18n="nav_pricing">Tarifs</a>
            <a href="#contact"   class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition" data-i18n="nav_contact">Contact</a>
            <!-- Language Switcher -->
            <div class="lang-switcher">
                <button class="lang-btn active" onclick="setLang('fr', this)">🇫🇷 FR</button>
                <button class="lang-btn"        onclick="setLang('en', this)">🇬🇧 EN</button>
            </div>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="relative gradient-animate text-white overflow-hidden min-h-[90vh] flex items-center">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-20 left-20 w-72 h-72 bg-blue-500 rounded-full filter blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-20 w-96 h-96 bg-cyan-500 rounded-full filter blur-3xl animate-pulse" style="animation-delay:1s;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-24 grid md:grid-cols-2 gap-12 items-center relative z-10">
        <div data-aos="fade-right" data-aos-duration="1000">
            <div class="inline-block bg-blue-500/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm mb-4 border border-blue-400/30" data-i18n="hero_badge">
                ✨ Solution RH N°1 au Maroc
            </div>
            <h1 class="text-5xl md:text-6xl font-bold leading-tight mb-4">HR Manager</h1>
            <p class="text-xl mb-4 text-blue-100">par <strong class="text-white">develop-it</strong></p>
            <h2 class="text-3xl md:text-4xl font-bold mb-6">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-200 via-cyan-200 to-blue-200" data-i18n="hero_subtitle">
                    Pointage GPS & Gestion RH
                </span>
            </h2>
            <p class="mt-6 text-xl text-blue-100 leading-relaxed" data-i18n="hero_desc">
                Une application web moderne pour gérer la présence des employés,
                les congés et les rapports RH avec géolocalisation sécurisée.
            </p>
            <div class="mt-8 flex flex-wrap gap-4">
                <a href="#contact" class="bg-white text-blue-900 px-8 py-4 rounded-xl font-semibold hover:bg-blue-50 transition transform hover:scale-105 shadow-lg" data-i18n="hero_cta1">
                    🚀 Demander une démo
                </a>
                <a href="#solution" class="border-2 border-white/40 backdrop-blur-sm px-8 py-4 rounded-xl hover:bg-white/10 transition" data-i18n="hero_cta2">
                    Découvrir la solution
                </a>
            </div>
            <div class="mt-12 grid grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="text-4xl font-bold">99%</div>
                    <div class="text-sm text-blue-200" data-i18n="stat1">Précision GPS</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold">100+</div>
                    <div class="text-sm text-blue-200" data-i18n="stat2">Entreprises</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold">24/7</div>
                    <div class="text-sm text-blue-200" data-i18n="stat3">Support</div>
                </div>
            </div>
        </div>
        <div data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200" class="float-animation">
            <img src="https://images.unsplash.com/photo-1553877522-43269d4ea984?auto=format&fit=crop&w=900&q=80"
                 alt="HR Manager Dashboard - develop-it"
                 class="rounded-2xl shadow-2xl pulse-glow">
        </div>
    </div>

    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <a href="#solution" class="text-white opacity-70 hover:opacity-100 transition">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </a>
    </div>
</section>

<!-- SOLUTION OVERVIEW -->
<section id="solution" class="py-24 bg-white">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider" data-i18n="sol_label">La solution</span>
            <h2 class="text-4xl md:text-5xl font-bold mt-3 mb-6" data-i18n="sol_title">Une solution RH complète et intuitive</h2>
            <p class="text-slate-600 text-lg max-w-3xl mx-auto leading-relaxed" data-i18n="sol_desc">
                HR Manager par <strong class="text-blue-600">develop-it</strong> centralise le pointage, la gestion du personnel et les rapports RH
                dans une interface moderne, sécurisée et facile à utiliser.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 mt-16">
            <!-- GPS -->
            <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl p-8 shadow-lg card-hover border border-blue-100" data-aos="fade-up">
                <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center text-white text-3xl mb-6 shadow-lg">📍</div>
                <h3 class="font-bold text-2xl mb-3" data-i18n="card1_title">Pointage GPS</h3>
                <p class="text-slate-600 leading-relaxed mb-4" data-i18n="card1_desc">Validation automatique du lieu de travail grâce à la géolocalisation en temps réel.</p>
                <ul class="space-y-2 text-sm text-slate-700">
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="card1_f1">Géofencing intelligent</span></li>
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="card1_f2">Historique complet</span></li>
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="card1_f3">Alertes temps réel</span></li>
                </ul>
            </div>
            <!-- Reports -->
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-8 shadow-lg card-hover border border-purple-100" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 bg-purple-600 rounded-2xl flex items-center justify-center text-white text-3xl mb-6 shadow-lg">📊</div>
                <h3 class="font-bold text-2xl mb-3" data-i18n="card2_title">Rapports RH</h3>
                <p class="text-slate-600 leading-relaxed mb-4" data-i18n="card2_desc">Feuilles de temps, ponctualité, anomalies et tableaux de bord analytiques.</p>
                <ul class="space-y-2 text-sm text-slate-700">
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="card2_f1">Tableaux de bord</span></li>
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="card2_f2">Exports Excel & PDF</span></li>
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="card2_f3">Analyses prédictives</span></li>
                </ul>
            </div>
            <!-- Personnel -->
            <div class="bg-gradient-to-br from-cyan-50 to-blue-50 rounded-2xl p-8 shadow-lg card-hover border border-cyan-100" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 bg-cyan-600 rounded-2xl flex items-center justify-center text-white text-3xl mb-6 shadow-lg">👥</div>
                <h3 class="font-bold text-2xl mb-3" data-i18n="card3_title">Gestion Personnel</h3>
                <p class="text-slate-600 leading-relaxed mb-4" data-i18n="card3_desc">Employés, équipes, départements et gestion des rôles utilisateurs.</p>
                <ul class="space-y-2 text-sm text-slate-700">
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="card3_f1">Organigramme interactif</span></li>
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="card3_f2">Gestion permissions</span></li>
                    <li class="flex items-start gap-2"><svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="card3_f3">Profils détaillés</span></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section id="features" class="bg-slate-50 py-24">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider" data-i18n="feat_label">Fonctionnalités</span>
            <h2 class="text-4xl md:text-5xl font-bold mt-3 mb-6" data-i18n="feat_title">Tout ce dont vous avez besoin</h2>
        </div>

        <div class="grid md:grid-cols-2 gap-12 items-center mb-24" data-aos="fade-right">
            <div>
                <div class="inline-block bg-blue-100 text-blue-600 px-4 py-2 rounded-full text-sm font-semibold mb-4" data-i18n="feat1_badge">Pointage intelligent</div>
                <h3 class="text-3xl font-bold mb-4" data-i18n="feat1_title">Pointage entrée / sortie horodaté</h3>
                <p class="text-slate-600 text-lg mb-6 leading-relaxed" data-i18n="feat1_desc">
                    Enregistrez automatiquement les heures d'arrivée et de départ avec une précision GPS.
                    Détection automatique des anomalies et alertes en temps réel.
                </p>
                <ul class="space-y-3">
                    <li class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-green-500 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span class="text-slate-700" data-i18n="feat1_f1"><strong>Horodatage précis</strong> avec validation GPS</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-green-500 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span class="text-slate-700" data-i18n="feat1_f2"><strong>Détection automatique</strong> des retards</span>
                    </li>
                </ul>
            </div>
            <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=900&q=80"
                 alt="Pointage intelligent - develop-it" class="rounded-2xl shadow-2xl">
        </div>

        <div class="grid md:grid-cols-2 gap-12 items-center" data-aos="fade-left">
            <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=900&q=80"
                 alt="Gestion des congés - develop-it" class="rounded-2xl shadow-2xl order-2 md:order-1">
            <div class="order-1 md:order-2">
                <div class="inline-block bg-purple-100 text-purple-600 px-4 py-2 rounded-full text-sm font-semibold mb-4" data-i18n="feat2_badge">Gestion complète</div>
                <h3 class="text-3xl font-bold mb-4" data-i18n="feat2_title">Gestion des congés et missions</h3>
                <p class="text-slate-600 text-lg mb-6" data-i18n="feat2_desc">Simplifiez la gestion des demandes de congés. Workflow de validation automatisé.</p>
                <ul class="space-y-3">
                    <li class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-green-500 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span class="text-slate-700" data-i18n="feat2_f1"><strong>Calendrier interactif</strong> des absences</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-green-500 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span class="text-slate-700" data-i18n="feat2_f2"><strong>Suivi des soldes</strong> en temps réel</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- CUSTOMIZATION -->
<section class="py-24 bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 text-white">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-12" data-aos="fade-up">
            <span class="text-blue-300 font-semibold text-sm uppercase tracking-wider" data-i18n="custom_label">Personnalisation</span>
            <h2 class="text-4xl md:text-5xl font-bold mt-3 mb-6" data-i18n="custom_title">100% adaptable à votre entreprise</h2>
            <p class="text-blue-100 text-lg max-w-3xl mx-auto" data-i18n="custom_desc">
                Développé par <strong class="text-white">develop-it</strong> sous Laravel et entièrement personnalisable
                selon vos règles internes et votre charte graphique.
            </p>
        </div>
        <div class="grid md:grid-cols-2 gap-8 mt-16">
            <div class="bg-white/10 backdrop-blur-sm p-8 rounded-2xl border border-white/20 card-hover">
                <div class="text-5xl mb-4">🎨</div>
                <h3 class="text-2xl font-bold mb-3" data-i18n="custom1_title">Interface personnalisable</h3>
                <p class="text-blue-100 mb-4" data-i18n="custom1_desc">Adaptez l'interface aux couleurs de votre marque.</p>
                <ul class="space-y-2 text-sm">
                    <li class="flex items-center gap-2"><svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="custom1_f1">Charte graphique personnalisée</span></li>
                    <li class="flex items-center gap-2"><svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="custom1_f2">Logo et branding</span></li>
                </ul>
            </div>
            <div class="bg-white/10 backdrop-blur-sm p-8 rounded-2xl border border-white/20 card-hover">
                <div class="text-5xl mb-4">⚙️</div>
                <h3 class="text-2xl font-bold mb-3" data-i18n="custom2_title">Règles métier sur mesure</h3>
                <p class="text-blue-100 mb-4" data-i18n="custom2_desc">Configurez les règles selon vos politiques RH.</p>
                <ul class="space-y-2 text-sm">
                    <li class="flex items-center gap-2"><svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="custom2_f1">Horaires flexibles</span></li>
                    <li class="flex items-center gap-2"><svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="custom2_f2">Workflows personnalisés</span></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- PRICING -->
<section id="pricing" class="py-24 bg-slate-50">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider" data-i18n="price_label">Tarification</span>
            <h2 class="text-4xl md:text-5xl font-bold mt-3 mb-6" data-i18n="price_title">Des formules adaptées à votre taille</h2>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Starter -->
            <div class="bg-white p-8 rounded-2xl shadow-lg card-hover border border-slate-200" data-aos="fade-up">
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-bold mb-2">Starter</h3>
                    <div class="text-slate-600 mb-4" data-i18n="plan1_sub">Petites équipes</div>
                    <div class="text-4xl font-bold text-blue-600 mb-2" data-i18n="plan_price">Sur devis</div>
                    <div class="text-sm text-slate-500" data-i18n="plan1_limit">Jusqu'à 20 employés</div>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-start gap-3"><svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="plan1_f1">Pointage GPS</span></li>
                    <li class="flex items-start gap-3"><svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="plan1_f2">Gestion congés</span></li>
                    <li class="flex items-start gap-3"><svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="plan1_f3">Support email</span></li>
                </ul>
                <a href="#contact" class="block w-full bg-slate-100 text-slate-900 py-3 rounded-xl font-semibold text-center hover:bg-slate-200 transition" data-i18n="plan_quote_btn">Demander un devis</a>
            </div>
            <!-- Professional -->
            <div class="bg-gradient-to-br from-blue-600 to-cyan-600 p-8 rounded-2xl shadow-2xl card-hover relative transform md:scale-105" data-aos="fade-up" data-aos-delay="100">
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                    <span class="bg-yellow-400 text-slate-900 px-4 py-1 rounded-full text-sm font-bold" data-i18n="popular_badge">⭐ POPULAIRE</span>
                </div>
                <div class="text-center mb-6 text-white">
                    <h3 class="text-2xl font-bold mb-2">Professional</h3>
                    <div class="text-blue-100 mb-4" data-i18n="plan2_sub">PME en croissance</div>
                    <div class="text-4xl font-bold mb-2" data-i18n="plan_price2">Sur devis</div>
                    <div class="text-sm text-blue-100" data-i18n="plan2_limit">Jusqu'à 100 employés</div>
                </div>
                <ul class="space-y-3 mb-8 text-white">
                    <li class="flex items-start gap-3"><svg class="w-5 h-5 text-green-300 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="plan2_f1">Tout Starter +</span></li>
                    <li class="flex items-start gap-3"><svg class="w-5 h-5 text-green-300 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="plan2_f2">Notes de frais</span></li>
                    <li class="flex items-start gap-3"><svg class="w-5 h-5 text-green-300 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="plan2_f3">Rapports avancés</span></li>
                    <li class="flex items-start gap-3"><svg class="w-5 h-5 text-green-300 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="plan2_f4">Support prioritaire</span></li>
                </ul>
                <a href="#contact" class="block w-full bg-white text-blue-600 py-3 rounded-xl font-semibold text-center hover:bg-blue-50 transition" data-i18n="plan_quote_btn2">Demander un devis</a>
            </div>
            <!-- Enterprise -->
            <div class="bg-white p-8 rounded-2xl shadow-lg card-hover border border-slate-200" data-aos="fade-up" data-aos-delay="200">
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-bold mb-2">Enterprise</h3>
                    <div class="text-slate-600 mb-4" data-i18n="plan3_sub">Grandes entreprises</div>
                    <div class="text-4xl font-bold text-blue-600 mb-2" data-i18n="plan3_price">Sur mesure</div>
                    <div class="text-sm text-slate-500" data-i18n="plan3_limit">Illimité</div>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-start gap-3"><svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="plan3_f1">Tout Pro +</span></li>
                    <li class="flex items-start gap-3"><svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="plan3_f2">Personnalisation totale</span></li>
                    <li class="flex items-start gap-3"><svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg><span data-i18n="plan3_f3">Support dédié 24/7</span></li>
                </ul>
                <a href="#contact" class="block w-full bg-slate-100 text-slate-900 py-3 rounded-xl font-semibold text-center hover:bg-slate-200 transition" data-i18n="plan3_btn">Nous contacter</a>
            </div>
        </div>
    </div>
</section>

<!-- CTA BANNER -->
<section class="py-24 bg-gradient-to-r from-blue-600 to-cyan-600 text-white">
    <div class="max-w-4xl mx-auto px-6 text-center" data-aos="zoom-in">
        <h2 class="text-4xl md:text-5xl font-bold mb-6" data-i18n="cta_title">Prêt à transformer votre gestion RH ?</h2>
        <p class="text-xl text-blue-100 mb-8" data-i18n="cta_desc">
            Demandez une démonstration gratuite de HR Manager par <strong class="text-white">develop-it</strong>
        </p>
        <a href="#contact" class="bg-white text-blue-600 px-8 py-4 rounded-xl font-semibold hover:bg-blue-50 transition transform hover:scale-105 shadow-lg inline-flex items-center gap-2" data-i18n="cta_btn">
            🚀 Demander une démo gratuite
        </a>
    </div>
</section>

<!-- CONTACT -->
<section id="contact" class="bg-slate-900 text-white py-24">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-12" data-aos="fade-up">
            <span class="text-blue-300 font-semibold text-sm uppercase tracking-wider" data-i18n="contact_label">Contact</span>
            <h2 class="text-4xl md:text-5xl font-bold mt-3 mb-6" data-i18n="contact_title">Contactez develop-it</h2>
            <p class="text-slate-300 text-lg max-w-2xl mx-auto" data-i18n="contact_desc">
                Besoin d'une démonstration ou d'une adaptation spécifique ?
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
            <h3 class="text-2xl font-bold mb-6 text-center" data-i18n="form_title">Demander une démonstration</h3>

            <!-- Success Message -->
            <?php if (!empty($success_message)): ?>
            <div class="mb-6 bg-green-500/20 border border-green-400/50 text-green-200 px-6 py-4 rounded-xl flex items-center gap-3">
                <svg class="w-6 h-6 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span><?php echo $success_message; ?></span>
            </div>
            <?php endif; ?>

            <!-- Error Message -->
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
                        <label class="block text-sm font-semibold mb-2" data-i18n="f_company">Nom de l'entreprise</label>
                        <input type="text" name="company" value="<?php echo htmlspecialchars($_POST['company'] ?? ''); ?>"
                            class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-slate-400 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400/50 transition"
                            placeholder="Votre entreprise">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2" data-i18n="f_employees">Nombre d'employés</label>
                        <select name="employees" class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400/50 transition">
                            <option value="">Sélectionnez</option>
                            <option value="1-20"  <?php echo (($_POST['employees'] ?? '') === '1-20')   ? 'selected' : ''; ?>>1-20</option>
                            <option value="21-50" <?php echo (($_POST['employees'] ?? '') === '21-50')  ? 'selected' : ''; ?>>21-50</option>
                            <option value="51-100"<?php echo (($_POST['employees'] ?? '') === '51-100') ? 'selected' : ''; ?>>51-100</option>
                            <option value="100+" <?php echo (($_POST['employees'] ?? '') === '100+')   ? 'selected' : ''; ?>>100+</option>
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
                <div>
                    <label class="block text-sm font-semibold mb-2" data-i18n="f_phone">Téléphone</label>
                    <input type="tel" name="phone" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>"
                        class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-slate-400 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400/50 transition"
                        placeholder="+212 XXX XXX XXX">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2" data-i18n="f_message">Message / Besoins spécifiques</label>
                    <textarea name="message" rows="5"
                        class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-slate-400 focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400/50 transition resize-none"
                        placeholder="Décrivez vos besoins..."><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" name="submit_demo"
                        class="bg-white text-slate-900 px-8 py-4 rounded-xl font-semibold hover:bg-slate-100 transition transform hover:scale-105 shadow-lg" data-i18n="f_submit">
                        🚀 Demander une démonstration
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    HR Manager
                </h4>
                <p class="text-sm leading-relaxed" data-i18n="footer_desc">Solution RH complète pour gérer vos employés efficacement.</p>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4" data-i18n="footer_product">Produit</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#features" class="hover:text-white transition" data-i18n="nav_features">Fonctionnalités</a></li>
                    <li><a href="#pricing"  class="hover:text-white transition" data-i18n="nav_pricing">Tarifs</a></li>
                    <li><a href="#"         class="hover:text-white transition" data-i18n="footer_docs">Documentation</a></li>
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
                    <a href="#" class="w-10 h-10 bg-slate-800 rounded-full flex items-center justify-center hover:bg-blue-400 transition" aria-label="Twitter">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    </a>
                    <a href="#" class="w-10 h-10 bg-slate-800 rounded-full flex items-center justify-center hover:bg-blue-700 transition" aria-label="LinkedIn">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="border-t border-slate-800 pt-8 text-center text-sm">
            <p>© 2026 <strong>DEVELOP IT</strong> | HR Manager – Pointage GPS & Gestion RH | Tous droits réservés</p>
        </div>
    </div>
</footer>

<!-- AOS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 1000, once: true, offset: 100 });

    // ─── Language Switcher ────────────────────────────────────────────
    const translations = {
        fr: {
            nav_solution: 'Solution',   nav_features: 'Fonctionnalités',
            nav_pricing:  'Tarifs',     nav_contact:  'Contact',
            hero_badge:   '✨ Solution RH N°1 au Maroc',
            hero_subtitle:'Pointage GPS & Gestion RH',
            hero_desc:    'Une application web moderne pour gérer la présence des employés, les congés et les rapports RH avec géolocalisation sécurisée.',
            hero_cta1:    '🚀 Demander une démo',
            hero_cta2:    'Découvrir la solution',
            stat1: 'Précision GPS',  stat2: 'Entreprises', stat3: 'Support',
            sol_label: 'La solution',
            sol_title: 'Une solution RH complète et intuitive',
            sol_desc:  'HR Manager par <strong class="text-blue-600">develop-it</strong> centralise le pointage, la gestion du personnel et les rapports RH dans une interface moderne, sécurisée et facile à utiliser.',
            card1_title:'Pointage GPS',   card1_desc:'Validation automatique du lieu de travail grâce à la géolocalisation en temps réel.',
            card1_f1:'Géofencing intelligent', card1_f2:'Historique complet', card1_f3:'Alertes temps réel',
            card2_title:'Rapports RH',    card2_desc:'Feuilles de temps, ponctualité, anomalies et tableaux de bord analytiques.',
            card2_f1:'Tableaux de bord',  card2_f2:'Exports Excel & PDF', card2_f3:'Analyses prédictives',
            card3_title:'Gestion Personnel', card3_desc:'Employés, équipes, départements et gestion des rôles utilisateurs.',
            card3_f1:'Organigramme interactif', card3_f2:'Gestion permissions', card3_f3:'Profils détaillés',
            feat_label:'Fonctionnalités', feat_title:'Tout ce dont vous avez besoin',
            feat1_badge:'Pointage intelligent', feat1_title:'Pointage entrée / sortie horodaté',
            feat1_desc:'Enregistrez automatiquement les heures d\'arrivée et de départ avec une précision GPS. Détection automatique des anomalies et alertes en temps réel.',
            feat1_f1:'<strong>Horodatage précis</strong> avec validation GPS',
            feat1_f2:'<strong>Détection automatique</strong> des retards',
            feat2_badge:'Gestion complète', feat2_title:'Gestion des congés et missions',
            feat2_desc:'Simplifiez la gestion des demandes de congés. Workflow de validation automatisé.',
            feat2_f1:'<strong>Calendrier interactif</strong> des absences',
            feat2_f2:'<strong>Suivi des soldes</strong> en temps réel',
            custom_label:'Personnalisation', custom_title:'100% adaptable à votre entreprise',
            custom_desc:'Développé par <strong class="text-white">develop-it</strong> sous Laravel et entièrement personnalisable selon vos règles internes et votre charte graphique.',
            custom1_title:'Interface personnalisable', custom1_desc:'Adaptez l\'interface aux couleurs de votre marque.',
            custom1_f1:'Charte graphique personnalisée', custom1_f2:'Logo et branding',
            custom2_title:'Règles métier sur mesure', custom2_desc:'Configurez les règles selon vos politiques RH.',
            custom2_f1:'Horaires flexibles', custom2_f2:'Workflows personnalisés',
            price_label:'Tarification', price_title:'Des formules adaptées à votre taille',
            plan1_sub:'Petites équipes', plan_price:'Sur devis', plan1_limit:'Jusqu\'à 20 employés',
            plan1_f1:'Pointage GPS', plan1_f2:'Gestion congés', plan1_f3:'Support email',
            plan_quote_btn:'Demander un devis',
            popular_badge:'⭐ POPULAIRE', plan2_sub:'PME en croissance', plan_price2:'Sur devis', plan2_limit:'Jusqu\'à 100 employés',
            plan2_f1:'Tout Starter +', plan2_f2:'Notes de frais', plan2_f3:'Rapports avancés', plan2_f4:'Support prioritaire',
            plan_quote_btn2:'Demander un devis',
            plan3_sub:'Grandes entreprises', plan3_price:'Sur mesure', plan3_limit:'Illimité',
            plan3_f1:'Tout Pro +', plan3_f2:'Personnalisation totale', plan3_f3:'Support dédié 24/7', plan3_btn:'Nous contacter',
            cta_title:'Prêt à transformer votre gestion RH ?',
            cta_desc:'Demandez une démonstration gratuite de HR Manager par <strong class="text-white">develop-it</strong>',
            cta_btn:'🚀 Demander une démo gratuite',
            contact_label:'Contact', contact_title:'Contactez develop-it',
            contact_desc:'Besoin d\'une démonstration ou d\'une adaptation spécifique ?',
            email_title:'Email',       email_desc:'Contactez-nous par email',
            phone_title:'Téléphone',   phone_desc:'Appelez-nous directement',
            form_title:'Demander une démonstration',
            f_company:'Nom de l\'entreprise', f_employees:'Nombre d\'employés',
            f_name:'Nom complet *', f_email:'Email *', f_phone:'Téléphone',
            f_message:'Message / Besoins spécifiques',
            f_submit:'🚀 Demander une démonstration',
            footer_desc:'Solution RH complète pour gérer vos employés efficacement.',
            footer_product:'Produit', footer_docs:'Documentation',
            footer_company:'Entreprise', footer_about:'À propos de develop-it',
            footer_follow:'Suivez-nous',
        },
        en: {
            nav_solution: 'Solution',   nav_features: 'Features',
            nav_pricing:  'Pricing',    nav_contact:  'Contact',
            hero_badge:   '✨ #1 HR Solution in Morocco',
            hero_subtitle:'GPS Time Tracking & HR Management',
            hero_desc:    'A modern web application to manage employee attendance, leave and HR reports with secure geolocation.',
            hero_cta1:    '🚀 Request a demo',
            hero_cta2:    'Discover the solution',
            stat1: 'GPS Accuracy', stat2: 'Companies', stat3: 'Support',
            sol_label: 'The solution',
            sol_title: 'A complete and intuitive HR solution',
            sol_desc:  'HR Manager by <strong class="text-blue-600">develop-it</strong> centralises time tracking, personnel management and HR reports in a modern, secure and easy-to-use interface.',
            card1_title:'GPS Tracking',  card1_desc:'Automatic validation of the workplace via real-time geolocation.',
            card1_f1:'Smart geofencing', card1_f2:'Full history', card1_f3:'Real-time alerts',
            card2_title:'HR Reports',    card2_desc:'Timesheets, punctuality, anomalies and analytical dashboards.',
            card2_f1:'Dashboards',       card2_f2:'Excel & PDF exports', card2_f3:'Predictive analytics',
            card3_title:'Personnel Management', card3_desc:'Employees, teams, departments and user role management.',
            card3_f1:'Interactive org chart', card3_f2:'Permission management', card3_f3:'Detailed profiles',
            feat_label:'Features', feat_title:'Everything you need',
            feat1_badge:'Smart tracking', feat1_title:'Timestamped clock-in / clock-out',
            feat1_desc:'Automatically record arrival and departure times with GPS precision. Automatic anomaly detection and real-time alerts.',
            feat1_f1:'<strong>Precise timestamp</strong> with GPS validation',
            feat1_f2:'<strong>Automatic detection</strong> of late arrivals',
            feat2_badge:'Full management', feat2_title:'Leave and mission management',
            feat2_desc:'Simplify leave request management. Automated approval workflow.',
            feat2_f1:'<strong>Interactive calendar</strong> of absences',
            feat2_f2:'<strong>Real-time balance</strong> tracking',
            custom_label:'Customisation', custom_title:'100% adaptable to your company',
            custom_desc:'Developed by <strong class="text-white">develop-it</strong> on Laravel and fully customisable according to your internal rules and brand guidelines.',
            custom1_title:'Customisable interface', custom1_desc:'Adapt the interface to your brand colours.',
            custom1_f1:'Custom brand guidelines', custom1_f2:'Logo and branding',
            custom2_title:'Custom business rules', custom2_desc:'Configure rules according to your HR policies.',
            custom2_f1:'Flexible schedules', custom2_f2:'Custom workflows',
            price_label:'Pricing', price_title:'Plans suited to your size',
            plan1_sub:'Small teams',    plan_price:'On request', plan1_limit:'Up to 20 employees',
            plan1_f1:'GPS Tracking', plan1_f2:'Leave management', plan1_f3:'Email support',
            plan_quote_btn:'Request a quote',
            popular_badge:'⭐ POPULAR', plan2_sub:'Growing SMEs', plan_price2:'On request', plan2_limit:'Up to 100 employees',
            plan2_f1:'Everything in Starter +', plan2_f2:'Expense reports', plan2_f3:'Advanced reports', plan2_f4:'Priority support',
            plan_quote_btn2:'Request a quote',
            plan3_sub:'Large enterprises', plan3_price:'Custom', plan3_limit:'Unlimited',
            plan3_f1:'Everything in Pro +', plan3_f2:'Full customisation', plan3_f3:'Dedicated 24/7 support', plan3_btn:'Contact us',
            cta_title:'Ready to transform your HR management?',
            cta_desc:'Request a free demonstration of HR Manager by <strong class="text-white">develop-it</strong>',
            cta_btn:'🚀 Request a free demo',
            contact_label:'Contact', contact_title:'Contact develop-it',
            contact_desc:'Need a demonstration or a specific adaptation?',
            email_title:'Email',       email_desc:'Contact us by email',
            phone_title:'Phone',       phone_desc:'Call us directly',
            form_title:'Request a demonstration',
            f_company:'Company name', f_employees:'Number of employees',
            f_name:'Full name *', f_email:'Email *', f_phone:'Phone',
            f_message:'Message / Specific needs',
            f_submit:'🚀 Request a demonstration',
            footer_desc:'Complete HR solution to manage your employees efficiently.',
            footer_product:'Product', footer_docs:'Documentation',
            footer_company:'Company', footer_about:'About develop-it',
            footer_follow:'Follow us',
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