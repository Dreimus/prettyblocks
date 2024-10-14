<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Resolver;

class FieldTypeResolver
{
    /**
     * Convert a class name to an ID.
     *
     * @param string $className
     *
     * @return string
     */
    public function classToId(string $className): string
    {
        return strtolower(str_replace(['\\', '_'], '_', $className));
    }

    /**
     * Convert an ID back to a class name.
     *
     * @param string $id
     * @param string $namespacePrefix optional prefix if needed for namespaces
     *
     * @return string
     */
    public function idToClass(string $id, string $namespacePrefix = ''): string
    {
        // Convert underscores back to namespace separators and class underscores
        $className = str_replace('_', '\\', ucwords($id, '_'));

        // Ensure proper capitalization if needed and add namespace prefix
        if ($namespacePrefix) {
            $className = rtrim($namespacePrefix, '\\') . '\\' . $className;
        }

        return $className;
    }
}
