<?php

require_once __DIR__ . '/../../security/Request.php';
require_once 'ApiUtils.php';
require_once '../../config/config.php';

$request = new Request();
$config = new config();

$device_id = $request->header('idu')->getString();
$appid = $request->header('appid')->getString();

if (empty($device_id) or empty($appid))
    $msg = ["error" => true, "url" => "", 'token' => ""];
else {
    $headers = [
        'idu: ' . $device_id,
        'appid: ' . $appid
    ];

    $server = config::$mainPage . "/api/v5/update.php";
    $ch = curl_init($server);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec($ch);
    curl_close($ch);
    header('Content-type: application/json');

    $response = json_decode($server_output, true);

    if ($response['error'] == true or !$response)
        $msg = ["access" => ApiUtils::GenerateToken($device_id), "url" => "", "update" => false];
    else
        $msg = ["access" => $response['token'], "url" => $response['url'], "update" => true];
}

header('Content-type: application/json');
echo json_encode($msg);