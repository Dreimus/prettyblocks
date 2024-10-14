<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element\Block;

use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\Entity\Block\Block\GenericBlock;
use PrestaSafe\PrettyBlocks\FieldType\Element\Component\Menu\SidebarMenu;
use PrestaSafe\PrettyBlocks\FieldType\Element\Component\Menu\SimpleMenu;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\TextPrimitiveFieldType;

class NavigationMenu extends AbstractBlockFieldType
{
    public function isRepeatable(): bool
    {
        return false;
    }

    public function getFields(): FieldTypeCollection
    {
        return new FieldTypeCollection([
            (new SimpleMenu())
                ->setLabel('Quick Menu')
                ->setRequired(true),
            (new TextPrimitiveFieldType())
                ->setLabel('Menu button text')
                ->setRequired(true),
            (new SidebarMenu())
                ->setLabel('Sidebar Menu')
                ->setRequired(true),
        ]);
    }

    public function getDefaultLabel(): string
    {
        return 'Navigation Menu';
    }

    public function getDataClass(): string|null
    {
        return GenericBlock::class;
    }
}
