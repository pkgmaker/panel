<?php
require_once('../security/Util.php');
require_once('../security/Request.php');
require_once('../config/PDOConnection.php');

$request = new Request();
$db = new PDOConnection();
Util::CheckInactive();

$id = $request->get('id')->getString();

try {
    $db->delete('content', "id='$id'");
    header("Location: index.php?a=success&m=Accion ejecutada correctamente.");
} catch (Exception $exception) {
    header("Location: index.php?a=danger&m=Error al eliminar");
}