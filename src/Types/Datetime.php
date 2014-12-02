<?php

namespace Mdd\QueryBuilder\Types;

class Datetime extends AbstractType
{
    const
        MYSQL_DATETIME_FORMAT = 'Y-m-d H:i:s';

    public function isEscapeRequired()
    {
        return true;
    }

    protected function format($value)
    {
        if($value instanceof \DateTime)
        {
            return $value->format(self::MYSQL_DATETIME_FORMAT);
        }

        return (string) $value;
    }
}