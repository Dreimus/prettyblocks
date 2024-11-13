<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Primitive;

class MapPrimitiveFieldType extends AbstractPrimitiveFieldType
{
    protected mixed $defaultValue = [];
    public function getType(): string
    {
        return 'map';
    }
}
