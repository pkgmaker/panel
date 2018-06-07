<!DOCTYPE HTML>
<html lang="es">
<head>
    <title>403 Error - Acceso Denegado</title>

    <meta charset="iso-8859-1" />

    <style type="text/css">
        body {
            background-color: #0000AA;
            font-family: "Courier New", Menlo;
            font-size: 13px;
            font-weight: bold;
            color: #ffffff;
        }
        #content {
            margin: 0 auto;
            padding-top: 80px;
            width: 640px;
            height: 300px;
            text-align: left;
        }
        h1.headline {
            margin: 0 auto;
            background-color: #AAAAAA;
            color: #0000AA;
            padding: 2px 5px 2px 5px;
            font-size: 14px;
            width: 230px;
            min-width: 130px;
            text-align: center;
            float: center;
        }

        p {
            line-height: 1.5em;
        }

        .continue {
            text-align: center;
        }

        .blink {
            -webkit-animation: blink .75s linear infinite;
            -moz-animation: blink .75s linear infinite;
            -ms-animation: blink .75s linear infinite;
            -o-animation: blink .75s linear infinite;
            animation: blink .75s linear infinite;
        }

        @-webkit-keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 1; }
            50.01% { opacity: 0; }
            100% { opacity: 0; }
        }

        @-moz-keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 1; }
            50.01% { opacity: 0; }
            100% { opacity: 0; }
        }

        @-ms-keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 1; }
            50.01% { opacity: 0; }
            100% { opacity: 0; }
        }

        @-o-keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 1; }
            50.01% { opacity: 0; }
            100% { opacity: 0; }
        }

        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 1; }
            50.01% { opacity: 0; }
            100% { opacity: 0; }
        }


    </style>
</head>

<body>
<div id="content">
    <h1 class="headline">403 Error - Acceso Denegado</h1>
    <p>Una excepci&oacute;n con error 403 se ha producido, la petici&oacute;n sera terminada.</p>

    <ul>
        <li>Su usuario no tiene permisos para entrar al modulo solicitado.</li>
        <li>Sus par&aacute;metros de seguridad caducaron.</li>
        <li>El sistema deniega expl&iacute;citamente el acceso a esta ubicaci&oacute;n.</li>
        <li>Si esto consiste en un error, por favor contacte a su proveedor.</li>
    </ul>

    <p class="continue">Presione cualquier tecla para continuar <span class="blink">_</span></p><br />
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://static.yeahwh.at/js/mousetrap.min.js"></script>

<script type="text/javascript">
    $(document).on('ready', function () {
        $(document).on('keypress', function () {
            window.location.replace('/security/login.php');
        })
    });
</script>
</div>
</body>
</html>
