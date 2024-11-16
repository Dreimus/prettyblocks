<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element;

use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\FieldType\AbstractFieldType;

abstract class AbstractElementFieldType extends AbstractFieldType implements ElementFieldTypeInterface
{
    protected FieldTypeCollection $fields;
    protected string $slug = '';
    protected string $template = '';

    public function setSlug(string $slug): AbstractElementFieldType
    {
        $this->slug = $slug;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setTemplate(string $template): AbstractElementFieldType
    {
        $this->template = $template;

        return $this;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }
}
