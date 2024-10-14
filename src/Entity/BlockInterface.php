<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Entity;

interface BlockInterface
{
    public function getLabel(): string;

    public function getId(): string;

    public function setId(string $id): BlockInterface;

    public function getPosition(): int;

    public function setPosition(int $position): BlockInterface;

    public function setBlockId(string $blockId): BlockInterface;

    public function getFields(): array;

    public function setFields(array $fields): BlockInterface;

    public function getZone(): Zone;

    public function setZone(?Zone $zone): BlockInterface;

}
