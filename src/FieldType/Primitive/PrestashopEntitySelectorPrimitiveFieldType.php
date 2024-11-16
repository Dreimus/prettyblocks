<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Primitive;

use Context;
use PrestaShopCollection;

class PrestashopEntitySelectorPrimitiveFieldType extends AbstractPrimitiveFieldType
{
    public function getType(): string
    {
        return 'prestashop-entity-selector';
    }
}
