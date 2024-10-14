<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element\Component;

use PrestaSafe\PrettyBlocks\FieldType\Element\ElementFieldTypeInterface;

interface ComponentFieldTypeInterface extends ElementFieldTypeInterface
{
    public function isRepeatable(): bool;

    public function setRepeatable(bool $repeatable): ComponentFieldTypeInterface;
}
