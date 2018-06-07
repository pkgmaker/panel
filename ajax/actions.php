<?php
require_once '../config/PDOConnection.php';
require_once '../security/Request.php';

$request = new Request();
$db = new PDOConnection();

$action = $request->post('action')->getString();
switch ($action) {
    case 'add-section':
        $seccion = $request->post('name')->getString();
        $count = $db->select('cat_tipo_contenido', "tipo_contenido='$seccion'");

        if ($count > 0)
            $msg = ["error" => true, "msg" => "That element exist."];
        else {
            $db->insert('cat_tipo_contenido', ['tipo_contenido' => $seccion, 'api' => 'video', 'pin' => '0']);
            $msg = ["error" => false, "msg" => "Added"];
        }
        break;
    case 'rm-section':
        $id = $request->post('id')->getString();
        $count = $db->delete('cat_tipo_contenido', "id='$id'");

        if ($count > 0)
            $msg = ["error" => false, "msg" => "Removed"];
        else
            $msg = ["error" => true, "msg" => "That element not exist."];

        break;
    case 'add-category':
        $seccion = $request->post('section')->getString();
        $category = $request->post('name')->getString();
        $count = $db->select('cat_categorias', "id_cat_tipo_contenido='$seccion' and categoria='$category'");

        if ($count > 0)
            $msg = ["error" => true, "msg" => "That element exist."];
        else {
            $db->insert('cat_categorias', ['id_cat_tipo_contenido' => $seccion, 'categoria' => $category]);
            $msg = ["error" => false, "msg" => "Added"];
        }
        break;
    case 'rm-category':
        $id = $request->post('id')->getString();
        $count = $db->delete('cat_categorias', "id='$id'");

        if ($count > 0)
            $msg = ["error" => false, "msg" => "Removed"];
        else
            $msg = ["error" => true, "msg" => "That element not exist."];

        break;
    case 'get-category':
        $id = $request->post('section')->getString();
        $count = $db->select('cat_categorias', "id_cat_tipo_contenido='$id'");

        if ($count > 0) {
            $data = $db->getResults();
            $msg = ["error" => false, "msg" => "Ready.", "values" => $data];
        } else
            $msg = ["error" => false, "msg" => "Empty.", "values" => []];

        break;
}

echo json_encode($msg);