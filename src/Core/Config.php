<?php
namespace BlueSky\Core;

class Config
{
    private static $values = null;
    private $prefix = 'config';

    public function __clone() {}
    public function __wakeup() {}

    public function __construct()
    {
        $configPath = ROOT_DIR . '/config/';
        foreach (glob($configPath.'*.php') as $file) {
            $fileName = getFileName($file);
            self::$values[$this->prefix][$fileName] = include $file;
        }
    }

    public function get(string $name = '')
    {
        if (empty($name)) {
            return self::$values;
        }
        if (str_contains($name, '.') == false) {
            return self::$values[$this->prefix][$name];
        }
        return $this->getFromDeepArray($name, self::$values[$this->prefix]);
    }

    public function set(string $name, string $value): void
    {
        if (empty($name)) {
            return;
        }
        if (strpos($name, '.') == false) {
            self::$values[$this->prefix][$name] = $value;
        }
        $this->setToDeepArray(self::$values[$this->prefix], $name, $value);
    }

    private function getFromDeepArray(string $name, array &$arr)
    {
        $pos = strpos($name,'.');
        if ($pos == false) {
            return $arr[$name] ?? '';
        }
        $key = substr($name, 0, $pos);
        $rest = substr($name, $pos + 1);
        if (!is_array($arr[$key])) {
            return $arr[$key];
        }
        return $this->getFromDeepArray($rest, $arr[$key]);
    }

    private function setToDeepArray(array &$arr, string $name, string $value)
    {
        $pos = strpos($name,'.');
        if ($pos == false) {
            $arr[$name] = $value;
            return;
        }
        $key = substr($name, 0, $pos);
        $rest = substr($name, $pos + 1);

        $this->setToDeepArray($arr[$key], $rest, $value);
    }
}