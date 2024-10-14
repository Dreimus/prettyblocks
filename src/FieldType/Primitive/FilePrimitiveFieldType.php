<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Primitive;

class FilePrimitiveFieldType extends AbstractPrimitiveFieldType
{
    public function getType(): string
    {
        return 'file';
    }

    public function getDefaultValue(): string
    {
        return '';
    }
}
