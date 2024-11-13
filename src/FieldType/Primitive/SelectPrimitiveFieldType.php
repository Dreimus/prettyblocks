<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Primitive;

class SelectPrimitiveFieldType extends AbstractPrimitiveFieldType
{
    protected array $options = [];
    protected bool $multiple = false;
    protected bool $expanded = false;
    protected bool $autocomplete = false;

    public function getType(): string
    {
        return 'select';
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getDefault(): array
    {
        return [
            'value' => $this->getDefaultValue(),
            'options' => $this->getOptions(),
        ];
    }

    public function addOption(mixed $value, string $label): self
    {
        $this->options[] = [
            'label' => $label,
            'value' => $value,
        ];

        return $this;
    }

    public function setOptions(array $options): self
    {
        foreach ($options as $value => $label) {
            $this->addOption($value, $label);
        }

        return $this;
    }
}
