<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element\Block;

use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\FieldType\Element\Component\Reassurance\Reassurance;
use PrestaSafe\PrettyBlocks\FieldType\Element\Component\ShopsListing;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\TextAreaPrimitiveFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\TextPrimitiveFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\WysiwygPrimitiveFieldType;

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
            (new Reassurance())
                ->setLabel('Reassurance component')
                ->setSlug('reassurance_component')
                ->setRequired(true),
            (new WysiwygPrimitiveFieldType())
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
            (new ShopsListing())
                ->setLabel('Shops')
                ->setSlug('shops')
                ->setRequired(true),
        ]);
    }

    public function getDefaultLabel(): string
    {
        return 'Footer';
    }
}
