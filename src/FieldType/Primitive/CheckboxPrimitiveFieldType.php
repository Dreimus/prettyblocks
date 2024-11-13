<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Primitive;

class CheckboxPrimitiveFieldType extends AbstractPrimitiveFieldType
{
    protected mixed $defaultValue = false;
    public function getType(): string
    {
        return 'checkbox';
    }
}
