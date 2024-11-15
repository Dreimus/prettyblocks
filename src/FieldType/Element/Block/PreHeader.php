<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element\Block;

use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\Entity\Block\Block\GenericBlock;
use PrestaSafe\PrettyBlocks\FieldType\Element\Component\PreHeader\PreHeaderReassurances;
use PrestaSafe\PrettyBlocks\FieldType\Element\Component\PreHeader\PreHeaderShops;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\TextPrimitiveFieldType;

class PreHeader extends AbstractBlockFieldType
{
    protected string $slug = 'pre_header';
    public function isRepeatable(): bool
    {
        return false;
    }

    public function getFields(): FieldTypeCollection
    {
        return new FieldTypeCollection([
            (new TextPrimitiveFieldType())
                ->setLabel('Label - All Shops')
                ->setRequired(true),
            (new PreHeaderShops())
                ->setLabel('Shops')
                ->setRequired(true),
            (new PreHeaderReassurances())
                ->setLabel('Reassurances')
                ->setRequired(true),
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
