<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element\Component\Menu;

use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\FieldType\Element\Component\AbstractComponentFieldType;

class SimpleMenu extends AbstractComponentFieldType
{
    protected string $slug = 'simple_menu';
    public function isRepeatable(): bool
    {
        return false;
    }

    public function getFields(): FieldTypeCollection
    {
        return new FieldTypeCollection([
            (new SimpleMenuItem())
                ->setLabel('Menu Item List')
                ->setSlug('menu_item_list')
                ->setRequired(true),
        ]);
    }

    public function getDefaultLabel(): string
    {
        return 'Simple Menu';
    }
}
