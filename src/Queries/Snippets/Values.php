<?php

namespace Mdd\QueryBuilder\Queries\Snippets;

use Mdd\QueryBuilder\Snippet;
use Mdd\QueryBuilder\Type;
use Mdd\QueryBuilder\Types;
use Mdd\QueryBuilder\Traits\EscaperAware;
use Mdd\QueryBuilder\Types\String;

class Values implements Snippet
{
    use EscaperAware;

    private
        $values;

    public function __construct($values = null)
    {
        $this->values = array();

        if(! empty($values))
        {
            $this->values($values);
        }
    }

    public function values(array $values)
    {
        $this->values[] = $values;

        return $this;
    }

    public function toString()
    {
        if(empty($this->values))
        {
            throw new \RuntimeException('No values to insert');
        }

        $columnsNameList = array_filter(array_keys(reset($this->values)));

        $values = array();
        foreach($this->values as $valuesSet)
        {
            if($columnsNameList !== array_keys($valuesSet))
            {
                throw new \RuntimeException('Cannot insert different schema on the same table.');
            }

            $values[] = $this->buildValuesSetString($valuesSet);
        }

        return sprintf(
            '%s VALUES %s',
            $this->wrapWithParentheses(implode(', ', $columnsNameList)),
            implode(', ', $values)
        );
    }

    private function buildValuesSetString(array $values)
    {
        $valuesSet = array();
        foreach($values as $columnName => $value)
        {
            if(! empty($columnName))
            {
                $valuesSet[] = $this->formatValue($value);
            }
        }

        return $this->wrapWithParentheses(implode(', ', $valuesSet));
    }

    private function formatValue($value)
    {
        if(is_null($value))
        {
            return 'NULL';
        }

        $type = $this->guessType($value);

        return $this->escapeValue($type);
    }

    private function escapeValue(Type $type)
    {
        $value = $type->getValue();

        if($type->isEscapeRequired())
        {
            $value = $this->escaper->escape($value);
        }

        return $value;
    }

    private function wrapWithParentheses($value)
    {
        return sprintf('(%s)', $value);
    }

    private function guessType($value)
    {
        if(is_int($value))
        {
            return new Types\Integer($value);
        }

        if(is_float($value))
        {
            return new Types\Float($value);
        }

        if($value instanceof \DateTime)
        {
            return new Types\Datetime($value);
        }

        return new Types\String($value);
    }
}
