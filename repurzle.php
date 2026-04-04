<?php
/**
 * Repurzel - Landing Page & Contact Form Handler
 */

$success_message = '';
$error_message   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_contact'])) {

    $name    = htmlspecialchars(strip_tags(trim($_POST['name']    ?? '')));
    $email   = filter_var(trim($_POST['email']   ?? ''), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(strip_tags(trim($_POST['subject'] ?? '')));
    $company = htmlspecialchars(strip_tags(trim($_POST['company'] ?? '')));
    $plan    = htmlspecialchars(strip_tags(trim($_POST['plan']    ?? '')));
    $message = htmlspecialchars(strip_tags(trim($_POST['message'] ?? '')));

    if (empty($name) || empty($email)) {
        $error_message = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Invalid email address.';
    } elseif (empty($subject) || empty($message)) {
        $error_message = 'Subject and message are required.';
    } else {
        $to           = 'contact@develop-it.tech';
        $subject_mail = '📩 Repurzel Contact - ' . $name . ' | develop-it.tech';

        $body  = "New contact message — Repurzel\n";
        $body .= str_repeat('─', 50) . "\n\n";
        $body .= "👤 Name       : $name\n";
        $body .= "📧 Email      : $email\n";
        $body .= "🏢 Company    : " . ($company ?: 'Not provided') . "\n";
        $body .= "💼 Plan       : " . ($plan    ?: 'Not provided') . "\n";
        $body .= "📋 Subject    : $subject\n\n";
        $body .= "💬 Message    :\n" . ($message ?: 'No message') . "\n\n";
        $body .= str_repeat('─', 50) . "\n";
        $body .= "Sent on : " . date('d/m/Y at H:i') . "\n";
        $body .= "IP      : " . ($_SERVER['REMOTE_ADDR'] ?? 'N/A') . "\n";

        $headers  = "From: no-reply@repurzel.com\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        if (mail($to, $subject_mail, $body, $headers)) {
            $success_message = 'Message sent! We\'ll get back to you within 24 hours.';
        } else {
            $error_message = 'An error occurred. Please try again or email us directly at hello@repurzel.com';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>

  <title>Repurzel — Turn One Piece of Content Into 5 Platform-Ready Posts with AI</title>
  <meta name="description" content="Repurzel uses AI to transform your blog posts, YouTube videos, and newsletters into Twitter threads, TikTok scripts, Instagram captions, emails, and LinkedIn posts — in seconds."/>
  <meta name="keywords" content="AI content repurposing, content marketing tool, social media automation, Twitter thread generator, TikTok script generator, content creator tools"/>
  <meta name="author" content="Repurzel"/>
  <meta name="robots" content="index, follow"/>
  <link rel="canonical" href="https://develop-it.tech/repurzle.php"/>
  <link rel="icon" type="image/png" sizes="32x32" href="/logo.jfif">
  <link rel="icon" type="image/png" sizes="16x16" href="/logo.jfif">
  <link rel="apple-touch-icon" href="/logo.jfif">
  <meta property="og:type"        content="website"/>
  <meta property="og:url"         content="https://repurzel.com/"/>
  <meta property="og:title"       content="Repurzel — AI Content Repurposing for Creators"/>
  <meta property="og:description" content="Paste your content once. Get 5 platform-ready posts instantly — Twitter, TikTok, Instagram, Email & LinkedIn."/>

  <meta name="twitter:card"        content="summary_large_image"/>
  <meta name="twitter:title"       content="Repurzel — AI Content Repurposing for Creators"/>
  <meta name="twitter:description" content="Paste your content once. Get 5 platform-ready posts instantly."/>

  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "Repurzel",
    "description": "AI-powered content repurposing tool that transforms your content into 5 platform-ready posts",
    "applicationCategory": "BusinessApplication",
    "operatingSystem": "Web",
    "offers": [
      { "@type": "Offer", "name": "Free",   "price": "0",  "priceCurrency": "USD" },
      { "@type": "Offer", "name": "Pro",    "price": "19", "priceCurrency": "USD" },
      { "@type": "Offer", "name": "Agency", "price": "49", "priceCurrency": "USD" }
    ]
  }
  </script>

  <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,300;12..96,400;12..96,700;12..96,800&family=Instrument+Serif:ital@0;1&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --ink:    #0d0d0d; --paper:  #f5f0e8; --cream:  #ede8dc; --warm: #e8e0cf;
      --gold:   #c9a84c; --gold2:  #e8c96a; --ember:  #c94c1e; --teal: #1a6b5e;
      --muted:  #6b6456; --border: #d4cdbf; --radius: 12px;
      --serif:  'Instrument Serif', Georgia, serif;
      --sans:   'Bricolage Grotesque', sans-serif;
      --mono:   'DM Mono', monospace;
    }
    html { scroll-behavior: smooth; }
    body { font-family: var(--sans); background: var(--paper); color: var(--ink); line-height: 1.6; overflow-x: hidden; }
    body::before {
      content: ''; position: fixed; inset: 0; z-index: 1000; pointer-events: none;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
      opacity: .35;
    }

    /* NAV */
    nav { position: sticky; top: 0; z-index: 100; display: flex; align-items: center; justify-content: space-between; padding: 1rem 2.5rem; background: rgba(245,240,232,.92); backdrop-filter: blur(14px); border-bottom: 1px solid var(--border); }
    .nav-logo { font-family: var(--sans); font-weight: 800; font-size: 1.35rem; color: var(--ink); text-decoration: none; display: flex; align-items: center; gap: .5rem; letter-spacing: -.03em; }
    .logo-mark { width: 32px; height: 32px; background: var(--ink); border-radius: 8px; display: flex; align-items: center; justify-content: center; }
    .logo-mark svg { width: 16px; height: 16px; color: var(--gold); }
    .nav-links { display: flex; align-items: center; gap: 2rem; }
    .nav-links a { color: var(--muted); text-decoration: none; font-size: .9rem; transition: color .15s; }
    .nav-links a:hover { color: var(--ink); }
    .nav-cta { background: var(--ink) !important; color: var(--paper) !important; font-weight: 600; padding: .5rem 1.25rem; border-radius: 8px; font-size: .85rem !important; }
    .nav-cta:hover { background: #2a2a2a !important; }

    /* HERO */
    .hero { min-height: 92vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 5rem 2rem 4rem; text-align: center; position: relative; }
    .hero::before { content: ''; position: absolute; inset: 0; z-index: 0; pointer-events: none; background-image: linear-gradient(var(--border) 1px, transparent 1px), linear-gradient(90deg, var(--border) 1px, transparent 1px); background-size: 60px 60px; opacity: .4; mask-image: radial-gradient(ellipse 80% 70% at 50% 50%, black 30%, transparent 100%); }
    .hero-badge { display: inline-flex; align-items: center; gap: .5rem; background: var(--ink); color: var(--gold2); padding: .35rem 1rem; border-radius: 100px; font-size: .75rem; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; margin-bottom: 2rem; position: relative; z-index: 1; animation: fadeUp .6s ease both; }
    .hero-badge svg { width: 13px; height: 13px; }
    .hero h1 { font-family: var(--sans); font-weight: 800; font-size: clamp(2.6rem, 7vw, 5.5rem); line-height: 1.05; letter-spacing: -.04em; max-width: 900px; margin-bottom: 1rem; position: relative; z-index: 1; animation: fadeUp .6s .1s ease both; }
    .hero h1 em { font-family: var(--serif); font-style: italic; font-weight: 400; color: var(--ember); }
    .hero-sub { font-size: clamp(1rem, 2vw, 1.2rem); color: var(--muted); max-width: 560px; margin: 0 auto 2.5rem; position: relative; z-index: 1; animation: fadeUp .6s .2s ease both; }
    .hero-actions { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; justify-content: center; position: relative; z-index: 1; animation: fadeUp .6s .3s ease both; }
    .btn-primary { background: var(--ink); color: var(--paper); padding: .9rem 2rem; border-radius: 10px; font-size: 1rem; font-weight: 700; text-decoration: none; font-family: var(--sans); display: inline-flex; align-items: center; gap: .5rem; transition: transform .2s, box-shadow .2s; box-shadow: 0 4px 20px rgba(13,13,13,.18); }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(13,13,13,.25); }
    .btn-primary svg { width: 16px; height: 16px; }
    .btn-ghost { color: var(--muted); text-decoration: none; font-size: .9rem; display: inline-flex; align-items: center; gap: .4rem; transition: color .15s; }
    .btn-ghost:hover { color: var(--ink); }
    .btn-ghost svg { width: 15px; height: 15px; }
    .hero-proof { margin-top: 2.5rem; display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap; justify-content: center; position: relative; z-index: 1; animation: fadeUp .6s .4s ease both; }
    .proof-item { display: flex; align-items: center; gap: .4rem; font-size: .82rem; color: var(--muted); }
    .proof-item svg { width: 14px; height: 14px; color: var(--teal); }
    .proof-divider { width: 1px; height: 16px; background: var(--border); }

    /* DEMO WINDOW */
    .hero-demo { margin-top: 4rem; max-width: 800px; width: 100%; position: relative; z-index: 1; animation: fadeUp .7s .5s ease both; }
    .demo-window { background: var(--ink); border-radius: 16px; overflow: hidden; box-shadow: 0 24px 80px rgba(13,13,13,.3); }
    .demo-titlebar { background: #1a1a1a; padding: .75rem 1rem; display: flex; align-items: center; gap: .5rem; }
    .demo-dot { width: 12px; height: 12px; border-radius: 50%; }
    .demo-dot:nth-child(1){background:#ff5f57} .demo-dot:nth-child(2){background:#febc2e} .demo-dot:nth-child(3){background:#28c840}
    .demo-url { margin-left: auto; background: #2a2a2a; border-radius: 6px; padding: .3rem .75rem; font-family: var(--mono); font-size: .72rem; color: #666; }
    .demo-body { padding: 1.5rem; }
    .demo-input-row { display: flex; gap: .75rem; margin-bottom: 1rem; }
    .demo-input { flex: 1; background: #1a1a1a; border: 1px solid #333; border-radius: 8px; padding: .75rem 1rem; color: #ccc; font-family: var(--mono); font-size: .8rem; line-height: 1.6; }
    .demo-input span { color: #888; } .demo-input strong { color: #c9a84c; }
    .demo-arrow { display: flex; align-items: center; color: #444; flex-shrink: 0; }
    .demo-arrow svg { width: 20px; height: 20px; }
    .demo-outputs { display: grid; grid-template-columns: repeat(5,1fr); gap: .5rem; }
    .demo-output { background: #1a1a1a; border-radius: 8px; padding: .6rem .7rem; border-top: 2px solid; }
    .demo-output:nth-child(1){border-color:#1da1f2} .demo-output:nth-child(2){border-color:#ff0050} .demo-output:nth-child(3){border-color:#e1306c} .demo-output:nth-child(4){border-color:#6c63ff} .demo-output:nth-child(5){border-color:#0077b5}
    .demo-output-label { font-size: .65rem; font-family: var(--mono); color: #666; margin-bottom: .35rem; }
    .demo-output-lines { display: flex; flex-direction: column; gap: .2rem; }
    .demo-line { height: 5px; background: #2a2a2a; border-radius: 3px; }
    .demo-line.w80{width:80%} .demo-line.w60{width:60%} .demo-line.w90{width:90%} .demo-line.w70{width:70%}

    /* LOGOS */
    .logos { padding: 2.5rem 2rem; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); text-align: center; }
    .logos-label { font-size: .75rem; text-transform: uppercase; letter-spacing: .1em; color: var(--muted); margin-bottom: 1.5rem; }
    .logos-row { display: flex; align-items: center; justify-content: center; gap: 3rem; flex-wrap: wrap; }
    .logo-pill { display: flex; align-items: center; gap: .5rem; color: var(--border); font-family: var(--sans); font-weight: 700; font-size: 1rem; }
    .logo-pill svg { width: 18px; height: 18px; }

    /* SECTIONS */
    .section-wrap { padding: 6rem 2rem; max-width: 1100px; margin: 0 auto; }
    .section-eyebrow { display: inline-flex; align-items: center; gap: .4rem; font-size: .72rem; text-transform: uppercase; letter-spacing: .1em; color: var(--ember); font-weight: 700; margin-bottom: 1rem; }
    .section-eyebrow::before { content: ''; width: 24px; height: 2px; background: var(--ember); border-radius: 2px; }
    .section-title { font-family: var(--sans); font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; letter-spacing: -.04em; line-height: 1.1; margin-bottom: 1rem; }
    .section-title em { font-family: var(--serif); font-style: italic; font-weight: 400; }
    .section-sub { color: var(--muted); font-size: 1.05rem; max-width: 540px; }

    /* FEATURES */
    .features-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 1.5rem; margin-top: 4rem; }
    .feat-card { background: var(--cream); border: 1px solid var(--border); border-radius: 16px; padding: 2rem; transition: transform .2s, box-shadow .2s; }
    .feat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(13,13,13,.08); }
    .feat-icon { width: 44px; height: 44px; border-radius: 10px; background: var(--ink); display: flex; align-items: center; justify-content: center; margin-bottom: 1.25rem; }
    .feat-icon svg { width: 20px; height: 20px; color: var(--gold); }
    .feat-card h3 { font-size: 1.05rem; font-weight: 700; margin-bottom: .5rem; letter-spacing: -.02em; }
    .feat-card p { font-size: .88rem; color: var(--muted); line-height: 1.7; }
    .feat-card.featured { background: var(--ink); border-color: var(--ink); color: var(--paper); }
    .feat-card.featured .feat-icon { background: rgba(201,168,76,.15); }
    .feat-card.featured p { color: #888; }

    /* HOW IT WORKS */
    .how-wrap { background: var(--cream); border-radius: 24px; padding: 4rem; }
    .steps { display: grid; grid-template-columns: repeat(3,1fr); gap: 2rem; margin-top: 3rem; position: relative; }
    .steps::before { content: ''; position: absolute; top: 28px; left: calc(16.67% + 1rem); right: calc(16.67% + 1rem); height: 1px; background: repeating-linear-gradient(90deg, var(--border) 0, var(--border) 8px, transparent 8px, transparent 16px); }
    .step { text-align: center; }
    .step-num { width: 56px; height: 56px; border-radius: 50%; background: var(--ink); color: var(--gold); font-family: var(--mono); font-weight: 700; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; position: relative; z-index: 1; box-shadow: 0 0 0 8px var(--cream); }
    .step h3 { font-size: 1rem; font-weight: 700; margin-bottom: .5rem; }
    .step p { font-size: .85rem; color: var(--muted); line-height: 1.7; }

    /* PLATFORMS */
    .platforms-grid { display: grid; grid-template-columns: repeat(5,1fr); gap: 1rem; margin-top: 3rem; }
    .platform-card { border-radius: 14px; padding: 1.75rem 1rem; text-align: center; border: 1px solid var(--border); background: var(--cream); transition: transform .2s; }
    .platform-card:hover { transform: translateY(-4px); }
    .platform-dot { width: 40px; height: 40px; border-radius: 50%; margin: 0 auto .85rem; display: flex; align-items: center; justify-content: center; }
    .platform-dot svg { width: 18px; height: 18px; color: #fff; }
    .twitter-dot{background:#1da1f2} .tiktok-dot{background:#ff0050} .instagram-dot{background:linear-gradient(135deg,#f58529,#dd2a7b,#8134af)} .email-dot{background:#6c63ff} .linkedin-dot{background:#0077b5}
    .platform-card h3 { font-size: .9rem; font-weight: 700; margin-bottom: .3rem; }
    .platform-card p { font-size: .78rem; color: var(--muted); }

    /* PRICING */
    .pricing-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 1.5rem; margin-top: 3rem; }
    .price-card { background: var(--cream); border: 1px solid var(--border); border-radius: 16px; padding: 2rem; position: relative; }
    .price-card.popular { background: var(--ink); border-color: var(--ink); color: var(--paper); transform: scale(1.03); }
    .popular-badge { position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: var(--gold); color: var(--ink); font-size: .7rem; font-weight: 700; padding: .3rem .85rem; border-radius: 100px; letter-spacing: .06em; text-transform: uppercase; white-space: nowrap; }
    .price-plan { font-size: .75rem; text-transform: uppercase; letter-spacing: .1em; color: var(--muted); font-weight: 700; margin-bottom: .75rem; }
    .price-card.popular .price-plan { color: #888; }
    .price-amount { font-family: var(--sans); font-size: 2.8rem; font-weight: 800; letter-spacing: -.04em; line-height: 1; margin-bottom: .25rem; }
    .price-period { font-size: .82rem; color: var(--muted); margin-bottom: 1.5rem; }
    .price-card.popular .price-period { color: #888; }
    .price-features { list-style: none; margin-bottom: 2rem; display: flex; flex-direction: column; gap: .65rem; }
    .price-features li { display: flex; align-items: center; gap: .5rem; font-size: .87rem; }
    .price-features li svg { width: 15px; height: 15px; flex-shrink: 0; color: var(--teal); }
    .price-card.popular .price-features li svg { color: var(--gold2); }
    .price-btn { width: 100%; padding: .8rem; border-radius: 9px; font-family: var(--sans); font-weight: 700; font-size: .9rem; cursor: pointer; border: none; text-decoration: none; display: block; text-align: center; transition: all .15s; }
    .price-btn-outline { background: transparent; border: 1.5px solid var(--border); color: var(--ink); }
    .price-btn-outline:hover { border-color: var(--ink); }
    .price-btn-solid { background: var(--gold); color: var(--ink); }
    .price-btn-solid:hover { background: var(--gold2); }
    .price-btn-dark { background: var(--paper); color: var(--ink); }
    .price-btn-dark:hover { background: var(--cream); }

    /* TESTIMONIALS */
    .testimonials-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 1.25rem; margin-top: 3rem; }
    .testi-card { background: var(--cream); border: 1px solid var(--border); border-radius: 16px; padding: 1.75rem; }
    .testi-stars { color: var(--gold); font-size: 1rem; margin-bottom: .75rem; }
    .testi-text { font-family: var(--serif); font-style: italic; font-size: 1rem; line-height: 1.75; color: var(--ink); margin-bottom: 1.25rem; }
    .testi-author { display: flex; align-items: center; gap: .75rem; }
    .testi-avatar { width: 36px; height: 36px; border-radius: 50%; background: var(--ink); color: var(--gold); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: .85rem; flex-shrink: 0; }
    .testi-name { font-size: .85rem; font-weight: 700; }
    .testi-role { font-size: .75rem; color: var(--muted); }

    /* FAQ */
    .faq-list { margin-top: 3rem; display: flex; flex-direction: column; gap: .75rem; max-width: 720px; }
    .faq-item { background: var(--cream); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; }
    .faq-q { width: 100%; padding: 1.2rem 1.5rem; display: flex; align-items: center; justify-content: space-between; background: none; border: none; font-family: var(--sans); font-weight: 700; font-size: .95rem; cursor: pointer; color: var(--ink); text-align: left; gap: 1rem; }
    .faq-q svg { width: 16px; height: 16px; color: var(--muted); flex-shrink: 0; transition: transform .25s; }
    .faq-item.open .faq-q svg { transform: rotate(45deg); }
    .faq-a { max-height: 0; overflow: hidden; transition: max-height .3s ease; }
    .faq-item.open .faq-a { max-height: 200px; }
    .faq-a p { padding: 0 1.5rem 1.2rem; color: var(--muted); font-size: .88rem; line-height: 1.8; }

    /* CONTACT */
    .contact-wrap { background: var(--cream); border-radius: 24px; padding: 4rem; display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; }
    .contact-left h2 { font-size: 2rem; font-weight: 800; letter-spacing: -.04em; margin-bottom: .75rem; }
    .contact-left h2 em { font-family: var(--serif); font-style: italic; font-weight: 400; }
    .contact-left p { color: var(--muted); font-size: .9rem; line-height: 1.8; margin-bottom: 2rem; }
    .contact-info { display: flex; flex-direction: column; gap: .85rem; }
    .contact-info-item { display: flex; align-items: center; gap: .75rem; font-size: .87rem; color: var(--muted); }
    .contact-info-item svg { width: 16px; height: 16px; color: var(--ember); flex-shrink: 0; }
    .form-group { margin-bottom: 1.1rem; }
    .form-label { display: block; font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; margin-bottom: .5rem; color: var(--muted); }
    .form-input, .form-textarea, .form-select { width: 100%; background: var(--paper); border: 1.5px solid var(--border); border-radius: 10px; color: var(--ink); font-family: var(--sans); font-size: .9rem; padding: .85rem 1rem; outline: none; transition: border-color .15s; appearance: none; }
    .form-input:focus, .form-textarea:focus, .form-select:focus { border-color: var(--ink); }
    .form-input::placeholder, .form-textarea::placeholder { color: #b0a898; }
    .form-textarea { min-height: 130px; resize: vertical; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .form-submit { width: 100%; padding: .9rem; background: var(--ink); color: var(--paper); border: none; border-radius: 10px; font-family: var(--sans); font-weight: 700; font-size: .95rem; cursor: pointer; transition: all .2s; display: flex; align-items: center; justify-content: center; gap: .5rem; }
    .form-submit:hover { background: #2a2a2a; transform: translateY(-1px); }
    .form-submit svg { width: 16px; height: 16px; }
    .alert { border-radius: 10px; padding: 1rem 1.25rem; font-size: .875rem; display: flex; align-items: flex-start; gap: .5rem; margin-bottom: 1.25rem; }
    .alert svg { width: 18px; height: 18px; flex-shrink: 0; margin-top: 1px; }
    .alert-success { background: rgba(26,107,94,.1); border: 1px solid rgba(26,107,94,.25); color: var(--teal); }
    .alert-error   { background: rgba(201,76,30,.1);  border: 1px solid rgba(201,76,30,.25);  color: var(--ember); }

    /* CTA BANNER */
    .cta-banner { background: var(--ink); border-radius: 24px; padding: 5rem 3rem; text-align: center; position: relative; overflow: hidden; margin: 0 2rem 6rem; }
    .cta-banner::before { content: ''; position: absolute; top: -50%; left: -20%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(201,168,76,.12) 0%, transparent 70%); pointer-events: none; }
    .cta-banner h2 { font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; color: var(--paper); letter-spacing: -.04em; margin-bottom: .75rem; position: relative; z-index: 1; }
    .cta-banner h2 em { font-family: var(--serif); font-style: italic; font-weight: 400; color: var(--gold2); }
    .cta-banner p { color: #888; margin-bottom: 2.5rem; font-size: 1.05rem; position: relative; z-index: 1; }
    .cta-banner .btn-primary { background: var(--gold); color: var(--ink); position: relative; z-index: 1; }
    .cta-banner .btn-primary:hover { background: var(--gold2); }

    /* FOOTER */
    .footer-inner { border-top: 1px solid var(--border); padding: 3rem 2.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1.5rem; max-width: 1200px; margin: 0 auto; }
    .footer-logo { font-family: var(--sans); font-weight: 800; font-size: 1.1rem; color: var(--ink); letter-spacing: -.03em; }
    .footer-links { display: flex; gap: 2rem; flex-wrap: wrap; }
    .footer-links a { color: var(--muted); text-decoration: none; font-size: .85rem; transition: color .15s; }
    .footer-links a:hover { color: var(--ink); }
    .footer-copy { color: var(--muted); font-size: .8rem; }

    /* ANIMATIONS */
    @keyframes fadeUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
    .reveal { opacity: 0; transform: translateY(28px); transition: opacity .6s ease, transform .6s ease; }
    .reveal.visible { opacity: 1; transform: translateY(0); }

    /* RESPONSIVE */
    @media (max-width: 900px) {
      nav { padding: 1rem 1.25rem; } .nav-links { display: none; }
      .features-grid { grid-template-columns: 1fr 1fr; }
      .steps { grid-template-columns: 1fr; } .steps::before { display: none; }
      .platforms-grid { grid-template-columns: repeat(3,1fr); }
      .pricing-grid { grid-template-columns: 1fr; } .price-card.popular { transform: none; }
      .testimonials-grid { grid-template-columns: 1fr; }
      .contact-wrap { grid-template-columns: 1fr; gap: 2.5rem; padding: 2rem; }
      .how-wrap { padding: 2rem; }
    }
    @media (max-width: 600px) {
      .features-grid { grid-template-columns: 1fr; }
      .platforms-grid { grid-template-columns: repeat(2,1fr); }
      .form-row { grid-template-columns: 1fr; }
      .hero-actions { flex-direction: column; align-items: stretch; text-align: center; }
      .demo-outputs { grid-template-columns: repeat(3,1fr); }
      .cta-banner { margin: 0 1rem 4rem; padding: 3rem 1.5rem; }
    }
  </style>
</head>
<body>

<nav>
  <a href="/" class="nav-logo"><div class="logo-mark"><i data-lucide="zap"></i></div> repurzel</a>
  <div class="nav-links">
    <a href="#features">Features</a>
    <a href="#how-it-works">How it works</a>
    <a href="#pricing">Pricing</a>
    <a href="#faq">FAQ</a>
    <a href="#contact">Contact</a>
    <a href="/login">Log in</a>
    <a href="/register" class="nav-cta">Start Free →</a>
  </div>
</nav>

<!-- HERO -->
<header class="hero">
  <div class="hero-badge"><i data-lucide="sparkles"></i> AI-Powered Content Repurposing</div>
  <h1>One piece of content.<br><em>Five platforms.</em> Zero effort.</h1>
  <p class="hero-sub">Paste your blog post, YouTube video, or newsletter — Repurzel's AI turns it into platform-perfect posts for Twitter, TikTok, Instagram, Email & LinkedIn in seconds.</p>
  <div class="hero-actions">
    <a href="/register" class="btn-primary"><i data-lucide="zap"></i> Start for Free — No credit card</a>
    <a href="#how-it-works" class="btn-ghost"><i data-lucide="play-circle"></i> See how it works</a>
  </div>
  <div class="hero-proof">
    <div class="proof-item"><i data-lucide="check-circle"></i> Free plan available</div>
    <div class="proof-divider"></div>
    <div class="proof-item"><i data-lucide="check-circle"></i> 5 platforms at once</div>
    <div class="proof-divider"></div>
    <div class="proof-item"><i data-lucide="check-circle"></i> No prompt engineering</div>
    <div class="proof-divider"></div>
    <div class="proof-item"><i data-lucide="check-circle"></i> Cancel anytime</div>
  </div>
  <div class="hero-demo" aria-hidden="true">
    <div class="demo-window">
      <div class="demo-titlebar">
        <div class="demo-dot"></div><div class="demo-dot"></div><div class="demo-dot"></div>
        <div class="demo-url">app.repurzel.com</div>
      </div>
      <div class="demo-body">
        <div class="demo-input-row">
          <div class="demo-input"><span>Your content:</span><br><strong>"I scaled my newsletter from 0 to 10,000 subscribers in 6 months by doing one thing differently — I stopped trying to go viral and focused on being genuinely useful to a tiny audience..."</strong></div>
          <div class="demo-arrow"><i data-lucide="arrow-right"></i></div>
        </div>
        <div class="demo-outputs">
          <div class="demo-output"><div class="demo-output-label">Twitter</div><div class="demo-output-lines"><div class="demo-line w90"></div><div class="demo-line w80"></div><div class="demo-line w60"></div></div></div>
          <div class="demo-output"><div class="demo-output-label">TikTok</div><div class="demo-output-lines"><div class="demo-line w80"></div><div class="demo-line w90"></div><div class="demo-line w70"></div></div></div>
          <div class="demo-output"><div class="demo-output-label">Instagram</div><div class="demo-output-lines"><div class="demo-line w90"></div><div class="demo-line w60"></div><div class="demo-line w80"></div></div></div>
          <div class="demo-output"><div class="demo-output-label">Email</div><div class="demo-output-lines"><div class="demo-line w70"></div><div class="demo-line w90"></div><div class="demo-line w80"></div></div></div>
          <div class="demo-output"><div class="demo-output-label">LinkedIn</div><div class="demo-output-lines"><div class="demo-line w80"></div><div class="demo-line w90"></div><div class="demo-line w60"></div></div></div>
        </div>
      </div>
    </div>
  </div>
</header>

<!-- LOGOS -->
<div class="logos reveal">
  <p class="logos-label">Works with content from</p>
  <div class="logos-row">
    <div class="logo-pill"><i data-lucide="youtube"></i> YouTube</div>
    <div class="logo-pill"><i data-lucide="rss"></i> Substack</div>
    <div class="logo-pill"><i data-lucide="file-text"></i> WordPress</div>
    <div class="logo-pill"><i data-lucide="headphones"></i> Podcasts</div>
    <div class="logo-pill"><i data-lucide="mic"></i> Notion</div>
  </div>
</div>

<!-- FEATURES -->
<section id="features" class="section-wrap">
  <div class="reveal">
    <p class="section-eyebrow">Features</p>
    <h2 class="section-title">Everything a creator needs<br>to <em>multiply their reach</em></h2>
    <p class="section-sub">Stop spending hours reformatting content. Let AI do the heavy lifting while you focus on creating.</p>
  </div>
  <div class="features-grid reveal">
    <div class="feat-card"><div class="feat-icon"><i data-lucide="layers"></i></div><h3>5 Platforms at Once</h3><p>Twitter thread, TikTok script, Instagram caption, Email newsletter, and LinkedIn post — all generated in a single click.</p></div>
    <div class="feat-card featured"><div class="feat-icon"><i data-lucide="mic"></i></div><h3>6 Tone Modes</h3><p style="color:#888">Casual, Professional, Funny, Motivational, Educational, Storytelling — your brand voice, dialed in.</p></div>
    <div class="feat-card"><div class="feat-icon"><i data-lucide="layout-template"></i></div><h3>9 Content Templates</h3><p>Before/After, Hot Take, Listicle, Case Study, Myth Busting, Tutorial, Personal Story, FAQ, and more.</p></div>
    <div class="feat-card"><div class="feat-icon"><i data-lucide="sliders"></i></div><h3>Custom Instructions</h3><p>Tell the AI your niche, audience, and CTAs. "I'm a fitness coach targeting women 30-45 — always link to my course."</p></div>
    <div class="feat-card"><div class="feat-icon"><i data-lucide="youtube"></i></div><h3>YouTube Extraction</h3><p>Paste a YouTube URL and we'll extract the transcript automatically. Turn any video into written content.</p></div>
    <div class="feat-card"><div class="feat-icon"><i data-lucide="refresh-cw"></i></div><h3>Regenerate Any Platform</h3><p>Not happy with the LinkedIn post? Regenerate just that one — without redoing everything else.</p></div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section id="how-it-works" class="section-wrap" style="padding-top:0">
  <div class="how-wrap reveal">
    <p class="section-eyebrow">How it works</p>
    <h2 class="section-title">From one idea to <em>everywhere</em><br>in three steps</h2>
    <div class="steps">
      <div class="step"><div class="step-num">01</div><h3>Paste Your Content</h3><p>Paste text directly, drop a YouTube URL, or paste from your blog. Any format works.</p></div>
      <div class="step"><div class="step-num">02</div><h3>Set Your Preferences</h3><p>Choose your tone, pick a content template, and add optional custom instructions about your niche.</p></div>
      <div class="step"><div class="step-num">03</div><h3>Copy & Publish</h3><p>Review 5 platform-ready outputs, regenerate any you want to improve, then copy and post.</p></div>
    </div>
  </div>
</section>

<!-- PLATFORMS -->
<section class="section-wrap">
  <div class="reveal">
    <p class="section-eyebrow">Platforms</p>
    <h2 class="section-title">Built for every channel<br>creators <em>actually use</em></h2>
  </div>
  <div class="platforms-grid reveal">
    <div class="platform-card"><div class="platform-dot twitter-dot"><i data-lucide="twitter"></i></div><h3>Twitter / X</h3><p>Scroll-stopping threads that build followers</p></div>
    <div class="platform-card"><div class="platform-dot tiktok-dot"><i data-lucide="video"></i></div><h3>TikTok</h3><p>45-second scripts optimized for virality</p></div>
    <div class="platform-card"><div class="platform-dot instagram-dot"><i data-lucide="instagram"></i></div><h3>Instagram</h3><p>Captions + hashtags that drive engagement</p></div>
    <div class="platform-card"><div class="platform-dot email-dot"><i data-lucide="mail"></i></div><h3>Email</h3><p>Newsletter-ready with subject lines included</p></div>
    <div class="platform-card"><div class="platform-dot linkedin-dot"><i data-lucide="linkedin"></i></div><h3>LinkedIn</h3><p>Thought leadership posts that build authority</p></div>
  </div>
</section>

<!-- PRICING -->
<section id="pricing" class="section-wrap">
  <div class="reveal" style="text-align:center;max-width:none">
    <p class="section-eyebrow" style="justify-content:center">Pricing</p>
    <h2 class="section-title">Start free. <em>Scale when ready.</em></h2>
    <p class="section-sub" style="max-width:none;color:var(--muted)">No hidden fees. Cancel anytime.</p>
  </div>
  <div class="pricing-grid reveal">
    <div class="price-card">
      <p class="price-plan">Free</p><p class="price-amount">$0</p><p class="price-period">forever</p>
      <ul class="price-features">
        <li><i data-lucide="check"></i> 3 repurposes / day</li>
        <li><i data-lucide="check"></i> All 5 platforms</li>
        <li><i data-lucide="check"></i> 3 tone modes</li>
        <li><i data-lucide="check"></i> Basic templates</li>
      </ul>
      <a href="/register" class="price-btn price-btn-outline">Get started free</a>
    </div>
    <div class="price-card popular">
      <div class="popular-badge">⚡ Most Popular</div>
      <p class="price-plan">Pro</p><p class="price-amount">$19</p><p class="price-period">per month</p>
      <ul class="price-features">
        <li><i data-lucide="check"></i> Unlimited repurposes</li>
        <li><i data-lucide="check"></i> All 5 platforms</li>
        <li><i data-lucide="check"></i> All 6 tone modes</li>
        <li><i data-lucide="check"></i> All 9 templates</li>
        <li><i data-lucide="check"></i> Custom instructions</li>
        <li><i data-lucide="check"></i> YouTube extraction</li>
        <li><i data-lucide="check"></i> Content history</li>
      </ul>
      <a href="/register?plan=pro" class="price-btn price-btn-solid">Start Pro — $19/mo</a>
    </div>
    <div class="price-card">
      <p class="price-plan">Agency</p><p class="price-amount">$49</p><p class="price-period">per month</p>
      <ul class="price-features">
        <li><i data-lucide="check"></i> Everything in Pro</li>
        <li><i data-lucide="check"></i> 5 team seats</li>
        <li><i data-lucide="check"></i> Shared brand voice</li>
        <li><i data-lucide="check"></i> Bulk generation</li>
        <li><i data-lucide="check"></i> Priority support</li>
        <li><i data-lucide="check"></i> API access (coming soon)</li>
      </ul>
      <a href="/register?plan=agency" class="price-btn price-btn-outline">Start Agency</a>
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section class="section-wrap">
  <div class="reveal">
    <p class="section-eyebrow">Testimonials</p>
    <h2 class="section-title">Creators are <em>saving hours</em><br>every single week</h2>
  </div>
  <div class="testimonials-grid reveal">
    <div class="testi-card"><div class="testi-stars">★★★★★</div><p class="testi-text">"I used to spend 3 hours per week repurposing my newsletter. Now it takes 5 minutes. Repurzel is the best $19 I spend every month."</p><div class="testi-author"><div class="testi-avatar">S</div><div><div class="testi-name">Sarah K.</div><div class="testi-role">Newsletter Creator, 28k subscribers</div></div></div></div>
    <div class="testi-card"><div class="testi-stars">★★★★★</div><p class="testi-text">"The custom instructions feature is a game changer. I told it I'm a crypto educator and it nails the tone every single time."</p><div class="testi-author"><div class="testi-avatar">M</div><div><div class="testi-name">Marcus T.</div><div class="testi-role">Crypto Educator, YouTube 45k</div></div></div></div>
    <div class="testi-card"><div class="testi-stars">★★★★★</div><p class="testi-text">"I paste my podcast transcript and get a week's worth of social content. My LinkedIn went from 500 to 8,000 followers in 4 months."</p><div class="testi-author"><div class="testi-avatar">A</div><div><div class="testi-name">Amira D.</div><div class="testi-role">Business Podcast Host</div></div></div></div>
  </div>
</section>

<!-- FAQ -->
<section id="faq" class="section-wrap">
  <div class="reveal">
    <p class="section-eyebrow">FAQ</p>
    <h2 class="section-title">Questions, <em>answered.</em></h2>
  </div>
  <div class="faq-list reveal">
    <div class="faq-item"><button class="faq-q" onclick="toggleFaq(this)">What kind of content can I repurpose? <i data-lucide="plus"></i></button><div class="faq-a"><p>Anything text-based: blog posts, newsletters, podcast transcripts, YouTube video transcripts (paste the URL and we extract it), notes, scripts — if you can write it, we can repurpose it.</p></div></div>
    <div class="faq-item"><button class="faq-q" onclick="toggleFaq(this)">How does the AI know my brand voice? <i data-lucide="plus"></i></button><div class="faq-a"><p>Repurzel's AI analyzes your original content to detect your natural writing style — vocabulary, tone, energy, and personality. You can further refine it with Custom Instructions and Tone modes.</p></div></div>
    <div class="faq-item"><button class="faq-q" onclick="toggleFaq(this)">Can I use it for a team or agency? <i data-lucide="plus"></i></button><div class="faq-a"><p>Yes. The Agency plan ($49/mo) includes 5 team seats, shared brand voice profiles, and bulk generation — perfect for content agencies or brands managing multiple creators.</p></div></div>
    <div class="faq-item"><button class="faq-q" onclick="toggleFaq(this)">Is the free plan really free? <i data-lucide="plus"></i></button><div class="faq-a"><p>Yes, completely. The free plan gives you 3 repurposes per day with no credit card required. Upgrade when you need more volume or advanced features.</p></div></div>
    <div class="faq-item"><button class="faq-q" onclick="toggleFaq(this)">What AI model powers Repurzel? <i data-lucide="plus"></i></button><div class="faq-a"><p>Repurzel uses Claude by Anthropic — one of the most capable AI models for nuanced writing, specifically prompted for platform-native content styles.</p></div></div>
  </div>
</section>

<!-- CONTACT -->
<section id="contact" class="section-wrap">
  <div class="contact-wrap reveal">
    <div class="contact-left">
      <p class="section-eyebrow">Contact</p>
      <h2><em>Get in touch</em> with our team</h2>
      <p>Have questions about Repurzel? Want to discuss an Agency plan? We reply within 24 hours.</p>
      <div class="contact-info">
        <div class="contact-info-item"><i data-lucide="mail"></i> hello@repurzel.com</div>
        <div class="contact-info-item"><i data-lucide="twitter"></i> @repurzel</div>
        <div class="contact-info-item"><i data-lucide="clock"></i> Typically reply within 24h</div>
      </div>
    </div>
    <div class="contact-right">

      <?php if (!empty($success_message)): ?>
      <div class="alert alert-success">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <?php echo $success_message; ?>
      </div>
      <?php endif; ?>

      <?php if (!empty($error_message)): ?>
      <div class="alert alert-error">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <?php echo $error_message; ?>
      </div>
      <?php endif; ?>

      <form method="POST" action="#contact">
        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="fname">Name *</label>
            <input class="form-input" type="text" id="fname" name="name" required
              value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
              placeholder="Your name"/>
          </div>
          <div class="form-group">
            <label class="form-label" for="company">Company</label>
            <input class="form-input" type="text" id="company" name="company"
              value="<?php echo htmlspecialchars($_POST['company'] ?? ''); ?>"
              placeholder="Optional"/>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label" for="email">Email *</label>
          <input class="form-input" type="email" id="email" name="email" required
            value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
            placeholder="you@example.com"/>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="subject">Subject *</label>
            <select class="form-select" id="subject" name="subject" required>
              <option value="" disabled <?php echo empty($_POST['subject']) ? 'selected' : ''; ?>>Select a topic...</option>
              <option value="General question"   <?php echo (($_POST['subject'] ?? '') === 'General question')   ? 'selected' : ''; ?>>General question</option>
              <option value="Pricing & plans"    <?php echo (($_POST['subject'] ?? '') === 'Pricing & plans')    ? 'selected' : ''; ?>>Pricing & plans</option>
              <option value="Agency inquiry"     <?php echo (($_POST['subject'] ?? '') === 'Agency inquiry')     ? 'selected' : ''; ?>>Agency inquiry</option>
              <option value="Bug report"         <?php echo (($_POST['subject'] ?? '') === 'Bug report')         ? 'selected' : ''; ?>>Bug report</option>
              <option value="Feature request"    <?php echo (($_POST['subject'] ?? '') === 'Feature request')    ? 'selected' : ''; ?>>Feature request</option>
              <option value="Other"              <?php echo (($_POST['subject'] ?? '') === 'Other')              ? 'selected' : ''; ?>>Other</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label" for="plan">Interested plan</label>
            <select class="form-select" id="plan" name="plan">
              <option value="" <?php echo empty($_POST['plan']) ? 'selected' : ''; ?>>Not sure yet</option>
              <option value="Free"   <?php echo (($_POST['plan'] ?? '') === 'Free')   ? 'selected' : ''; ?>>Free</option>
              <option value="Pro"    <?php echo (($_POST['plan'] ?? '') === 'Pro')    ? 'selected' : ''; ?>>Pro — $19/mo</option>
              <option value="Agency" <?php echo (($_POST['plan'] ?? '') === 'Agency') ? 'selected' : ''; ?>>Agency — $49/mo</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label" for="message">Message *</label>
          <textarea class="form-textarea" id="message" name="message" required
            placeholder="Tell us how we can help..."><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
        </div>
        <button type="submit" name="submit_contact" class="form-submit">
          <i data-lucide="send"></i> Send Message
        </button>
      </form>
    </div>
  </div>
</section>

<!-- CTA BANNER -->
<div class="cta-banner reveal">
  <h2>Stop creating content <em>once.</em><br>Start publishing everywhere.</h2>
  <p>Join thousands of creators who ship 5× more content with half the effort.</p>
  <a href="/register" class="btn-primary"><i data-lucide="zap"></i> Start Free Today</a>
</div>

<footer>
  <div class="footer-inner">
    <div class="footer-logo">repurzel</div>
    <nav class="footer-links">
      <a href="#features">Features</a>
      <a href="#pricing">Pricing</a>
      <a href="#faq">FAQ</a>
      <a href="#contact">Contact</a>
      <a href="/privacy">Privacy</a>
      <a href="/terms">Terms</a>
    </nav>
    <p class="footer-copy">© <?php echo date('Y'); ?> Repurzel. All rights reserved.</p>
  </div>
</footer>

<script>
  lucide.createIcons();

  const revealEls = document.querySelectorAll('.reveal');
  const observer  = new IntersectionObserver((entries) => {
    entries.forEach((e, i) => {
      if (e.isIntersecting) { setTimeout(() => e.target.classList.add('visible'), i * 80); observer.unobserve(e.target); }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -60px 0px' });
  revealEls.forEach(el => observer.observe(el));

  function toggleFaq(btn) {
    const item   = btn.closest('.faq-item');
    const isOpen = item.classList.contains('open');
    document.querySelectorAll('.faq-item.open').forEach(el => el.classList.remove('open'));
    if (!isOpen) item.classList.add('open');
    lucide.createIcons();
  }

  <?php if (!empty($success_message) || !empty($error_message)): ?>
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('#contact').scrollIntoView({ behavior: 'smooth' });
  });
  <?php endif; ?>
</script>
</body>
</html>