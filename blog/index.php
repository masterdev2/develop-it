<?php
require_once __DIR__ . '/../config.php';
$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$db->set_charset('utf8mb4');

$page = max(1, (int) ($_GET['page'] ?? 1));
$limit = 9;
$offset = ($page - 1) * $limit;

$total = $db->query("SELECT COUNT(*) FROM blogs WHERE status='published'")->fetch_row()[0];
$pages = ceil($total / $limit);
$result = $db->query("SELECT * FROM blogs WHERE status='published' ORDER BY created_at DESC LIMIT $limit OFFSET $offset");
$blogs = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog — DEVELOP IT | Actualités Tech & IA</title>
    <meta name="description"
        content="Découvrez les dernières tendances en développement informatique, intelligence artificielle et transformation digitale par DEVELOP IT.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://develop-it.tech/blog/">
    <meta property="og:title" content="Blog DEVELOP IT — Tech, IA & Transformation Digitale">
    <meta property="og:description" content="Articles sur le développement web, l'IA et la transformation digitale.">
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://develop-it.tech/logo.jfif">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Blog DEVELOP IT — Tech, IA & Transformation Digitale">
    <meta name="twitter:description" content="Articles sur le développement web, l'IA et la transformation digitale.">
    <script type="application/ld+json">
    {
      "@context":"https://schema.org",
      "@type":"Blog",
      "@id":"https://develop-it.tech/blog/",
      "name":"Blog DEVELOP IT",
      "description":"Actualités tech, IA et transformation digitale par l'équipe DEVELOP IT.",
      "url":"https://develop-it.tech/blog/",
      "publisher":{"@type":"Organization","name":"DEVELOP IT","url":"https://develop-it.tech","logo":{"@type":"ImageObject","url":"https://develop-it.tech/logo.jfif"}},
      "breadcrumb":{"@type":"BreadcrumbList","itemListElement":[
        {"@type":"ListItem","position":1,"name":"Accueil","item":"https://develop-it.tech"},
        {"@type":"ListItem","position":2,"name":"Blog","item":"https://develop-it.tech/blog/"}
      ]}
    }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap"></noscript>
    <link rel="preload" as="style" href="https://unpkg.com/aos@2.3.1/dist/aos.css" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css"></noscript>
    <style>body{font-family:'Inter',system-ui,-apple-system,sans-serif;}</style>
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="/logo.jfif">
    <link rel="icon" type="image/png" sizes="16x16" href="/logo.jfif">
    <link rel="apple-touch-icon" href="/logo.jfif">
</head>

<body class="bg-slate-50 text-slate-800">

    <?php include '../nav.php'; // your existing nav ?>

    <main class="pt-28 pb-24">
        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-14">
                <nav class="text-sm text-slate-400 mb-4 flex justify-center gap-2" aria-label="Fil d'Ariane">
                    <a href="/" class="hover:text-blue-600 transition">Accueil</a>
                    <span>/</span>
                    <span class="text-slate-600">Blog</span>
                </nav>
                <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider">Blog</span>
                <h1 class="text-4xl md:text-5xl font-bold mt-3 mb-4">Actualités & Insights</h1>
                <p class="text-slate-500 text-lg">Tech, IA et transformation digitale — par l'équipe DEVELOP IT</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-10">

                <!-- Posts grid -->
                <div class="flex-1">
                    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-7">
                        <?php foreach ($blogs as $b): ?>
                            <article
                                class="bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col"
                                data-aos="fade-up">
                                <a href="/blog/post.php?slug=<?= urlencode($b['slug']) ?>">
                                    <img src="<?= htmlspecialchars($b['cover_image'] ?: 'https://images.unsplash.com/photo-1677442135703-1787eea5ce01?w=600&q=60') ?>"
                                        class="w-full h-44 object-cover" alt="<?= htmlspecialchars($b['title']) ?>">
                                </a>
                                <div class="p-5 flex flex-col flex-1">
                                    <p class="text-xs text-slate-400 mb-2">
                                        <?= date('d M Y', strtotime($b['created_at'])) ?>
                                    </p>
                                    <h2 class="font-bold text-slate-800 mb-2 leading-snug">
                                        <a href="/blog/post.php?slug=<?= urlencode($b['slug']) ?>"
                                            class="hover:text-blue-600 transition">
                                            <?= htmlspecialchars($b['title']) ?>
                                        </a>
                                    </h2>
                                    <p class="text-slate-500 text-sm flex-1 leading-relaxed">
                                        <?= htmlspecialchars(mb_substr($b['excerpt'], 0, 120)) ?>...
                                    </p>
                                    <a href="/blog/post.php?slug=<?= urlencode($b['slug']) ?>"
                                        class="mt-4 inline-flex items-center gap-1 text-blue-600 text-sm font-semibold hover:gap-2 transition-all">
                                        Lire l'article →
                                    </a>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <!-- Pagination -->
                    <?php if ($pages > 1): ?>
                        <div class="flex justify-center gap-2 mt-12">
                            <?php for ($i = 1; $i <= $pages; $i++): ?>
                                <a href="?page=<?= $i ?>"
                                    class="w-10 h-10 flex items-center justify-center rounded-xl border font-semibold text-sm transition
                    <?= $i === $page ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-slate-600 border-slate-200 hover:border-blue-400' ?>">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Sidebar -->
                <div class="lg:w-80 flex-shrink-0">
                    <?php include 'sidebar.php'; ?>
                </div>

            </div>
        </div>
    </main>

    <?php include '../footer.php'; ?>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js" defer></script>
    <script>document.addEventListener('DOMContentLoaded',function(){if(typeof AOS!=='undefined')AOS.init({duration:800,once:true});});</script>
</body>

</html>