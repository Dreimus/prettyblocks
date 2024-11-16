<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element\Block;

use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\FieldType\Element\Component\Menu\SidebarMenu;
use PrestaSafe\PrettyBlocks\FieldType\Element\Component\Menu\SimpleMenu;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\TextPrimitiveFieldType;

class NavigationMenu extends AbstractBlockFieldType
{
    protected string $slug = 'navigation_menu';
    protected string $template = 'module:prettyblocks/templates/element/block/navigation_menu.tpl';

    public function isRepeatable(): bool
    {
        return false;
    }

    public function getFields(): FieldTypeCollection
    {
        return new FieldTypeCollection([
            (new SimpleMenu())
                ->setLabel('Quick Menu')
                ->setSlug('quick_menu')
                ->setRequired(true),
            (new TextPrimitiveFieldType())
                ->setLabel('Menu button text')
                ->setSlug('menu_button_text')
                ->setRequired(true),
            (new SidebarMenu())
                ->setLabel('Sidebar Menu')
                ->setSlug('sidebar_menu')
                ->setRequired(true),
        ]);
    }

    public function getDefaultLabel(): string
    {
        return 'Navigation Menu';
    }
}
