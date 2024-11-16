<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element\Block;

use PrestaSafe\PrettyBlocks\FieldType\Element\AbstractElementFieldType;

abstract class AbstractBlockFieldType extends AbstractElementFieldType implements BlockFieldTypeInterface
{
    protected string $slug = 'undefined_block';
    protected string $template = 'module:prettyblocks/templates/element/block/undefined_block.tpl';

    public function getType(): string
    {
        return 'block';
    }
}
