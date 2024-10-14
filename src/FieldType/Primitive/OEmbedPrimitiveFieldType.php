<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Primitive;

class OEmbedPrimitiveFieldType extends AbstractPrimitiveFieldType
{
    public function getType(): string
    {
        return 'oembed';
    }

    public function getDefaultValue(): string
    {
        return '';
    }
}
