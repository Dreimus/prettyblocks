<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element\Block;

use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\Entity\Block\Block\GenericBlock;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\TextPrimitiveFieldType;

class PreHeader extends AbstractBlockFieldType
{
    public function isRepeatable(): bool
    {
        return false;
    }

    public function getFields(): FieldTypeCollection
    {
        return new FieldTypeCollection([
            (new TextPrimitiveFieldType())
                ->setLabel('Label Raviday Matelas')
                ->setRequired(true),
            (new TextPrimitiveFieldType())
                ->setLabel('Label Raviday Piscine')
                ->setRequired(true),
            (new TextPrimitiveFieldType())
                ->setLabel('Label Raviday Jardin')
                ->setRequired(true),
            (new TextPrimitiveFieldType())
                ->setLabel('Label Raviday Barbecue')
                ->setRequired(true),
            (new TextPrimitiveFieldType())
                ->setLabel('Label Raviday Allemagne')
                ->setRequired(true),
            (new TextPrimitiveFieldType())
                ->setLabel('Avis Vérifiés'),
            (new TextPrimitiveFieldType())
                ->setLabel('Livraison'),
            (new TextPrimitiveFieldType())
                ->setLabel('Besoin d\'aide'),
            (new TextPrimitiveFieldType())
                ->setLabel('Contact Phone'),
        ]);
    }

    public function getDefaultLabel(): string
    {
        return 'Contenu de l\'entête';
    }

    public function getDataClass(): string|null
    {
        return GenericBlock::class;
    }
}
