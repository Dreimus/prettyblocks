<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Primitive;

class SwitchPrimitiveFieldType extends AbstractPrimitiveFieldType
{
    public function getType(): string
    {
        return 'switch';
    }

    public function getDefaultValue(): bool
    {
        return false;
    }
}
