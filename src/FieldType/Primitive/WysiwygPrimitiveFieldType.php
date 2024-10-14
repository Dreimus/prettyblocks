<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Primitive;

class WysiwygPrimitiveFieldType extends AbstractPrimitiveFieldType
{
    public function getType(): string
    {
        return 'wysiwyg';
    }

    public function getDefaultValue(): string
    {
        return '';
    }
}
