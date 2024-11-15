<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element\Block;

use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\Entity\Block\Block\GenericBlock;
use PrestaSafe\PrettyBlocks\FieldType\Element\Component\Slider\TextSlider;

class PromotionSlider extends AbstractBlockFieldType
{
    protected string $slug = 'promotion_slider';
    public function isRepeatable(): bool
    {
        return false;
    }

    public function getFields(): FieldTypeCollection
    {
        return new FieldTypeCollection([
            (new TextSlider())
                ->setLabel('Slider')
                ->setSlug('slider')
                ->setRequired(true),
        ]);
    }

    public function getDefaultLabel(): string
    {
        return 'Promotion Slider';
    }

    public function getDataClass(): string|null
    {
        return GenericBlock::class;
    }
}
