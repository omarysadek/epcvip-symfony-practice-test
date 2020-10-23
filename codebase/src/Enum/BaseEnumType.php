<?php

namespace App\Enum;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

abstract class BaseEnumType extends Type
{
    protected static $constantsArray = array();

    protected $name;

    protected $values = [];

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        $values = array_map(function($val) { return "'".$val."'"; }, $this->values);

        return "ENUM(".implode(", ", $values).")";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!in_array($value, $this->values)) {
            throw new \InvalidArgumentException("Invalid '".$this->name."' value.");
        }
        return $value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }

    public static function getConstants(): array
    {
        $calledClass = get_called_class();

        if (!isset(self::$constantsArray[$calledClass])) {
            $reflect = new \ReflectionClass($calledClass);
            self::$constantsArray[$calledClass] = $reflect->getConstants();
        }

        return self::$constantsArray[$calledClass];
    }

    public static function getValues(): array
    {
        return array_values(self::getConstants());
    }

    public static function isValidValue($value, $caseSensitive = false): bool
    {
        if (is_null($value)) {
            return false;
        }

        return in_array((is_int($value) ? $value : (!$caseSensitive ? strtolower($value) : $value)), self::getValues(), true);
    }
}