<?php

namespace Muffin\Queries\Snippets;

use Muffin\Snippet;

class Count implements Snippet, Selectable
{
    private
        $columnName,
        $alias;

    public function __construct($columnName, $alias = null)
    {
        if((! $columnName instanceof Snippet) && empty($columnName))
        {
            throw new \InvalidArgumentException('Empty column name.');
        }

        $this->columnName = $columnName;
        $this->alias = $alias;
    }

    public function toString()
    {
        return implode(' ', array_filter(array(
            $this->buildCountSnippet(),
            $this->buildAliasSnippet()
        )));
    }

    private function buildCountSnippet()
    {
        $columnName = $this->columnName;

        if($columnName instanceof Snippet)
        {
            $columnName = $columnName->toString();
        }

        return sprintf('COUNT(%s)', $columnName);
    }

    private function buildAliasSnippet()
    {
        $alias = $this->alias;

        if(! empty($alias))
        {
            return sprintf('AS %s', $alias);
        }
    }
}
