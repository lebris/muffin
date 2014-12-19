<?php

namespace Muffin\Queries\Snippets;

use Muffin\Snippet;

class OrderBy implements Snippet
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

    public function addOrderBy($column, $direction = self::ASC)
    {
        $this->validateDirection($direction);

        $this->orders[$column] = (string) $direction;
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
    }
}
