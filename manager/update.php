<?php
require_once('../security/Util.php');
require_once('../security/Request.php');
require_once('../config/PDOConnection.php');

$request = new Request();
$db = new PDOConnection();
Util::CheckInactive();

$old = $request->post('old_pass')->getString();
$new = $request->post('pass')->getString();
$renew = $request->post('confirm_pass')->getString();

try {

    $password_old = hash('sha256', config::$passSalt . $old);
    $exist = $db->select('usuario', "usuario='admin' and contrasenia='$password_old'");

    if ($exist > 0 and strcmp($new, $renew) === 0) {
        $password = hash('sha256', config::$passSalt . $new);
        $db->update('usuario', ['contrasenia' => $password], "usuario='admin'");
        header("Location: index.php?a=success&m=Contraseña actualizada.");
    } else
        header("Location: index.php?a=danger&m=Error al actualizar.");
} catch (Exception $exception) {
    header("Location: index.php?a=danger&m=Error al actualizar.");
}