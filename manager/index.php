<?php
require_once("../security/Util.php");
require_once('../config/PDOConnection.php');
require_once('../security/Util.php');
require_once('../security/Request.php');

Util::CheckInactive();
$db = new PDOConnection();
$request = new Request();
if ($request->existGet('exit'))
    Util::close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Panel de Administración </title>
    <meta name="generator" content="Mundoiptv"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap-switch.css">
    <link rel="stylesheet" href="/assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/dataTables.bootstrap.css">
    <link rel="stylesheet" href="/assets/pnotify/pnotify.css">
    <link rel="stylesheet" href="/assets/pnotify/pnotify.brighttheme.css">
    <link rel="stylesheet" href="/assets/chosen/chosen.min.css">
    <link rel="stylesheet" href="/assets/css/bootstrap-select.css"/>
    <link rel="stylesheet" href="/assets/css/admin.css"/>
    <link rel="stylesheet" href="/assets/css/_all-skins.css"/>
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="/css/styles.css" rel="stylesheet">
</head>
<body class="skin-dark">
<div class="wrapper">
    <header class="main-header">
        <a href="/#" class="logo">
                <span class="log-lg">
                    <span>Panel</span>
                </span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
            <a class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span>
                <span class="icon-bar"></span><span class="icon-bar"></span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="glyphicon glyphicon-user"></i><span><?php echo $_SESSION['username']; ?></span>
                            <i class="caret"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header bg-dark">
                                <img class="img-circle" alt="User Image" src="avatars/avatar.png">
                                <p style="margin-top: 0"><?php echo $_SESSION['username']; ?>
                                    <small></small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-right">
                                    <a class="btn btn-default btn-flat" target="_self" href="?exit=true">
                                        <i class="fa fa-lock"></i><span>Salir</span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <aside class="main-sidebar">
        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 924px;">
            <div class="sidebar" style="height: 924px; overflow: hidden; width: auto;">
                <ul class="sidebar-menu">
                    <li class="header">Panel de administración</li>
                    <li>
                        <a href="./index.php?action=sections">
                            <i class="glyphicon glyphicon-list"></i>Secciones
                        </a>
                    </li>
                    <li>
                        <a href="./index.php?action=categories">
                            <i class="glyphicon glyphicon-list-alt"></i>Categorias
                        </a>
                    </li>
                    <li>
                        <a href="./index.php">
                            <i class="glyphicon glyphicon-film"></i>Contenido
                        </a>
                    </li>
                    <li>
                        <a href="./index.php?action=password">
                            <i class="glyphicon glyphicon-eye-close"></i>Cambiar contraseña
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </aside>

    <aside class="content-wrapper">
        <section class="content">
            <?php
            switch ($request->get('action')->getString()) {
                case 'sections':
                    include_once 'partials/sections.php';
                    break;
                case 'categories':
                    include_once 'partials/categories.php';
                    break;
                case 'password':
                    include_once 'partials/user.php';
                    break;
                default:
                    include_once 'partials/content.php';
            }
            ?>
        </section>
    </aside>

</div>

<style type="text/css">
    .panel-widget .panel-footer a {
        color: #999;
    }

    .panel-widget .panel-footer a:hover {
        color: #666;
        text-decoration: none;
    }

    .panel-blue .panel-body p,
    .panel-teal .panel-body p,
    .panel-orange .panel-body p,
    .panel-red .panel-body p {
        color: #fff;
        color: rgba(255, 255, 255, .8);
    }
</style>


<footer class="main-footer">
    <div class="pull-right hidden-xs"></div>
    <strong><span> Copyright © <?php echo date("Y"); ?></span><a href="/"> Panel TV.</a></strong><span> Todos los derechos reservados.</span>
</footer>
</div>


<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<script src="/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="/assets/bootstrap/js/bootstrap-switch.js"></script>
<script src="/js/bootstrap-select.min.js"></script>
<script src="/assets/pnotify/pnotify.min.js"></script>
<script src="/assets/chosen/chosen.jquery.min.js"></script>
<script src="/assets/js/app.js"></script>
<script src="/assets/js/scripts.js"></script>
</body>
</html>