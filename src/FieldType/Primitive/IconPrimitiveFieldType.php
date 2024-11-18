<?php

namespace PrestaSafe\PrettyBlocks\FieldType\Primitive;

use PrestaSafe\PrettyBlocks\FieldType\Primitive\SelectPrimitiveFieldType;

class IconPrimitiveFieldType extends SelectPrimitiveFieldType
{
    public function getType(): string
    {
        return 'icon';
    }
}

