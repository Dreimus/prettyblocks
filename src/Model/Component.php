<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Model;

class Component
{
    protected string $id;
    protected string $type;
    protected string $label;
    protected bool $repeatable = false;
    /**
     * @var array<int, Component|Field>
     */
    protected array $fields = [];

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): Component
    {
        $this->type = $type;

        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): Component
    {
        $this->label = $label;

        return $this;
    }

    public function isRepeatable(): bool
    {
        return $this->repeatable;
    }

    public function setRepeatable(bool $repeatable): Component
    {
        $this->repeatable = $repeatable;

        return $this;
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function setFields(array $fields): Component
    {
        $this->fields = $fields;

        return $this;
    }

    public function setId(string $id): Component
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
