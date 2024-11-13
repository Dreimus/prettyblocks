<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Primitive;

class PasswordPrimitiveFieldType extends AbstractPrimitiveFieldType
{
    public function getType(): string
    {
        return 'password';
    }
}
