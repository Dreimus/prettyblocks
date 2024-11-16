<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Primitive;

use PrestaSafe\PrettyBlocks\FieldType\AbstractFieldType;

abstract class AbstractPrimitiveFieldType extends AbstractFieldType implements PrimitiveFieldTypeInterface
{
    protected mixed $value;
    protected mixed $defaultValue = null;
    protected string $slug = '';

    public function getDefaultLabel(): string
    {
        // Primitive fields use unique type, so we can use it as a default label
        return $this->getType();
    }

    public function getDefault(): array
    {
        return [
            'value' => $this->getDefaultValue(),
        ];
    }

    public function getDefaultValue(): mixed
    {
        return $this->defaultValue;
    }

    public function setDefaultValue(mixed $defaultValue): PrimitiveFieldTypeInterface
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }

    public function setSlug(string $slug): PrimitiveFieldTypeInterface
    {
        $this->slug = $slug;
        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }
}
