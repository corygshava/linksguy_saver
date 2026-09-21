<?php
// linksaver_via_api.php
// Accepts POST: { url: string, screenshot: file (optional) }
// Saves screenshot to __DIR__/images/ and logs entry to __DIR__/data/saved_links.json

header('Content-Type: application/json');

// --- Only allow POST ---
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$url = isset($_POST['url']) ? trim($_POST['url']) : null;

if (!$url || !filter_var($url, FILTER_VALIDATE_URL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing or invalid URL']);
    exit;
}

// --- Dirs ---
$imagesDir = __DIR__ . '/images/';
$dataDir   = __DIR__ . '/data/';
$jsonFile  = $dataDir . 'saved_links.json';

foreach ([$imagesDir, $dataDir] as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// --- Handle screenshot ---
$screenshotFilename = null;

$hasFile = isset($_FILES['screenshot'])
    && $_FILES['screenshot']['error'] === UPLOAD_ERR_OK
    && $_FILES['screenshot']['size'] > 0;

if ($hasFile) {
    // Filename: timestamp + sanitized hostname
    $host     = preg_replace('/[^a-z0-9\-]/', '_', strtolower(parse_url($url, PHP_URL_HOST) ?? 'unknown'));
    $ts       = date('Ymd_His');
    $ext      = 'png'; // html2canvas always sends PNG
    $screenshotFilename = "{$ts}_{$host}.{$ext}";
    $savePath = $imagesDir . $screenshotFilename;

    if (!move_uploaded_file($_FILES['screenshot']['tmp_name'], $savePath)) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to save screenshot']);
        exit;
    }
}

// --- Build log entry ---
$entry = [
    'url'        => $url,
    'screenshot' => $screenshotFilename, // null if not provided
    'saved_at'   => date('Y-m-d H:i:s'),
];

// --- Load existing JSON, append, save ---
$existing = [];

if (file_exists($jsonFile)) {
    $raw = file_get_contents($jsonFile);
    $decoded = json_decode($raw, true);
    if (is_array($decoded)) {
        $existing = $decoded;
    }
}

$existing[] = $entry;

$written = file_put_contents(
    $jsonFile,
    json_encode($existing, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
);

if ($written === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to write data file']);
    exit;
}

// --- Done ---
http_response_code(200);
echo json_encode([
    'success'    => true,
    'url'        => $url,
    'screenshot' => $screenshotFilename,
    'saved_at'   => $entry['saved_at'],
]);
