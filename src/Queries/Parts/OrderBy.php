<?php

namespace Mdd\QueryBuilder\Queries\Parts;

use Mdd\QueryBuilder\PartBuilder;

class OrderBy implements PartBuilder
{
    const
        ASC = 'ASC',
        DESC = 'DESC';

    private
        $orders;

    public function __construct()
    {
        $this->orders = array();
    }

    public function orderBy($column, $direction = self::ASC)
    {
        $directrion = $this->validateDirection((string) $direction);

        $this->orders[$column] = $direction;
    }

    public function toString()
    {
        $orders = array();
        foreach($this->orders as $column => $direction)
        {
            if(! empty($column))
            {
                $orders[] = $column . ' ' . $direction;
            }
        }

        if(empty($orders))
        {
            return '';
        }

        return sprintf('ORDER BY %s', implode(', ', $orders));
    }

    private function validateDirection($direction)
    {
        $availableDirections = array(self::ASC, self::DESC);
        if(! in_array($direction, $availableDirections))
        {
            throw new \InvalidArgumentException(sprintf('Unsupported ORDER BY direction "%s"', $direction));
        }

        $this->direction = $direction;
    }
}