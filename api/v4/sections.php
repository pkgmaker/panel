<?php
require_once '../../security/Request.php';
require_once '../../config/PDOConnection.php';
require_once 'ApiUtils.php';

$request = new Request();
$db = new PDOConnection();

$limit = $request->get('l')->getString();
$offset = $request->get('s')->getString();

$db->query("SELECT * FROM cat_tipo_contenido");
$db->execute();
$sections = [];

foreach ($db->getResults() as $res) {
    $sections[] = array(
        "cve" => $res["id"],
        "tipo_contenido" => ApiUtils::EncodeText($res["tipo_contenido"]),
        "api" => "video",
        "pin" => $res["pin"],
        "poster" => '',
        "fondo" => ''
    );
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($sections);
