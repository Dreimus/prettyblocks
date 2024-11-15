<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element;

use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\FieldType\AbstractFieldType;

abstract class AbstractElementFieldType extends AbstractFieldType implements ElementFieldTypeInterface
{
    protected FieldTypeCollection $fields;
    protected string $slug = '';

    public function getDataClass(): string|null
    {
        return null;
    }

    public function setSlug(string $slug): AbstractElementFieldType
    {
        $this->slug = $slug;
        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }
}
