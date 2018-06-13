<?php

date_default_timezone_set("America/Mexico_City");

require_once('DataType.php');
require_once('Request.php');
require_once('Crypto.php');
require_once(__DIR__ . '/../config/config.php');

class Util
{
    public static $INACTIVE = 86400;

    /**
     * @param string $type
     */
    public static function CheckInactive($type = 'html')
    {
        @session_start();
        if (isset($_SESSION['time'])) {
            $vida_session = time() - $_SESSION['time'];
            if ($vida_session > self::$INACTIVE) {
                session_unset();
                session_destroy();
                if ($type == 'html')
                    header("Location: ../index.php");
                else {
                    echo json_encode(
                        array(
                            "error" => "1",
                            "mensaje" => "tu sesion a expirado.",
                            "contenido" => ""
                        )
                    );
                    exit;
                }
            }
        }
        if (!isset($_SESSION['id']))
            header("Location: ../index.php");
        $_SESSION['time'] = time();
    }

    /**
     * @param string $txt
     * @param string $CRYPT_KEY
     * @return bool|string
     */
    public static function Encrypt($txt, $CRYPT_KEY)
    {
        return Crypto::encrypt($txt, $CRYPT_KEY);
    }

    /**
     * @param string $txt
     * @param string $CRYPT_KEY
     * @return string
     */
    public static function Decrypt($txt, $CRYPT_KEY)
    {
        return Crypto::decrypt($txt, $CRYPT_KEY);
    }

    /**
     * @param string $token
     * @return bool|string
     */
    public static function EncryptToken($token)
    {
        return self::Encrypt($token, config::$tokenEncrypt);
    }

    /**
     * @param string $token
     * @return string
     */
    public static function DecryptToken($token)
    {
        return self::Decrypt($token, config::$tokenEncrypt);
    }

    public static function KeyValue($CRYPT_KEY)
    {
        $keyvalue = "";
        $keyvalue[1] = "0";
        $keyvalue[2] = "0";
        for ($i = 1; $i < strlen($CRYPT_KEY); $i++) {
            $curchr = ord(substr($CRYPT_KEY, $i, 1));
            $keyvalue[1] = $keyvalue[1] + $curchr;
            $keyvalue[2] = strlen($CRYPT_KEY);
        }
        return $keyvalue;
    }

    /**
     * @return string mixed
     */
    public static function GetIpRealCliente()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];

        return $_SERVER['REMOTE_ADDR'];
    }

    public static function CheckSession()
    {
        @session_start();
        if (isset($_SESSION['logging']) and $_SESSION['logging']) {
            echo "<script>window.location='../manager/'</script>";
        } else {
            $request = new Request();
            if ($request->existGet('ref')) {
                if ($request->get('ref')->getString() != '/') {
                    header("Location: /security/login.php?ref=/");
                } else {
                    echo '<a href="/security/login.php?ref=/">Click Aqui Para Acceder</a>';
                }
            } else {
                header("Location: /security/login.php?ref=/");
            }
        }
    }

    public static function Redirect($url, $permanent = false)
    {
        header('Location: ' . $url, true, $permanent ? 301 : 302);
        exit();
    }

    /**
     * @param string $username
     * @param int $min
     * @param int $max
     * @return int|bool
     */
    public static function CheckUserValidation($username, $min = 3, $max = 13)
    {
        return preg_match('/[-_a-zA-Z0-9]{' . $min . ',' . $max . '}/', $username);
    }

    /**
     * @param string $password
     * @param int $min
     * @param int $max
     * @return int|bool
     */
    public static function CheckPassValidation($password, $min = 3, $max = 20)
    {
        return preg_match('/[-_0-9a-zA-Z]{' . $min . ',' . $max . '}/', $password);
    }

    public static function close()
    {
        session_start();
        session_unset();
        session_destroy();

        header("Location: ./index.php", true);
    }
}