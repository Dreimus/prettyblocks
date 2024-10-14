<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Exception;

use Exception;

class PrettyBlocksException extends Exception
{
    public function __construct(string $message = 'Pretty Block')
    {
        parent::__construct($message);
    }
}
