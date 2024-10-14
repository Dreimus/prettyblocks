<?php

namespace PrestaSafe\PrettyBlocks\Model;

use PrestaSafe\PrettyBlocks\Entity\Zone;

class Block
{
    protected string $id;
    protected string $blockId;
    protected string $type;
    protected ?Zone $zone;
    protected ?string $label;
    protected bool $repeatable;
    protected int $position = 0;

    /**
     * @var array<int, Component|Field>
     */
    private array $fields = [];

    public function getId(): string
    {
        return $this->id;
    }

    public function setId($id): Block
    {
        $this->id = $id;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): Block
    {
        $this->type = $type;
        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): Block
    {
        $this->label = $label;
        return $this;
    }

    public function isRepeatable(): bool
    {
        return $this->repeatable;
    }

    public function setRepeatable(bool $repeatable): Block
    {
        $this->repeatable = $repeatable;
        return $this;
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function setFields(array $fields): Block
    {
        $this->fields = $fields;
        return $this;
    }

    public function setBlockId(mixed $id): Block
    {
        $this->blockId = $id;

        return $this;
    }

    public function setZone(Zone $zone): Block
    {
        $this->zone = $zone;

        return $this;
    }

    public function setPosition(int $position): Block
    {
        $this->position = $position;

        return $this;
    }

}
