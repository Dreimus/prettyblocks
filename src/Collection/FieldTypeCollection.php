<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Collection;

use PrestaSafe\PrettyBlocks\FieldType\FieldTypeInterface;
use PrestaShop\PrestaShop\Core\Data\AbstractTypedCollection;

class FieldTypeCollection extends AbstractTypedCollection
{
    public function getType(): string
    {
        return FieldTypeInterface::class;
    }
}
