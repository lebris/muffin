<?php

namespace Muffin\Queries\Snippets;

use Muffin\Snippet;
use Muffin\Type;
use Muffin\Types;
use Muffin\Traits\EscaperAware;
use Muffin\Types\String;
use Muffin\Traits\TypeGuesser;

class Values implements Snippet
{
    use
        EscaperAware,
        TypeGuesser;

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
                $type = $this->guessType($columnName, $value);

                $valuesSet[] = $this->formatValue($type, $value);
            }
        }

        return $this->wrapWithParentheses(implode(', ', $valuesSet));
    }

    private function formatValue(Type $type, $value)
    {
        if(is_null($value))
        {
            return 'NULL';
        }

        return $this->escapeValue($type, $value);
    }

    private function escapeValue(Type $type, $value)
    {
        $value = $type->format($value);

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
}
