<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Primitive;

class NumberPrimitiveFieldType extends AbstractPrimitiveFieldType
{
    public function getType(): string
    {
        return 'number';
    }
}
