<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element\Block;

use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\Entity\Block\Block\GenericBlock;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\TextAreaPrimitiveFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\TextPrimitiveFieldType;

class Footer extends AbstractBlockFieldType
{
    protected string $slug = 'footer';
    protected string $template = 'module:prettyblocks/templates/element/block/footer.tpl';

    public function isRepeatable(): bool
    {
        return false;
    }

    public function getFields(): FieldTypeCollection
    {
        return new FieldTypeCollection([
            (new TextAreaPrimitiveFieldType())
                ->setLabel('Seo description')
                ->setSlug('seo_description')
                ->setRequired(true),
            (new TextPrimitiveFieldType())
                ->setLabel('Raviday + - Title')
                ->setSlug('raviday_plus_title')
                ->setRequired(true),
            (new TextAreaPrimitiveFieldType())
                ->setSlug('raviday_plus_content')
                ->setLabel('Raviday + - Content')
                ->setRequired(true),
        ]);
    }

    public function getDefaultLabel(): string
    {
        return 'Footer';
    }
}
