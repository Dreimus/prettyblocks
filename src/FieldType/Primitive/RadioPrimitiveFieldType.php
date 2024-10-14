<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Primitive;

class RadioPrimitiveFieldType extends AbstractPrimitiveFieldType
{
    protected array $options;

    public function getType(): string
    {
        return 'radio';
    }

    public function getDefaultValue(): string
    {
        return '';
    }

    public function getOptions(): array
    {
        return [];
    }

    public function getDefault(): array
    {
        return [
            'value' => $this->getDefaultValue(),
            'options' => $this->getOptions(),
        ];
    }

    public function addOption(string $value, string $label): self
    {
        $this->options[] = [
            'value' => $value,
            'label' => $label,
        ];

        return $this;
    }
}
