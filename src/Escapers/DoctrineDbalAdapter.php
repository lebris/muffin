<?php

namespace Mdd\QueryBuilder\Escapers;

use Mdd\QueryBuilder\Escaper;
use Doctrine\DBAL\Driver\Connection;

class DoctrineDbalAdapter implements Escaper
{
    private
        $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function escape($value)
    {
        return $this->db->quote($value);
    }
}
