<?php
require_once '../../config/config.php';
require_once '../../vendor/autoload.php';

use \Firebase\JWT\JWT;

class ApiUtils
{
    public static function EncodeText($text)
    {
        return utf8_encode($text);
    }

    public static function ShortText($texto, $limite = 100)
    {
        $texto = str_replace(":", "", $texto);
        $texto = trim($texto);
        $texto = strip_tags($texto);
        $tamano = strlen($texto);
        $resultado = '';
        if ($tamano <= $limite) {
            return $texto;
        } else {
            $texto = mb_substr($texto, 0, $limite, 'UTF-8');
            $palabras = explode(' ', $texto);
            $resultado = implode(' ', $palabras);
            $resultado .= '...';
        }
        return $resultado;
    }

    public static function GenerateToken($idu)
    {
        $config = new config();
        $issuedAt = time();
        $notBefore = $issuedAt;
        $expire = $notBefore + 60 * 60 * 24;

        $data = [
            'iat' => $issuedAt,
            'nbf' => $notBefore,
            'exp' => $expire,
            'data' => ['idu' => $idu]
        ];

        $hash = md5(config::$tokenEncrypt);

        $token = JWT::encode($data, $hash, 'HS512');
        return $token;
    }
}