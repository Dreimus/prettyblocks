<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element\Component\PreHeader;

use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\FieldType\Element\Component\AbstractComponentFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\LinkPrimitiveFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\SelectPrimitiveFieldType;

class PreHeaderShops extends AbstractComponentFieldType
{
    protected string $slug = 'pre_header_shops';
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
            'raviday_matelas' => 'Raviday Matelas',
            'raviday_piscine' => 'Raviday Piscine',
            'raviday_barbecue' => 'Raviday Barbecue',
            'raviday_allemagne' => 'Raviday Allemagne',
        ];
    }
}
