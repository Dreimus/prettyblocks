<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element\Component\Reassurance;

use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\FieldType\Element\Component\AbstractComponentFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\EntitySelectorPrimitiveFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\RavipotePrimitiveFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\SelectPrimitiveFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\TextAreaPrimitiveFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\TextPrimitiveFieldType;

class Reassurance extends AbstractComponentFieldType
{
    protected string $slug = 'reassurance';
    protected string $template = 'module:prettyblocks/templates/element/component/reassurance/reassurance.tpl';

    public function isRepeatable(): bool
    {
        return true;
    }

    public function getFields(): FieldTypeCollection
    {
        return new FieldTypeCollection([
            (new RavipotePrimitiveFieldType())
                ->setLabel('Icon')
                ->setSlug('icon')
                ->setRequired(true),
            (new TextPrimitiveFieldType())
                ->setLabel('Title')
                ->setSlug('title')
                ->setRequired(true),
            (new TextAreaPrimitiveFieldType())
                ->setLabel('Description')
                ->setSlug('description')
                ->setRequired(true),
        ]);
    }

    public function getDefaultLabel(): string
    {
        return 'Reassurance Item(s)';
    }
}
