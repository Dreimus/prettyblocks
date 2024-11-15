<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element\Component\Menu;

use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\FieldType\Element\Component\AbstractComponentFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\PrestashopLinkSelectPrimitiveFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\SelectPrimitiveFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\TextPrimitiveFieldType;

class ExpandableMenuItem extends AbstractComponentFieldType
{
    protected string $slug = 'expandable_menu_item';
    public function isRepeatable(): bool
    {
        return true;
    }

    public function getFields(): FieldTypeCollection
    {
        return new FieldTypeCollection([
            (new TextPrimitiveFieldType())
                ->setLabel('Menu item text')
                ->setRequired(true),
            (new PrestashopLinkSelectPrimitiveFieldType())
                ->setLabel('Associated Category')
                ->setPrestashopClasses(
                    [\Category::class]
                )
                ->setRequired(true),
            (new SelectPrimitiveFieldType())
                ->setLabel('Menu item icon')
                ->setOptions($this->getIconChoices())
                ->setRequired(false),
            (new SimpleMenu())
                ->setLabel('Submenu')
                ->setRequired(false),
        ]);
    }

    public function getDefaultLabel(): string
    {
        return 'Item(s)';
    }

    protected function getIconChoices(): array
    {
        return [
            'tag' => 'Tag',
            'charcoal_barbecue' => 'Barbecue',
            'gas_barbecue' => 'Gas barbecue',
            'plancha' => 'Plancha',
            'outdoor_kitchen' => 'Outdoor kitchen',
            'pizza_oven' => 'Pizza oven',
            'pellets_barbecue' => 'Pellets barbecue',
            'electric_barbecue' => 'Electric barbecue',
            'brasero' => 'Brasero',
            'smoker' => 'Smoker',
            'accessories' => 'Accessories',
            'spare_parts' => 'Spare parts',
            'flag' => 'Flag',
            'size' => 'Size',
        ];
    }
}
