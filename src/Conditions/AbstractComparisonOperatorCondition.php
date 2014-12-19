<?php

namespace Muffin\Conditions;

use Muffin\Escaper;
use Muffin\Type;

abstract class AbstractComparisonOperatorCondition extends AbstractCondition
{
    protected
        $leftOperand,
        $rightOperand;

    public function __construct(Type $leftOperand, $rightOperand)
    {
        $this->leftOperand = $leftOperand;
        $this->rightOperand = $rightOperand;
    }

    public function toString(Escaper $escaper)
    {
        if($this->isEmpty())
        {
            return '';
        }

        return sprintf(
            '%s %s %s',
            $this->generateFieldOperand($this->leftOperand),
            $this->getConditionOperator(),
            $this->generateRightOperand($escaper)
        );
    }

    private function generateFieldOperand(Type $field)
    {
        return $field->getName();
    }

    private function generateRightOperand(Escaper $escaper)
    {
        if($this->rightOperand instanceof Type)
        {
            return $this->generateFieldOperand($this->rightOperand);
        }

        return $this->escapeValue($this->rightOperand, $escaper);
    }

    public function isEmpty()
    {
        $columnName = $this->leftOperand->getName();

        return empty($columnName);
    }

    abstract protected function getConditionOperator();

    private function escapeValue($value, Escaper $escaper)
    {
        $value = $this->leftOperand->format($value);

        if($this->leftOperand->isEscapeRequired())
        {
            $value = $escaper->escape($value);
        }

        return $value;
    }
}
