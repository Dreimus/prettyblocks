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
            (new TextAreaPrimitiveFieldType())
                ->setLabel('Les + de Raviday - Titre')
                ->setRequired(true),
            (new TextAreaPrimitiveFieldType())
                ->setLabel('Les + de Raviday - Contenu')
                ->setRequired(true),
            (new TextPrimitiveFieldType())
                ->setLabel('Nos Produits - Titre')
                ->setRequired(true)
                ->setDefaultValue('Nos produits'),
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
