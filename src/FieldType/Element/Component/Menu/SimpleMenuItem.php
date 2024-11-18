<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element\Component\Menu;

use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\FieldType\Element\Component\AbstractComponentFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\CheckboxPrimitiveFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\LinkPrimitiveFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\EntitySelectorPrimitiveFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\SwitchPrimitiveFieldType;
use PrestaShopCollection;
use Product;

class SimpleMenuItem extends AbstractComponentFieldType
{
    protected string $slug = 'simple_menu_item';
    protected string $template = 'module:prettyblocks/templates/element/component/menu/simple_menu_item.tpl';

    public function isRepeatable(): bool
    {
        return true;
    }

    public function getFields(): FieldTypeCollection
    {
        return new FieldTypeCollection([
            (new EntitySelectorPrimitiveFieldType())
                ->setLabel('Link')
                ->setSlug('link')
                ->setRequired(true),
            (new SwitchPrimitiveFieldType())
                ->setLabel('Mis en avant')
                ->setSlug('highlighted')
                ->setRequired(true),
        ]);
    }

    public function getDefaultLabel(): string
    {
        return 'Item(s)';
    }

}
