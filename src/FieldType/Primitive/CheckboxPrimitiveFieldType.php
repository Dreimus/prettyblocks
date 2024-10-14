<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Primitive;

class CheckboxPrimitiveFieldType extends AbstractPrimitiveFieldType
{
    public function getType(): string
    {
        return 'checkbox';
    }

    public function getDefaultValue(): bool
    {
        return false;
    }
}
