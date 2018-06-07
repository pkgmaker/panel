<?php
require_once('Request.php');
require_once('Util.php');
require_once('CSRF.php');
require_once('../config/PDOConnection.php');
require_once('../config/config.php');

session_start();

$request = new Request();
$db = new PDOConnection();
$config = new config();

$csrf = new CSRF();
$token_id = $csrf->GetTokenId();
$token_value = $csrf->GetToken();
$form_names = $csrf->FormNames(['username', 'password']);

$fecha = date("Y-m-d H:i:s");
$ip = Util::GetIpRealCliente();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && $request->existPost($form_names['username']) && $request->existPost($form_names['password'])) {

    if ($csrf->CheckValid('post')) {
        $user = $request->post($form_names['username'])->getString();
        $pass = hash('sha256', config::$passSalt . $request->post($form_names['password'])->getString());

        if (Util::CheckUserValidation($user)) {
            $resp = $db->select('usuario', "usuario='$user' LIMIT 1");

            if ($resp == 1) {
                $row = $db->fetchObjects()[0];

                if ($pass == $row->contrasenia) {
                    if ($row->status != 1) {
                        Util::Redirect("suspended.php?username=" . $user);
                    }

                    @session_start();
                    $_SESSION['id'] = $row->id;
                    $_SESSION['usuario'] = $row->usuario;
                    $_SESSION['logueado'] = true;

                    $db->update('usuario', array('fecha_uconexion' => $fecha, 'ip_uconexion' => $ip), "id=$row->id  LIMIT 1");

                    Util::CheckSession();
                } else {
                    $message = "Usuario y/o Contraseña incorrecta.";
                    Util::Redirect("/security/login.php?message=" . $message);
                }
            } else {
                $message = "Usuario y/o Contraseña incorrecta.";
                Util::Redirect("/security/login.php?message=" . $message);
            }
        } else {
            $message = "Usuario no valido";
            $_SESSION['logueado'] = false;
            Util::Redirect("/security/login.php?message=" . $message);
        }
    } else {
        $message = "Error validando su peticion.";
        $_SESSION['logueado'] = false;
        $form_names = $csrf->FormNames(array('username', 'password'), true);
        Util::Redirect("/security/login.php?message=" . $message);
    }
} else {
    $error_message = "";
    $html_error = "";

    if ($request->existGet("message")) {
        $error_message = $request->get("message")->getString();
        $html_error = '<div id="error" class="label label-danger">' . htmlentities($error_message) . '</div>';
    }

    echo ' 
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="">
        <meta http-equiv="Expires" content="Mon, 26 Jul 1997 05:00:00 GMT">
        <meta http-equiv="Pragma" content="no-cache">
        <title>TV Panel</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="/assets/css/style.css">
        <link rel="stylesheet" href="/assets/css/style2.css">
        <link rel="stylesheet" href="/assets/css/login.css">
        <link rel="stylesheet" href="/assets/css/admin.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link rel="shortcut icon" href="/assets/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="/assets/ico/apple-touch-icon-57-precomposed.png">
    </head>
    <body class="hold-transition login-page register-page lockscreen">
    <div id="login-box" class="form-box box">
        <div id="loading"></div>
        <div class="login-logo"><a href="/"></a></div>
        <div class="login-box-body">
            <p class="login-box-msg"><strong>Autentíquese</strong><span> para iniciar sesión</span></p>
            ' . $html_error . '
            <form id="formulario" class="login-form" role="form" action="/security/login.php" method="post">
                <br/>
                <input type="hidden" name="' . $token_id . '" value="' . $token_value . '" />
                <div class="form-group has-feedback">
                    <input type="text" name="' . $form_names['username'] . '" placeholder="Nombre de usuario" autofocus="autofocus"
                           required="required" class="form-control"/><span
                        class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <br/>
                <div class="form-group has-feedback">
                    <input type="password" name="' . $form_names['password'] . '" placeholder="contraseña" required="required"
                           class="form-control"/><span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <br/>
                <div class="form-group has-feedback">
                    <input type="submit" value="ACCEDER" class="btn bg-blue-gradient btn-block btn-flat"/>
                </div>                
            </form>
        </div>
    </div>
    
    <!-- Javascript -->
    <script src="/assets/js/jquery-1.11.1.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/js/jquery.backstretch.min.js"></script>
    <script src="/assets/js/scripts.js"></script>
    <!--[if lt IE 10]>
    <script src="/assets/js/placeholder.js"></script>
    <![endif]-->
    </body>
    </html>';
}