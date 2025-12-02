<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Omeka S configuration
$omekaBaseUrl = 'http://localhost/omk_thyp_25-26_clone';
$identity = 'apDsWeLrBaARNIElOcFY5uISBlRs9Vtd';
$credential = 'ScjaQajebr7WFO2oTL7flEYdoR4Oi1vs';

// Get the endpoint from query parameter
$endpoint = $_GET['endpoint'] ?? '/api/items';
$url = $omekaBaseUrl . $endpoint;

// Initialize cURL
$ch = curl_init($url);

// Set authorization header
$auth = base64_encode("$identity:$credential");
$headers = [
    'Authorization: Basic ' . $auth,
    'Content-Type: application/json'
];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Handle different HTTP methods
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $postData = file_get_contents('php://input');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
} elseif ($method === 'PUT') {
    $putData = file_get_contents('php://input');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $putData);
} elseif ($method === 'DELETE') {
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
}

// Execute request
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Check for errors
if (curl_errno($ch)) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Proxy error',
        'message' => curl_error($ch),
        'url' => $url
    ]);
    curl_close($ch);
    exit();
}

curl_close($ch);

// Return response with appropriate status code
http_response_code($httpCode);
echo $response;
?>
