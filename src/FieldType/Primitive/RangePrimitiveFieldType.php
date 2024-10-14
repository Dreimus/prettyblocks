<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Primitive;

class RangePrimitiveFieldType extends AbstractPrimitiveFieldType
{
    protected int $min;
    protected int $max;

    public function getType(): string
    {
        return 'range';
    }

    public function getDefaultValue(): mixed
    {
        return 0;
    }

    public function getDefault(): array
    {
        return [
            'min' => $this->min,
            'value' => $this->getDefaultValue(),
            'max' => $this->max,
        ];
    }
}
