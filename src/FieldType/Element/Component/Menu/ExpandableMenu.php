<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element\Component\Menu;

use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\FieldType\Element\Component\AbstractComponentFieldType;

class ExpandableMenu extends AbstractComponentFieldType
{
    protected string $slug = 'expandable_menu';
    protected string $template = 'module:prettyblocks/templates/element/component/menu/expandable_menu.tpl';

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
