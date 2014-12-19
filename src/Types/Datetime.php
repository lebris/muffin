<?php

namespace Muffin\Types;

class Datetime extends AbstractType
{
    const
        MYSQL_DATETIME_FORMAT = 'Y-m-d H:i:s';

    public function isEscapeRequired()
    {
        return true;
    }

    public function format($value)
    {
        if($value instanceof \DateTime)
        {
            return $value->format(self::MYSQL_DATETIME_FORMAT);
        }

        return (string) $value;
    }
}
