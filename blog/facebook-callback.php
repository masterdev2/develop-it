<?php
/**
 * Facebook Page Access Token Helper
 * ───────────────────────────────────────────────────────────────────────────
 * This page guides you through the 3-step OAuth flow to obtain a long-lived
 * Facebook Page Access Token for auto-posting.
 *
 * Required .env keys: FACEBOOK_APP_ID, FACEBOOK_APP_SECRET, SITE_URL
 * After completing the flow, copy the Page Access Token into .env as
 * FACEBOOK_PAGE_ACCESS_TOKEN and the Page ID as FACEBOOK_PAGE_ID.
 *
 * ACCESS: Restrict this page in production (or delete it after setup).
 */

require_once __DIR__ . '/../config.php';

$appId       = FACEBOOK_APP_ID;
$appSecret   = FACEBOOK_APP_SECRET;
$redirectUri = SITE_URL . '/blog/facebook-callback.php';
$graphVer    = 'v19.0';

$error  = null;
$step   = 'start';
$result = [];

// ── Handle OAuth callback (code present) ────────────────────────────────────
if (isset($_GET['code'])) {
    $step = 'exchange';

    // 1. Exchange authorization code → short-lived user token
    $tokenUrl = "https://graph.facebook.com/{$graphVer}/oauth/access_token?" . http_build_query([
        'client_id'     => $appId,
        'client_secret' => $appSecret,
        'redirect_uri'  => $redirectUri,
        'code'          => $_GET['code'],
    ]);

    $ch = curl_init($tokenUrl);
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_SSL_VERIFYPEER => false, CURLOPT_TIMEOUT => 15]);
    $shortTokenData = json_decode(curl_exec($ch), true);
    curl_close($ch);

    if (empty($shortTokenData['access_token'])) {
        $error = 'Step 1 failed — could not get short-lived token: ' . json_encode($shortTokenData);
    } else {
        $shortToken = $shortTokenData['access_token'];

        // 2. Exchange short-lived user token → long-lived user token (60 days)
        $llUrl = "https://graph.facebook.com/{$graphVer}/oauth/access_token?" . http_build_query([
            'grant_type'        => 'fb_exchange_token',
            'client_id'         => $appId,
            'client_secret'     => $appSecret,
            'fb_exchange_token' => $shortToken,
        ]);

        $ch = curl_init($llUrl);
        curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_SSL_VERIFYPEER => false, CURLOPT_TIMEOUT => 15]);
        $longTokenData = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if (empty($longTokenData['access_token'])) {
            $error = 'Step 2 failed — could not get long-lived user token: ' . json_encode($longTokenData);
        } else {
            $longUserToken = $longTokenData['access_token'];

            // 3. Get managed pages and their never-expiring page access tokens
            $pagesUrl = "https://graph.facebook.com/{$graphVer}/me/accounts?access_token=" . urlencode($longUserToken);

            $ch = curl_init($pagesUrl);
            curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_SSL_VERIFYPEER => false, CURLOPT_TIMEOUT => 15]);
            $pagesData = json_decode(curl_exec($ch), true);
            curl_close($ch);

            $result = [
                'long_user_token' => $longUserToken,
                'expires_in'      => $longTokenData['expires_in'] ?? 'unknown',
                'pages'           => $pagesData['data'] ?? [],
            ];
            $step = 'done';
        }
    }
} elseif (isset($_GET['error'])) {
    $error = 'OAuth error: ' . htmlspecialchars($_GET['error_description'] ?? $_GET['error']);
}

// Build the authorization URL
$authUrl = "https://www.facebook.com/{$graphVer}/dialog/oauth?" . http_build_query([
    'client_id'     => $appId,
    'redirect_uri'  => $redirectUri,
    'scope'         => 'pages_manage_posts,pages_read_engagement,pages_show_list',
    'response_type' => 'code',
]);

$configured = $appId && $appSecret;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facebook Page Token Setup — DEVELOP IT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body{font-family:system-ui,sans-serif;}</style>
</head>
<body class="bg-slate-900 min-h-screen flex items-start justify-center pt-16 pb-16 px-4">
<div class="w-full max-w-2xl space-y-6">

    <!-- Header -->
    <div class="text-center">
        <div class="text-4xl mb-3">🔵</div>
        <h1 class="text-2xl font-bold text-white mb-1">Facebook Page Token Setup</h1>
        <p class="text-slate-400 text-sm">Obtain a long-lived Page Access Token for auto-posting</p>
    </div>

    <?php if ($error): ?>
    <div class="bg-red-900/50 border border-red-500 rounded-2xl p-5 text-red-200 text-sm font-mono break-all">
        ❌ <?= htmlspecialchars($error) ?>
    </div>
    <?php endif; ?>

    <?php if (!$configured): ?>
    <!-- Missing config warning -->
    <div class="bg-amber-900/40 border border-amber-500 rounded-2xl p-5">
        <p class="text-amber-300 font-semibold mb-2">⚠️ Missing configuration</p>
        <p class="text-amber-200 text-sm">Add <code class="bg-black/30 px-1 rounded">FACEBOOK_APP_ID</code> and
           <code class="bg-black/30 px-1 rounded">FACEBOOK_APP_SECRET</code> to your <code class="bg-black/30 px-1 rounded">.env</code> file first.</p>
    </div>

    <?php elseif ($step === 'done'): ?>
    <!-- Success -->
    <div class="bg-green-900/40 border border-green-500 rounded-2xl p-5">
        <p class="text-green-300 font-bold text-lg mb-1">✅ Token exchange successful!</p>
        <p class="text-green-200 text-sm">Long-lived user token expires in <?= htmlspecialchars((string)($result['expires_in'] ?? '?')) ?> seconds (~60 days).</p>
    </div>

    <?php if (!empty($result['pages'])): ?>
    <div class="bg-slate-800 rounded-2xl p-5 space-y-4">
        <h2 class="text-white font-semibold">📄 Your Pages — copy these into <code class="text-blue-300">.env</code></h2>
        <?php foreach ($result['pages'] as $page): ?>
        <div class="bg-slate-700 rounded-xl p-4 space-y-2">
            <p class="text-white font-semibold"><?= htmlspecialchars($page['name']) ?></p>
            <div>
                <label class="text-slate-400 text-xs uppercase tracking-wider">FACEBOOK_PAGE_ID</label>
                <pre class="mt-1 bg-black/40 text-green-300 rounded-lg px-3 py-2 text-sm overflow-x-auto select-all"><?= htmlspecialchars($page['id']) ?></pre>
            </div>
            <div>
                <label class="text-slate-400 text-xs uppercase tracking-wider">FACEBOOK_PAGE_ACCESS_TOKEN (never expires)</label>
                <pre class="mt-1 bg-black/40 text-green-300 rounded-lg px-3 py-2 text-sm overflow-x-auto break-all select-all"><?= htmlspecialchars($page['access_token']) ?></pre>
            </div>
            <p class="text-slate-400 text-xs">Category: <?= htmlspecialchars($page['category'] ?? '—') ?></p>
        </div>
        <?php endforeach; ?>
    </div>

    <?php else: ?>
    <div class="bg-amber-900/40 border border-amber-500 rounded-2xl p-4 text-amber-200 text-sm">
        ⚠️ No pages found. Make sure you have admin access to at least one Facebook Page and that
        <strong>pages_show_list</strong> scope was granted.
    </div>
    <?php endif; ?>

    <div class="bg-slate-800 rounded-2xl p-5 text-sm text-slate-300 space-y-1">
        <p class="text-slate-400 font-semibold uppercase tracking-wider text-xs mb-2">Next steps</p>
        <p>1. Copy <strong>FACEBOOK_PAGE_ID</strong> and <strong>FACEBOOK_PAGE_ACCESS_TOKEN</strong> from above into your <code class="text-blue-300">.env</code> file.</p>
        <p>2. Page access tokens from <code>/me/accounts</code> <strong>do not expire</strong> as long as your app and the user are in good standing.</p>
        <p>3. Delete or protect this file in production.</p>
    </div>

    <?php else: ?>
    <!-- Step 1: Instructions + authorize button -->
    <div class="bg-slate-800 rounded-2xl p-6 space-y-4">
        <h2 class="text-white font-semibold">How it works</h2>
        <ol class="text-slate-300 text-sm space-y-2 list-decimal list-inside">
            <li>Click <strong>Authorize with Facebook</strong> — log in and grant the requested permissions.</li>
            <li>You'll be redirected back here with an authorization code.</li>
            <li>The code is automatically exchanged for a <strong>long-lived Page Access Token</strong>.</li>
            <li>Copy the token and your Page ID into <code class="text-blue-300">.env</code> and you're done.</li>
        </ol>

        <div class="bg-slate-700 rounded-xl p-4 text-xs text-slate-400 space-y-1">
            <p class="font-semibold text-slate-300">Required Facebook App setup</p>
            <p>• Add <strong>Facebook Login</strong> and <strong>Pages API</strong> products to your app.</p>
            <p>• Add <code class="text-blue-300"><?= htmlspecialchars($redirectUri) ?></code> as a valid OAuth Redirect URI.</p>
            <p>• App must be in <strong>Live</strong> mode (or you must be an App Tester for Development mode).</p>
        </div>

        <a href="<?= htmlspecialchars($authUrl) ?>"
           class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition">
            Authorize with Facebook →
        </a>
    </div>

    <div class="bg-slate-800 rounded-2xl p-5 space-y-2">
        <p class="text-slate-400 text-xs uppercase tracking-wider font-semibold">Current .env values</p>
        <div class="text-sm font-mono space-y-1">
            <p><span class="text-slate-500">FACEBOOK_APP_ID:</span>
               <span class="text-green-300"><?= $appId ? '✓ set (' . substr($appId, 0, 6) . '...)' : '<span class="text-red-400">not set</span>' ?></span></p>
            <p><span class="text-slate-500">FACEBOOK_APP_SECRET:</span>
               <span class="text-green-300"><?= $appSecret ? '✓ set' : '<span class="text-red-400">not set</span>' ?></span></p>
            <p><span class="text-slate-500">FACEBOOK_PAGE_ID:</span>
               <span class="<?= FACEBOOK_PAGE_ID ? 'text-green-300' : 'text-amber-400' ?>"><?= FACEBOOK_PAGE_ID ?: 'not set' ?></span></p>
            <p><span class="text-slate-500">FACEBOOK_PAGE_ACCESS_TOKEN:</span>
               <span class="<?= FACEBOOK_PAGE_ACCESS_TOKEN ? 'text-green-300' : 'text-amber-400' ?>"><?= FACEBOOK_PAGE_ACCESS_TOKEN ? '✓ set' : 'not set' ?></span></p>
        </div>
    </div>
    <?php endif; ?>

    <p class="text-center text-slate-600 text-xs">
        This page is excluded from public crawling via robots.txt. Remove it after setup.
    </p>
</div>
</body>
</html>
