<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element\Block;

use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\Entity\Block\Block\GenericBlock;
use PrestaSafe\PrettyBlocks\FieldType\Element\Component\Menu\SimpleMenu;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\TextAreaPrimitiveFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\TextPrimitiveFieldType;

class Footer extends AbstractBlockFieldType
{
    public function isRepeatable(): bool
    {
        return false;
    }

    public function getFields(): FieldTypeCollection
    {
        return new FieldTypeCollection([
            (new TextAreaPrimitiveFieldType())
                ->setLabel('Seo description')
                ->setRequired(true),
            (new TextPrimitiveFieldType())
                ->setLabel('Raviday + - Title')
                ->setRequired(true),
            (new TextAreaPrimitiveFieldType())
                ->setLabel('Raviday + - Content')
                ->setRequired(true),
            (new TextPrimitiveFieldType())
                ->setLabel('Our Products - Title')
                ->setRequired(true)
                ->setDefaultValue('Our Products'),
            (new SimpleMenu())
                ->setLabel('Our Products - Menu')
                ->setRequired(true),
            (new TextPrimitiveFieldType())
                ->setLabel('Useful Links - Title')
                ->setRequired(true)
                ->setDefaultValue('Useful Links'),
            (new SimpleMenu())
                ->setLabel('Useful Links - Menu')
                ->setRequired(true),
        ]);
    }

    public function getDefaultLabel(): string
    {
        return 'Footer';
    }

    public function getDataClass(): string|null
    {
        return GenericBlock::class;
    }
}
