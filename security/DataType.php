<?php

class DataType
{
    private $value = null;

    /**
     * DataType constructor.
     * @param mixed $val
     */
    public function __construct($val)
    {
        if (!empty($val)) 
            $this->value = $val;
    }

    /**
     * @return int|null
     */
    public function getInt()
    {
        return abs($this->getDataType($this->value, 'int'));
    }

    /**
     * @return float|null
     */
    public function getFloat()
    {
        return abs($this->getDataType($this->value, 'float'));
    }

    /**
     * @return string|null
     */
    public function getString()
    {
        return $this->getDataType($this->scapeString($this->value), 'string');
    }

    /**
     * @return bool|null
     */
    public function getBool()
    {
        return $this->getDataType($this->value, 'bool');
    }

    /**
     * @return array|null
     */
    public function getArray()
    {
        return (is_array($this->value)) ? $this->getDataType($this->value, 'array') : null;
    }

    private function getDataType($value, $type)
    {
        settype($value, $type);
        return $value;
    }

    public static function scapeString($unescaped)
    {
        $replacements = array(
            "\x00" => '\x00',
            "\n" => '\n',
            "\r" => '\r',
            "\\" => '\\\\',
            "'" => "\'",
            '"' => '\"',
            "\x1a" => '\x1a'
        );
        return strtr($unescaped, $replacements);
    }

    public function __toString()
    {
        return $this->getString();
    }
}