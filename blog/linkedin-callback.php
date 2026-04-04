<?php
require_once __DIR__ . '/../config.php';

if (!isset($_GET['code'])) {
    die('No code received');
}

$code          = $_GET['code'];
$client_id     = LINKEDIN_CLIENT_ID;
$client_secret = LINKEDIN_CLIENT_SECRET;
$redirect_uri  = SITE_URL . '/blog/linkedin-callback.php';

$post_data = http_build_query([
    'grant_type'    => 'authorization_code',
    'code'          => $code,
    'redirect_uri'  => $redirect_uri,
    'client_id'     => $client_id,
    'client_secret' => $client_secret
]);

$ch = curl_init('https://www.linkedin.com/oauth/v2/accessToken');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $post_data,
    CURLOPT_HTTPHEADER     => ['Content-Type: application/x-www-form-urlencoded'],
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_VERBOSE        => true
]);

$response  = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_error = curl_error($ch);
curl_close($ch);

echo "<h2>Debug Info</h2>";
echo "<p><strong>HTTP Code:</strong> $http_code</p>";
echo "<p><strong>cURL Error:</strong> " . ($curl_error ?: 'none') . "</p>";
echo "<p><strong>Raw Response:</strong></p>";
echo "<pre>" . htmlspecialchars($response) . "</pre>";

$data = json_decode($response, true);
echo "<p><strong>Parsed:</strong></p>";
echo "<pre>" . print_r($data, true) . "</pre>";

if (!empty($data['access_token'])) {
    echo "<h2>✅ Token:</h2>";
    echo "<textarea rows='3' style='width:100%'>" . $data['access_token'] . "</textarea>";
}

// Get Person URN

// Add this to your callback file
$id_token = $data['id_token'];
$parts = explode('.', $id_token);
$payload = json_decode(base64_decode(str_pad(strtr($parts[1], '-_', '+/'), strlen($parts[1]) % 4, '=', STR_PAD_RIGHT)), true);

echo "<h2>✅ Your Identity (from JWT)</h2>";
echo "<p><strong>Person ID:</strong> " . $payload['sub'] . "</p>";
echo "<p><strong>URN:</strong> urn:li:person:" . $payload['sub'] . "</p>";
echo "<p><strong>Name:</strong> " . $payload['name'] . "</p>";
