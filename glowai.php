<?php
/**
 * GlowAI — AI Beauty Diagnostic Landing Page
 * develop-it
 */
$success_message = '';
$error_message   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_contact'])) {
    $name    = htmlspecialchars(strip_tags(trim($_POST['name']    ?? '')));
    $email   = filter_var(trim($_POST['email']   ?? ''), FILTER_SANITIZE_EMAIL);
    $plan    = htmlspecialchars(strip_tags(trim($_POST['plan']    ?? '')));
    $message = htmlspecialchars(strip_tags(trim($_POST['message'] ?? '')));

    if (empty($name) || empty($email)) {
        $error_message = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Invalid email address.';
    } else {
        $to = 'contact@develop-it.tech';
        $subject_mail = '✨ GlowAI — New Lead: ' . $name;
        $body  = "New GlowAI Lead\n" . str_repeat('─', 50) . "\n\n";
        $body .= "👤 Name  : $name\n📧 Email : $email\n💼 Plan  : " . ($plan ?: 'N/A') . "\n\n";
        $body .= "💬 Message:\n" . ($message ?: 'No message') . "\n\n";
        $body .= str_repeat('─', 50) . "\nSent: " . date('d/m/Y H:i') . " | IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'N/A');
        $headers = "From: no-reply@develop-it.tech\r\nReply-To: $email\r\nContent-Type: text/plain; charset=UTF-8\r\n";
        if (mail($to, $subject_mail, $body, $headers)) {
            $success_message = 'Request sent! We\'ll contact you within 24h.';
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
<title>GlowAI | AI-Powered Skin Analysis & Personalized Beauty Routines</title>
<meta name="description" content="GlowAI — AI beauty diagnostic that analyzes your skin, builds personalized routines, recommends products and tracks your progress over time.">
<meta name="keywords" content="glowai, ai skin analysis, beauty ai, skincare routine, skin diagnostic, personalized beauty, develop-it">
<meta name="author" content="develop-it">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://develop-it.tech/glowai.php">
<link rel="icon" href="/logo.jfif">
<meta property="og:type" content="website">
<meta property="og:url" content="https://develop-it.tech/glowai.php">
<meta property="og:title" content="GlowAI — AI Skin Analysis & Beauty Routines">
<meta property="og:description" content="AI-powered skin diagnostic with personalized routines, product recommendations and progress tracking.">
<meta property="og:image" content="https://images.unsplash.com/photo-1596755389378-c31d21fd1273?w=1200&q=80">
<meta name="twitter:card" content="summary_large_image">
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"GlowAI","description":"AI-powered skin analysis and personalized beauty routine builder.","url":"https://develop-it.tech/glowai.php","applicationCategory":"HealthApplication","operatingSystem":"Web","publisher":{"@type":"Organization","name":"DEVELOP IT","url":"https://develop-it.tech"}}
</script>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="preload" as="style" href="https://unpkg.com/aos@2.3.1/dist/aos.css" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css"></noscript>
<style>
body{font-family:'Inter',sans-serif}
:root{--glow:#ec4899;--glow-light:#f9a8d4;--glow-dark:#9d174d}
@keyframes bgShift{0%,100%{background-position:0% 50%}50%{background-position:100% 50%}}
.hero-bg{background:linear-gradient(-45deg,#1a0a14,#4a1942,#831843,#1a0a14);background-size:400% 400%;animation:bgShift 20s ease infinite}
.card-h{transition:transform .28s,box-shadow .28s}.card-h:hover{transform:translateY(-5px);box-shadow:0 20px 50px rgba(236,72,153,.12)}
html{scroll-behavior:smooth}
</style>
</head>
<body class="bg-white text-slate-800">

<!-- NAV -->
<nav class="bg-white/95 backdrop-blur-sm border-b border-slate-100 sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
    <div class="flex items-center gap-6">
      <a href="/" class="flex items-center gap-2 text-slate-500 hover:text-slate-800 transition text-sm font-medium">
        <img src="/logo.jfif" alt="develop-it" class="w-5 h-5"> develop-it
      </a>
      <div class="hidden md:block w-px h-4 bg-slate-200"></div>
      <span class="hidden md:flex items-center gap-2 font-bold text-lg text-slate-800">✨ GlowAI</span>
    </div>
    <div class="hidden md:flex items-center gap-6">
      <a href="#features" class="text-slate-500 hover:text-pink-600 text-sm font-medium transition">Features</a>
      <a href="#how" class="text-slate-500 hover:text-pink-600 text-sm font-medium transition">How it works</a>
      <a href="#pricing" class="text-slate-500 hover:text-pink-600 text-sm font-medium transition">Pricing</a>
      <a href="#contact" class="bg-pink-600 text-white px-6 py-2 rounded-lg hover:bg-pink-700 transition text-sm font-semibold">Get Started</a>
    </div>
  </div>
</nav>

<!-- HERO -->
<section class="hero-bg text-white overflow-hidden min-h-screen flex items-center relative">
  <div class="absolute inset-0 opacity-15">
    <div class="absolute top-20 left-20 w-72 h-72 bg-pink-400 rounded-full filter blur-3xl animate-pulse"></div>
    <div class="absolute bottom-20 right-20 w-96 h-96 bg-fuchsia-500 rounded-full filter blur-3xl animate-pulse" style="animation-delay:1s"></div>
  </div>
  <div class="max-w-7xl mx-auto px-6 py-24 grid md:grid-cols-2 gap-12 items-center relative z-10 w-full">
    <div data-aos="fade-right" data-aos-duration="1000">
      <div class="inline-flex items-center gap-2 bg-pink-500/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm mb-6 border border-pink-400/30">
        <span class="relative flex h-2.5 w-2.5"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-pink-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-pink-500"></span></span>
        ✨ AI-Powered Beauty Diagnostic
      </div>
      <h1 class="text-5xl md:text-7xl font-extrabold leading-tight mb-6">
        Your Skin,<br>Decoded by<br>
        <span class="bg-clip-text text-transparent bg-gradient-to-r from-pink-400 via-fuchsia-300 to-rose-400">Artificial Intelligence.</span>
      </h1>
      <p class="text-lg text-pink-100 leading-relaxed mb-8 max-w-lg">
        GlowAI analyzes your skin with <strong class="text-white">computer vision</strong>, identifies concerns, builds a <strong class="text-white">personalized routine</strong>, recommends the right products, and tracks your progress week by week.
      </p>
      <div class="flex flex-wrap gap-4">
        <a href="#contact" class="bg-white text-slate-900 px-8 py-4 rounded-xl font-semibold hover:bg-pink-50 transition shadow-lg">✨ Analyze My Skin — Free</a>
        <a href="#features" class="border-2 border-white/30 px-8 py-4 rounded-xl hover:bg-white/10 transition">See Features</a>
      </div>
      <div class="mt-12 grid grid-cols-3 gap-6">
        <div class="text-center"><div class="text-3xl font-bold">15+</div><div class="text-xs text-pink-200">Skin Metrics</div></div>
        <div class="text-center"><div class="text-3xl font-bold">92%</div><div class="text-xs text-pink-200">Accuracy</div></div>
        <div class="text-center"><div class="text-3xl font-bold">30s</div><div class="text-xs text-pink-200">Analysis Time</div></div>
      </div>
    </div>
    <div data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
      <img src="https://images.unsplash.com/photo-1596755389378-c31d21fd1273?auto=format&fit=crop&w=800&q=80"
           alt="GlowAI — AI Skin Analysis" class="rounded-2xl shadow-2xl w-full" loading="eager">
    </div>
  </div>
</section>

<!-- FEATURES -->
<section id="features" class="py-24 bg-white">
  <div class="max-w-7xl mx-auto px-6">
    <div class="text-center mb-16" data-aos="fade-up">
      <span class="text-pink-600 font-semibold text-sm uppercase tracking-wider">Features</span>
      <h2 class="text-4xl md:text-5xl font-bold mt-3 mb-6">Science meets skincare</h2>
      <p class="text-slate-500 text-lg max-w-2xl mx-auto">From diagnosis to daily routine — GlowAI is your personal dermatologist in your pocket.</p>
    </div>
    <div class="grid md:grid-cols-3 gap-6">
      <?php
      $feats = [
        ['📸','AI Skin Scan','Upload a selfie and our computer vision model analyzes 15+ skin metrics: hydration, pores, wrinkles, dark spots, redness, texture and more.','bg-pink-50 border-pink-100'],
        ['💊','Personalized Routine','Based on your skin type, concerns and goals, GlowAI builds a morning + evening routine with specific product types and application order.','bg-fuchsia-50 border-fuchsia-100'],
        ['🛍️','Product Matching','AI matches your routine steps to real products from 500+ brands. Filters by budget, ingredients, cruelty-free, vegan and skin sensitivity.','bg-rose-50 border-rose-100'],
        ['📈','Progress Tracking','Take weekly scans and watch your skin improve. Visual timeline, metric graphs and AI-generated progress reports.','bg-violet-50 border-violet-100'],
        ['⚠️','Ingredient Checker','Scan any product barcode or paste ingredients. GlowAI flags irritants, comedogenic ingredients and conflicts with your routine.','bg-amber-50 border-amber-100'],
        ['🌙','Smart Reminders','Morning and evening routine reminders. Tracks which steps you completed. Adapts suggestions based on weather and season.','bg-cyan-50 border-cyan-100'],
      ];
      foreach($feats as $i=>$f): ?>
      <div class="p-7 rounded-2xl border card-h <?=$f[3]?>" data-aos="fade-up" data-aos-delay="<?=$i*60?>">
        <div class="text-3xl mb-4"><?=$f[0]?></div>
        <h3 class="font-bold text-xl mb-3"><?=$f[1]?></h3>
        <p class="text-slate-600 text-sm leading-relaxed"><?=$f[2]?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section id="how" class="py-24 bg-slate-50">
  <div class="max-w-5xl mx-auto px-6">
    <div class="text-center mb-16" data-aos="fade-up">
      <span class="text-pink-600 font-semibold text-sm uppercase tracking-wider">How it works</span>
      <h2 class="text-4xl md:text-5xl font-bold mt-3 mb-6">3 steps to better skin</h2>
    </div>
    <div class="grid md:grid-cols-3 gap-8">
      <?php
      $steps = [
        ['1','📸','Snap a selfie','No makeup, natural light. Our AI needs just one photo to analyze 15+ skin metrics in under 30 seconds.'],
        ['2','🤖','Get your diagnosis','Detailed skin report with scores, concerns identified, skin type classification and personalized recommendations.'],
        ['3','✨','Follow your routine','Morning + evening routine with exact products. Track progress weekly and watch your skin transform.'],
      ];
      foreach($steps as $i=>$s): ?>
      <div class="text-center" data-aos="fade-up" data-aos-delay="<?=$i*100?>">
        <div class="w-16 h-16 bg-pink-600 text-white rounded-2xl flex items-center justify-center text-2xl mx-auto mb-5 shadow-lg"><?=$s[1]?></div>
        <div class="text-pink-600 font-bold text-sm mb-2">Step <?=$s[0]?></div>
        <h3 class="font-bold text-xl mb-3"><?=$s[2]?></h3>
        <p class="text-slate-600 text-sm leading-relaxed"><?=$s[3]?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- SKIN METRICS -->
<section class="py-24 bg-gradient-to-br from-slate-900 via-pink-950 to-slate-900 text-white">
  <div class="max-w-7xl mx-auto px-6">
    <div class="text-center mb-16" data-aos="fade-up">
      <span class="text-pink-400 font-semibold text-sm uppercase tracking-wider">AI Analysis</span>
      <h2 class="text-4xl md:text-5xl font-bold mt-3 mb-6">15+ skin metrics analyzed</h2>
      <p class="text-slate-300 text-lg max-w-2xl mx-auto">Our computer vision model detects what the naked eye can't see.</p>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
      <?php
      $metrics = [
        ['💧','Hydration'],['🔬','Pore Size'],['✨','Texture'],['🌑','Dark Spots'],['😊','Wrinkles'],
        ['🔴','Redness'],['☀️','Sun Damage'],['🛡️','Barrier Health'],['⚖️','Oil Balance'],['🧬','Elasticity'],
        ['💎','Radiance'],['🎯','Acne Score'],['👁️','Under-Eye'],['🌿','Sensitivity'],['📊','Overall Score'],
      ];
      foreach($metrics as $i=>$m): ?>
      <div class="bg-white/5 backdrop-blur-sm p-4 rounded-xl border border-white/10 text-center hover:bg-white/10 transition" data-aos="zoom-in" data-aos-delay="<?=$i*40?>">
        <div class="text-2xl mb-2"><?=$m[0]?></div>
        <div class="text-sm font-semibold"><?=$m[1]?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- PRICING -->
<section id="pricing" class="py-24 bg-white">
  <div class="max-w-5xl mx-auto px-6">
    <div class="text-center mb-16" data-aos="fade-up">
      <span class="text-pink-600 font-semibold text-sm uppercase tracking-wider">Pricing</span>
      <h2 class="text-4xl md:text-5xl font-bold mt-3 mb-6">Invest in your skin</h2>
    </div>
    <div class="grid md:grid-cols-3 gap-6">
      <?php
      $plans = [
        ['Basic','Free','0','1 scan/month, basic routine, product suggestions',['1 skin scan/month','Basic routine','Top 3 product picks','Email support'],'bg-white border-slate-200','text-slate-800'],
        ['Glow','Popular','14','Unlimited scans, full routine, progress tracking',['Unlimited scans','Full AM/PM routine','500+ brand matching','Weekly progress tracking','Priority support'],'bg-pink-600 border-pink-600 text-white','text-white'],
        ['Pro','Clinic','29','Everything + ingredient checker, API, white-label',['Everything in Glow','Ingredient scanner','API access','White-label for clinics','Dedicated account manager'],'bg-white border-slate-200','text-slate-800'],
      ];
      foreach($plans as $i=>$p): ?>
      <div class="p-8 rounded-2xl border-2 <?=$p[5]?> card-h <?=$i===1?'shadow-xl scale-105':''?>" data-aos="fade-up" data-aos-delay="<?=$i*80?>">
        <div class="text-sm font-semibold uppercase tracking-wider <?=$i===1?'text-pink-200':'text-pink-600'?> mb-1"><?=$p[1]?></div>
        <h3 class="text-2xl font-bold mb-1 <?=$p[6]?>"><?=$p[0]?></h3>
        <div class="mb-4"><span class="text-4xl font-extrabold <?=$p[6]?>">$<?=$p[2]?></span><span class="text-sm <?=$i===1?'text-pink-200':'text-slate-500'?>">/month</span></div>
        <p class="text-sm <?=$i===1?'text-pink-100':'text-slate-500'?> mb-6"><?=$p[3]?></p>
        <ul class="space-y-2 mb-8">
          <?php foreach($p[4] as $feat): ?>
          <li class="flex items-center gap-2 text-sm <?=$i===1?'text-pink-100':'text-slate-600'?>">
            <svg class="w-4 h-4 <?=$i===1?'text-pink-300':'text-pink-500'?> flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
            <?=$feat?>
          </li>
          <?php endforeach; ?>
        </ul>
        <a href="#contact" class="block text-center py-3 rounded-xl font-semibold text-sm transition <?=$i===1?'bg-white text-pink-600 hover:bg-pink-50':'bg-pink-600 text-white hover:bg-pink-700'?>">Get Started</a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CONTACT -->
<section id="contact" class="py-24 bg-gradient-to-br from-slate-900 via-pink-950 to-slate-900 text-white">
  <div class="max-w-3xl mx-auto px-6">
    <div class="text-center mb-12" data-aos="fade-up">
      <span class="text-pink-400 font-semibold text-sm uppercase tracking-wider">Get Started</span>
      <h2 class="text-4xl md:text-5xl font-bold mt-3 mb-4">Ready to transform your skin?</h2>
      <p class="text-slate-300 text-lg">Start your AI skin analysis today.</p>
    </div>
    <div class="bg-white/5 backdrop-blur-sm p-8 sm:p-10 rounded-2xl border border-white/10" data-aos="fade-up" data-aos-delay="100">
      <?php if(!empty($success_message)): ?>
      <div class="mb-6 bg-green-500/20 border border-green-400/50 text-green-200 px-6 py-4 rounded-xl" role="alert"><?=htmlspecialchars($success_message)?></div>
      <?php endif; ?>
      <?php if(!empty($error_message)): ?>
      <div class="mb-6 bg-red-500/20 border border-red-400/50 text-red-200 px-6 py-4 rounded-xl" role="alert"><?=htmlspecialchars($error_message)?></div>
      <?php endif; ?>
      <form method="POST" action="#contact" class="space-y-5">
        <div class="grid sm:grid-cols-2 gap-5">
          <div>
            <label for="c_name" class="block text-sm font-semibold mb-2">Full Name *</label>
            <input id="c_name" type="text" name="name" required class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-slate-400 focus:border-pink-400 focus:outline-none transition" placeholder="Your name">
          </div>
          <div>
            <label for="c_email" class="block text-sm font-semibold mb-2">Email *</label>
            <input id="c_email" type="email" name="email" required class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-slate-400 focus:border-pink-400 focus:outline-none transition" placeholder="you@email.com">
          </div>
        </div>
        <div>
          <label for="c_plan" class="block text-sm font-semibold mb-2">Interested Plan</label>
          <select id="c_plan" name="plan" class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white focus:border-pink-400 focus:outline-none transition">
            <option value="">Select a plan</option>
            <option value="Basic (Free)">Basic — Free</option>
            <option value="Glow ($14/mo)">Glow — $14/mo</option>
            <option value="Pro ($29/mo)">Pro — $29/mo</option>
          </select>
        </div>
        <div>
          <label for="c_msg" class="block text-sm font-semibold mb-2">Tell us about your skin goals</label>
          <textarea id="c_msg" name="message" rows="4" class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-slate-400 focus:border-pink-400 focus:outline-none transition resize-none" placeholder="What skin concerns do you have?"></textarea>
        </div>
        <button type="submit" name="submit_contact" class="w-full bg-pink-600 text-white py-4 rounded-xl font-semibold hover:bg-pink-700 transition text-sm">✨ Start My Skin Analysis</button>
      </form>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="bg-black text-slate-400 py-10">
  <div class="max-w-7xl mx-auto px-6">
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
      <div class="flex items-center gap-3">
        <img src="/logo.jfif" alt="develop-it" class="w-6 h-6 rounded-sm">
        <span class="text-white font-bold">GlowAI</span>
        <span class="text-slate-600">by develop-it</span>
      </div>
      <div class="flex gap-6 text-sm">
        <a href="/" class="hover:text-white transition">Home</a>
        <a href="/blog/" class="hover:text-white transition">Blog</a>
        <a href="/#contact" class="hover:text-white transition">Contact</a>
      </div>
    </div>
    <div class="border-t border-slate-800 mt-6 pt-6 text-center text-xs">
      <p>© <?=date('Y')?> <strong class="text-white">DEVELOP IT</strong> — All rights reserved</p>
    </div>
  </div>
</footer>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js" defer></script>
<script>document.addEventListener('DOMContentLoaded',function(){if(typeof AOS!=='undefined')AOS.init({duration:800,once:true});});</script>
</body>
</html>
