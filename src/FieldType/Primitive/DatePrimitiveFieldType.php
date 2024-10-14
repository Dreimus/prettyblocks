<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Primitive;

class DatePrimitiveFieldType extends AbstractPrimitiveFieldType
{
    public function getType(): string
    {
        return 'date';
    }

    public function getDefaultValue(): string
    {
        return '';
    }
}
