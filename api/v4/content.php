<?php
require_once '../../security/Request.php';
require_once '../../config/PDOConnection.php';
require_once 'ApiUtils.php';

$request = new Request();
$db = new PDOConnection();

$operation = $request->get('o')->getString();
header('Content-type: application/json;charset=utf-8');

if ($operation == 'track') {
    echo json_encode(array(
        'error' => 'no',
        'mensaje' => 'View update.'
    ));
} else if ($operation == 'checkFR') {
    echo json_encode(array(
        "totalR" => "0",
        "totalF" => "0"
    ));
} else if ($operation == 'recents') {
    $movies = [];

    echo json_encode($movies);
} else if ($operation == 'report') {
    $section = $request->get('t')->getString();
    $content = $request->get('cve')->getString();

    echo json_encode(array(
        'error' => 'no',
        'mensaje' => 'Content reported.'
    ));
} else {
    echo json_encode(array(
        'error' => 'si',
        'mensaje' => 'Unknown operation.'
    ));
}