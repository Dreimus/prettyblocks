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
    protected string $template = 'module:prettyblocks/templates/element/block/pre_header.tpl';
    public function isRepeatable(): bool
    {
        return false;
    }

    public function getFields(): FieldTypeCollection
    {
        return new FieldTypeCollection([
            (new TextPrimitiveFieldType())
                ->setLabel('Label - All Shops')
                ->setSlug('label_all_shops')
                ->setDefaultValue('Tous nos magasins')
                ->setRequired(true),
            (new PreHeaderShops())
                ->setLabel('Shops')
                ->setSlug('shops')
                ->setRequired(true),
            (new PreHeaderReassurances())
                ->setLabel('Reassurances')
                ->setSlug('reassurances')
                ->setRequired(true),
        ]);
    }

    public function getDefaultLabel(): string
    {
        return 'Contenu de l\'entête';
    }
}
