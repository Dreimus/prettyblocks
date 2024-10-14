<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType;

interface FieldTypeInterface
{
    public function getId(): string;

    public function getType(): string;

    public function getLabel(): string;

    public function isRequired(): bool;

    public function setRequired(bool $required): FieldTypeInterface;
}
