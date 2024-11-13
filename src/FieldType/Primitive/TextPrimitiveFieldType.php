<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Primitive;

class TextPrimitiveFieldType extends AbstractPrimitiveFieldType
{
    public function getType(): string
    {
        return 'text';
    }
}
