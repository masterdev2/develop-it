<?php
/**
 * ملعب لايف - Landing Page & Contact Form
 * Sports Streaming AI Agent Platform
 */

$success_message = '';
$error_message   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_contact'])) {
    $name    = htmlspecialchars(strip_tags(trim($_POST['name']    ?? '')));
    $email   = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(strip_tags(trim($_POST['subject'] ?? '')));
    $phone   = htmlspecialchars(strip_tags(trim($_POST['phone']   ?? '')));
    $message = htmlspecialchars(strip_tags(trim($_POST['message'] ?? '')));

    if (empty($name) || empty($email)) {
        $error_message = 'يرجى ملء جميع الحقول المطلوبة.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'عنوان البريد الإلكتروني غير صالح.';
    } elseif (empty($subject) || empty($message)) {
        $error_message = 'الموضوع والرسالة مطلوبان.';
    } else {
        $to           = 'contact@develop-it.tech';
        $subject_mail = '📩 ملعب لايف - رسالة جديدة من ' . $name;

        $body  = "رسالة جديدة من موقع ملعب لايف\n";
        $body .= str_repeat('─', 50) . "\n\n";
        $body .= "👤 الاسم       : $name\n";
        $body .= "📧 البريد      : $email\n";
        $body .= "📱 الهاتف      : " . ($phone ?: 'غير محدد') . "\n";
        $body .= "📋 الموضوع    : $subject\n\n";
        $body .= "💬 الرسالة    :\n$message\n\n";
        $body .= str_repeat('─', 50) . "\n";
        $body .= "تاريخ الإرسال : " . date('d/m/Y الساعة H:i') . "\n";
        $body .= "IP            : " . ($_SERVER['REMOTE_ADDR'] ?? 'N/A') . "\n";

        $headers  = "From: no-reply@malab.live\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        if (mail($to, $subject_mail, $body, $headers)) {
            $success_message = 'تم إرسال رسالتك بنجاح! سنرد عليك خلال 24 ساعة.';
        } else {
            $error_message = 'حدث خطأ. يرجى المحاولة مرة أخرى أو مراسلتنا مباشرة على contact@develop-it.tech';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>ملعب لايف — بث مباشر ذكي للمباريات الرياضية</title>
  <meta name="description" content="منصة ذكاء اصطناعي تجلب أحداث الرياضة الحية، تبحث عن روابط البث، وتنشر تلقائياً على فيسبوك بالعربية."/>
  <meta name="keywords" content="بث مباشر, مباريات رياضية, كرة القدم, ذكاء اصطناعي, فيسبوك تلقائي"/>
  <meta name="author" content="develop-it.tech"/>
  <link rel="canonical" href="https://develop-it.tech/stream_agent.php"/>
  <link rel="icon" type="image/png" sizes="32x32" href="/logo.jfif">
  <link rel="apple-touch-icon" href="/logo.jfif">
  <meta property="og:type"        content="website"/>
  <meta property="og:url"         content="https://malab.live/"/>
  <meta property="og:title"       content="ملعب لايف — بث مباشر ذكي للمباريات"/>
  <meta property="og:description" content="وكيل ذكاء اصطناعي يجلب المباريات الحية، يبحث عن روابط البث، وينشر على فيسبوك تلقائياً."/>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Readex+Pro:wght@300;400;600;700&display=swap" rel="stylesheet"/>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --bg:        #080c14;
      --bg2:       #0d1120;
      --bg3:       #111827;
      --card:      #141c2e;
      --border:    #1e2d4a;
      --red:       #e63946;
      --red2:      #ff6b6b;
      --gold:      #f4a261;
      --teal:      #2ec4b6;
      --text:      #f0f4ff;
      --muted:     #8b9cc8;
      --faint:     #3a4a6a;
      --radius:    14px;
      --font:      'Cairo', 'Readex Pro', sans-serif;
    }

    html { scroll-behavior: smooth; }

    body {
      font-family: var(--font);
      background: var(--bg);
      color: var(--text);
      line-height: 1.6;
      overflow-x: hidden;
      direction: rtl;
    }

    /* Grain overlay */
    body::after {
      content: '';
      position: fixed;
      inset: 0;
      z-index: 1000;
      pointer-events: none;
      opacity: .025;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='1'/%3E%3C/svg%3E");
    }

    a { text-decoration: none; color: inherit; }

    /* ── NAVBAR ─────────────────────────────── */
    .nav {
      position: sticky; top: 0; z-index: 200;
      display: flex; align-items: center; justify-content: space-between;
      padding: 0 2.5rem; height: 68px;
      background: rgba(8,12,20,.88);
      backdrop-filter: blur(20px);
      border-bottom: 1px solid var(--border);
    }

    .nav-logo {
      display: flex; align-items: center; gap: 10px;
      font-size: 1.4rem; font-weight: 900;
      letter-spacing: -.02em;
    }
    .nav-logo-icon {
      width: 38px; height: 38px;
      background: var(--red);
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.1rem;
      box-shadow: 0 4px 16px rgba(230,57,70,.4);
    }
    .nav-logo em { color: var(--red); font-style: normal; }

    .nav-links {
      display: flex; align-items: center; gap: .25rem;
    }
    .nav-links a {
      color: var(--muted); font-size: .88rem;
      padding: .45rem 1rem; border-radius: 8px;
      transition: all .15s;
    }
    .nav-links a:hover { color: var(--text); background: rgba(255,255,255,.05); }

    .nav-cta {
      background: var(--red) !important;
      color: white !important;
      font-weight: 700 !important;
      padding: .5rem 1.3rem !important;
      border-radius: 9px !important;
      box-shadow: 0 4px 16px rgba(230,57,70,.35);
      transition: transform .15s, box-shadow .15s !important;
    }
    .nav-cta:hover { transform: translateY(-2px) !important; box-shadow: 0 8px 24px rgba(230,57,70,.45) !important; }

    .live-pill {
      display: flex; align-items: center; gap: 6px;
      background: rgba(230,57,70,.12);
      border: 1px solid rgba(230,57,70,.25);
      color: var(--red);
      padding: .3rem .9rem;
      border-radius: 20px;
      font-size: .78rem;
      font-weight: 700;
    }
    .pulse { width: 7px; height: 7px; border-radius: 50%; background: var(--red); animation: pulse 1.5s infinite; }
    @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.4;transform:scale(.7)} }

    /* ── HERO ───────────────────────────────── */
    .hero {
      min-height: 94vh;
      display: flex; flex-direction: column;
      align-items: center; justify-content: center;
      padding: 6rem 2rem 5rem;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .hero-bg {
      position: absolute; inset: 0; z-index: 0; pointer-events: none;
      background:
        radial-gradient(ellipse 80% 60% at 50% 0%, rgba(230,57,70,.1) 0%, transparent 60%),
        radial-gradient(ellipse 60% 40% at 80% 100%, rgba(46,196,182,.06) 0%, transparent 50%);
    }

    .hero-grid {
      position: absolute; inset: 0; z-index: 0; pointer-events: none;
      background-image:
        linear-gradient(rgba(255,255,255,.028) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.028) 1px, transparent 1px);
      background-size: 56px 56px;
      mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 20%, transparent 75%);
    }

    .hero-eyebrow {
      display: inline-flex; align-items: center; gap: .5rem;
      background: rgba(230,57,70,.12);
      border: 1px solid rgba(230,57,70,.25);
      color: var(--red2);
      padding: .35rem 1.1rem;
      border-radius: 100px;
      font-size: .75rem;
      font-weight: 700;
      letter-spacing: .07em;
      text-transform: uppercase;
      margin-bottom: 2rem;
      position: relative; z-index: 1;
      animation: fadeUp .6s ease both;
    }

    .hero h1 {
      font-size: clamp(2.8rem, 7vw, 5.5rem);
      font-weight: 900;
      letter-spacing: -.04em;
      line-height: 1.05;
      max-width: 860px;
      margin-bottom: 1.25rem;
      position: relative; z-index: 1;
      animation: fadeUp .6s .1s ease both;
    }

    .hero h1 .accent { color: var(--red); }
    .hero h1 .accent2 { color: var(--gold); }

    .hero-sub {
      font-size: clamp(.95rem, 1.8vw, 1.15rem);
      color: var(--muted);
      max-width: 580px;
      margin: 0 auto 2.5rem;
      line-height: 1.8;
      position: relative; z-index: 1;
      animation: fadeUp .6s .2s ease both;
    }

    .hero-actions {
      display: flex; align-items: center; gap: 1rem;
      flex-wrap: wrap; justify-content: center;
      position: relative; z-index: 1;
      animation: fadeUp .6s .3s ease both;
    }

    .btn-primary {
      display: inline-flex; align-items: center; gap: .5rem;
      background: var(--red);
      color: white; font-weight: 700; font-size: 1rem;
      padding: .9rem 2rem; border-radius: 11px;
      font-family: var(--font);
      box-shadow: 0 6px 24px rgba(230,57,70,.35);
      transition: transform .2s, box-shadow .2s;
    }
    .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 12px 36px rgba(230,57,70,.45); }

    .btn-ghost {
      display: inline-flex; align-items: center; gap: .5rem;
      color: var(--muted); font-size: .9rem;
      padding: .9rem 1.5rem; border-radius: 11px;
      border: 1px solid var(--border);
      transition: all .2s;
    }
    .btn-ghost:hover { color: var(--text); border-color: var(--faint); background: rgba(255,255,255,.04); }

    /* Stats row */
    .hero-stats {
      display: flex; align-items: center; gap: 0;
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 50px;
      padding: .6rem .4rem;
      margin-top: 3rem;
      position: relative; z-index: 1;
      animation: fadeUp .6s .45s ease both;
    }
    .hstat {
      padding: .3rem 1.5rem;
      text-align: center;
    }
    .hstat strong { display: block; font-size: 1.5rem; font-weight: 900; color: var(--red); line-height: 1; }
    .hstat span { font-size: .72rem; color: var(--muted); font-weight: 600; }
    .hstat-div { width: 1px; height: 32px; background: var(--border); }

    /* ── DEMO WINDOW ────────────────────────── */
    .hero-demo {
      margin-top: 4.5rem;
      max-width: 780px; width: 100%;
      position: relative; z-index: 1;
      animation: fadeUp .7s .55s ease both;
    }

    .demo-win {
      background: var(--bg2);
      border: 1px solid var(--border);
      border-radius: 18px;
      overflow: hidden;
      box-shadow: 0 32px 80px rgba(0,0,0,.5), 0 0 0 1px rgba(255,255,255,.04) inset;
    }

    .demo-bar {
      background: var(--bg3);
      padding: .7rem 1.1rem;
      display: flex; align-items: center; gap: .5rem;
      border-bottom: 1px solid var(--border);
    }
    .d-dot { width: 11px; height: 11px; border-radius: 50%; }
    .d-dot:nth-child(1){background:#ff5f57} .d-dot:nth-child(2){background:#febc2e} .d-dot:nth-child(3){background:#28c840}
    .demo-url {
      margin-right: auto;
      background: rgba(255,255,255,.05);
      border-radius: 6px; padding: .25rem .85rem;
      font-size: .7rem; color: var(--faint);
      font-family: monospace;
    }

    .demo-body { padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem; }

    .demo-agent-row {
      display: flex; align-items: center; gap: .75rem;
      font-size: .8rem; color: var(--muted);
    }
    .agent-step {
      display: flex; align-items: center; gap: .5rem;
      background: rgba(255,255,255,.04);
      border: 1px solid var(--border);
      border-radius: 8px;
      padding: .5rem .85rem;
      font-size: .75rem;
      color: var(--muted);
      transition: border-color .2s;
    }
    .agent-step.done { border-color: rgba(46,196,182,.3); color: var(--teal); }
    .agent-step.active { border-color: rgba(230,57,70,.4); color: var(--red2); }
    .agent-step svg { width: 13px; height: 13px; }
    .agent-arrow { color: var(--faint); flex-shrink: 0; }
    .agent-arrow svg { width: 14px; height: 14px; }

    .demo-match {
      background: var(--bg3);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 1rem 1.25rem;
      display: flex; align-items: center; gap: 1rem;
    }
    .demo-live-tag {
      display: flex; align-items: center; gap: 5px;
      background: rgba(230,57,70,.15);
      color: var(--red);
      font-size: .68rem; font-weight: 700;
      padding: .2rem .6rem; border-radius: 20px;
      white-space: nowrap;
    }
    .demo-match-teams {
      flex: 1;
      display: flex; align-items: center; justify-content: center; gap: .75rem;
      font-weight: 700; font-size: .95rem;
    }
    .demo-score {
      font-size: 1.1rem; font-weight: 900;
      color: var(--text);
      background: rgba(255,255,255,.06);
      padding: .2rem .7rem; border-radius: 6px;
    }
    .demo-links {
      display: flex; gap: .5rem;
    }
    .demo-link-pill {
      background: rgba(46,196,182,.1);
      border: 1px solid rgba(46,196,182,.2);
      color: var(--teal);
      font-size: .68rem; font-weight: 700;
      padding: .2rem .65rem; border-radius: 20px;
    }

    .demo-fb {
      background: rgba(24,119,242,.08);
      border: 1px solid rgba(24,119,242,.2);
      border-radius: 10px;
      padding: .75rem 1rem;
      font-size: .78rem; color: #7aaff0;
      display: flex; align-items: flex-start; gap: .6rem;
    }
    .demo-fb svg { width: 15px; height: 15px; flex-shrink: 0; margin-top: 1px; }

    /* ── SECTIONS ───────────────────────────── */
    .section { padding: 6rem 2rem; max-width: 1100px; margin: 0 auto; }

    .eyebrow {
      display: inline-flex; align-items: center; gap: .4rem;
      font-size: .7rem; text-transform: uppercase;
      letter-spacing: .1em; color: var(--red2);
      font-weight: 700; margin-bottom: 1rem;
    }
    .eyebrow::before { content: ''; width: 20px; height: 2px; background: var(--red); border-radius: 2px; }

    .section-title {
      font-size: clamp(2rem, 4vw, 3rem);
      font-weight: 900; letter-spacing: -.04em;
      line-height: 1.1; margin-bottom: 1rem;
    }
    .section-title .hl { color: var(--red); }
    .section-title .hlg { color: var(--gold); }

    .section-sub { color: var(--muted); font-size: 1rem; max-width: 520px; line-height: 1.8; }

    /* ── HOW IT WORKS ───────────────────────── */
    .how-bg { background: var(--bg2); border-radius: 24px; padding: 4rem; }

    .steps-grid {
      display: grid; grid-template-columns: repeat(4, 1fr);
      gap: 1.5rem; margin-top: 3.5rem;
      position: relative;
    }
    .steps-grid::before {
      content: '';
      position: absolute; top: 27px;
      right: calc(12.5% + 1rem); left: calc(12.5% + 1rem);
      height: 1px;
      background: repeating-linear-gradient(
        270deg, var(--border) 0, var(--border) 8px, transparent 8px, transparent 18px
      );
    }

    .step { text-align: center; }
    .step-num {
      width: 54px; height: 54px; border-radius: 50%;
      background: var(--red);
      color: white; font-weight: 900; font-size: 1.1rem;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 1.25rem;
      position: relative; z-index: 1;
      box-shadow: 0 8px 24px rgba(230,57,70,.35), 0 0 0 8px var(--bg2);
    }
    .step h3 { font-size: .95rem; font-weight: 700; margin-bottom: .5rem; }
    .step p { font-size: .82rem; color: var(--muted); line-height: 1.75; }

    /* ── FEATURES GRID ──────────────────────── */
    .features-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.25rem; margin-top: 3.5rem;
    }

    .feat {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 1.75rem;
      transition: transform .2s, border-color .2s;
      position: relative; overflow: hidden;
    }
    .feat::before {
      content: '';
      position: absolute; top: 0; right: 0; left: 0;
      height: 2px; background: transparent;
      transition: background .2s;
    }
    .feat:hover { transform: translateY(-4px); border-color: rgba(230,57,70,.25); }
    .feat:hover::before { background: var(--red); }
    .feat.featured { background: var(--red); border-color: var(--red); }
    .feat.featured p { color: rgba(255,255,255,.7); }

    .feat-icon {
      width: 42px; height: 42px; border-radius: 10px;
      background: rgba(230,57,70,.15);
      display: flex; align-items: center; justify-content: center;
      margin-bottom: 1.1rem;
    }
    .feat-icon svg { width: 19px; height: 19px; color: var(--red); }
    .feat.featured .feat-icon { background: rgba(255,255,255,.15); }
    .feat.featured .feat-icon svg { color: white; }

    .feat h3 { font-size: 1rem; font-weight: 700; margin-bottom: .5rem; }
    .feat p { font-size: .84rem; color: var(--muted); line-height: 1.75; }

    /* ── SPORTS COVERAGE ────────────────────── */
    .sports-row {
      display: grid; grid-template-columns: repeat(3, 1fr);
      gap: 1.25rem; margin-top: 3rem;
    }

    .sport-card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 2rem;
      text-align: center;
      transition: transform .2s, border-color .2s;
    }
    .sport-card:hover { transform: translateY(-4px); }
    .sport-card:nth-child(1):hover { border-color: rgba(46,196,182,.3); }
    .sport-card:nth-child(2):hover { border-color: rgba(244,162,97,.3); }
    .sport-card:nth-child(3):hover { border-color: rgba(74,144,226,.3); }

    .sport-emoji { font-size: 3rem; margin-bottom: 1rem; display: block; }
    .sport-card h3 { font-size: 1.15rem; font-weight: 700; margin-bottom: .5rem; }
    .sport-card p { font-size: .84rem; color: var(--muted); line-height: 1.7; }

    .sport-tags {
      display: flex; flex-wrap: wrap; justify-content: center;
      gap: .4rem; margin-top: 1rem;
    }
    .sport-tag {
      font-size: .68rem; font-weight: 600;
      padding: .25rem .7rem; border-radius: 20px;
      border: 1px solid var(--border);
      color: var(--muted);
    }

    /* ── TECH STACK ─────────────────────────── */
    .tech-grid {
      display: grid; grid-template-columns: repeat(4, 1fr);
      gap: 1rem; margin-top: 3rem;
    }
    .tech-card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 1.25rem;
      display: flex; align-items: center; gap: .75rem;
      transition: border-color .2s;
    }
    .tech-card:hover { border-color: rgba(230,57,70,.3); }
    .tech-dot {
      width: 36px; height: 36px; border-radius: 9px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.1rem; flex-shrink: 0;
    }
    .tech-info h4 { font-size: .85rem; font-weight: 700; }
    .tech-info p  { font-size: .72rem; color: var(--muted); }

    /* ── CTA BANNER ─────────────────────────── */
    .cta-section { padding: 0 2rem 6rem; }
    .cta-inner {
      background: var(--red);
      border-radius: 24px;
      padding: 5rem 3rem;
      text-align: center;
      position: relative; overflow: hidden;
    }
    .cta-inner::before {
      content: '';
      position: absolute; top: -40%; left: -10%;
      width: 500px; height: 500px;
      background: radial-gradient(circle, rgba(255,255,255,.12) 0%, transparent 70%);
      pointer-events: none;
    }
    .cta-inner h2 {
      font-size: clamp(2rem, 4vw, 3rem);
      font-weight: 900; color: white;
      letter-spacing: -.04em;
      margin-bottom: .75rem;
      position: relative; z-index: 1;
    }
    .cta-inner p {
      color: rgba(255,255,255,.7);
      font-size: 1.05rem;
      margin-bottom: 2.5rem;
      position: relative; z-index: 1;
    }
    .btn-white {
      display: inline-flex; align-items: center; gap: .5rem;
      background: white; color: var(--red);
      font-weight: 700; font-size: 1rem;
      padding: .9rem 2rem; border-radius: 11px;
      font-family: var(--font);
      position: relative; z-index: 1;
      transition: transform .2s, box-shadow .2s;
      box-shadow: 0 6px 24px rgba(0,0,0,.2);
    }
    .btn-white:hover { transform: translateY(-3px); box-shadow: 0 12px 36px rgba(0,0,0,.3); }

    /* ── CONTACT ────────────────────────────── */
    .contact-wrap {
      background: var(--bg2);
      border-radius: 24px;
      padding: 4rem;
      display: grid; grid-template-columns: 1fr 1.2fr;
      gap: 4rem;
    }

    .contact-left h2 {
      font-size: 2rem; font-weight: 900;
      letter-spacing: -.04em;
      margin-bottom: .75rem;
      line-height: 1.2;
    }
    .contact-left h2 .hl { color: var(--red); }
    .contact-left p { color: var(--muted); font-size: .9rem; line-height: 1.85; margin-bottom: 2rem; }

    .contact-info { display: flex; flex-direction: column; gap: 1rem; }
    .ci {
      display: flex; align-items: center; gap: .75rem;
      font-size: .87rem; color: var(--muted);
    }
    .ci-icon {
      width: 34px; height: 34px; border-radius: 8px;
      background: rgba(230,57,70,.1);
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }
    .ci-icon svg { width: 15px; height: 15px; color: var(--red); }

    /* Form */
    .fg { margin-bottom: 1.1rem; }
    .fl {
      display: block; font-size: .72rem; font-weight: 700;
      text-transform: uppercase; letter-spacing: .07em;
      margin-bottom: .45rem; color: var(--muted);
    }
    .fi, .ft, .fs {
      width: 100%;
      background: var(--bg3);
      border: 1.5px solid var(--border);
      border-radius: 10px;
      color: var(--text);
      font-family: var(--font);
      font-size: .9rem;
      padding: .85rem 1rem;
      outline: none;
      transition: border-color .2s, box-shadow .2s;
      appearance: none;
    }
    .fi::placeholder, .ft::placeholder { color: var(--faint); }
    .fi:focus, .ft:focus, .fs:focus {
      border-color: var(--red);
      box-shadow: 0 0 0 3px rgba(230,57,70,.12);
    }
    .ft { min-height: 130px; resize: vertical; }
    .fs option { background: var(--bg3); }

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

    .fsub {
      width: 100%; padding: .9rem;
      background: var(--red);
      color: white; border: none;
      border-radius: 10px;
      font-family: var(--font);
      font-weight: 700; font-size: .95rem;
      cursor: pointer;
      display: flex; align-items: center; justify-content: center; gap: .5rem;
      transition: transform .2s, box-shadow .2s;
      box-shadow: 0 4px 16px rgba(230,57,70,.3);
    }
    .fsub:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(230,57,70,.4); }
    .fsub svg { width: 16px; height: 16px; }

    .alert {
      border-radius: 10px; padding: 1rem 1.25rem;
      font-size: .875rem; margin-bottom: 1.25rem;
      display: flex; align-items: flex-start; gap: .5rem;
    }
    .alert svg { width: 18px; height: 18px; flex-shrink: 0; margin-top: 1px; }
    .alert-ok  { background: rgba(46,196,182,.08); border: 1px solid rgba(46,196,182,.2); color: var(--teal); }
    .alert-err { background: rgba(230,57,70,.08);  border: 1px solid rgba(230,57,70,.2);  color: var(--red2); }

    /* ── FOOTER ─────────────────────────────── */
    .footer {
      border-top: 1px solid var(--border);
      padding: 2.5rem 2.5rem;
      display: flex; align-items: center; justify-content: space-between;
      flex-wrap: wrap; gap: 1.5rem;
      max-width: 1200px; margin: 0 auto;
    }
    .footer-logo { font-size: 1.2rem; font-weight: 900; }
    .footer-logo em { color: var(--red); font-style: normal; }
    .footer-links { display: flex; gap: 2rem; flex-wrap: wrap; }
    .footer-links a { color: var(--muted); font-size: .85rem; transition: color .15s; }
    .footer-links a:hover { color: var(--red); }
    .footer-copy { color: var(--faint); font-size: .78rem; }

    /* ── ANIMATIONS ─────────────────────────── */
    @keyframes fadeUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
    .reveal { opacity:0; transform:translateY(28px); transition: opacity .6s ease, transform .6s ease; }
    .reveal.visible { opacity:1; transform:translateY(0); }

    /* ── RESPONSIVE ─────────────────────────── */
    @media(max-width:900px){
      .nav { padding: 0 1.25rem; }
      .nav-links { display: none; }
      .steps-grid { grid-template-columns: repeat(2,1fr); }
      .steps-grid::before { display: none; }
      .features-grid { grid-template-columns: repeat(2,1fr); }
      .sports-row { grid-template-columns: 1fr; }
      .tech-grid { grid-template-columns: repeat(2,1fr); }
      .contact-wrap { grid-template-columns: 1fr; gap: 2.5rem; padding: 2rem; }
      .how-bg { padding: 2rem; }
    }
    @media(max-width:600px){
      .features-grid { grid-template-columns: 1fr; }
      .steps-grid { grid-template-columns: 1fr; }
      .tech-grid { grid-template-columns: 1fr 1fr; }
      .form-row { grid-template-columns: 1fr; }
      .hero-stats { flex-direction: column; border-radius: 16px; }
      .hstat-div { width: 60px; height: 1px; }
      .hero-actions { flex-direction: column; align-items: stretch; text-align: center; }
      .cta-inner { padding: 3rem 1.5rem; }
    }
  </style>
</head>
<body>

<!-- NAV -->
<nav class="nav">
  <a href="/" class="nav-logo">
    <div class="nav-logo-icon">📺</div>
    ملعب <em>لايف</em>
  </a>
  <div class="nav-links">
    <a href="#how">كيف يعمل</a>
    <a href="#features">المميزات</a>
    <a href="#sports">الرياضات</a>
    <a href="#tech">التقنية</a>
    <a href="#contact">تواصل معنا</a>
    <a href="/dashboard" class="nav-cta">لوحة التحكم ←</a>
  </div>
  <div class="live-pill">
    <div class="pulse"></div>
    بث مباشر الآن
  </div>
</nav>

<!-- HERO -->
<header class="hero">
  <div class="hero-bg"></div>
  <div class="hero-grid"></div>

  <div class="hero-eyebrow">
    <i data-lucide="zap"></i>
    وكيل ذكاء اصطناعي رياضي
  </div>

  <h1>
    مباريات حية.<br>
    <span class="accent">بث تلقائي.</span>
    <span class="accent2">فيسبوك فوراً.</span>
  </h1>

  <p class="hero-sub">
    وكيل ذكاء اصطناعي يجلب أحداث الرياضة الحية، يبحث عن روابط البث على الإنترنت،
    ينشئ صفحات المباريات تلقائياً، وينشر على فيسبوك بالعربية — كل 15 دقيقة بدون تدخل بشري.
  </p>

  <div class="hero-actions">
    <a href="#contact" class="btn-primary">
      <i data-lucide="rocket"></i>
      ابدأ الآن مجاناً
    </a>
    <a href="#how" class="btn-ghost">
      <i data-lucide="play-circle"></i>
      كيف يعمل؟
    </a>
  </div>

  <div class="hero-stats">
    <div class="hstat">
      <strong>3</strong>
      <span>رياضات مدعومة</span>
    </div>
    <div class="hstat-div"></div>
    <div class="hstat">
      <strong>15د</strong>
      <span>دورة تحديث تلقائي</span>
    </div>
    <div class="hstat-div"></div>
    <div class="hstat">
      <strong>100%</strong>
      <span>محتوى عربي</span>
    </div>
    <div class="hstat-div"></div>
    <div class="hstat">
      <strong>∞</strong>
      <span>مباريات يومياً</span>
    </div>
  </div>

  <!-- Demo Window -->
  <div class="hero-demo">
    <div class="demo-win">
      <div class="demo-bar">
        <div class="d-dot"></div>
        <div class="d-dot"></div>
        <div class="d-dot"></div>
        <div class="demo-url">malab.live/dashboard</div>
      </div>
      <div class="demo-body">

        <!-- Agent pipeline steps -->
        <div class="demo-agent-row">
          <div class="agent-step done"><i data-lucide="check-circle"></i> جلب المباريات</div>
          <div class="agent-arrow"><i data-lucide="arrow-left"></i></div>
          <div class="agent-step done"><i data-lucide="check-circle"></i> البحث عن روابط البث</div>
          <div class="agent-arrow"><i data-lucide="arrow-left"></i></div>
          <div class="agent-step active"><i data-lucide="loader"></i> نشر على فيسبوك</div>
          <div class="agent-arrow"><i data-lucide="arrow-left"></i></div>
          <div class="agent-step"><i data-lucide="message-circle"></i> تعليق على الصفحات</div>
        </div>

        <!-- Live match card -->
        <div class="demo-match">
          <div class="demo-live-tag"><div class="pulse"></div> مباشر</div>
          <div class="demo-match-teams">
            <span>ريال مدريد</span>
            <div class="demo-score">2 - 1</div>
            <span>برشلونة</span>
          </div>
          <div class="demo-links">
            <div class="demo-link-pill">HD ×3</div>
            <div class="demo-link-pill">FHD ×1</div>
          </div>
        </div>

        <!-- Facebook post preview -->
        <div class="demo-fb">
          <i data-lucide="facebook"></i>
          <span>
            <strong style="color:#7aaff0">منشور فيسبوك تلقائي:</strong>
            ⚽ الآن مباشرة | ريال مدريد 🆚 برشلونة | الدوري الإسباني
            📺 شاهد المباراة مجاناً الآن 👉 malab.live/match/real-madrid-vs-barcelona
          </span>
        </div>

      </div>
    </div>
  </div>
</header>

<!-- HOW IT WORKS -->
<section id="how" class="section">
  <div class="how-bg reveal">
    <p class="eyebrow">كيف يعمل</p>
    <h2 class="section-title">من المباراة إلى <span class="hl">فيسبوك</span><br>في 4 خطوات تلقائية</h2>
    <div class="steps-grid">
      <div class="step">
        <div class="step-num">01</div>
        <h3>جلب المباريات الحية</h3>
        <p>الوكيل يستعلم api-sports.io كل 15 دقيقة ليجلب مباريات كرة القدم، كرة السلة، والتنس الحية والقادمة.</p>
      </div>
      <div class="step">
        <div class="step-num">02</div>
        <h3>البحث عن روابط البث</h3>
        <p>يفحص الوكيل أشهر مواقع البث العربية والدولية تلقائياً ويستخرج روابط المشاهدة الحية.</p>
      </div>
      <div class="step">
        <div class="step-num">03</div>
        <h3>إنشاء صفحة المباراة</h3>
        <p>ينشئ صفحة عربية جاهزة لكل مباراة مع جميع روابط البث مرتبة حسب الجودة، ومتاحة للمشاهدين مجاناً.</p>
      </div>
      <div class="step">
        <div class="step-num">04</div>
        <h3>النشر التلقائي على فيسبوك</h3>
        <p>ينشر منشوراً عربياً جذاباً على صفحتك، ويعلّق على أشهر صفحات الرياضة لجلب أكبر عدد من المشاهدين.</p>
      </div>
    </div>
  </div>
</section>

<!-- FEATURES -->
<section id="features" class="section" style="padding-top:0">
  <div class="reveal">
    <p class="eyebrow">المميزات</p>
    <h2 class="section-title">كل ما تحتاجه لإدارة<br>منصة بث <span class="hl">احترافية</span></h2>
    <p class="section-sub">نظام متكامل يعمل تلقائياً على مدار الساعة دون أي تدخل يدوي.</p>
  </div>
  <div class="features-grid reveal">
    <div class="feat">
      <div class="feat-icon"><i data-lucide="bot"></i></div>
      <h3>وكيل ذكاء اصطناعي</h3>
      <p>يعمل بشكل مستقل كل 15 دقيقة — يجلب، يبحث، ينشئ الصفحات، وينشر دون أي تدخل.</p>
    </div>
    <div class="feat featured">
      <div class="feat-icon"><i data-lucide="globe"></i></div>
      <h3>واجهة عربية كاملة</h3>
      <p>موقع RTL بالكامل مع أسماء الفرق والدوريات بالعربية، مصمم لجمهور المشاهدين العرب.</p>
    </div>
    <div class="feat">
      <div class="feat-icon"><i data-lucide="facebook"></i></div>
      <h3>أتمتة فيسبوك</h3>
      <p>نشر تلقائي على صفحتك + تعليق على صفحات الرياضة الشهيرة مع رابط المشاهدة.</p>
    </div>
    <div class="feat">
      <div class="feat-icon"><i data-lucide="eye"></i></div>
      <h3>تتبع المشاهدات</h3>
      <p>إحصاء دقيق للمشاهدات لكل مباراة مع لوحة تحكم تعرض الأكثر مشاهدة والإحصاءات الحية.</p>
    </div>
    <div class="feat">
      <div class="feat-icon"><i data-lucide="shield"></i></div>
      <h3>لوحة تحكم محمية</h3>
      <p>تسجيل دخول بكلمة مرور مشفرة bcrypt، جلسات آمنة، محمية تماماً من الوصول العام.</p>
    </div>
    <div class="feat">
      <div class="feat-icon"><i data-lucide="zap"></i></div>
      <h3>سريع ومحسّن للـ SEO</h3>
      <p>صفحات مباريات خفيفة مع عناوين وصفية كاملة محسّنة لمحركات البحث العربية.</p>
    </div>
  </div>
</section>

<!-- SPORTS -->
<section id="sports" class="section" style="padding-top:0">
  <div class="reveal">
    <p class="eyebrow">الرياضات المدعومة</p>
    <h2 class="section-title">ثلاث رياضات،<br>مصدر واحد <span class="hlg">api-sports.io</span></h2>
    <p class="section-sub">مفتاح API واحد من api-sports.io يغطي الرياضات الثلاث بالكامل.</p>
  </div>
  <div class="sports-row reveal">
    <div class="sport-card">
      <span class="sport-emoji">⚽</span>
      <h3>كرة القدم</h3>
      <p>جميع الدوريات الكبرى والبطولات الدولية — الدوري الإنجليزي، الإسباني، الأبطال، وأكثر.</p>
      <div class="sport-tags">
        <span class="sport-tag">الدوري الإنجليزي</span>
        <span class="sport-tag">لا ليغا</span>
        <span class="sport-tag">دوري الأبطال</span>
        <span class="sport-tag">الدوري الإيطالي</span>
      </div>
    </div>
    <div class="sport-card">
      <span class="sport-emoji">🏀</span>
      <h3>كرة السلة</h3>
      <p>مباريات NBA الحية يومياً مع أسماء الفرق والنتائج الفورية والروابط المباشرة.</p>
      <div class="sport-tags">
        <span class="sport-tag">NBA</span>
        <span class="sport-tag">لوس أنجلوس ليكرز</span>
        <span class="sport-tag">جولدن ستيت</span>
      </div>
    </div>
    <div class="sport-card">
      <span class="sport-emoji">🎾</span>
      <h3>كرة المضرب</h3>
      <p>بطولات ATP وWTA الكبرى — ويمبلدون، فرنسا المفتوحة، أمريكا المفتوحة وأستراليا.</p>
      <div class="sport-tags">
        <span class="sport-tag">ويمبلدون</span>
        <span class="sport-tag">Roland Garros</span>
        <span class="sport-tag">US Open</span>
      </div>
    </div>
  </div>
</section>

<!-- TECH STACK -->
<section id="tech" class="section" style="padding-top:0">
  <div class="reveal">
    <p class="eyebrow">التقنيات المستخدمة</p>
    <h2 class="section-title">مبني على تقنيات <span class="hl">حديثة وموثوقة</span></h2>
  </div>
  <div class="tech-grid reveal">
    <div class="tech-card">
      <div class="tech-dot" style="background:rgba(83,158,66,.15)">🟢</div>
      <div class="tech-info"><h4>Node.js</h4><p>الخادم الرئيسي + الوكيل</p></div>
    </div>
    <div class="tech-card">
      <div class="tech-dot" style="background:rgba(0,115,216,.15)">⚡</div>
      <div class="tech-info"><h4>Express.js</h4><p>API + المسارات والجلسات</p></div>
    </div>
    <div class="tech-card">
      <div class="tech-dot" style="background:rgba(230,57,70,.15)">🕐</div>
      <div class="tech-info"><h4>node-cron</h4><p>جدولة الوكيل كل 15 دقيقة</p></div>
    </div>
    <div class="tech-card">
      <div class="tech-dot" style="background:rgba(244,162,97,.15)">🔍</div>
      <div class="tech-info"><h4>Cheerio + Axios</h4><p>تجريف روابط البث</p></div>
    </div>
    <div class="tech-card">
      <div class="tech-dot" style="background:rgba(24,119,242,.15)">📘</div>
      <div class="tech-info"><h4>Facebook Graph API</h4><p>النشر التلقائي والتعليقات</p></div>
    </div>
    <div class="tech-card">
      <div class="tech-dot" style="background:rgba(46,196,182,.15)">📡</div>
      <div class="tech-info"><h4>api-sports.io</h4><p>بيانات المباريات الحية</p></div>
    </div>
    <div class="tech-card">
      <div class="tech-dot" style="background:rgba(155,93,229,.15)">🔐</div>
      <div class="tech-info"><h4>bcrypt + Sessions</h4><p>مصادقة آمنة للوحة التحكم</p></div>
    </div>
    <div class="tech-card">
      <div class="tech-dot" style="background:rgba(139,156,200,.15)">🎨</div>
      <div class="tech-info"><h4>EJS Templates</h4><p>واجهة عربية RTL ديناميكية</p></div>
    </div>
  </div>
</section>

<!-- CTA -->
<div class="cta-section reveal">
  <div class="cta-inner">
    <h2>ابدأ بث مبارياتك<br>تلقائياً اليوم</h2>
    <p>جهّز المنصة مرة واحدة — الوكيل يعمل لك 24/7 بدون توقف.</p>
    <a href="#contact" class="btn-white">
      <i data-lucide="send"></i>
      تواصل معنا للبدء
    </a>
  </div>
</div>

<!-- CONTACT -->
<section id="contact" class="section">
  <div class="contact-wrap reveal">
    <div class="contact-left">
      <p class="eyebrow">تواصل معنا</p>
      <h2>لديك سؤال؟<br><span class="hl">نحن هنا</span> للمساعدة</h2>
      <p>
        هل تريد نشر ملعب لايف على موقعك؟ تريد تخصيصاً خاصاً؟
        أو تحتاج دعم تقني؟ راسلنا وسنرد خلال 24 ساعة.
      </p>
      <div class="contact-info">
        <div class="ci">
          <div class="ci-icon"><i data-lucide="mail"></i></div>
          <span>contact@develop-it.tech</span>
        </div>
        <div class="ci">
          <div class="ci-icon"><i data-lucide="globe"></i></div>
          <span>develop-it.tech</span>
        </div>
        <div class="ci">
          <div class="ci-icon"><i data-lucide="map-pin"></i></div>
          <span>المغرب — الدار البيضاء</span>
        </div>
        <div class="ci">
          <div class="ci-icon"><i data-lucide="clock"></i></div>
          <span>الرد خلال 24 ساعة</span>
        </div>
      </div>
    </div>

    <div class="contact-right">
      <?php if (!empty($success_message)): ?>
      <div class="alert alert-ok">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <?= $success_message ?>
      </div>
      <?php endif; ?>
      <?php if (!empty($error_message)): ?>
      <div class="alert alert-err">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <?= $error_message ?>
      </div>
      <?php endif; ?>

      <form method="POST" action="#contact">
        <div class="form-row">
          <div class="fg">
            <label class="fl" for="fname">الاسم *</label>
            <input class="fi" type="text" id="fname" name="name" required
              value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
              placeholder="اسمك الكامل"/>
          </div>
          <div class="fg">
            <label class="fl" for="fphone">رقم الهاتف</label>
            <input class="fi" type="tel" id="fphone" name="phone"
              value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
              placeholder="اختياري"/>
          </div>
        </div>
        <div class="fg">
          <label class="fl" for="femail">البريد الإلكتروني *</label>
          <input class="fi" type="email" id="femail" name="email" required
            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
            placeholder="email@example.com"/>
        </div>
        <div class="fg">
          <label class="fl" for="fsubject">الموضوع *</label>
          <select class="fs" id="fsubject" name="subject" required>
            <option value="" disabled <?= empty($_POST['subject']) ? 'selected' : '' ?>>اختر موضوعاً...</option>
            <option value="استفسار عام"       <?= (($_POST['subject']??'')==='استفسار عام')       ?'selected':'' ?>>استفسار عام</option>
            <option value="طلب تثبيت المنصة" <?= (($_POST['subject']??'')==='طلب تثبيت المنصة') ?'selected':'' ?>>طلب تثبيت المنصة</option>
            <option value="دعم تقني"          <?= (($_POST['subject']??'')==='دعم تقني')          ?'selected':'' ?>>دعم تقني</option>
            <option value="تخصيص وإضافات"    <?= (($_POST['subject']??'')==='تخصيص وإضافات')    ?'selected':'' ?>>تخصيص وإضافات</option>
            <option value="شراكة تجارية"     <?= (($_POST['subject']??'')==='شراكة تجارية')     ?'selected':'' ?>>شراكة تجارية</option>
            <option value="أخرى"              <?= (($_POST['subject']??'')==='أخرى')              ?'selected':'' ?>>أخرى</option>
          </select>
        </div>
        <div class="fg">
          <label class="fl" for="fmessage">رسالتك *</label>
          <textarea class="ft" id="fmessage" name="message" required
            placeholder="اشرح ما تحتاجه..."><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
        </div>
        <button type="submit" name="submit_contact" class="fsub">
          <i data-lucide="send"></i>
          إرسال الرسالة
        </button>
      </form>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="footer">
    <div class="footer-logo">ملعب <em>لايف</em></div>
    <nav class="footer-links">
      <a href="#how">كيف يعمل</a>
      <a href="#features">المميزات</a>
      <a href="#sports">الرياضات</a>
      <a href="#contact">تواصل معنا</a>
      <a href="/dashboard">لوحة التحكم</a>
    </nav>
    <p class="footer-copy">© <?= date('Y') ?> ملعب لايف · develop-it.tech</p>
  </div>
</footer>

<script>
  lucide.createIcons();

  // Scroll reveal
  const obs = new IntersectionObserver((entries) => {
    entries.forEach((e, i) => {
      if (e.isIntersecting) {
        setTimeout(() => e.target.classList.add('visible'), i * 90);
        obs.unobserve(e.target);
      }
    });
  }, { threshold: 0.08, rootMargin: '0px 0px -50px 0px' });
  document.querySelectorAll('.reveal').forEach(el => obs.observe(el));

  <?php if (!empty($success_message) || !empty($error_message)): ?>
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('#contact').scrollIntoView({ behavior: 'smooth' });
  });
  <?php endif; ?>
</script>
</body>
</html>