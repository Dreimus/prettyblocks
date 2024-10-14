<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element\Block;

use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\Entity\Block\Block\GenericBlock;
use PrestaSafe\PrettyBlocks\FieldType\Element\Component\Menu\SimpleMenu;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\TextAreaPrimitiveFieldType;

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
            (new SimpleMenu())
                ->setLabel('Les + de Raviday')
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
