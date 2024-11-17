<?php

namespace PrestaSafe\PrettyBlocks\Formatter;

interface FieldFormatterInterface
{
    public function format(array $fields): array;
}
