<?php
header('Content-Type: application/json');
// Get UBRN from URL parameters
$ubrn = $_GET['ubrn'] ?? '';  // Gets 'ubrn' parameter from URL like ?ubrn=12345
$requestId = $_GET['request_id'] ?? uniqid();  // Optional: Get or generate request ID

// Validate UBRN
if (empty($ubrn)) {
    echo json_encode([
        "ok" => false,
        "message" => "UBRN parameter is required",
        "request_id" => $requestId,
        "api_owner" => "MR OGGY BHAI"
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

$url1 = "https://best-seba.top/api/UBRN/brnDobFinder.php";
$postData1 = http_build_query([
    "u" => $ubrn,
    "m" => "",
    "t" => ""
]);

$ch1 = curl_init();
curl_setopt_array($ch1, [
    CURLOPT_URL => $url1,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $postData1,
    CURLOPT_HTTPHEADER => [
        "User-Agent: Mozilla/5.0",
        "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
        "X-Requested-With: XMLHttpRequest"
    ],
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => 0
]);
$response1 = curl_exec($ch1);
curl_close($ch1);

$data1 = json_decode($response1, true);

if (!$data1 || empty($data1['ok']) || $data1['ok'] !== true) {
    echo json_encode([
        "ok" => false,
        "message" => "UBRN information not found",
        "request_id" => $requestId,
        "api_owner" => "MR OGGY BHAI"
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

// Extract data from first API
$name = $data1['name'] ?? '';
$nameEn = $data1['nameEn'] ?? '';
$dob1 = $data1['dob'] ?? '';
$gender = strtoupper($data1['gender'] ?? '');

// Return the successful response
echo json_encode([
    "ok" => true,
    "data" => [
        "ubrn" => $ubrn,
        "name" => $name,
        "name_en" => $nameEn,
        "dob" => $dob1,
        "gender" => $gender
    ],
    "request_id" => $requestId,
    "api_owner" => "MR OGGY BHAI"
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

?>