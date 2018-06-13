<?php
require_once '../../security/Request.php';
require_once '../../config/PDOConnection.php';
require_once 'ApiUtils.php';

$request = new Request();
$db = new PDOConnection();
$type = $request->get('t')->getString();
$categories = array();

$total = $db->select("categories", "id_content_type='$type'");

foreach ($db->getResults() as $res) {
    $id = $res['id'];

    $totalItems = $db->count('content', "id_content_type = $type AND FIND_IN_SET($id, id_category)");

    $categories[] = array(
        "cve" => $res['id'],
        "name" => ApiUtils::EncodeText($res['categoria']),
        "total" => $totalItems
    );
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($categories);