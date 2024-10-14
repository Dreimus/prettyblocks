<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element\Component;

use PrestaSafe\PrettyBlocks\FieldType\Element\AbstractElementFieldType;

abstract class AbstractComponentFieldType extends AbstractElementFieldType implements ComponentFieldTypeInterface
{
    protected bool $isRepeatable;

    abstract public function isRepeatable(): bool;

    public function getType(): string
    {
        return 'component';
    }

    public function setRepeatable(bool $repeatable): ComponentFieldTypeInterface
    {
        $this->isRepeatable = $repeatable;

        return $this;
    }
}
