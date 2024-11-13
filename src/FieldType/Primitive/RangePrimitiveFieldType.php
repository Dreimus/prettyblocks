<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Primitive;

class RangePrimitiveFieldType extends AbstractPrimitiveFieldType
{
    protected int $min;
    protected int $max;
    protected mixed $defaultValue = 0;

    public function getType(): string
    {
        return 'range';
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
