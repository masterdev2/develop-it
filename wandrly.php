<?php
/**
 * Wandrly — AI Travel Planner Landing Page
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
        $subject_mail = '✈️ Wandrly — New Lead: ' . $name;
        $body  = "New Wandrly Lead\n" . str_repeat('─', 50) . "\n\n";
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
<title>Wandrly | AI-Powered Travel Planner — Smart Itineraries & Budget Optimization</title>
<meta name="description" content="Wandrly — Your AI travel companion. Personalized itineraries, real-time budget optimization, smart hotel & flight recommendations. Plan your perfect trip in minutes.">
<meta name="keywords" content="wandrly, ai travel planner, smart itinerary, travel ai, budget travel, trip planner, develop-it">
<meta name="author" content="develop-it">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://develop-it.tech/wandrly.php">
<link rel="icon" href="/logo.jfif">
<meta property="og:type" content="website">
<meta property="og:url" content="https://develop-it.tech/wandrly.php">
<meta property="og:title" content="Wandrly — AI Travel Planner">
<meta property="og:description" content="Plan your perfect trip in minutes with AI-powered itineraries, budget optimization and smart recommendations.">
<meta property="og:image" content="https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=1200&q=80">
<meta name="twitter:card" content="summary_large_image">
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Wandrly","description":"AI-powered travel planner with personalized itineraries and budget optimization.","url":"https://develop-it.tech/wandrly.php","applicationCategory":"TravelApplication","operatingSystem":"Web","publisher":{"@type":"Organization","name":"DEVELOP IT","url":"https://develop-it.tech"}}
</script>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="preload" as="style" href="https://unpkg.com/aos@2.3.1/dist/aos.css" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css"></noscript>
<style>
body{font-family:'Inter',sans-serif}
:root{--sky:#0ea5e9;--ocean:#0369a1;--sand:#f59e0b;--dark:#0c1222}
@keyframes bgShift{0%,100%{background-position:0% 50%}50%{background-position:100% 50%}}
.hero-bg{background:linear-gradient(-45deg,#0c1222,#0c4a6e,#164e63,#0c1222);background-size:400% 400%;animation:bgShift 20s ease infinite}
.card-h{transition:transform .28s,box-shadow .28s}.card-h:hover{transform:translateY(-5px);box-shadow:0 20px 50px rgba(14,165,233,.12)}
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
      <span class="hidden md:flex items-center gap-2 font-bold text-lg text-slate-800">✈️ Wandrly</span>
    </div>
    <div class="hidden md:flex items-center gap-6">
      <a href="#features" class="text-slate-500 hover:text-sky-600 text-sm font-medium transition">Features</a>
      <a href="#how" class="text-slate-500 hover:text-sky-600 text-sm font-medium transition">How it works</a>
      <a href="#pricing" class="text-slate-500 hover:text-sky-600 text-sm font-medium transition">Pricing</a>
      <a href="#contact" class="bg-sky-600 text-white px-6 py-2 rounded-lg hover:bg-sky-700 transition text-sm font-semibold">Get Started</a>
    </div>
  </div>
</nav>

<!-- HERO -->
<section class="hero-bg text-white overflow-hidden min-h-screen flex items-center relative">
  <div class="absolute inset-0 opacity-15">
    <div class="absolute top-20 left-20 w-72 h-72 bg-sky-400 rounded-full filter blur-3xl animate-pulse"></div>
    <div class="absolute bottom-20 right-20 w-96 h-96 bg-cyan-500 rounded-full filter blur-3xl animate-pulse" style="animation-delay:1s"></div>
  </div>
  <div class="max-w-7xl mx-auto px-6 py-24 grid md:grid-cols-2 gap-12 items-center relative z-10 w-full">
    <div data-aos="fade-right" data-aos-duration="1000">
      <div class="inline-flex items-center gap-2 bg-sky-500/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm mb-6 border border-sky-400/30">
        <span class="relative flex h-2.5 w-2.5"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-sky-500"></span></span>
        ✨ AI-Powered Travel Planning
      </div>
      <h1 class="text-5xl md:text-7xl font-extrabold leading-tight mb-6">
        Plan Your<br>Dream Trip<br>
        <span class="bg-clip-text text-transparent bg-gradient-to-r from-sky-400 via-cyan-300 to-amber-400">In Minutes.</span>
      </h1>
      <p class="text-lg text-sky-100 leading-relaxed mb-8 max-w-lg">
        Wandrly uses AI to craft <strong class="text-white">personalized itineraries</strong>, find the best deals on flights & hotels, optimize your <strong class="text-white">budget in real-time</strong>, and suggest hidden gems — all tailored to your travel style.
      </p>
      <div class="flex flex-wrap gap-4">
        <a href="#contact" class="bg-white text-slate-900 px-8 py-4 rounded-xl font-semibold hover:bg-sky-50 transition shadow-lg">🚀 Plan My Trip — Free</a>
        <a href="#features" class="border-2 border-white/30 px-8 py-4 rounded-xl hover:bg-white/10 transition">See Features</a>
      </div>
      <div class="mt-12 grid grid-cols-3 gap-6">
        <div class="text-center"><div class="text-3xl font-bold">50+</div><div class="text-xs text-sky-200">Destinations</div></div>
        <div class="text-center"><div class="text-3xl font-bold">30%</div><div class="text-xs text-sky-200">Avg. Savings</div></div>
        <div class="text-center"><div class="text-3xl font-bold">2min</div><div class="text-xs text-sky-200">Itinerary Gen</div></div>
      </div>
    </div>
    <div data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
      <img src="https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&w=800&q=80"
           alt="Wandrly — AI Travel Planner" class="rounded-2xl shadow-2xl w-full" loading="eager">
    </div>
  </div>
</section>

<!-- FEATURES -->
<section id="features" class="py-24 bg-white">
  <div class="max-w-7xl mx-auto px-6">
    <div class="text-center mb-16" data-aos="fade-up">
      <span class="text-sky-600 font-semibold text-sm uppercase tracking-wider">Features</span>
      <h2 class="text-4xl md:text-5xl font-bold mt-3 mb-6">Everything for the perfect trip</h2>
      <p class="text-slate-500 text-lg max-w-2xl mx-auto">From inspiration to booking — Wandrly handles every step with AI precision.</p>
    </div>
    <div class="grid md:grid-cols-3 gap-6">
      <?php
      $feats = [
        ['🗺️','Smart Itineraries','AI generates day-by-day plans based on your interests, pace, budget and travel dates. Drag-and-drop to customize.','bg-sky-50 border-sky-100'],
        ['💰','Budget Optimizer','Set your budget and Wandrly finds the best flight + hotel combos, suggests free activities, and tracks spending in real-time.','bg-amber-50 border-amber-100'],
        ['🏨','Hotel & Flight Finder','Compare prices across 200+ providers. AI ranks options by value score — not just price — factoring location, reviews and convenience.','bg-cyan-50 border-cyan-100'],
        ['📍','Hidden Gems','Discover local restaurants, viewpoints and experiences that tourists miss. Powered by local data and traveler reviews.','bg-emerald-50 border-emerald-100'],
        ['🌤️','Weather & Events','Real-time weather forecasts and local events integrated into your itinerary. Auto-adjusts outdoor activities for rainy days.','bg-violet-50 border-violet-100'],
        ['📱','Offline Access','Download your full itinerary, maps and reservations for offline use. No WiFi needed while traveling.','bg-rose-50 border-rose-100'],
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
      <span class="text-sky-600 font-semibold text-sm uppercase tracking-wider">How it works</span>
      <h2 class="text-4xl md:text-5xl font-bold mt-3 mb-6">3 steps to your perfect trip</h2>
    </div>
    <div class="grid md:grid-cols-3 gap-8">
      <?php
      $steps = [
        ['1','🎯','Tell us your vibe','Destination, dates, budget, interests — solo, couple, family or group. Wandrly adapts to your style.'],
        ['2','🤖','AI builds your plan','In under 2 minutes, get a complete day-by-day itinerary with flights, hotels, activities and restaurants.'],
        ['3','✈️','Book & go','One-click booking for flights and hotels. Download offline maps. Share with travel companions.'],
      ];
      foreach($steps as $i=>$s): ?>
      <div class="text-center" data-aos="fade-up" data-aos-delay="<?=$i*100?>">
        <div class="w-16 h-16 bg-sky-600 text-white rounded-2xl flex items-center justify-center text-2xl mx-auto mb-5 shadow-lg"><?=$s[1]?></div>
        <div class="text-sky-600 font-bold text-sm mb-2">Step <?=$s[0]?></div>
        <h3 class="font-bold text-xl mb-3"><?=$s[2]?></h3>
        <p class="text-slate-600 text-sm leading-relaxed"><?=$s[3]?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- USE CASES -->
<section class="py-24 bg-gradient-to-br from-slate-900 via-sky-950 to-slate-900 text-white">
  <div class="max-w-7xl mx-auto px-6">
    <div class="text-center mb-16" data-aos="fade-up">
      <span class="text-sky-400 font-semibold text-sm uppercase tracking-wider">Use Cases</span>
      <h2 class="text-4xl md:text-5xl font-bold mt-3 mb-6">Built for every traveler</h2>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <?php
      $cases = [
        ['🎒','Solo Backpacker','Budget-friendly routes, hostel recommendations, safety tips and local meetup suggestions.'],
        ['💑','Romantic Getaway','Curated couple experiences, sunset spots, fine dining and boutique hotels.'],
        ['👨‍👩‍👧‍👦','Family Vacation','Kid-friendly activities, family hotels, stroller-accessible routes and nap-time scheduling.'],
        ['💼','Business + Leisure','Optimize around meetings. AI suggests activities between appointments and weekend extensions.'],
      ];
      foreach($cases as $i=>$c): ?>
      <div class="bg-white/5 backdrop-blur-sm p-6 rounded-2xl border border-white/10 hover:bg-white/10 transition" data-aos="fade-up" data-aos-delay="<?=$i*80?>">
        <div class="text-3xl mb-4"><?=$c[0]?></div>
        <h3 class="font-bold text-lg mb-2"><?=$c[1]?></h3>
        <p class="text-slate-300 text-sm leading-relaxed"><?=$c[2]?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- PRICING -->
<section id="pricing" class="py-24 bg-white">
  <div class="max-w-5xl mx-auto px-6">
    <div class="text-center mb-16" data-aos="fade-up">
      <span class="text-sky-600 font-semibold text-sm uppercase tracking-wider">Pricing</span>
      <h2 class="text-4xl md:text-5xl font-bold mt-3 mb-6">Simple, transparent pricing</h2>
    </div>
    <div class="grid md:grid-cols-3 gap-6">
      <?php
      $plans = [
        ['Explorer','Free','0','1 trip/month, basic itinerary, budget tracker',['1 trip per month','Basic AI itinerary','Budget tracker','Email support'],'bg-white border-slate-200','text-slate-800'],
        ['Voyager','Popular','19','Unlimited trips, premium AI, offline maps, priority support',['Unlimited trips','Premium AI planner','Hotel & flight finder','Offline maps','Priority support'],'bg-sky-600 border-sky-600 text-white','text-white'],
        ['Nomad','Pro','39','Everything + API access, team sharing, concierge',['Everything in Voyager','API access','Team trip sharing','AI concierge chat','Custom branding'],'bg-white border-slate-200','text-slate-800'],
      ];
      foreach($plans as $i=>$p): ?>
      <div class="p-8 rounded-2xl border-2 <?=$p[5]?> card-h <?=$i===1?'shadow-xl scale-105':''?>" data-aos="fade-up" data-aos-delay="<?=$i*80?>">
        <div class="text-sm font-semibold uppercase tracking-wider <?=$i===1?'text-sky-200':'text-sky-600'?> mb-1"><?=$p[1]?></div>
        <h3 class="text-2xl font-bold mb-1 <?=$p[6]?>"><?=$p[0]?></h3>
        <div class="mb-4"><span class="text-4xl font-extrabold <?=$p[6]?>">$<?=$p[2]?></span><span class="text-sm <?=$i===1?'text-sky-200':'text-slate-500'?>">/month</span></div>
        <p class="text-sm <?=$i===1?'text-sky-100':'text-slate-500'?> mb-6"><?=$p[3]?></p>
        <ul class="space-y-2 mb-8">
          <?php foreach($p[4] as $feat): ?>
          <li class="flex items-center gap-2 text-sm <?=$i===1?'text-sky-100':'text-slate-600'?>">
            <svg class="w-4 h-4 <?=$i===1?'text-sky-300':'text-sky-500'?> flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
            <?=$feat?>
          </li>
          <?php endforeach; ?>
        </ul>
        <a href="#contact" class="block text-center py-3 rounded-xl font-semibold text-sm transition <?=$i===1?'bg-white text-sky-600 hover:bg-sky-50':'bg-sky-600 text-white hover:bg-sky-700'?>">Get Started</a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CONTACT -->
<section id="contact" class="py-24 bg-gradient-to-br from-slate-900 via-sky-950 to-slate-900 text-white">
  <div class="max-w-3xl mx-auto px-6">
    <div class="text-center mb-12" data-aos="fade-up">
      <span class="text-sky-400 font-semibold text-sm uppercase tracking-wider">Get Started</span>
      <h2 class="text-4xl md:text-5xl font-bold mt-3 mb-4">Ready to plan your next adventure?</h2>
      <p class="text-slate-300 text-lg">Tell us about your dream trip and we'll set you up.</p>
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
            <input id="c_name" type="text" name="name" required class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-slate-400 focus:border-sky-400 focus:outline-none transition" placeholder="Your name">
          </div>
          <div>
            <label for="c_email" class="block text-sm font-semibold mb-2">Email *</label>
            <input id="c_email" type="email" name="email" required class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-slate-400 focus:border-sky-400 focus:outline-none transition" placeholder="you@email.com">
          </div>
        </div>
        <div>
          <label for="c_plan" class="block text-sm font-semibold mb-2">Interested Plan</label>
          <select id="c_plan" name="plan" class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white focus:border-sky-400 focus:outline-none transition">
            <option value="">Select a plan</option>
            <option value="Explorer (Free)">Explorer — Free</option>
            <option value="Voyager ($19/mo)">Voyager — $19/mo</option>
            <option value="Nomad ($39/mo)">Nomad — $39/mo</option>
          </select>
        </div>
        <div>
          <label for="c_msg" class="block text-sm font-semibold mb-2">Tell us about your trip</label>
          <textarea id="c_msg" name="message" rows="4" class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-slate-400 focus:border-sky-400 focus:outline-none transition resize-none" placeholder="Where do you want to go?"></textarea>
        </div>
        <button type="submit" name="submit_contact" class="w-full bg-sky-600 text-white py-4 rounded-xl font-semibold hover:bg-sky-700 transition text-sm">✈️ Start Planning My Trip</button>
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
        <span class="text-white font-bold">Wandrly</span>
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
