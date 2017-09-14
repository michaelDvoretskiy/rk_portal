<?php

namespace KvintBundle\DoctrineType;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class DateTimeSql2000 extends Type
{
    const MYTYPE = 'datetime_sql2000'; // modify to match your type name

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'datetime';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (!is_null($value)) {
            return \DateTime::createFromFormat('Y-m-d H:i:s', substr($value,0,19));
        }
        return $value;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!is_null($value)) {
            return $value->format("Y-m-d H:i:s");
        }
        return $value;
    }

    public function getName()
    {
        return self::MYTYPE; // modify to match your constant name
    }
}