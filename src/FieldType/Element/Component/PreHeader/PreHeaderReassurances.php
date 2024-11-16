<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element\Component\PreHeader;

use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\FieldType\Element\Component\AbstractComponentFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\LinkPrimitiveFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\SelectPrimitiveFieldType;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\WysiwygPrimitiveFieldType;

class PreHeaderReassurances extends AbstractComponentFieldType
{
    protected string $slug = 'pre_header_reassurances';
    protected string $template = 'module:prettyblocks/templates/element/component/pre_header/pre_header_reassurances.tpl';

    public function isRepeatable(): bool
    {
        return true;
    }

    public function getFields(): FieldTypeCollection
    {
        return new FieldTypeCollection([
            (new SelectPrimitiveFieldType())
                ->setLabel('Icon')
                ->setSlug('icon')
                ->setOptions($this->getIconChoices())
                ->setRequired(false),
            (new WysiwygPrimitiveFieldType())
                ->setLabel('Reassurance Description')
                ->setSlug('description')
                ->setRequired(false),
        ]);
    }

    public function getDefaultLabel(): string
    {
        return 'Reassurance';
    }

    protected function getIconChoices(): array
    {
        return [
            'truck' => 'Truck',
            'star' => 'Star',
            'headset_mic' => 'Headset Mic',
        ];
    }
}
