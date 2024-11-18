<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element\Component;

use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\FieldType\Element\Component\AbstractComponentFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\LinkPrimitiveFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\SelectPrimitiveFieldType;

class ShopsListing extends AbstractComponentFieldType
{
    protected string $slug = 'shop_listing';
    protected string $template = 'module:prettyblocks/templates/element/component/shop_listing.tpl';

    public function isRepeatable(): bool
    {
        return true;
    }

    public function getFields(): FieldTypeCollection
    {
        return new FieldTypeCollection([
            (new SelectPrimitiveFieldType())
                ->setLabel('Logo')
                ->setSlug('icon')
                ->setOptions($this->getIconChoices())
                ->setRequired(false),
            (new LinkPrimitiveFieldType())
                ->setLabel('Link and Description')
                ->setSlug('link')
                ->setLinkLabel('Raviday')
                ->setLinkUrl('https://www.raviday.com')
                ->setRequired(false),
        ]);
    }

    public function getDefaultLabel(): string
    {
        return 'Logo(s)';
    }

    protected function getIconChoices(): array
    {
        return [
            'raviday_jardin' => 'Raviday Jardin',
            'raviday_jardin-dark' => '[DARK] - Raviday Jardin',
            'raviday_matelas' => 'Raviday Matelas',
            'raviday_matelas-dark' => '[DARK] - Raviday Matelas',
            'raviday_piscine' => 'Raviday Piscine',
            'raviday_piscine-dark' => '[DARK] - Raviday Piscine',
            'raviday_barbecue' => 'Raviday Barbecue',
            'raviday_barbecue-dark' => '[DARK] - Raviday Barbecue',
            'raviday_allemagne' => 'Raviday Allemagne',
            'raviday_allemagne-dark' => '[DARK] - Raviday Allemagne',
        ];
    }
}
