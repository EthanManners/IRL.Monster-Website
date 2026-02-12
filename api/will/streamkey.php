<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false]);
    exit;
}

$rawBody = file_get_contents('php://input');
$payload = json_decode($rawBody, true);

if (!is_array($payload)) {
    http_response_code(400);
    echo json_encode(['success' => false]);
    exit;
}

$providedToken = isset($payload['t']) && is_string($payload['t']) ? $payload['t'] : '';
$expectedToken = getenv('WILL_TOKEN');

if (!is_string($expectedToken) || $expectedToken === '' || !hash_equals($expectedToken, $providedToken)) {
    http_response_code(403);
    echo json_encode(['success' => false]);
    exit;
}

$streamKey = isset($payload['streamKey']) && is_string($payload['streamKey']) ? trim($payload['streamKey']) : '';
$keyLength = strlen($streamKey);

if ($keyLength < 10 || $keyLength > 512) {
    http_response_code(400);
    echo json_encode(['success' => false]);
    exit;
}

$secretsDir = __DIR__ . '/../../.secrets';
$streamKeyPath = $secretsDir . '/will_stream_key.txt';
$cooldownPath = $secretsDir . '/will_stream_key.cooldown';

if (!is_dir($secretsDir) && !mkdir($secretsDir, 0700, true)) {
    http_response_code(500);
    echo json_encode(['success' => false]);
    exit;
}

@chmod($secretsDir, 0700);

$now = time();
$lastSubmission = 0;
if (is_file($cooldownPath)) {
    $lastValue = file_get_contents($cooldownPath);
    if ($lastValue !== false && ctype_digit(trim($lastValue))) {
        $lastSubmission = (int) trim($lastValue);
    }
}

if ($lastSubmission > 0 && ($now - $lastSubmission) < 5) {
    http_response_code(429);
    echo json_encode(['success' => false]);
    exit;
}

// Ethan will manually read this file and delete it after pickup.
if (file_put_contents($streamKeyPath, $streamKey . PHP_EOL, LOCK_EX) === false) {
    http_response_code(500);
    echo json_encode(['success' => false]);
    exit;
}

@chmod($streamKeyPath, 0600);
file_put_contents($cooldownPath, (string) $now, LOCK_EX);
@chmod($cooldownPath, 0600);

echo json_encode(['success' => true]);
