<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Primitive;

use Context;
use PrestaShopCollection;

class EntitySelectorPrimitiveFieldType extends AbstractPrimitiveFieldType
{
    public function getType(): string
    {
        return 'entity-selector';
    }
}
