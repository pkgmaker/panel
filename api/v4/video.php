<?php
require_once '../../security/Request.php';
require_once '../../config/PDOConnection.php';
require_once 'ApiUtils.php';

$request = new Request();
$db = new PDOConnection();

$category = $request->get('c')->getString();
$limit = $request->get('l')->getString();
$offset = $request->get('s')->getString();
$section = $request->get('section')->getInt();

$AND = "";
$LIMIT = 100;
if (strlen($category) > 0) {
    $AND = " AND FIND_IN_SET($category, id_cat_categoria) ";
}

if (strlen($limit) > 0) {
    if (strlen($offset) > 0) {
        $LIMIT = $limit . " OFFSET " . $offset;
    } else {
        $LIMIT = $limit;
    }
}

$ORDER = "";

$query = "SELECT * FROM contenido WHERE id_cat_tipo_contenido=$section
            " . $AND . "	
            LIMIT " . $LIMIT;

$total = $db->query($query);

$live_tv = [];

foreach ($db->getResults() as $res) {

    if (empty($res['poster'])) {
        $poster = "no-poster.png";
    } else {
        $poster = $res['poster'];
    }

    if (empty($res['fondo'])) {
        $fondo = "no-poster.png";
    } else {
        $fondo = $res['fondo'];
    }


    $channel = array(
        "cve" => $res['id'],
        "section" => $section,
        "titulo" => ApiUtils::EncodeText($res['titulo']),
        "anio" => '',
        "sinopsis" => '',
        "ahora" => '',
        "despues" => '',
        "duracion" => "",
        "calidad" => "LiveTV",
        "director" => "",
        "clasificacion" => "",
        "pin" => "0",
        "star" => rand(10, 100),
        "capitulos" => "0",
        "childs" => false,
        "category" => $category,
        "live" => true,
        "link" => ApiUtils::EncodeText($res['url']),
        "poster" => ApiUtils::EncodeText($poster),
        "fondo" => ApiUtils::EncodeText($fondo)
    );

    $live_tv[] = $channel;
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($live_tv);
