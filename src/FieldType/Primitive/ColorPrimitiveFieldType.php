<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Primitive;

class ColorPrimitiveFieldType extends AbstractPrimitiveFieldType
{
    protected mixed $defaultValue = '#000000';

    public function getType(): string
    {
        return 'color';
    }

}
