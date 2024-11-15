<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element\Component\Menu;

use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\FieldType\Element\Component\AbstractComponentFieldType;

class ExpandableMenu extends AbstractComponentFieldType
{
    public function isRepeatable(): bool
    {
        return false;
    }

    public function getFields(): FieldTypeCollection
    {
        return new FieldTypeCollection([
            (new ExpandableMenuItem())
                ->setLabel('Menu item(s)')
                ->setRequired(true),
        ]);
    }

    public function getDefaultLabel(): string
    {
        return 'Expandable Menu';
    }
}