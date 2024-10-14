<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element\Block;

use PrestaSafe\PrettyBlocks\FieldType\Element\AbstractElementFieldType;

abstract class AbstractBlockFieldType extends AbstractElementFieldType implements BlockFieldTypeInterface
{
    public function getType(): string
    {
        return 'block';
    }
}
