<?php

namespace PrestaSafe\PrettyBlocks\Model;

class Field
{
    protected string $id;
    protected string $type;
    protected string $label;
    protected mixed $default;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): Field
    {
        $this->id = $id;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): Field
    {
        $this->type = $type;
        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): Field
    {
        $this->label = $label;
        return $this;
    }

    public function getDefault(): mixed
    {
        return $this->default;
    }

    public function setDefault(mixed $default): Field
    {
        $this->default = $default;
        return $this;
    }

}
