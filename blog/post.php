<?php
require_once __DIR__ . '/../config.php';
$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$db->set_charset('utf8mb4');

$slug = $db->real_escape_string($_GET['slug'] ?? '');
$post = $db->query("SELECT * FROM blogs WHERE slug='$slug' AND status='published'")->fetch_assoc();
if (!$post) {
    http_response_code(404);
    die('Article introuvable');
}

$canonical = "https://develop-it.tech/blog/post.php?slug=" . urlencode($slug);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="/logo.jfif">
    <link rel="icon" type="image/png" sizes="16x16" href="/logo.jfif">
    <link rel="apple-touch-icon" href="/logo.jfif">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO -->
    <title><?= htmlspecialchars($post['meta_title'] ?: $post['title']) ?> — DEVELOP IT</title>
    <meta name="description" content="<?= htmlspecialchars($post['meta_description'] ?: $post['excerpt']) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($post['meta_keywords']) ?>">
    <meta name="author" content="<?= htmlspecialchars($post['author']) ?>">
    <meta name="robots" content="index, follow">
    <meta name="google-adsense-account" content="<?= htmlspecialchars(ADSENSE_CLIENT_ID) ?>">
    <link rel="canonical" href="<?= $canonical ?>">

    <!-- Open Graph -->
    <meta property="og:type" content="article">
    <meta property="og:title" content="<?= htmlspecialchars($post['title']) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($post['excerpt']) ?>">
    <meta property="og:url" content="<?= $canonical ?>">
    <meta property="og:image" content="<?= htmlspecialchars($post['cover_image']) ?>">
    <meta property="og:site_name" content="DEVELOP IT">
    <meta property="article:published_time" content="<?= $post['created_at'] ?>">
    <meta property="article:author" content="DEVELOP IT">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($post['title']) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($post['excerpt']) ?>">
    <meta name="twitter:image" content="<?= htmlspecialchars($post['cover_image']) ?>">

    <!-- Schema.org Article -->
    <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Article",
    "headline": "<?= addslashes($post['title']) ?>",
    "description": "<?= addslashes($post['excerpt']) ?>",
    "image": "<?= $post['cover_image'] ?>",
    "author": { "@type": "Organization", "name": "DEVELOP IT", "url": "https://develop-it.tech" },
    "publisher": {
      "@type": "Organization",
      "name": "DEVELOP IT",
      "logo": { "@type": "ImageObject", "url": "https://develop-it.tech/logo.jfif" }
    },
    "datePublished": "<?= $post['created_at'] ?>",
    "dateModified": "<?= $post['updated_at'] ?>",
    "mainEntityOfPage": { "@type": "WebPage", "@id": "<?= $canonical ?>" }
  }
  </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap"></noscript>
    <style>
        body{font-family:'Inter',system-ui,-apple-system,sans-serif;}
        .prose h2 {
            font-size: 1.6rem;
            font-weight: 700;
            margin: 2rem 0 1rem;
            color: #1e293b;
        }

        .prose h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 1.5rem 0 0.75rem;
            color: #334155;
        }

        .prose p {
            margin-bottom: 1.25rem;
            line-height: 1.8;
            color: #475569;
        }

        .prose ul {
            list-style: disc;
            padding-left: 1.5rem;
            margin-bottom: 1.25rem;
            color: #475569;
        }

        .prose ol {
            list-style: decimal;
            padding-left: 1.5rem;
            margin-bottom: 1.25rem;
            color: #475569;
        }

        .prose li {
            margin-bottom: 0.4rem;
        }

        .prose strong {
            color: #1e293b;
            font-weight: 600;
        }

        .prose blockquote {
            border-left: 4px solid #3b82f6;
            padding: 0.5rem 1.25rem;
            background: #eff6ff;
            border-radius: 0 8px 8px 0;
            margin: 1.5rem 0;
            color: #1e40af;
            font-style: italic;
        }

        .prose code {
            background: #f1f5f9;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.9em;
            color: #7c3aed;
        }

        .prose a {
            color: #2563eb;
            text-decoration: underline;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">

    <?php include '../nav.php'; ?>

    <main class="pt-28 pb-24">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col lg:flex-row gap-12">

                <!-- Article -->
                <article class="flex-1 min-w-0">

                    <!-- Breadcrumb -->
                    <nav class="text-sm text-slate-400 mb-6">
                        <a href="/" class="hover:text-blue-600">Accueil</a>
                        <span class="mx-2">/</span>
                        <a href="/blog/" class="hover:text-blue-600">Blog</a>
                        <span class="mx-2">/</span>
                        <span class="text-slate-600"><?= htmlspecialchars(mb_substr($post['title'], 0, 50)) ?>...</span>
                    </nav>

                    <!-- Cover -->
                    <img src="<?= htmlspecialchars($post['cover_image'] ?: 'https://images.unsplash.com/photo-1677442135703-1787eea5ce01?w=1200&q=80') ?>"
                        class="w-full h-72 md:h-96 object-cover rounded-2xl mb-8 shadow-sm"
                        alt="<?= htmlspecialchars($post['title']) ?>">

                    <!-- Meta -->
                    <div class="flex items-center gap-4 text-sm text-slate-400 mb-4">
                        <span class="bg-blue-100 text-blue-700 font-semibold px-3 py-1 rounded-full text-xs">Tech &
                            IA</span>
                        <span><?= date('d M Y', strtotime($post['created_at'])) ?></span>
                        <span>par <strong
                                class="text-slate-600"><?= htmlspecialchars($post['author']) ?></strong></span>
                    </div>

                    <!-- Title -->
                    <h1 class="text-3xl md:text-4xl font-bold text-slate-900 leading-tight mb-6">
                        <?= htmlspecialchars($post['title']) ?>
                    </h1>

                    <!-- Excerpt -->
                    <p class="text-xl text-slate-500 leading-relaxed mb-8 pb-8 border-b border-slate-100">
                        <?= htmlspecialchars($post['excerpt']) ?>
                    </p>

                    <?php if (ADSENSE_CLIENT_ID && ADSENSE_SLOT_POST_TOP): ?>
                    <!-- AdSense — above content -->
                    <div class="my-6">
                        <ins class="adsbygoogle"
                             style="display:block"
                             data-ad-client="<?= htmlspecialchars(ADSENSE_CLIENT_ID) ?>"
                             data-ad-slot="<?= htmlspecialchars(ADSENSE_SLOT_POST_TOP) ?>"
                             data-ad-format="auto"
                             data-full-width-responsive="true"></ins>
                        <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
                    </div>
                    <?php endif; ?>

                    <!-- Content -->
                    <div class="prose max-w-none">
                        <?= $post['content'] /* HTML content from AI */ ?>
                    </div>

                    <?php if (ADSENSE_CLIENT_ID && ADSENSE_SLOT_POST_BOTTOM): ?>
                    <!-- AdSense — below content -->
                    <div class="my-8">
                        <ins class="adsbygoogle"
                             style="display:block"
                             data-ad-client="<?= htmlspecialchars(ADSENSE_CLIENT_ID) ?>"
                             data-ad-slot="<?= htmlspecialchars(ADSENSE_SLOT_POST_BOTTOM) ?>"
                             data-ad-format="auto"
                             data-full-width-responsive="true"></ins>
                        <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
                    </div>
                    <?php endif; ?>

                    <!-- Share -->
                    <div class="mt-12 pt-8 border-t border-slate-100">
                        <p class="font-semibold text-slate-700 mb-4">Partager cet article</p>
                        <div class="flex gap-3">
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode($canonical) ?>"
                                target="_blank"
                                class="flex items-center gap-2 bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-blue-800 transition">
                                LinkedIn
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?= urlencode($canonical) ?>&text=<?= urlencode($post['title']) ?>"
                                target="_blank"
                                class="flex items-center gap-2 bg-slate-900 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-black transition">
                                Twitter / X
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($canonical) ?>"
                                target="_blank"
                                class="flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-blue-700 transition">
                                Facebook
                            </a>
                        </div>
                    </div>

                </article>

                <!-- Sidebar -->
                <div class="lg:w-80 flex-shrink-0">
                    <?php include 'sidebar.php'; ?>
                </div>

            </div>
        </div>
    </main>

    <?php include '../footer.php'; ?>
</body>

</html>