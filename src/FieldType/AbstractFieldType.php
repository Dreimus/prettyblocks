<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType;

use PrestaSafe\PrettyBlocks\FieldType\Resolver\FieldTypeResolver;

abstract class AbstractFieldType implements FieldTypeInterface
{
    protected string $id;
    protected string $type;
    protected string $label;
    protected bool $required = false;

    public function __construct()
    {
        $fieldTypeResolver = new FieldTypeResolver();
        $this->id = $fieldTypeResolver->classToId($this::class);
        $this->label = $this->getDefaultLabel();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    abstract public function getType(): string;

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function setRequired(bool $required): FieldTypeInterface
    {
        $this->required = $required;

        return $this;
    }

    public function setLabel(string $label): FieldTypeInterface
    {
        $this->label = $label;

        return $this;
    }

    abstract public function getDefaultLabel(): string;
}
