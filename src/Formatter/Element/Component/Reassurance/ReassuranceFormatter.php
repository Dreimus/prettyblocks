<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Formatter\Element\Component\Reassurance;

use Category;
use CMS;
use PrestaSafe\PrettyBlocks\Formatter\FieldFormatterInterface;
use PrestaSafe\PrettyBlocks\Formatter\Primitive\EntitySelectorFormatter;
use PrestaShop\PrestaShop\Adapter\LegacyContext;
use Product;

class ReassuranceFormatter implements FieldFormatterInterface
{

    public function format(array $fields): array
    {
        $formattedFields = [];
        foreach ($fields['fields'] as $reassuranceContent) {
            if (!isset($reassuranceContent['sub_elements'])) {
                continue;
            }
            foreach ($reassuranceContent['sub_elements'] as $reassuranceItem) {
                $content = [];
                foreach ($reassuranceItem['fields'] as $simpleMenuContentItemField) {
                    if ($simpleMenuContentItemField['slug'] === 'link') {
                        $content += $this->prestashopEntitySelectorFormatter->format($simpleMenuContentItemField);
                    }
                    if ($simpleMenuContentItemField['slug'] === 'highlighted') {
                        $content['highlighted'] =
                            $simpleMenuContentItemField['content']['value'] ??
                            false;
                    }
                }
                if (!empty($content)) {
                    $formattedFields[] = $content;
                }
            }
        }

        return $formattedFields;
    }
}
