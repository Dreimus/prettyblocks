<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Collection;

use PrestaSafe\PrettyBlocks\Entity\BlockInterface;
use PrestaShop\PrestaShop\Core\Data\AbstractTypedCollection;

class BlockCollection extends AbstractTypedCollection
{
    public function getType(): string
    {
        return BlockInterface::class;
    }
}
