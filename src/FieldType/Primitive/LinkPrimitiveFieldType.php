<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Primitive;

class LinkPrimitiveFieldType extends AbstractPrimitiveFieldType
{
    public function getType(): string
    {
        return 'link';
    }

    public function getDefaultValue(): mixed
    {
        return null;
    }

    public function getDefault(): array
    {
        return [
            'label' => 'Link text',
            'href' => 'https://www.example.com',
        ];
    }
}
