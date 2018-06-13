<?php
require_once '../../security/Request.php';
require_once '../../config/PDOConnection.php';
require_once 'ApiUtils.php';

$request = new Request();
$db = new PDOConnection();

$limit = $request->get('l')->getString();

$AND = "";
$LIMIT = 20;

$AND = "";

if (strlen($limit) > 0) {
    $LIMIT = $limit;
}

$ORDER = " ORDER BY RAND()";

$query = "SELECT * FROM content
	      WHERE poster is not null and poster <> '' AND
            background is not null and background <> ''
            " . $ORDER . " LIMIT " . $LIMIT;

$total = $db->query($query);

$movies = [];

foreach ($db->getResults() as $res) {
    $movie = array(
        "cve" => $res['id'],
        "titulo" => ApiUtils::ShortText($res['title'], 32),
        "audio" => '',
        "anio" => '',
        "duracion" => '',
        "calidad" => '',
        "clasificacion" => '',
        "poster" => $res['poster'],
        "fondo" => $res['background']
    );

    $movies[] = $movie;
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($movies);