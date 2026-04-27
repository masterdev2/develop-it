<?php
/**
 * Central configuration — loads .env and defines constants.
 * Include this once at the top of any file that needs credentials.
 */

// Prevent double-loading
if (defined('CONFIG_LOADED')) return;
define('CONFIG_LOADED', true);

// Resolve .env path (works from root or /blog/ subdirectory)
$envPath = __DIR__ . '/.env';
if (!file_exists($envPath)) {
    $envPath = dirname(__DIR__) . '/.env';
}

if (!file_exists($envPath)) {
    die('⚠️ .env file not found. Copy .env.example to .env and fill in your credentials.');
}

// Parse .env
foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    $line = trim($line);
    if ($line === '' || $line[0] === '#') continue;
    if (strpos($line, '=') === false) continue;
    [$key, $value] = explode('=', $line, 2);
    $key   = trim($key);
    $value = trim($value);
    if (!array_key_exists($key, $_ENV)) {
        $_ENV[$key] = $value;
        putenv("$key=$value");
    }
}

// Helper
function env(string $key, string $default = ''): string {
    return $_ENV[$key] ?? getenv($key) ?: $default;
}

// Database
define('DB_HOST', env('DB_HOST', 'localhost'));
define('DB_USER', env('DB_USER'));
define('DB_PASS', env('DB_PASS'));
define('DB_NAME', env('DB_NAME'));

// APIs
define('ANTHROPIC_API_KEY',    env('ANTHROPIC_API_KEY'));
define('LINKEDIN_TOKEN',       env('LINKEDIN_TOKEN'));
define('LINKEDIN_PERSON_URN',  env('LINKEDIN_PERSON_URN'));
define('LINKEDIN_CLIENT_ID',   env('LINKEDIN_CLIENT_ID'));
define('LINKEDIN_CLIENT_SECRET', env('LINKEDIN_CLIENT_SECRET'));
define('UNSPLASH_KEY',         env('UNSPLASH_KEY'));
define('SITE_URL',             env('SITE_URL', 'https://develop-it.tech'));

// Facebook
define('FACEBOOK_APP_ID',            env('FACEBOOK_APP_ID'));
define('FACEBOOK_APP_SECRET',        env('FACEBOOK_APP_SECRET'));
define('FACEBOOK_PAGE_ACCESS_TOKEN', env('FACEBOOK_PAGE_ACCESS_TOKEN'));
define('FACEBOOK_PAGE_ID',           env('FACEBOOK_PAGE_ID'));

// Google AdSense
define('ADSENSE_CLIENT_ID',     env('ADSENSE_CLIENT_ID'));
define('ADSENSE_SLOT_POST_TOP',    env('ADSENSE_SLOT_POST_TOP'));
define('ADSENSE_SLOT_POST_BOTTOM', env('ADSENSE_SLOT_POST_BOTTOM'));
define('ADSENSE_SLOT_BLOG',        env('ADSENSE_SLOT_BLOG'));
