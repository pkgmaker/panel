<?php
require_once '../../security/Request.php';
require_once '../../config/PDOConnection.php';
require_once 'ApiUtils.php';

header("Access-Control-Allow-Origin: *");
header('Content-type: application/json;charset=utf-8');
header('Access-Control-Allow-Methods: OPTIONS, GET');
header('Access-Control-Allow-Headers: origin, x-content, x-app');

$request = new Request();
$db = new PDOConnection();

$operation = $request->get('o')->getString();

if ($operation == 'track') {
    echo json_encode(array(
        'error' => 'no',
        'mensaje' => 'Visita reportada.'
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
        'mensaje' => 'Contenido reportado.'
    ));
} else {
    echo json_encode(array(
        'error' => 'si',
        'mensaje' => 'Operacion desconocida.'
    ));
}