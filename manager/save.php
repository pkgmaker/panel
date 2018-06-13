<?php
require_once('../security/Util.php');
require_once('../security/Request.php');
require_once('../config/PDOConnection.php');

$request = new Request();
$db = new PDOConnection();
Util::CheckInactive();

$titulo = $request->post('titulo')->getString();
$poster = $request->post('poster')->getString();
$fondo = $request->post('fondo')->getString();
$link = $request->post('link')->getString();
$categories = $request->post('categories')->getArray();
$section = $request->post('type')->getString();

try {
    $values = array(
        'title' => $titulo,
        'poster' => $poster,
        'background' => $fondo,
        'url' => $link,
        'id_content_type' => $section,
        'id_category' => implode(',', $categories)
    );

    $db->insert('content', $values);
    header("Location: index.php?a=success&m=Guardado Correctamente.");
} catch (Exception $exception) {
    header("Location: index.php?a=danger&m=Error al insertar");
}