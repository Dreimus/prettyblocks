<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Primitive;

class TextAreaPrimitiveFieldType extends AbstractPrimitiveFieldType
{
    public function getType(): string
    {
        return 'textarea';
    }

    public function getDefaultValue(): string
    {
        return '';
    }
}
