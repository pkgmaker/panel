<?php
require_once '../../security/Request.php';
require_once 'ApiUtils.php';

$request = new Request();
$operation = $request->get('o')->getString();

header('Content-Type: application/json; charset=utf-8');

if ($operation == 'add')
    echo json_encode(array(
        'error' => 'no',
        'mensaje' => 'Already in favorites.'
    ));
elseif ($operation == 'check')
    echo json_encode(array(
        'error' => 'no',
        'mensaje' => '1'
    ));
elseif ($operation == 'remove')
    echo json_encode(array(
        'error' => 'no',
        'mensaje' => 'Removed from favorite.'
    ));
elseif ($operation == 'get'){
    $results = [];
    echo json_encode($results);
}
else
    echo json_encode(array(
        'error' => 'si',
        'mensaje' => 'Unknown operation.'
    ));