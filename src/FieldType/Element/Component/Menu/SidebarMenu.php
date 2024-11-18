<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element\Component\Menu;

use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\FieldType\Element\Component\AbstractComponentFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\RavipotePrimitiveFieldType;

class SidebarMenu extends AbstractComponentFieldType
{
    protected string $slug = 'sidebar_menu';
    protected string $template = 'module:prettyblocks/templates/element/component/menu/sidebar_menu.tpl';

    public function isRepeatable(): bool
    {
        return false;
    }

    public function getFields(): FieldTypeCollection
    {
        return new FieldTypeCollection([
            (new ExpandableMenu())
                ->setLabel('Expandable Menu')
                ->setSlug('expandable_menu')
                ->setRequired(true),
            (new SimpleMenu())
                ->setLabel('Sidebar footer menu')
                ->setSlug('sidebar_footer_menu')
                ->setRequired(true),
            (new RavipotePrimitiveFieldType())
                ->setLabel('Footer RaviPote')
                ->setSlug('footer_ravipote')
                ->setRequired(true),
        ]);
    }

    public function getDefaultLabel(): string
    {
        return 'Sidebar Menu';
    }
}
