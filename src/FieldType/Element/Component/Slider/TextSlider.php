<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element\Component\Slider;

use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\FieldType\Element\Component\AbstractComponentFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\LinkPrimitiveFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\WysiwygPrimitiveFieldType;

class TextSlider extends AbstractComponentFieldType
{
    protected string $slug = 'text_slider';
    protected string $template = 'module:prettyblocks/templates/element/component/slider/text_slider.tpl';

    public function isRepeatable(): bool
    {
        return true;
    }

    public function getFields(): FieldTypeCollection
    {
        return new FieldTypeCollection(
            [
                (new WysiwygPrimitiveFieldType())
                    ->setLabel('Text')
                    ->setSlug('text')
                    ->setRequired(true),
            ]
        );
    }

    public function getDefaultLabel(): string
    {
        return 'Slider';
    }
}
