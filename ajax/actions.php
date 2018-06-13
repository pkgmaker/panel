<?php
require_once '../config/PDOConnection.php';
require_once '../security/Request.php';

$request = new Request();
$db = new PDOConnection();

$action = $request->post('action')->getString();
switch ($action) {
    case 'add-section':
        $section = $request->post('name')->getString();
        $count = $db->select('content_type', "content_type='$section'");

        if ($count > 0)
            $msg = ["error" => true, "msg" => "That element exist."];
        else {
            $db->insert('content_type', ['content_type' => $section, 'api' => 'video', 'pin' => '0']);
            $msg = ["error" => false, "msg" => "Added"];
        }
        break;
    case 'rm-section':
        $id = $request->post('id')->getString();
        $count = $db->delete('content_type', "id='$id'");

        if ($count > 0)
            $msg = ["error" => false, "msg" => "Removed"];
        else
            $msg = ["error" => true, "msg" => "That element not exist."];

        break;
    case 'add-category':
        $section = $request->post('section')->getString();
        $category = $request->post('name')->getString();
        $count = $db->select('categories', "id_content_type='$section' and category='$category'");

        if ($count > 0)
            $msg = ["error" => true, "msg" => "That element exist."];
        else {
            $db->insert('categories', ['id_content_type' => $section, 'category' => $category]);
            $msg = ["error" => false, "msg" => "Added"];
        }
        break;
    case 'rm-category':
        $id = $request->post('id')->getString();
        $count = $db->delete('categories', "id='$id'");

        if ($count > 0)
            $msg = ["error" => false, "msg" => "Removed"];
        else
            $msg = ["error" => true, "msg" => "That element not exist."];

        break;
    case 'get-category':
        $id = $request->post('section')->getString();
        $count = $db->select('categories', "id_content_type='$id'");

        if ($count > 0) {
            $data = $db->getResults();
            $msg = ["error" => false, "msg" => "Ready.", "values" => $data];
        } else
            $msg = ["error" => false, "msg" => "Empty.", "values" => []];

        break;
}

echo json_encode($msg);