<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Primitive;

use PrestaSafe\PrettyBlocks\FieldType\AbstractFieldType;

abstract class AbstractPrimitiveFieldType extends AbstractFieldType implements PrimitiveFieldTypeInterface
{
    protected mixed $value;

    public function getDefaultLabel(): string
    {
        // Primitive fields use unique type, so we can use it as a default label
        return $this->getType();
    }

    public function getDefault(): array
    {
        return [
            'value' => $this->getDefaultValue(),
        ];
    }

    abstract public function getDefaultValue(): mixed;
}
