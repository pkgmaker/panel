<?php

require_once('DataType.php');

class Request
{
    public function get($param)
    {
        return new DataType(@$_GET[$param]);
    }

    public function post($param)
    {
        return new DataType(@$_POST[$param]);
    }

    public function req($param)
    {
        return new DataType(@$_REQUEST[$param]);
    }

    public function header($param)
    {
        $header = 'HTTP_'.strtoupper($param);
        return new DataType(@$_SERVER[$header]);
    }

    public function existGet($param)
    {
        return isset($_GET[$param]);
    }

    public function existPost($param)
    {
        return isset($_POST[$param]);
    }
}
