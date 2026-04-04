<?php
/**
 * TrendDrop - Landing Page
 * develop-it / Abdelhamid
 */

$success_message = '';
$error_message   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_contact'])) {

    $name    = htmlspecialchars(strip_tags(trim($_POST['name']    ?? '')));
    $email   = filter_var(trim($_POST['email']   ?? ''), FILTER_SANITIZE_EMAIL);
    $plan    = htmlspecialchars(strip_tags(trim($_POST['plan']    ?? '')));
    $niche   = htmlspecialchars(strip_tags(trim($_POST['niche']   ?? '')));
    $message = htmlspecialchars(strip_tags(trim($_POST['message'] ?? '')));

    if (empty($name) || empty($email)) {
        $error_message = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Invalid email address.';
    } else {
        $to           = 'contact@develop-it.tech';
        $subject_mail = '🔥 TrendDrop — New Lead: ' . $name;

        $body  = "New TrendDrop Lead\n";
        $body .= str_repeat('─', 50) . "\n\n";
        $body .= "👤 Name    : $name\n";
        $body .= "📧 Email   : $email\n";
        $body .= "💼 Plan    : " . ($plan    ?: 'Not specified') . "\n";
        $body .= "🎯 Niche   : " . ($niche   ?: 'Not specified') . "\n\n";
        $body .= "💬 Message :\n" . ($message ?: 'No message') . "\n\n";
        $body .= str_repeat('─', 50) . "\n";
        $body .= "Sent on : " . date('d/m/Y at H:i') . "\n";
        $body .= "IP      : " . ($_SERVER['REMOTE_ADDR'] ?? 'N/A') . "\n";

        $headers  = "From: no-reply@develop-it.tech\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        if (mail($to, $subject_mail, $body, $headers)) {
            $success_message = 'Request sent! We\'ll contact you within 24h to set up your free trial.';
        } else {
            $error_message = 'An error occurred. Please try again or email us directly.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>TrendDrop | AI-Powered Product Research & Drop-shipping Intelligence</title>
    <meta name="description" content="TrendDrop — Find winning dropshipping products before everyone else. Google Trends + TikTok data, AI ad copy, supplier sourcing, competitor spy. Free plan available.">
    <meta name="keywords" content="trenddrop, dropshipping, product research, trending products, ai ad copy, google trends, tiktok trends, supplier sourcing, competitor analysis">
    <meta name="author" content="develop-it">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://develop-it.tech/trenddrop.php">
    <link rel="icon" type="image/png" sizes="32x32" href="/logo.jfif">
    <link rel="apple-touch-icon" href="/logo.jfif">
    <meta property="og:type"        content="website">
    <meta property="og:url"         content="https://trenddrop.io">
    <meta property="og:title"       content="TrendDrop — Find Winning Products Before Everyone Else">
    <meta property="og:description" content="Real-time trend data, AI ad generation, supplier sourcing and competitor spy in one platform.">
    <meta property="og:image"       content="https://images.unsplash.com/photo-1611532736597-de2d4265fba3?w=1200&q=80">
    <meta name="twitter:card"       content="summary_large_image">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Mono:wght@300;400;500&family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --black:    #07080a;
            --fire:     #ff4d1c;
            --fire-dim: #7a2508;
            --ember:    #ff8c42;
            --smoke:    #1a1c20;
            --ash:      #2e3038;
            --mist:     #6b7280;
            --cream:    #f9f7f4;
        }

        * { box-sizing: border-box; }
        body { font-family: 'Manrope', sans-serif; background: #ffffff; color: #07080a; }
        .font-display { font-family: 'Syne', sans-serif; }
        .font-mono    { font-family: 'DM Mono', monospace; }

        /* ── Animated hero ── */
        @keyframes bgPulse {
            0%,100% { background-position: 0% 50%; }
            50%      { background-position: 100% 50%; }
        }
        .hero-bg {
            background: linear-gradient(-45deg, #07080a, #0f1014, #110a07, #1a0d08);
            background-size: 400% 400%;
            animation: bgPulse 20s ease infinite;
        }

        /* ── Fire underline ── */
        .fire-line {
            background-image: linear-gradient(90deg, var(--fire), var(--ember));
            background-repeat: no-repeat;
            background-position: 0 100%;
            background-size: 100% 3px;
        }

        /* ── Section eyebrow ── */
        .eyebrow {
            font-family: 'DM Mono', monospace;
            font-size: 11px;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: var(--fire);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .eyebrow::before {
            content: '';
            display: block;
            width: 28px; height: 1px;
            background: var(--fire);
        }

        /* ── Cards ── */
        .card-h {
            transition: transform 0.28s ease, box-shadow 0.28s ease;
        }
        .card-h:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(255,77,28,0.1);
        }

        /* ── Metric accent ── */
        .metric-num {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            background: linear-gradient(135deg, var(--fire), var(--ember));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
        }

        /* ── Badge pill ── */
        .badge-fire {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,77,28,0.12);
            border: 1px solid rgba(255,77,28,0.3);
            color: var(--fire);
            padding: 5px 14px;
            border-radius: 0;
            font-family: 'DM Mono', monospace;
            font-size: 11px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        /* ── Feature tag ── */
        .feat-num {
            font-family: 'DM Mono', monospace;
            font-size: 10px;
            letter-spacing: 0.2em;
            color: var(--fire);
            text-transform: uppercase;
            margin-bottom: 14px;
        }

        /* ── Form inputs ── */
        .td-input {
            width: 100%;
            padding: 14px 18px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.12);
            color: white;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            font-family: 'Manrope', sans-serif;
            font-size: 14px;
            border-radius: 0;
        }
        .td-input:focus {
            border-color: var(--fire);
            box-shadow: 0 0 0 3px rgba(255,77,28,0.1);
        }
        .td-input::placeholder { color: rgba(255,255,255,0.3); }
        .td-input option { background: #111; color: white; }

        /* ── Buttons ── */
        .btn-fire {
            background: linear-gradient(135deg, var(--fire), var(--ember));
            color: white;
            padding: 15px 36px;
            font-family: 'DM Mono', monospace;
            font-size: 12px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            text-decoration: none;
            display: inline-block;
            border: none;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s;
            border-radius: 0;
        }
        .btn-fire:hover { opacity: 0.88; transform: scale(1.02); }

        .btn-outline-fire {
            border: 1px solid rgba(255,77,28,0.5);
            color: var(--fire);
            padding: 14px 32px;
            font-family: 'DM Mono', monospace;
            font-size: 11px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
            border-radius: 0;
        }
        .btn-outline-fire:hover { background: rgba(255,77,28,0.1); border-color: var(--fire); }

        /* ── Noise overlay ── */
        .noise::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
        }

        /* ── Marquee ── */
        @keyframes marquee { from { transform: translateX(0); } to { transform: translateX(-50%); } }
        .marquee-track { animation: marquee 32s linear infinite; white-space: nowrap; display: flex; }

        /* ── Hero animations ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(28px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .h1 { animation: fadeUp 0.8s ease forwards; }
        .h2 { animation: fadeUp 0.8s 0.15s ease both; }
        .h3 { animation: fadeUp 0.8s 0.3s ease both; }
        .h4 { animation: fadeUp 0.8s 0.45s ease both; }

        /* ── Plan card ── */
        .plan-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            padding: 36px 28px;
            position: relative;
            transition: all 0.3s ease;
        }
        .plan-card:hover { border-color: var(--fire); box-shadow: 0 16px 40px rgba(255,77,28,0.08); transform: translateY(-4px); }
        .plan-card.featured { border-color: var(--fire); box-shadow: 0 0 0 2px var(--fire); }

        /* ── Step timeline ── */
        .step-item { position: relative; padding-left: 52px; }
        .step-item::before {
            content: attr(data-num);
            position: absolute;
            left: 0; top: 0;
            width: 34px; height: 34px;
            background: linear-gradient(135deg, var(--fire), var(--ember));
            color: white;
            font-family: 'DM Mono', monospace;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
        }
        .step-item::after {
            content: '';
            position: absolute;
            left: 16px; top: 34px;
            width: 1px; height: calc(100% + 20px);
            background: #e5e7eb;
        }
        .step-item:last-child::after { display: none; }

        /* ── Dark section ── */
        .dark-section { background: var(--black); color: white; }

        /* ── Source badge ── */
        .src-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 0;
            font-family: 'DM Mono', monospace;
            font-size: 10px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        /* ── Glow line ── */
        .glow-line {
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--fire), var(--ember), transparent);
        }

        /* ── Screen mockup ── */
        .screen-mock {
            background: #111318;
            border: 1px solid #1e2028;
            border-radius: 0;
            overflow: hidden;
        }
        .screen-bar {
            background: #1a1c22;
            padding: 10px 14px;
            display: flex;
            align-items: center;
            gap: 6px;
            border-bottom: 1px solid #1e2028;
        }
        .dot { width: 8px; height: 8px; border-radius: 50%; }

        /* ── Score pill ── */
        .score-high { color: #22c55e; background: rgba(34,197,94,0.12); }
        .score-mid  { color: #f59e0b; background: rgba(245,158,11,0.12); }

        /* ── Extension mockup ── */
        .ext-panel {
            background: #1a1a24;
            border: 1px solid #2a2a3a;
            width: 280px;
        }

        /* ── Scroll hint ── */
        @keyframes bounce {
            0%,100% { transform: translateY(0); }
            50%      { transform: translateY(6px); }
        }
        .scroll-hint { animation: bounce 2s ease infinite; }


        /* Language Switcher */
        .lang-switcher { display:flex; align-items:center; background:#f1f5f9; border-radius:9999px; padding:3px; gap:2px; }
        .lang-btn { padding:4px 12px; border-radius:9999px; font-size:13px; font-weight:600; cursor:pointer; transition:all 0.2s; border:none; background:transparent; color:#64748b; font-family:'DM Mono',monospace; }
        .lang-btn.active { background:var(--fire); color:white; box-shadow:0 1px 4px rgba(255,77,28,0.4); }
        .lang-btn:hover:not(.active) { color:var(--fire-dim); }

        html { scroll-behavior: smooth; }
    </style>
</head>
<body>

<!-- ══════════════════════════════════════════════
     NAV
══════════════════════════════════════════════ -->
<nav class="bg-white border-b border-slate-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-8">
            <a href="/" class="flex items-center gap-2 text-slate-500 hover:text-slate-800 transition text-sm font-medium">
                <img src="/logo.jfif" alt="develop-it" class="w-5 h-5">
                develop-it
            </a>
            <div class="hidden md:block w-px h-4 bg-slate-200"></div>
            <span class="hidden md:flex items-center gap-2 font-display font-bold text-lg" style="color:var(--black)">
                🔥 TrendDrop
            </span>
        </div>
        <div class="hidden md:flex items-center gap-6">
            <a href="#features"  class="text-slate-500 hover:text-slate-900 text-sm font-medium transition" data-i18n="nav_features">Features</a>
            <a href="#sources"   class="text-slate-500 hover:text-slate-900 text-sm font-medium transition" data-i18n="nav_sources">Data Sources</a>
            <a href="#extension" class="text-slate-500 hover:text-slate-900 text-sm font-medium transition" data-i18n="nav_extension">Extension</a>
            <a href="#mobile"    class="text-slate-500 hover:text-slate-900 text-sm font-medium transition" data-i18n="nav_mobile">Mobile</a>
            <a href="#pricing"   class="text-slate-500 hover:text-slate-900 text-sm font-medium transition" data-i18n="nav_pricing">Pricing</a>
            <a href="#contact"   class="btn-fire text-xs" data-i18n="nav_cta">Get Early Access →</a>
            <div class="lang-switcher">
                <button class="lang-btn active" onclick="setLang('en', this)">🇬🇧 EN</button>
                <button class="lang-btn"        onclick="setLang('fr', this)">🇫🇷 FR</button>
            </div>
        </div>
        <!-- Mobile menu button -->
        <button class="md:hidden text-slate-600" onclick="document.getElementById('mob-menu').classList.toggle('hidden')">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </div>
    <!-- Mobile nav -->
    <div id="mob-menu" class="hidden md:hidden border-t border-slate-100 px-6 py-4 flex flex-col gap-3">
        <a href="#features"  class="text-slate-600 text-sm py-1">Features</a>
        <a href="#sources"   class="text-slate-600 text-sm py-1">Data Sources</a>
        <a href="#extension" class="text-slate-600 text-sm py-1">Extension</a>
        <a href="#mobile"    class="text-slate-600 text-sm py-1">Mobile App</a>
        <a href="#pricing"   class="text-slate-600 text-sm py-1">Pricing</a>
        <a href="#contact"   class="btn-fire text-xs inline-block w-fit mt-2">Get Early Access →</a>
    </div>
</nav>

<!-- ══════════════════════════════════════════════
     HERO
══════════════════════════════════════════════ -->
<section class="hero-bg noise relative text-white overflow-hidden min-h-screen flex items-center">

    <!-- Grid overlay -->
    <div class="absolute inset-0" style="background-image:linear-gradient(rgba(255,77,28,0.03) 1px,transparent 1px),linear-gradient(90deg,rgba(255,77,28,0.03) 1px,transparent 1px);background-size:72px 72px;"></div>

    <!-- Glow blobs -->
    <div class="absolute top-1/4 left-1/4 w-96 h-96 rounded-full opacity-10" style="background:radial-gradient(circle,var(--fire),transparent 70%);filter:blur(60px);"></div>
    <div class="absolute bottom-1/4 right-1/3 w-64 h-64 rounded-full opacity-8" style="background:radial-gradient(circle,var(--ember),transparent 70%);filter:blur(80px);"></div>

    <div class="max-w-7xl mx-auto px-6 py-28 grid md:grid-cols-2 gap-16 items-center relative z-10 w-full">

        <!-- LEFT -->
        <div>
            <div class="badge-fire h1 mb-8" data-i18n="hero_badge">🔥 Product Research Intelligence</div>

            <h1 class="font-display text-6xl md:text-7xl font-black leading-none mb-6 h2" style="letter-spacing:-0.025em;">
                Find Winning<br>
                Products<br>
                <span style="background:linear-gradient(90deg,var(--fire),var(--ember));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;" data-i18n="hero_accent">Before Everyone.</span>
            </h1>

            <p class="text-slate-300 text-lg leading-relaxed mb-4 h3 max-w-lg">
                <span data-i18n="hero_desc">TrendDrop scans <strong class="text-white">Google Trends, TikTok</strong> and <strong class="text-white">CJDropshipping</strong> in real-time, scores every product by demand velocity, and generates AI-powered ads, landing pages, and video scripts — in seconds.</span>
            </p>

            <div class="flex flex-wrap gap-3 mb-8 h3">
                <span class="src-badge" style="background:rgba(66,133,244,0.15);color:#4285f4;">🔍 Google Trends</span>
                <span class="src-badge" style="background:rgba(255,0,80,0.15);color:#ff0050;">🎵 TikTok</span>
                <span class="src-badge" style="background:rgba(0,166,81,0.15);color:#00a651;">📦 CJDropshipping</span>
            </div>

            <div class="flex flex-wrap gap-4 h4">
                <a href="#contact" class="btn-fire" data-i18n="hero_cta1">🚀 Start Free — No Card</a>
                <a href="#features" class="btn-outline-fire" data-i18n="hero_cta2">See All Features</a>
            </div>

            <div class="mt-12 grid grid-cols-3 gap-6 h4">
                <div class="border-r border-white/10 pr-6 text-center">
                    <div class="metric-num text-4xl mb-1">50+</div>
                    <div class="font-mono text-xs text-slate-400 uppercase tracking-widest">Product<br>Categories</div>
                </div>
                <div class="border-r border-white/10 pr-6 text-center">
                    <div class="metric-num text-4xl mb-1">6</div>
                    <div class="font-mono text-xs text-slate-400 uppercase tracking-widest">Languages<br>Supported</div>
                </div>
                <div class="text-center">
                    <div class="metric-num text-4xl mb-1">∞</div>
                    <div class="font-mono text-xs text-slate-400 uppercase tracking-widest">AI Creatives<br>on Pro</div>
                </div>
            </div>
        </div>

        <!-- RIGHT — Dashboard mockup -->
        <div data-aos="fade-left" data-aos-duration="900" data-aos-delay="300">
            <div class="screen-mock">
                <div class="screen-bar">
                    <div class="dot bg-red-500"></div>
                    <div class="dot bg-yellow-400"></div>
                    <div class="dot bg-green-400"></div>
                    <span class="font-mono text-xs text-slate-500 ml-4">trenddrop.io/dashboard/trends</span>
                </div>
                <div style="padding:20px;font-family:'DM Mono',monospace;">
                    <div style="font-size:9px;letter-spacing:0.2em;color:var(--fire);text-transform:uppercase;margin-bottom:16px;">🔥 Trending Now — US · All Categories</div>

                    <?php
                    $mock_products = [
                        ['Portable Blender',    'Kitchen',    92, 'Exploding', '#22c55e', 'Google + TikTok'],
                        ['Posture Corrector',   'Health',     81, 'Hot',       '#f59e0b', 'TikTok'],
                        ['LED Strip Lights',    'Home Decor', 74, 'Rising',    '#f59e0b', 'Google'],
                        ['Massage Gun',         'Fitness',    68, 'Rising',    '#f59e0b', 'Google + TikTok'],
                        ['Cat Tree Tower',      'Pet',        61, 'Stable',    '#6b7280', 'CJ'],
                    ];
                    foreach ($mock_products as $p):
                    ?>
                    <div style="display:flex;align-items:center;gap:10px;padding:10px 12px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.04);margin-bottom:6px;">
                        <div style="flex:1;">
                            <div style="font-size:12px;color:#fff;font-weight:600;margin-bottom:2px;"><?= $p[0] ?></div>
                            <div style="font-size:9px;color:#555;letter-spacing:0.1em;"><?= $p[1] ?> · <?= $p[5] ?></div>
                        </div>
                        <div style="text-align:center;min-width:42px;">
                            <div style="font-size:16px;font-weight:800;color:<?= $p[4] ?>;line-height:1;"><?= $p[2] ?></div>
                            <div style="font-size:8px;color:<?= $p[4] ?>;letter-spacing:0.05em;"><?= $p[3] ?></div>
                        </div>
                        <div style="display:flex;gap:4px;">
                            <span style="font-size:9px;padding:2px 6px;background:rgba(255,77,28,0.15);color:var(--fire);">Ad →</span>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <div style="margin-top:14px;padding:12px;background:rgba(255,77,28,0.08);border-left:2px solid var(--fire);">
                        <div style="font-size:9px;color:var(--fire);letter-spacing:0.15em;text-transform:uppercase;margin-bottom:4px;">✨ AI Ad Copy — Generated</div>
                        <div style="font-size:11px;color:#ccc;line-height:1.6;">"Your protein shake is tired. Meet the blender<br>that fits in your gym bag. 🔥 Shop now →"</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll hint -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 scroll-hint">
        <div style="width:1px;height:48px;background:linear-gradient(to bottom,transparent,var(--fire));margin:0 auto;"></div>
    </div>
</section>

<!-- ══════════════════════════════════════════════
     MARQUEE
══════════════════════════════════════════════ -->
<div style="background:linear-gradient(90deg,var(--fire),var(--ember));padding:11px 0;overflow:hidden;">
    <div class="marquee-track">
        <?php
        $marquee_items = ['REAL-TIME TREND DATA', 'AI AD COPY', 'VIDEO SCRIPTS', 'LANDING PAGES', 'COMPETITOR SPY', 'SHOPIFY IMPORT', 'BROWSER EXTENSION', 'MOBILE APP', 'SUPPLIER SOURCING', '6 LANGUAGES'];
        $items_doubled = array_merge($marquee_items, $marquee_items);
        foreach ($items_doubled as $item):
        ?>
        <span style="font-family:'DM Mono',monospace;font-size:12px;letter-spacing:0.2em;color:white;padding:0 36px;"><?= $item ?></span>
        <span style="color:rgba(255,255,255,0.5);padding:0 8px;">·</span>
        <?php endforeach; ?>
    </div>
</div>

<!-- ══════════════════════════════════════════════
     FEATURES OVERVIEW
══════════════════════════════════════════════ -->
<section id="features" class="py-28 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="eyebrow justify-center mb-6" data-i18n="feat_eyebrow">What TrendDrop does</div>
<h2 class="font-display text-5xl md:text-6xl font-black mb-6 leading-tight">
                <span data-i18n="feat_title_1">Everything you need to</span><br>
                <span class="fire-line" data-i18n="feat_title_2">launch winning products.</span>
            </h2>
            <p class="text-slate-500 text-lg max-w-2xl mx-auto" data-i18n="feat_desc">
                From finding the trend to launching the ad — TrendDrop covers the entire dropshipping workflow in one platform.
            </p>
        </div>

        <!-- Feature grid -->
        <div class="grid md:grid-cols-3 gap-6">
            <?php
            $features = [
                ['01', '🔥', 'Trend Intelligence', 'Scans Google Trends, TikTok, and CJDropshipping simultaneously. Each product gets a 0–100 trend score with velocity label: Exploding, Hot, Rising, Stable, or Declining.', ['Real-time scoring', 'Multi-source fusion', '10 product categories', '9 countries supported']],
                ['02', '✍️', 'AI Creative Suite', 'Generate platform-optimized ad copy, video scripts, landing pages, and image prompts in seconds. All in English, French, Arabic (Darija & Gulf), Spanish, or German.', ['Facebook, TikTok, Google, Instagram', 'A/B variation generator', '6 languages', 'Shopify-ready copy']],
                ['03', '🔬', 'Product Analyzer', 'Deep viability scorecard before you spend a dollar on ads. Verdict, platform scores, risks, opportunities, winning angle — and a recommended ad budget.', ['0–100 viability score', 'Platform score breakdown', 'Risk & opportunity matrix', 'Ad strategy recommendation']],
                ['04', '📦', 'Supplier Sourcing', 'Find real CJDropshipping suppliers for any product with shipping costs, shipping speed, tracking status and live pricing. Built-in profit calculator with margin and ROI.', ['CJDropshipping integration', 'Shipping cost calculator', 'Profit & ROI calculator', 'Compare up to 3 suppliers']],
                ['05', '🕵️', 'Competitor Spy', 'Enter any public Shopify store URL. TrendDrop fetches their products, scores each one against Google Trends, identifies their rising vs declining products, and surfaces gaps you can exploit.', ['Any public Shopify store', 'Trend score per product', 'Rising vs declining products', 'Opportunity gap analysis']],
                ['06', '🌍', 'Community + Marketplace', 'Browse winning products shared by the community with real CTR and ROAS results. Save, upvote, and use any community find. Browse and publish ad copy templates — free or premium.', ['Community product feed', 'Ad template marketplace', 'Shareable product cards', 'Upvote & bookmark system']],
            ];
            foreach ($features as $f):
            ?>
            <div class="p-8 border border-slate-200 card-h" data-aos="fade-up">
                <div class="feat-num"><?= $f[0] ?></div>
                <div style="font-size:32px;margin-bottom:12px;"><?= $f[1] ?></div>
                <h3 class="font-display font-bold text-xl mb-3"><?= $f[2] ?></h3>
                <p class="text-slate-500 text-sm leading-relaxed mb-5"><?= $f[3] ?></p>
                <ul class="space-y-2">
                    <?php foreach ($f[4] as $bullet): ?>
                    <li class="flex items-center gap-2 text-sm text-slate-600">
                        <span style="color:var(--fire);font-size:10px;">▶</span>
                        <?= $bullet ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════
     DATA SOURCES
══════════════════════════════════════════════ -->
<section id="sources" class="py-28" style="background:#f8f7f5;">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-20 items-center">
            <div data-aos="fade-right">
                <div class="eyebrow mb-6" data-i18n="src_eyebrow">Where the data comes from</div>
                <h2 class="font-display text-5xl font-black leading-tight mb-8">
                    <span data-i18n="src_title_1">3 sources.</span><br>
                    <span style="color:var(--fire)" data-i18n="src_title_2">1 unified score.</span>
                </h2>
                <p class="text-slate-600 text-lg leading-relaxed mb-10" data-i18n="src_desc">
                    Most tools use one data source. TrendDrop fuses three in real-time, weights them by recency, and produces a composite score that reflects true market demand — not a single platform\'s bubble.
                </p>

                <div class="space-y-8">
                    <div class="step-item" data-num="40%" data-aos="fade-up">
                        <h3 class="font-bold text-lg mb-2" style="color:#4285f4;">Google Trends</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Weighted 40% of the composite score. Uses a 2-step widget API with exponential recency weighting — the last 4 weeks count 3× more than older data. Batched with 1.5s delays and 12h Redis cache to stay within rate limits.</p>
                    </div>
                    <div class="step-item" data-num="35%" data-aos="fade-up" data-aos-delay="100">
                        <h3 class="font-bold text-lg mb-2" style="color:#ff0050;">TikTok Signals</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Weighted 35%. Filters for real product names (not hashtags like #TikTokMadeMeBuyIt). Extracts buy-intent phrases from video descriptions. Products with 1,000+ likes only. Refreshed every 6h.</p>
                    </div>
                    <div class="step-item" data-num="25%" data-aos="fade-up" data-aos-delay="200">
                        <h3 class="font-bold text-lg mb-2" style="color:#00a651;">CJDropshipping Supply</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Weighted 25%. Live product catalog search, shipping cost calculation per country, and supplier enrichment. When supply is deep and trend is rising — that's the signal.</p>
                    </div>
                </div>
            </div>

            <!-- Score visualization -->
            <div data-aos="fade-left" data-aos-delay="200">
                <div style="background:#07080a;padding:36px;position:relative;">
                    <div style="font-family:'DM Mono',monospace;font-size:9px;letter-spacing:0.3em;color:var(--fire);margin-bottom:24px;text-transform:uppercase;">Composite Score — Portable Blender · US</div>

                    <!-- Source bars -->
                    <?php
                    $sources = [
                        ['Google Trends', '40%', 88, '#4285f4'],
                        ['TikTok',        '35%', 91, '#ff0050'],
                        ['CJDropshipping','25%', 72, '#00a651'],
                    ];
                    foreach ($sources as $src):
                    ?>
                    <div style="margin-bottom:20px;">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                            <span style="font-size:13px;color:#fff;font-weight:600;"><?= $src[0] ?></span>
                            <span style="font-family:'DM Mono',monospace;font-size:11px;color:<?= $src[3] ?>;"><?= $src[1] ?> weight · <?= $src[2] ?>/100</span>
                        </div>
                        <div style="height:8px;background:#1a1c20;border-radius:0;">
                            <div style="height:100%;width:<?= $src[2] ?>%;background:<?= $src[3] ?>;transition:width 1s ease;"></div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <!-- Final score -->
                    <div style="margin-top:28px;padding:20px;border:1px solid rgba(255,77,28,0.3);background:rgba(255,77,28,0.06);display:flex;align-items:center;gap:20px;">
                        <div style="text-align:center;">
                            <div style="font-family:'Syne',sans-serif;font-size:52px;font-weight:800;background:linear-gradient(135deg,#ff4d1c,#ff8c42);-webkit-background-clip:text;-webkit-text-fill-color:transparent;line-height:1;">87</div>
                            <div style="font-size:10px;color:#555;font-family:'DM Mono',monospace;margin-top:2px;">COMPOSITE</div>
                        </div>
                        <div>
                            <div style="font-size:14px;color:#fff;font-weight:700;margin-bottom:4px;">🔥 Exploding</div>
                            <div style="font-size:12px;color:#888;line-height:1.6;">High velocity across all 3 sources. Rising faster than 91% of tracked products this week.</div>
                        </div>
                    </div>

                    <!-- Corners -->
                    <div style="position:absolute;top:0;left:0;width:32px;height:32px;border-top:2px solid var(--fire);border-left:2px solid var(--fire);"></div>
                    <div style="position:absolute;bottom:0;right:0;width:32px;height:32px;border-bottom:2px solid var(--fire);border-right:2px solid var(--fire);"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════
     AI CREATIVE SUITE DEEP DIVE
══════════════════════════════════════════════ -->
<section class="py-28 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="eyebrow justify-center mb-6" data-i18n="creative_eyebrow">AI Creative Suite</div>
            <h2 class="font-display text-5xl font-black mb-6">
                <span data-i18n="creative_title_1">From product to launch-ready.</span><br>
                <span style="color:var(--fire)" data-i18n="creative_title_2">In under 60 seconds.</span>
            </h2>
            <p class="text-slate-500 text-lg max-w-2xl mx-auto" data-i18n="creative_desc">5 AI tools built specifically for dropshipping creatives. Not generic. Not templated. Trained on dropshipping copy patterns.</p>
        </div>

        <div class="grid md:grid-cols-5 gap-4">
            <?php
            $tools = [
                ['✍️', 'Ad Copy', 'Platform-optimized for Facebook, TikTok, Google, Instagram, YouTube. 3 A/B angle variations (benefit, urgency, social proof) per request.'],
                ['🎬', 'Video Script', 'Full TikTok/Reels/Shorts scripts: hook (0–3s), problem, solution, demo, CTA. With 3 hook variations and music vibe suggestion.'],
                ['🏠', 'Landing Page', 'Complete Shopify product page: SEO title, hero, 4 benefit cards, 3 social proof reviews, FAQ, and urgency block. Copy-paste ready.'],
                ['🔬', 'Product Analyzer', 'Viability scorecard: overall score, verdict, platform scores, saturation, risks, opportunities, winning angle, and ad strategy.'],
                ['🖼️', 'Image Prompts', '4 FAL.AI-ready image prompts per request with negative prompts, aspect ratios (1:1, 9:16, 4:5) and use-case labels.'],
            ];
            foreach ($tools as $i => $t):
            ?>
            <div class="p-6 border border-slate-200 card-h" data-aos="fade-up" data-aos-delay="<?= $i * 70 ?>">
                <div style="font-size:28px;margin-bottom:12px;"><?= $t[0] ?></div>
                <h3 class="font-display font-bold text-base mb-3"><?= $t[1] ?></h3>
                <p class="text-slate-500 text-xs leading-relaxed"><?= $t[2] ?></p>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Language support -->
        <div class="mt-10 p-8 border border-slate-200" data-aos="fade-up">
            <div class="flex flex-wrap gap-4 items-center">
                <span class="font-display font-bold text-lg">🌐 Multi-Language Support:</span>
                <?php
                $langs = ['🇺🇸 English','🇫🇷 French','🇲🇦 Arabic (Darija)','🇸🇦 Arabic (Gulf / MSA)','🇪🇸 Spanish','🇩🇪 German'];
                foreach ($langs as $l): ?>
                <span style="padding:6px 14px;border:1px solid #e5e7eb;font-size:13px;font-family:'DM Mono',monospace;"><?= $l ?></span>
                <?php endforeach; ?>
                <p class="text-slate-500 text-sm ml-auto">All AI tools generate in your selected language with cultural adaptation — not just translation.</p>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════
     BROWSER EXTENSION
══════════════════════════════════════════════ -->
<section id="extension" class="py-28 dark-section">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-20 items-center">

            <!-- LEFT -->
            <div data-aos="fade-right">
                <div class="eyebrow mb-6" style="color:var(--fire)" data-i18n="ext_eyebrow">Chrome Extension</div>
                <h2 class="font-display text-5xl font-black leading-tight mb-6 text-white">
                    <span data-i18n="ext_title_1">Research while</span><br>
                    <em style="color:var(--fire)" data-i18n="ext_title_2">you browse.</em>
                </h2>
                <p class="text-slate-400 leading-relaxed mb-10" data-i18n="ext_desc">
                    Install the TrendDrop Chrome extension and get a live sidebar panel on every AliExpress, Amazon, and CJDropshipping product page — without leaving the tab.
                </p>

                <div class="space-y-6 mb-10">
                    <?php
                    $ext_features = [
                        ['📊', 'Live Trend Score', 'Instant 0–100 score for any product you\'re browsing — pulled from the same multi-source engine as the dashboard.'],
                        ['✍️', 'Generate Ad Copy', 'One-click Facebook/TikTok ad copy generation directly from the product page. Copy to clipboard instantly.'],
                        ['🔖', 'Save to TrendDrop', 'Save any product to your TrendDrop dashboard with one click. No copy-pasting URLs or product names.'],
                        ['🚀', 'Open in Dashboard', 'Jump straight to the Creative Suite with the product pre-loaded — ready to generate scripts, landing pages, image prompts.'],
                    ];
                    foreach ($ext_features as $ef):
                    ?>
                    <div style="display:flex;gap:16px;align-items:flex-start;">
                        <span style="font-size:24px;flex-shrink:0;"><?= $ef[0] ?></span>
                        <div>
                            <h4 style="color:white;font-weight:700;font-size:15px;margin-bottom:4px;"><?= $ef[1] ?></h4>
                            <p style="color:#6b7280;font-size:13px;line-height:1.6;"><?= $ef[2] ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:20px;">
                    <span class="src-badge" style="background:rgba(255,255,255,0.07);color:#aaa;">✅ AliExpress</span>
                    <span class="src-badge" style="background:rgba(255,255,255,0.07);color:#aaa;">✅ Amazon.com</span>
                    <span class="src-badge" style="background:rgba(255,255,255,0.07);color:#aaa;">✅ Amazon.co.uk</span>
                    <span class="src-badge" style="background:rgba(255,255,255,0.07);color:#aaa;">✅ CJDropshipping</span>
                </div>

                <div style="padding:16px 20px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);">
                    <div style="font-family:'DM Mono',monospace;font-size:10px;color:var(--fire);letter-spacing:0.15em;text-transform:uppercase;margin-bottom:6px;">Install in 30 seconds</div>
                    <p style="font-size:13px;color:#888;line-height:1.6;">Chrome → Extensions → Developer Mode → Load unpacked. No Chrome Web Store approval needed for self-hosted deployment.</p>
                </div>
            </div>

            <!-- RIGHT — Extension panel mockup -->
            <div data-aos="fade-left" data-aos-delay="200">
                <!-- AliExpress product page simulation -->
                <div style="position:relative;">
                    <div class="screen-mock">
                        <div class="screen-bar">
                            <div class="dot bg-red-500"></div>
                            <div class="dot bg-yellow-400"></div>
                            <div class="dot bg-green-400"></div>
                            <span class="font-mono text-xs text-slate-500 ml-4">aliexpress.com/item/portable-blender</span>
                        </div>
                        <div style="padding:20px;display:flex;gap:12px;">
                            <!-- Fake product page -->
                            <div style="flex:1;">
                                <div style="background:#1e2028;height:180px;margin-bottom:12px;display:flex;align-items:center;justify-content:center;color:#555;font-size:12px;">Product Image</div>
                                <div style="font-size:13px;color:#ddd;font-weight:600;margin-bottom:6px;">Portable USB Rechargeable Personal Blender...</div>
                                <div style="font-size:16px;color:#ff6b35;font-weight:700;margin-bottom:8px;">$8.99</div>
                                <div style="font-size:10px;color:#555;">⭐⭐⭐⭐⭐ (4,821 reviews)</div>
                            </div>

                            <!-- TrendDrop panel -->
                            <div class="ext-panel" style="flex-shrink:0;">
                                <div style="background:#111;padding:10px 12px;border-bottom:1px solid #2a2a3a;display:flex;justify-content:space-between;align-items:center;">
                                    <span style="font-size:12px;font-weight:800;color:#ff4d1c;font-family:'Syne',sans-serif;">TrendDrop</span>
                                    <span style="color:#555;cursor:pointer;font-size:14px;">×</span>
                                </div>
                                <div style="padding:14px;">
                                    <div style="font-size:10px;color:#555;font-family:'DM Mono',monospace;margin-bottom:4px;">PORTABLE USB RECHARGEABLE...</div>
                                    <div style="font-size:8px;color:#444;margin-bottom:12px;">AliExpress · $8.99</div>

                                    <div style="background:#22223a;border-radius:0;padding:12px;display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                                        <div style="width:44px;height:44px;border-radius:50%;border:2px solid #22c55e;display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:800;color:#22c55e;flex-shrink:0;">87</div>
                                        <div>
                                            <div style="font-size:12px;font-weight:700;color:#fff;">🔥 Exploding</div>
                                            <div style="font-size:10px;color:#666;">Trend Score / 100</div>
                                        </div>
                                    </div>

                                    <div style="background:rgba(34,197,94,0.1);padding:8px;font-size:10px;color:#22c55e;margin-bottom:10px;line-height:1.5;">✅ High velocity. Consider adding to store.</div>

                                    <div style="display:flex;flex-direction:column;gap:5px;">
                                        <div style="padding:6px 10px;background:#ff4d1c;color:white;font-size:10px;text-align:center;cursor:pointer;font-family:'DM Mono',monospace;">✍️ GENERATE AD COPY</div>
                                        <div style="padding:6px 10px;background:#22223a;color:#aaa;font-size:10px;text-align:center;cursor:pointer;font-family:'DM Mono',monospace;border:1px solid #3a3a4a;">🔖 SAVE TO TRENDDROP</div>
                                        <div style="padding:6px 10px;background:transparent;color:#ff4d1c;font-size:10px;text-align:center;cursor:pointer;font-family:'DM Mono',monospace;border:1px solid rgba(255,77,28,0.4);">🚀 OPEN IN DASHBOARD</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════
     MOBILE APP
══════════════════════════════════════════════ -->
<section id="mobile" class="py-28 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-20 items-center">

            <!-- LEFT — Phone mockups -->
            <div data-aos="fade-right" class="flex gap-6 justify-center">
                <!-- Phone 1 — Trends screen -->
                <div style="width:160px;background:#07080a;border:1px solid #1a1a24;border-radius:16px;overflow:hidden;margin-top:40px;padding:12px;">
                    <div style="font-size:9px;color:var(--fire);font-family:'DM Mono',monospace;letter-spacing:0.15em;text-transform:uppercase;margin-bottom:10px;">🔥 Trending · US</div>
                    <?php
                    $mobile_products = [
                        ['Portable Blender', 92, '#22c55e'],
                        ['Massage Gun',      81, '#22c55e'],
                        ['LED Strips',       74, '#f59e0b'],
                        ['Cat Tree',         61, '#f59e0b'],
                    ];
                    foreach ($mobile_products as $mp):
                    ?>
                    <div style="background:#111318;border:1px solid #1e2028;padding:8px;margin-bottom:5px;display:flex;justify-content:space-between;align-items:center;">
                        <div>
                            <div style="font-size:10px;color:#fff;font-weight:600;"><?= $mp[0] ?></div>
                        </div>
                        <div style="font-size:14px;font-weight:800;color:<?= $mp[2] ?>;"><?= $mp[1] ?></div>
                    </div>
                    <?php endforeach; ?>
                    <div style="margin-top:8px;padding:8px;background:rgba(255,77,28,0.1);border:1px solid rgba(255,77,28,0.2);">
                        <div style="font-size:9px;color:var(--fire);font-family:'DM Mono',monospace;">PULL TO REFRESH</div>
                    </div>
                </div>

                <!-- Phone 2 — Product detail screen -->
                <div style="width:160px;background:#07080a;border:1px solid #1a1a24;border-radius:16px;overflow:hidden;padding:12px;">
                    <div style="font-size:9px;color:#555;font-family:'DM Mono',monospace;margin-bottom:10px;">← Portable Blender</div>
                    <div style="background:#111318;border:1px solid #1e2028;padding:10px;margin-bottom:8px;display:flex;align-items:center;gap:8px;">
                        <div style="width:40px;height:40px;border-radius:50%;border:2px solid #22c55e;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:800;color:#22c55e;flex-shrink:0;">92</div>
                        <div>
                            <div style="font-size:10px;color:#fff;font-weight:700;">Portable Blender</div>
                            <div style="font-size:9px;color:#22c55e;">🔥 Exploding</div>
                        </div>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:4px;">
                        <div style="padding:7px;background:#ff4d1c;color:white;font-size:9px;text-align:center;font-family:'DM Mono',monospace;">✍️ GENERATE AD COPY</div>
                        <div style="padding:7px;background:#22223a;color:#aaa;font-size:9px;text-align:center;font-family:'DM Mono',monospace;border:1px solid #3a3a4a;">🔬 ANALYZE PRODUCT</div>
                        <div style="padding:7px;background:transparent;color:#ff4d1c;font-size:9px;text-align:center;font-family:'DM Mono',monospace;border:1px solid rgba(255,77,28,0.4);">🔗 SHARE RESULT</div>
                    </div>
                    <!-- Ad copy preview -->
                    <div style="margin-top:8px;background:#111318;border:1px solid #1e2028;padding:8px;">
                        <div style="font-size:8px;color:var(--fire);font-family:'DM Mono',monospace;margin-bottom:4px;">AI AD — TIKTOK</div>
                        <div style="font-size:9px;color:#ccc;line-height:1.5;">"Gym bag blender hack nobody told you about 🤫"</div>
                    </div>
                </div>
            </div>

            <!-- RIGHT -->
            <div data-aos="fade-left" data-aos-delay="200">
                <div class="eyebrow mb-6" data-i18n="mob_eyebrow">Mobile App</div>
                <h2 class="font-display text-5xl font-black leading-tight mb-6">
                    <span data-i18n="mob_title_1">Research on the go.</span><br>
                    <span style="color:var(--fire)" data-i18n="mob_title_2">iOS & Android.</span>
                </h2>
                <p class="text-slate-600 leading-relaxed mb-10" data-i18n="mob_desc">
                    You spot a potential winner on TikTok at midnight. Pull out TrendDrop mobile. Trend score in 5 seconds. Ad copy in 10. Saved to your dashboard in 2. That's the workflow.
                </p>

                <div class="grid grid-cols-2 gap-4 mb-10">
                    <?php
                    $mob_features = [
                        ['📱', 'Native iOS & Android', 'Built with React Native + Expo. One codebase, fully native performance on both platforms.'],
                        ['🔒', 'Secure Auth', 'JWT stored in device Secure Store. Same account as web dashboard. No re-login.'],
                        ['🔔', 'Push Notifications', 'Instant alerts when watched products spike — no waiting for the daily email digest.'],
                        ['🔄', 'Pull to Refresh', 'Real-time trend data with pull-to-refresh. Swipe a product to save it.'],
                    ];
                    foreach ($mob_features as $mf):
                    ?>
                    <div style="padding:16px;background:#f8f7f5;border:1px solid #e5e7eb;" class="card-h">
                        <div style="font-size:22px;margin-bottom:8px;"><?= $mf[0] ?></div>
                        <div style="font-weight:700;font-size:13px;margin-bottom:4px;"><?= $mf[1] ?></div>
                        <div style="font-size:12px;color:#6b7280;line-height:1.5;"><?= $mf[2] ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div style="padding:20px 24px;border:1px solid #e5e7eb;background:#f8f7f5;">
                    <div style="font-family:'DM Mono',monospace;font-size:10px;color:var(--fire);letter-spacing:0.15em;text-transform:uppercase;margin-bottom:8px;">Built with Expo — ship in days</div>
                    <div style="display:flex;gap:12px;flex-wrap:wrap;">
                        <span style="font-size:12px;color:#555;font-family:'DM Mono',monospace;">React Native 0.74</span>
                        <span style="color:#e5e7eb;">·</span>
                        <span style="font-size:12px;color:#555;font-family:'DM Mono',monospace;">Expo SDK 51</span>
                        <span style="color:#e5e7eb;">·</span>
                        <span style="font-size:12px;color:#555;font-family:'DM Mono',monospace;">expo-secure-store</span>
                        <span style="color:#e5e7eb;">·</span>
                        <span style="font-size:12px;color:#555;font-family:'DM Mono',monospace;">expo-notifications</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════
     SHOPIFY ONE-CLICK IMPORT
══════════════════════════════════════════════ -->
<section class="py-28" style="background:#f8f7f5;">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="eyebrow justify-center mb-6" data-i18n="shopify_eyebrow">Shopify Integration</div>
            <h2 class="font-display text-5xl font-black mb-6">
                <span data-i18n="shopify_title_1">From research to Shopify.</span><br>
                <span style="color:var(--fire)" data-i18n="shopify_title_2">One click.</span>
            </h2>
            <p class="text-slate-500 text-lg max-w-2xl mx-auto" data-i18n="shopify_desc">Connect your Shopify store once. Then import any product you find directly from TrendDrop — with title, description (from your AI landing page), price, and images already filled in.</p>
        </div>

        <div class="grid md:grid-cols-4 gap-6">
            <?php
            $shopify_steps = [
                ['01', '🔗', 'Connect Store', 'OAuth with your Shopify store in under 60 seconds. TrendDrop only requests write_products permission.'],
                ['02', '🔥', 'Find a Winner', 'Browse trends until you find a product with a score above your threshold.'],
                ['03', '✍️', 'Generate Copy', 'Run the AI landing page generator to create Shopify-ready product description, benefits, and FAQ.'],
                ['04', '🛒', 'Import → Done', 'Click the 🛒 button on any product card. Review name, price, description, and push directly to your store.'],
            ];
            foreach ($shopify_steps as $ss):
            ?>
            <div class="p-8 bg-white border border-slate-200 card-h text-center" data-aos="fade-up">
                <div style="font-family:'DM Mono',monospace;font-size:10px;color:var(--fire);letter-spacing:0.2em;text-transform:uppercase;margin-bottom:12px;"><?= $ss[0] ?></div>
                <div style="font-size:32px;margin-bottom:12px;"><?= $ss[1] ?></div>
                <h3 class="font-display font-bold text-base mb-3"><?= $ss[2] ?></h3>
                <p class="text-slate-500 text-sm leading-relaxed"><?= $ss[3] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════
     PRICING
══════════════════════════════════════════════ -->
<section id="pricing" class="py-28 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="eyebrow justify-center mb-6" data-i18n="pricing_eyebrow">Pricing</div>
            <h2 class="font-display text-5xl font-black mb-6" data-i18n="pricing_title">Simple, honest pricing.</h2>
            <p class="text-slate-500 text-lg" data-i18n="pricing_desc">Start free. No credit card required. Upgrade when you're ready to scale.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 items-start">
            <?php
            $plans = [
                [
                    'Free', '$0', '/forever', '#6b7280', null,
                    'Get started and explore the platform.',
                    ['5 product searches / day', '3 AI ad copies / day', '2 product analyses / day', '1 video script / day', '10 saved products', 'Google Trends + TikTok data', 'CJDropshipping sourcing', 'Community feed (view only)'],
                    ['Landing page generator', 'Image generation', 'Trend alert emails', 'Shopify import', 'API access'],
                    'Start Free', false
                ],
                [
                    'Pro', '$29', '/month', 'var(--fire)', '🔥 Most Popular',
                    'Everything you need to run a serious dropshipping business.',
                    ['Unlimited searches', 'Unlimited AI creatives (all tools)', 'Unlimited product analyzer', 'Landing page generator', 'AI image prompts + FAL.AI generation', 'Video scripts (all styles)', 'Multi-language copy (6 languages)', 'Trend alert emails (daily digest)', 'Shopify one-click import', 'Community posting + templates', 'Unlimited saved products', 'Browser extension access'],
                    [],
                    'Get Pro Now', true
                ],
                [
                    'Agency', '$79', '/month', '#f59e0b', '⚡ For Teams',
                    'For dropshipping agencies managing multiple stores and clients.',
                    ['Everything in Pro', '3 team member seats', 'White-label PDF client reports', 'Public API access (10,000 req/day)', 'Bulk product analysis', 'Team workspace with shared saves', 'Premium template marketplace access', 'Dedicated Slack support channel'],
                    [],
                    'Get Agency', false
                ],
            ];
            foreach ($plans as $plan):
                $planColor = $plan[3];
            ?>
            <div class="plan-card <?= $plan[9] ? 'featured' : '' ?>" data-aos="fade-up" style="position:relative;">
                <?php if ($plan[4]): ?>
                <div style="position:absolute;top:-14px;left:50%;transform:translateX(-50%);background:var(--fire);color:white;padding:4px 16px;font-family:'DM Mono',monospace;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;white-space:nowrap;">
                    <?= $plan[4] ?>
                </div>
                <?php endif; ?>

                <div style="margin-bottom:24px;">
                    <h3 class="font-display font-black text-2xl mb-1" style="color:<?= $planColor ?>;"><?= $plan[0] ?></h3>
                    <p class="text-slate-500 text-sm mb-4"><?= $plan[5] ?></p>
                    <div style="display:flex;align-items:baseline;gap:4px;">
                        <span style="font-family:'Syne',sans-serif;font-size:44px;font-weight:800;color:<?= $planColor ?>;"><?= $plan[1] ?></span>
                        <span class="text-slate-400 text-sm"><?= $plan[2] ?></span>
                    </div>
                </div>

                <a href="#contact" class="btn-fire" style="display:block;text-align:center;margin-bottom:28px;<?= !$plan[9] ? 'background:#07080a;' : '' ?>"><?= $plan[8] ?></a>

                <div style="border-top:1px solid #f3f4f6;padding-top:20px;">
                    <?php foreach ($plan[6] as $feat): ?>
                    <div style="display:flex;gap:10px;align-items:flex-start;margin-bottom:10px;">
                        <span style="color:<?= $planColor ?>;font-size:13px;flex-shrink:0;margin-top:1px;">✓</span>
                        <span style="font-size:13px;color:#374151;"><?= $feat ?></span>
                    </div>
                    <?php endforeach; ?>
                    <?php foreach ($plan[7] as $noFeat): ?>
                    <div style="display:flex;gap:10px;align-items:flex-start;margin-bottom:10px;opacity:0.4;">
                        <span style="color:#9ca3af;font-size:13px;flex-shrink:0;margin-top:1px;">✗</span>
                        <span style="font-size:13px;color:#9ca3af;"><?= $noFeat ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- FAQ row -->
        <div class="grid md:grid-cols-3 gap-6 mt-16" data-aos="fade-up">
            <?php
            $faqs = [
                ['Can I cancel anytime?', 'Yes — cancel from your billing dashboard. You keep Pro access until the end of the billing period. No questions asked.'],
                ['Is there a free trial?', 'The Free plan is free forever. Users who sign up via a referral link automatically get 7 days Pro free.'],
                ['Do you offer refunds?', '7-day money-back guarantee on Pro and Agency plans. Email us if you\'re not satisfied within the first week.'],
            ];
            foreach ($faqs as $faq):
            ?>
            <div style="padding:24px;background:#f8f7f5;border:1px solid #e5e7eb;">
                <h4 style="font-weight:700;margin-bottom:8px;font-size:14px;"><?= $faq[0] ?></h4>
                <p style="font-size:13px;color:#6b7280;line-height:1.6;"><?= $faq[1] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════
     TECH STACK / TRUST SIGNALS
══════════════════════════════════════════════ -->
<section class="py-16 dark-section">
    <div class="max-w-7xl mx-auto px-6">
        <div class="glow-line mb-12"></div>
        <div class="text-center mb-10">
            <p class="font-mono text-xs text-slate-500 tracking-widest uppercase">Built on</p>
        </div>
        <div class="flex flex-wrap justify-center gap-10 items-center">
            <?php
            $stack = [
                ['Next.js 14', '#fff'],
                ['Node.js', '#22c55e'],
                ['PostgreSQL', '#4169e1'],
                ['Redis', '#ef4444'],
                ['Anthropic Claude API', '#ff6b2b'],
                ['Stripe', '#635bff'],
                ['Docker', '#2496ed'],
                ['React Native', '#61dafb'],
            ];
            foreach ($stack as $s):
            ?>
            <span style="font-family:'DM Mono',monospace;font-size:12px;color:<?= $s[1] ?>;letter-spacing:0.1em;opacity:0.7;"><?= $s[0] ?></span>
            <?php endforeach; ?>
        </div>
        <div class="glow-line mt-12"></div>
    </div>
</section>

<!-- ══════════════════════════════════════════════
     CONTACT / CTA
══════════════════════════════════════════════ -->
<section id="contact" class="py-28 dark-section">
    <div class="max-w-5xl mx-auto px-6">
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="eyebrow justify-center mb-6" style="color:var(--fire)" data-i18n="contact_eyebrow">Get Early Access</div>
            <h2 class="font-display text-5xl md:text-6xl font-black mb-6 text-white">
                <span data-i18n="contact_title_1">Stop guessing.</span><br>
                <em style="color:var(--fire)" data-i18n="contact_title_2">Start knowing.</em>
            </h2>
            <p class="text-slate-400 text-lg max-w-2xl mx-auto" data-i18n="contact_desc">
                The products trending today won't be tomorrow. Join TrendDrop and be the first to find them — with the data, the ads, and the supplier already in your hands.
            </p>
        </div>

        <!-- Contact info -->
        <div class="grid md:grid-cols-2 gap-6 mb-12">
            <div style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);padding:28px;" class="card-h" data-aos="fade-right">
                <div style="font-size:32px;margin-bottom:12px;">📧</div>
                <h3 style="color:white;font-weight:700;font-size:16px;margin-bottom:6px;">Email</h3>
                <p style="color:#6b7280;font-size:13px;margin-bottom:12px;">Reach us directly for enterprise or custom plans</p>
                <a href="mailto:contact@develop-it.tech" style="color:var(--fire);font-family:'DM Mono',monospace;font-size:13px;text-decoration:none;">contact@develop-it.tech</a>
            </div>
            <div style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);padding:28px;" class="card-h" data-aos="fade-left">
                <div style="font-size:32px;margin-bottom:12px;">📞</div>
                <h3 style="color:white;font-weight:700;font-size:16px;margin-bottom:6px;">Phone</h3>
                <p style="color:#6b7280;font-size:13px;margin-bottom:12px;">Talk to us directly about your dropshipping setup</p>
                <a href="tel:+2120611191926" style="color:var(--fire);font-family:'DM Mono',monospace;font-size:13px;text-decoration:none;">+212 06 11 19 19 26</a>
            </div>
        </div>

        <!-- Form -->
        <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);padding:44px;" data-aos="fade-up">
            <h3 class="font-display text-3xl font-bold text-white text-center mb-2" data-i18n="form_title">Request Free Access</h3>
            <p class="text-center font-mono text-slate-500 text-sm mb-10" data-i18n="form_sub">We'll set up your account and walk you through the platform.</p>

            <?php if (!empty($success_message)): ?>
            <div style="background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.3);color:#22c55e;padding:16px 20px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:14px;">
                <svg style="width:20px;height:20px;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <?= $success_message ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($error_message)): ?>
            <div style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#ef4444;padding:16px 20px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:14px;">
                <svg style="width:20px;height:20px;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <?= $error_message ?>
            </div>
            <?php endif; ?>

            <form method="POST" action="#contact" style="display:flex;flex-direction:column;gap:20px;">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                    <div>
                        <label style="display:block;font-family:'DM Mono',monospace;font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:rgba(255,255,255,0.35);margin-bottom:8px;" data-i18n="f_name">Full Name *</label>
                        <input type="text" name="name" required class="td-input"
                               value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                               placeholder="Your name">
                    </div>
                    <div>
                        <label style="display:block;font-family:'DM Mono',monospace;font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:rgba(255,255,255,0.35);margin-bottom:8px;" data-i18n="f_email">Email *</label>
                        <input type="email" name="email" required class="td-input"
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                               placeholder="you@email.com">
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                    <div>
                        <label style="display:block;font-family:'DM Mono',monospace;font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:rgba(255,255,255,0.35);margin-bottom:8px;" data-i18n="f_plan">Interested Plan</label>
                        <select name="plan" class="td-input">
                            <option value="">Select a plan</option>
                            <?php
                            $plan_opts = ['Free — just exploring', 'Pro — $29/month', 'Agency — $79/month', 'Not sure yet'];
                            foreach ($plan_opts as $po): ?>
                            <option value="<?= $po ?>" <?= (($_POST['plan'] ?? '') === $po) ? 'selected' : '' ?>><?= $po ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label style="display:block;font-family:'DM Mono',monospace;font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:rgba(255,255,255,0.35);margin-bottom:8px;" data-i18n="f_niche">Your Niche / Market</label>
                        <select name="niche" class="td-input">
                            <option value="">Select your niche</option>
                            <?php
                            $niches = ['Kitchen & Home', 'Health & Beauty', 'Fitness', 'Pet Products', 'Tech & Gadgets', 'Fashion & Accessories', 'Baby & Kids', 'Automotive', 'General / Multiple niches', 'Not started yet'];
                            foreach ($niches as $n): ?>
                            <option value="<?= $n ?>" <?= (($_POST['niche'] ?? '') === $n) ? 'selected' : '' ?>><?= $n ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div>
                    <label style="display:block;font-family:'DM Mono',monospace;font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:rgba(255,255,255,0.35);margin-bottom:8px;" data-i18n="f_message">Message (optional)</label>
                    <textarea name="message" rows="4" class="td-input" style="resize:none;"
                              placeholder="Tell us about your current setup — store, volume, what you're looking for..."><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                </div>

                <div style="text-align:center;padding-top:8px;">
                    <button type="submit" name="submit_contact" class="btn-fire" style="font-size:13px;padding:17px 44px;" data-i18n="form_btn">
                        🔥 Request Free Access
                    </button>
                    <p style="margin-top:14px;font-family:'DM Mono',monospace;font-size:11px;color:#2a2a2a;letter-spacing:0.05em;">
                        <span data-i18n="form_note">Response within 24h · No credit card · develop-it</span>
                    </p>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════
     FOOTER
══════════════════════════════════════════════ -->
<footer style="background:#000;color:#6b7280;padding:64px 0 32px;">
    <div class="max-w-7xl mx-auto px-6">
        <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:40px;margin-bottom:48px;" class="grid-cols-1 md:grid-cols-4">
            <div>
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                    <span style="font-family:'Syne',sans-serif;font-size:20px;font-weight:800;color:white;">🔥 TrendDrop</span>
                </div>
                <div style="font-size:11px;font-family:'DM Mono',monospace;color:#333;letter-spacing:0.1em;text-transform:uppercase;margin-bottom:12px;">by develop-it</div>
                <p style="font-size:13px;line-height:1.7;max-width:280px;">AI-powered product research and launch intelligence for dropshippers. Find winning products before everyone else.</p>
                <div style="display:flex;gap:8px;margin-top:16px;">
                    <a href="#" style="width:32px;height:32px;background:#111;display:flex;align-items:center;justify-content:center;transition:background 0.2s;text-decoration:none;" onmouseover="this.style.background='#1a1a1a'" onmouseout="this.style.background='#111'" aria-label="Facebook">
                        <svg style="width:14px;height:14px;color:#6b7280;" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" style="width:32px;height:32px;background:#111;display:flex;align-items:center;justify-content:center;transition:background 0.2s;text-decoration:none;" onmouseover="this.style.background='#1a1a1a'" onmouseout="this.style.background='#111'" aria-label="LinkedIn">
                        <svg style="width:14px;height:14px;color:#6b7280;" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                </div>
            </div>
            <div>
                <h4 style="color:white;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:0.1em;font-family:'DM Mono',monospace;margin-bottom:16px;">Platform</h4>
                <ul style="display:flex;flex-direction:column;gap:10px;list-style:none;padding:0;margin:0;">
                    <?php foreach (['#features'=>'Features', '#sources'=>'Data Sources', '#extension'=>'Chrome Extension', '#mobile'=>'Mobile App', '#pricing'=>'Pricing'] as $href=>$label): ?>
                    <li><a href="<?= $href ?>" style="color:#6b7280;font-size:13px;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='#6b7280'"><?= $label ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div>
                <h4 style="color:white;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:0.1em;font-family:'DM Mono',monospace;margin-bottom:16px;">Product</h4>
                <ul style="display:flex;flex-direction:column;gap:10px;list-style:none;padding:0;margin:0;">
                    <?php foreach (['AI Creative Suite', 'Competitor Spy', 'Shopify Import', 'Community Feed', 'Ad Template Marketplace', 'PDF Reports'] as $item): ?>
                    <li><span style="color:#6b7280;font-size:13px;"><?= $item ?></span></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div>
                <h4 style="color:white;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:0.1em;font-family:'DM Mono',monospace;margin-bottom:16px;">Company</h4>
                <ul style="display:flex;flex-direction:column;gap:10px;list-style:none;padding:0;margin:0;">
                    <li><a href="/" style="color:#6b7280;font-size:13px;text-decoration:none;" onmouseover="this.style.color='white'" onmouseout="this.style.color='#6b7280'">develop-it.tech</a></li>
                    <li><a href="#contact" style="color:#6b7280;font-size:13px;text-decoration:none;" onmouseover="this.style.color='white'" onmouseout="this.style.color='#6b7280'">Contact</a></li>
                    <li><a href="mailto:contact@develop-it.tech" style="color:#6b7280;font-size:13px;text-decoration:none;" onmouseover="this.style.color='white'" onmouseout="this.style.color='#6b7280'">contact@develop-it.tech</a></li>
                    <li><a href="tel:+2120611191926" style="color:#6b7280;font-size:13px;text-decoration:none;" onmouseover="this.style.color='white'" onmouseout="this.style.color='#6b7280'">+212 06 11 19 19 26</a></li>
                </ul>
            </div>
        </div>
        <div style="border-top:1px solid #111;padding-top:28px;text-align:center;">
            <p style="font-size:12px;font-family:'DM Mono',monospace;letter-spacing:0.05em;">
                © 2026 <strong style="color:white">develop-it</strong> · TrendDrop — AI Product Research Intelligence · All rights reserved
            </p>
        </div>
    </div>
</footer>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({ duration: 850, once: true, offset: 70 });

// ─── Language Switcher ────────────────────────────────────────────────────────
const translations = {
  en: {
    // Nav
    nav_features:  'Features',
    nav_sources:   'Data Sources',
    nav_extension: 'Extension',
    nav_mobile:    'Mobile',
    nav_pricing:   'Pricing',
    nav_cta:       'Get Early Access →',

    // Hero
    hero_badge:  '🔥 Product Research Intelligence',
    hero_title_1: 'Find Winning',
    hero_title_2: 'Products',
    hero_accent: 'Before Everyone.',
    hero_desc:   'TrendDrop scans <strong style="color:white">Google Trends, TikTok</strong> and <strong style="color:white">CJDropshipping</strong> in real-time, scores every product by demand velocity, and generates AI-powered ads, landing pages, and video scripts — in seconds.',
    hero_cta1:   '🚀 Start Free — No Card',
    hero_cta2:   'See All Features',
    stat1: 'Product<br>Categories',
    stat2: 'Languages<br>Supported',
    stat3: 'AI Creatives<br>on Pro',

    // Features
    feat_eyebrow:  'What TrendDrop does',
    feat_title_1:  'Everything you need to',
    feat_title_2:  'launch winning products.',
    feat_desc:     'From finding the trend to launching the ad — TrendDrop covers the entire dropshipping workflow in one platform.',

    // Sources
    src_eyebrow:   'Where the data comes from',
    src_title_1:   '3 sources.',
    src_title_2:   '1 unified score.',
    src_desc:      'Most tools use one data source. TrendDrop fuses three in real-time, weights them by recency, and produces a composite score that reflects true market demand — not a single platform\'s bubble.',

    // AI Creative
    creative_eyebrow: 'AI Creative Suite',
    creative_title_1: 'From product to launch-ready.',
    creative_title_2: 'In under 60 seconds.',
    creative_desc:    '5 AI tools built specifically for dropshipping creatives. Not generic. Not templated. Trained on dropshipping copy patterns.',

    // Extension
    ext_eyebrow:   'Chrome Extension',
    ext_title_1:   'Research while',
    ext_title_2:   'you browse.',
    ext_desc:      'Install the TrendDrop Chrome extension and get a live sidebar panel on every AliExpress, Amazon, and CJDropshipping product page — without leaving the tab.',

    // Mobile
    mob_eyebrow:   'Mobile App',
    mob_title_1:   'Research on the go.',
    mob_title_2:   'iOS & Android.',
    mob_desc:      'You spot a potential winner on TikTok at midnight. Pull out TrendDrop mobile. Trend score in 5 seconds. Ad copy in 10. Saved to your dashboard in 2. That\'s the workflow.',

    // Shopify
    shopify_eyebrow: 'Shopify Integration',
    shopify_title_1: 'From research to Shopify.',
    shopify_title_2: 'One click.',
    shopify_desc:    'Connect your Shopify store once. Then import any product you find directly from TrendDrop — with title, description (from your AI landing page), price, and images already filled in.',

    // Pricing
    pricing_eyebrow: 'Pricing',
    pricing_title:   'Simple, honest pricing.',
    pricing_desc:    'Start free. No credit card required. Upgrade when you\'re ready to scale.',

    // Contact
    contact_eyebrow: 'Get Early Access',
    contact_title_1: 'Stop guessing.',
    contact_title_2: 'Start knowing.',
    contact_desc:    'The products trending today won\'t be tomorrow. Join TrendDrop and be the first to find them — with the data, the ads, and the supplier already in your hands.',

    // Form
    form_title: 'Request Free Access',
    form_sub:   'We\'ll set up your account and walk you through the platform.',
    form_btn:   '🔥 Request Free Access',
    form_note:  'Response within 24h · No credit card · develop-it',
    f_name:     'Full Name *',
    f_email:    'Email *',
    f_plan:     'Interested Plan',
    f_niche:    'Your Niche / Market',
    f_message:  'Message (optional)',
  },

  fr: {
    // Nav
    nav_features:  'Fonctionnalités',
    nav_sources:   'Sources de données',
    nav_extension: 'Extension',
    nav_mobile:    'Mobile',
    nav_pricing:   'Tarifs',
    nav_cta:       'Accès anticipé →',

    // Hero
    hero_badge:  '🔥 Intelligence Produit en Temps Réel',
    hero_title_1: 'Trouvez les produits',
    hero_title_2: 'gagnants',
    hero_accent: 'avant tout le monde.',
    hero_desc:   'TrendDrop analyse <strong style="color:white">Google Trends, TikTok</strong> et <strong style="color:white">CJDropshipping</strong> en temps réel, note chaque produit par vélocité de demande, et génère des publicités, pages de vente et scripts vidéo IA — en quelques secondes.',
    hero_cta1:   '🚀 Démarrer gratuitement',
    hero_cta2:   'Voir toutes les fonctionnalités',
    stat1: 'Catégories<br>de produits',
    stat2: 'Langues<br>supportées',
    stat3: 'Créatifs IA<br>en Pro',

    // Features
    feat_eyebrow:  'Ce que fait TrendDrop',
    feat_title_1:  'Tout ce qu\'il vous faut pour',
    feat_title_2:  'lancer des produits gagnants.',
    feat_desc:     'De la découverte de la tendance au lancement de la pub — TrendDrop couvre tout le workflow dropshipping en une seule plateforme.',

    // Sources
    src_eyebrow:   'D\'où viennent les données',
    src_title_1:   '3 sources.',
    src_title_2:   '1 score unifié.',
    src_desc:      'La plupart des outils utilisent une seule source. TrendDrop en fusionne trois en temps réel, les pondère par récence, et produit un score composite qui reflète la vraie demande du marché.',

    // AI Creative
    creative_eyebrow: 'Suite Créative IA',
    creative_title_1: 'Du produit au lancement.',
    creative_title_2: 'En moins de 60 secondes.',
    creative_desc:    '5 outils IA conçus spécifiquement pour les créatifs dropshipping. Pas générique. Pas templateté. Entraîné sur des patterns de copy dropshipping.',

    // Extension
    ext_eyebrow:   'Extension Chrome',
    ext_title_1:   'Recherchez pendant',
    ext_title_2:   'que vous naviguez.',
    ext_desc:      'Installez l\'extension Chrome TrendDrop et obtenez un panneau latéral en direct sur chaque page produit AliExpress, Amazon et CJDropshipping — sans quitter l\'onglet.',

    // Mobile
    mob_eyebrow:   'Application Mobile',
    mob_title_1:   'Recherche en déplacement.',
    mob_title_2:   'iOS & Android.',
    mob_desc:      'Vous repérez un potentiel gagnant sur TikTok à minuit. Ouvrez TrendDrop mobile. Score de tendance en 5 secondes. Copy publicitaire en 10. Sauvegardé dans votre tableau de bord en 2. C\'est le workflow.',

    // Shopify
    shopify_eyebrow: 'Intégration Shopify',
    shopify_title_1: 'De la recherche à Shopify.',
    shopify_title_2: 'En un clic.',
    shopify_desc:    'Connectez votre boutique Shopify une fois. Puis importez n\'importe quel produit trouvé sur TrendDrop — avec le titre, la description (depuis votre page de vente IA), le prix et les images déjà remplis.',

    // Pricing
    pricing_eyebrow: 'Tarifs',
    pricing_title:   'Tarifs simples et transparents.',
    pricing_desc:    'Commencez gratuitement. Aucune carte bancaire requise. Passez à la version supérieure quand vous êtes prêt à scaler.',

    // Contact
    contact_eyebrow: 'Obtenir l\'accès anticipé',
    contact_title_1: 'Arrêtez de deviner.',
    contact_title_2: 'Commencez à savoir.',
    contact_desc:    'Les produits qui trending aujourd\'hui ne le seront plus demain. Rejoignez TrendDrop et soyez le premier à les trouver — avec les données, les pubs et le fournisseur déjà en main.',

    // Form
    form_title: 'Demander un accès gratuit',
    form_sub:   'Nous configurerons votre compte et vous guiderons sur la plateforme.',
    form_btn:   '🔥 Demander l\'accès gratuit',
    form_note:  'Réponse sous 24h · Sans carte bancaire · develop-it',
    f_name:     'Nom complet *',
    f_email:    'Email *',
    f_plan:     'Plan souhaité',
    f_niche:    'Votre niche / marché',
    f_message:  'Message (optionnel)',
  }
};

// Also translate form labels on switch
const formLabels = {
  en: {
    plan_placeholder: 'Select a plan',
    niche_placeholder: 'Select your niche',
    name_ph: 'Your name',
    email_ph: 'you@email.com',
    msg_ph: 'Tell us about your current setup — store, volume, what you\'re looking for...',
    plan_opts: ['Free — just exploring', 'Pro — $29/month', 'Agency — $79/month', 'Not sure yet'],
    niche_opts: ['Kitchen & Home', 'Health & Beauty', 'Fitness', 'Pet Products', 'Tech & Gadgets', 'Fashion & Accessories', 'Baby & Kids', 'Automotive', 'General / Multiple niches', 'Not started yet'],
  },
  fr: {
    plan_placeholder: 'Choisir un plan',
    niche_placeholder: 'Choisir votre niche',
    name_ph: 'Votre nom',
    email_ph: 'vous@email.com',
    msg_ph: 'Parlez-nous de votre configuration actuelle — boutique, volume, ce que vous cherchez...',
    plan_opts: ['Gratuit — juste explorer', 'Pro — 29$/mois', 'Agency — 79$/mois', 'Pas encore décidé'],
    niche_opts: ['Cuisine & Maison', 'Santé & Beauté', 'Fitness', 'Produits pour animaux', 'Tech & Gadgets', 'Mode & Accessoires', 'Bébé & Enfants', 'Automobile', 'Général / Plusieurs niches', 'Pas encore commencé'],
  }
};

function setLang(lang, btn) {
  // Update active button
  document.querySelectorAll('.lang-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.documentElement.lang = lang;

  const t = translations[lang];

  // Translate all data-i18n elements
  document.querySelectorAll('[data-i18n]').forEach(el => {
    const key = el.getAttribute('data-i18n');
    if (t[key] !== undefined) el.innerHTML = t[key];
  });

  // Translate form labels
  const fl = formLabels[lang];
  const nameInput  = document.querySelector('input[name="name"]');
  const emailInput = document.querySelector('input[name="email"]');
  const msgInput   = document.querySelector('textarea[name="message"]');
  const planSelect = document.querySelector('select[name="plan"]');
  const nicheSelect = document.querySelector('select[name="niche"]');

  if (nameInput)   nameInput.placeholder   = fl.name_ph;
  if (emailInput)  emailInput.placeholder  = fl.email_ph;
  if (msgInput)    msgInput.placeholder    = fl.msg_ph;

  // Translate select options
  if (planSelect) {
    const planVals = planSelect.querySelectorAll('option:not([value=""])');
    planVals.forEach((opt, i) => { if (fl.plan_opts[i]) opt.textContent = fl.plan_opts[i]; });
    planSelect.querySelector('option[value=""]').textContent = fl.plan_placeholder;
  }
  if (nicheSelect) {
    const nicheVals = nicheSelect.querySelectorAll('option:not([value=""])');
    nicheVals.forEach((opt, i) => { if (fl.niche_opts[i]) opt.textContent = fl.niche_opts[i]; });
    nicheSelect.querySelector('option[value=""]').textContent = fl.niche_placeholder;
  }

  localStorage.setItem('td_lang', lang);
}

document.addEventListener('DOMContentLoaded', () => {
  const saved = localStorage.getItem('td_lang');
  if (saved && saved !== 'en') {
    const btn = document.querySelector(`.lang-btn[onclick="setLang('${saved}', this)"]`);
    if (btn) setLang(saved, btn);
  }
});


// Animate score bars when they come into view
const bars = document.querySelectorAll('[style*="background:#4285f4"], [style*="background:#ff0050"], [style*="background:#00a651"]');
const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.transition = 'width 1.2s ease';
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.5 });
bars.forEach(b => observer.observe(b));
</script>
</body>
</html>