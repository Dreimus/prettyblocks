<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Primitive;

class TextAreaPrimitiveFieldType extends AbstractPrimitiveFieldType
{
    protected mixed $defaultValue = '';

    public function getType(): string
    {
        return 'textarea';
    }
}
