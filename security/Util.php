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
        if (isset($_SESSION['tiempo'])) {
            $vida_session = time() - $_SESSION['tiempo'];
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
        $_SESSION['tiempo'] = time();
    }

    /**
     * @param string $type
     * @return null
     */
    public static function CheckSingleAccess($type)
    {
        @session_start();
        if ($_SESSION['logueado']) {
            if ($_SESSION['tipo_acceso'] != $type) {
                $location = self::CreateUrl('security/forbidden.php');
                header("Location: $location");
            }
        } else {
            $location = self::CreateUrl('index.php');
            header("Location: $location");
        }
    }

    /**
     * @param array $permissions
     * @param string $type
     */
    public static function CheckAccess($permissions, $type = 'html')
    {
        @session_start();
        if (!self::checkTypeUser($permissions)) {
            if ($type == 'html') {
                $location = self::createUrl('security/forbidden.php');
                header("Location: $location");
            } else {
                echo json_encode(
                    array(
                        "err" => true,
                        "mensaje" => "No tienes permisos.",
                        "contenido" => ""
                    )
                );
                exit;
            }
        }
    }

    /**
     * @param array $type
     * @return bool
     */
    public static function checkTypeUser($type)
    {
        if (isset($_SESSION['tipo_acceso']) and in_array($_SESSION['tipo_acceso'], $type, true)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $url
     * @return string
     */
    public static function CreateUrl($url)
    {
        $protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];

        return $protocol . '://' . $host . '/' . $url;
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

    /**
     * @return string
     */
    public static function URL()
    {
        $url = "https://" . $_SERVER['HTTP_HOST'] . ":" . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
        return $url;
    }

    /**
     * @return string
     */
    public static function RealURL()
    {
        $url = $_SERVER['REQUEST_URI'];
        return $url;
    }

    public static function CompressImage($ext, $uploadedfile, $path, $actual_image_name, $newwidth, $newheight)
    {

        if ($ext == "jpg" || $ext == "jpeg") {
            $src = imagecreatefromjpeg($uploadedfile);
        } else if ($ext == "png") {
            $src = imagecreatefrompng($uploadedfile);
        } else if ($ext == "gif") {
            $src = imagecreatefromgif($uploadedfile);
        } else {
            $src = imagecreatefrombmp($uploadedfile);
        }

        list($width, $height) = getimagesize($uploadedfile);
        $tmp = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        $filename = $path . $actual_image_name; //PixelSize_TimeStamp.jpg
        imagejpeg($tmp, $filename, 100);
        imagedestroy($tmp);
        return $actual_image_name;
    }

    public static function GetExtension($str)
    {
        $i = strrpos($str, ".");
        if (!$i) {
            return "";
        }
        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }

    public static function SaveImg($image)
    {

        $img_file = file_get_contents($image);

        $image_path = parse_url($image);
        $img_path_parts = pathinfo($image_path['path']);

        $filename = $img_path_parts['filename'];
        $img_ext = $img_path_parts['extension'];

        $path = "./posters/";
        $filex = $path . $filename . "." . $img_ext;
        $fh = fopen($filex, 'w');
        fputs($fh, $img_file);
        fclose($fh);
        return $filename . "." . $img_ext;
    }

    public static function ShorterText($cadena, $limite, $corte = " ", $pad = "...")
    {
        if (strlen($cadena) <= $limite)
            return $cadena;
        if (false !== ($breakpoint = strpos($cadena, $corte, $limite))) {
            if ($breakpoint < strlen($cadena) - 1) {
                $cadena = substr($cadena, 0, $breakpoint) . $pad;
            }
        }
        return $cadena;
    }

    public static function StatusDemos()
    {
        $my_file = 'config/demos.txt';
        $handle = fopen($my_file, 'r');
        $data = fread($handle, filesize($my_file));
        return $data;
    }

    public static function SaveStatusDemos($status)
    {
        $my_file = 'config/demos.txt';
        $handle = fopen($my_file, 'w');
        $data = $status;
        fwrite($handle, $data);
        return true;
    }

    public static function InsertEPG(PDOConnection $db, $channels)
    {
        $result = true;

        foreach ($channels as $channel) {
            $id_canal = DataType::scapeString((string)$channel->attributes()->site_id);
            $canal = DataType::scapeString((string)$channel->attributes()->xmltv_id);
            $titulo = DataType::scapeString((string)$channel->attributes()->xmltv_id);
            $sub_titulo = DataType::scapeString((string)$channel->attributes()->site);

            $id = $db->insert("epg", array('id_canal' => $id_canal, 'canal' => $canal, 'titulo' => $titulo, 'sub_titulo' => $sub_titulo));

            if (!$id) {
                $result = false;
                break;
            }

        }
        return $result;

    }

    public static function CheckSession()
    {
        @session_start();
        if (isset($_SESSION['logueado']) and $_SESSION['logueado']) {
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

    /**
     * @param string $pin
     * @param int $min
     * @param int $max
     * @return int|bool
     */
    public static function CheckPinValidation($pin, $min = 4, $max = 4)
    {
        return preg_match('/[0-9]{' . $min . ',' . $max . '}/', $pin);
    }

    /**
     * @param string $action
     * @return bool
     */
    public static function UploaderHasPermission($action)
    {
        if ($_SESSION['tipo_acceso'] === "2") {
            if (in_array($action, explode(',', $_SESSION['permisos']), true))
                return true;
            return false;
        } else return true;
    }

    /**
     * @param string $action
     * @return null
     */
    public static function UploaderHasAccess($action)
    {
        if (!self::UploaderHasPermission($action))
            header("Location: /");
    }

    /**
     * @param string|DateTime $dateEnd
     * @param string|DateTime $dateBegin
     * @param string $format
     * @return bool|DateInterval
     */
    public static function DateDifference($dateBegin, $dateEnd = '', $format = 'str')
    {
        $end = $dateEnd;
        $init = $dateBegin;

        if ($dateEnd == '')
            $dateEnd = date("Y-m-d H:i:s");

        if ($format == 'str') {
            $end = new DateTime($dateEnd);
            $init = new DateTime($dateBegin);
        }

        return $end->diff($init);
    }

    public static function close()
    {
        session_start();
        session_unset();
        session_destroy();

        header("Location: ./index.php", true);
    }
}