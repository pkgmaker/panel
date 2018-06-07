<?php

class Crypto {

    private static $_workFactor = 12;
    private static $_identifier = '2y';
    private static $_validIdentifiers = array ('2a', '2x', '2y');
    private static $_method = "aes-256-cbc";

    private static function KeyValue($CRYPT_KEY)
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

    public static function encrypt($txt, $CRYPT_KEY){
        if (!$txt && $txt != "0") {
            return false;
            exit;
        }

        if (!$CRYPT_KEY) {
            return false;
            exit;
        }

        $kv = self::KeyValue($CRYPT_KEY);
        $estr = "";
        $enc = "";

        for ($i = 0; $i < strlen($txt); $i++) {
            $e = ord(substr($txt, $i, 1));
            $e = $e + $kv[1];
            $e = $e * $kv[2];
            (double)microtime() * 1000000;
            $rstr = chr(rand(65, 90));
            $estr .= "$rstr$e";
        }

        return $estr;
    }

    public static function decrypt($txt, $CRYPT_KEY){
        if (!$txt && $txt != "0") {
            return false;
            exit;
        }

        if (!$CRYPT_KEY) {
            return false;
            exit;
        }

        $kv = self::KeyValue($CRYPT_KEY);
        $estr = "";
        $tmp = "";

        for ($i = 0; $i < strlen($txt); $i++) {
            if (ord(substr($txt, $i, 1)) > 64 && ord(substr($txt,
                    $i, 1)) < 91) {
                if ($tmp != "") {
                    $tmp = $tmp / $kv[2];
                    $tmp = $tmp - $kv[1];
                    $estr .= chr($tmp);
                    $tmp = "";
                }
            } else {
                $tmp .= substr($txt, $i, 1);
            }
        }

        $tmp = $tmp / $kv[2];
        $tmp = $tmp - $kv[1];
        $estr .= chr($tmp);

        return $estr;
    }

    public static function hashPassword($password, $workFactor = 0) {
        if (version_compare(PHP_VERSION, '5.3') < 0) {
            throw new Exception('Me :) requires PHP 5.3 or above');
        }

        $salt = self::_genSalt($workFactor);
        return crypt($password, $salt);
    }
    public static function checkPassword($password, $storedHash) {
        if (version_compare(PHP_VERSION, '5.3') < 0) {
            throw new Exception('Me :) requires PHP 5.3 or above');
        }

        self::_validateIdentifier($storedHash);
        $checkHash = crypt($password, $storedHash);

        return ($checkHash === $storedHash);
    }
    private static function _genSalt($workFactor) {
        if ($workFactor < 4 || $workFactor > 31) {
            $workFactor = self::$_workFactor;
        }

        $input = self::_getRandomBytes();
        $salt = '$' . self::$_identifier . '$';

        $salt .= str_pad($workFactor, 2, '0', STR_PAD_LEFT);
        $salt .= '$';

        $salt .= substr(strtr(base64_encode($input), '+', '.'), 0, 22);

        return $salt;
    }
    private static function _getRandomBytes() {
        if (!function_exists('openssl_random_pseudo_bytes')) {
            throw new Exception('Unsupported hash format.');
        }
        return openssl_random_pseudo_bytes(16);
    }
    private static function _validateIdentifier($hash) {
        if (!in_array(substr($hash, 1, 2), self::$_validIdentifiers)) {
            throw new Exception('Unsupported hash format.');
        }
    }
}