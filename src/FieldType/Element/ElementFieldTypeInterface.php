<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Element;

use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\FieldType\FieldTypeInterface;
use PrestaShop\PrestaShop\Core\Exception\TypeException;

interface ElementFieldTypeInterface extends FieldTypeInterface
{
    /**
     * @throws TypeException
     */
    public function getFields(): FieldTypeCollection;

    public function isRepeatable(): bool;

    public function getSlug(): string;

    public function getTemplate(): string;
}
