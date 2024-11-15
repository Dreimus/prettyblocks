<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element\Component\Slider;

use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\FieldType\Element\Component\AbstractComponentFieldType;

class TextSlider extends AbstractComponentFieldType
{
    protected string $slug = 'text_slider';
    public function isRepeatable(): bool
    {
        return false;
    }

    public function getFields(): FieldTypeCollection
    {
        return new FieldTypeCollection([
            (new TextSliderItem())
                ->setLabel('Slides')
                ->setSlug('slides')
                ->setRequired(true),
        ]);
    }

    public function getDefaultLabel(): string
    {
        return 'Text Slider';
    }
}
