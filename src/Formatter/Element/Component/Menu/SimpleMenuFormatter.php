<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Formatter\Element\Component\Menu;

use Category;
use CMS;
use PrestaSafe\PrettyBlocks\Formatter\FieldFormatterInterface;
use PrestaSafe\PrettyBlocks\Formatter\Primitive\PrestashopEntitySelectorFormatter;
use PrestaShop\PrestaShop\Adapter\LegacyContext;
use Product;

class SimpleMenuFormatter implements FieldFormatterInterface
{
    public function __construct(
        protected LegacyContext $context,
        protected PrestashopEntitySelectorFormatter $prestashopEntitySelectorFormatter
    ) {
    }

    public function format(array $fields): array
    {
        $formattedSimpleMenu = [];
        foreach ($fields['fields'] as $simpleMenuContent) {
            if (!isset($simpleMenuContent['sub_elements'])) {
                continue;
            }
            foreach ($simpleMenuContent['sub_elements'] as $simpleMenuContentItem) {
                $menuItem = [];
                foreach ($simpleMenuContentItem['fields'] as $simpleMenuContentItemField) {
                    if ($simpleMenuContentItemField['slug'] === 'link') {
                        $menuItem += $this->prestashopEntitySelectorFormatter->format($simpleMenuContentItemField);
                    }
                    if ($simpleMenuContentItemField['slug'] === 'highlighted') {
                        $menuItem['highlighted'] =
                            $simpleMenuContentItemField['content']['value'] ??
                            false;
                    }
                }
                if (!empty($menuItem)) {
                    $formattedSimpleMenu[] = $menuItem;
                }
            }
        }

        return $formattedSimpleMenu;
    }
}
