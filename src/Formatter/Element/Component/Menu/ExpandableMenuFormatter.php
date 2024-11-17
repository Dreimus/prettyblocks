<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Formatter\Element\Component\Menu;

use Category;
use PrestaSafe\PrettyBlocks\Formatter\FieldFormatterInterface;
use PrestaSafe\PrettyBlocks\Formatter\Primitive\PrestashopEntitySelectorFormatter;
use PrestaShop\PrestaShop\Adapter\LegacyContext;

class ExpandableMenuFormatter implements FieldFormatterInterface
{
    public function __construct(
        protected LegacyContext $context,
        protected PrestashopEntitySelectorFormatter $prestashopEntitySelectorFormatter
    ) {
    }

    public function format(array $fields): array
    {
        $formattedExpandableMenu = [];

        foreach ($fields['fields'] as $expandableMenuItem) {
            $formattedExpandableMenu['items'] = $this->formatExpandableMenuItems($expandableMenuItem);
        }

        return $formattedExpandableMenu;
    }

    protected function formatExpandableMenuItems(array $expandableMenuItem): array
    {
        $formattedExpandableMenuItem = [];

        foreach ($expandableMenuItem['sub_elements'] as $expandableMenuItemContent) {
            $menuItem = [];
            foreach ($expandableMenuItemContent['fields'] as $expandableMenuItemContentItem) {
                switch ($expandableMenuItemContentItem['slug']) {
                    case 'menu_item_text':
                        $menuItem['title'] = $expandableMenuItemContentItem['content']['value'] ?? '';
                        break;
                    case 'associated_category':
                        $menuItem += $this->prestashopEntitySelectorFormatter->format($expandableMenuItemContentItem);
                        break;
                    case 'menu_item_icon':
                        $menuItem['icon'] = $expandableMenuItemContentItem['content']['value'] ?? '';
                        break;
                    case 'submenu':
                        if (isset($expandableMenuItemContentItem['sub_elements'])) {
                            $menuItem['submenu'] = $this->formatExpandableMenuItems($expandableMenuItemContentItem);
                        }
                        break;
                    default:
                        break;
                }
            }
            if (!empty($menuItem)) {
                $formattedExpandableMenuItem[] = $menuItem;
            }
        }

        return $formattedExpandableMenuItem;
    }
}
