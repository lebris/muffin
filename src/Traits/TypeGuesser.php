<?php

namespace Mdd\QueryBuilder\Traits;

use Mdd\QueryBuilder\Types;

trait TypeGuesser
{
    private function guessType($columnName, $value)
    {
        $type = new Types\String($columnName);
        if(is_bool($value))
        {
            $type = new Types\Boolean($columnName);
        }

        if(is_int($value))
        {
            $type = new Types\Integer($columnName);
        }

        if(is_float($value))
        {
            $type = new Types\Float($columnName);
        }

        if($value instanceof \DateTime)
        {
            $type = new Types\Datetime($columnName);
        }

        return $type;
    }
}