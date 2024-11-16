<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Primitive;

use PrestaSafe\PrettyBlocks\FieldType\FieldTypeInterface;

interface PrimitiveFieldTypeInterface extends FieldTypeInterface
{
    /**
     * @return array The default value for the field, key 'value' with the default value
     */
    public function getDefault(): array;

    public function getDefaultValue(): mixed;

    public function setDefaultValue(mixed $defaultValue): PrimitiveFieldTypeInterface;
}
