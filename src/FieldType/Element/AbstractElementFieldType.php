<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element;

use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\FieldType\AbstractFieldType;

abstract class AbstractElementFieldType extends AbstractFieldType implements ElementFieldTypeInterface
{
    protected FieldTypeCollection $fields;

    public function getDataClass(): string|null
    {
        return null;
    }
}
