<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Exception;

class CannotInstallPrettyBlocksException extends PrettyBlocksException
{
    public function __construct(string $message = 'Cannot install Pretty Block')
    {
        parent::__construct($message);
    }
}
