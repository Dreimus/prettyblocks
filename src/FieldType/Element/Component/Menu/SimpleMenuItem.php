<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element\Component\Menu;

use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\FieldType\Element\Component\AbstractComponentFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\CheckboxPrimitiveFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\LinkPrimitiveFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\SwitchPrimitiveFieldType;

class SimpleMenuItem extends AbstractComponentFieldType
{
    public function isRepeatable(): bool
    {
        return true;
    }

    public function getFields(): FieldTypeCollection
    {
        return new FieldTypeCollection([
            (new LinkPrimitiveFieldType())
                ->setLabel('Link')
                ->setRequired(true),
            (new SwitchPrimitiveFieldType())
                ->setLabel('Mis en avant')
                ->setRequired(true),
        ]);
    }

    public function getDefaultLabel(): string
    {
        return 'Item(s)';
    }
}
