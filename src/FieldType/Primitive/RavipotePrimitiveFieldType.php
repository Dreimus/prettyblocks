<?php

namespace PrestaSafe\PrettyBlocks\FieldType\Primitive;

use PrestaSafe\PrettyBlocks\FieldType\Primitive\SelectPrimitiveFieldType;

class RavipotePrimitiveFieldType extends SelectPrimitiveFieldType
{
    public function getType(): string
    {
        return 'ravipote';
    }
}
