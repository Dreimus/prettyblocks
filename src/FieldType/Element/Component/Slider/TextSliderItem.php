<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element\Component\Slider;

use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\FieldType\Element\Component\AbstractComponentFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\LinkPrimitiveFieldType;

class TextSliderItem extends AbstractComponentFieldType
{
    protected string $slug = 'text_slider_item';
    public function isRepeatable(): bool
    {
        return true;
    }

    public function getFields(): FieldTypeCollection
    {
        return new FieldTypeCollection([
            (new LinkPrimitiveFieldType())
                ->setLabel('Link')
                ->setSlug('link')
                ->setRequired(true),
        ]);
    }

    public function getDefaultLabel(): string
    {
        return 'Slide(s)';
    }
}
