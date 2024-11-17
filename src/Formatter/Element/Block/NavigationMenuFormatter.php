<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Formatter\Element\Block;

use PrestaSafe\PrettyBlocks\Formatter\Element\Component\Menu\SidebarMenuFormatter;
use PrestaSafe\PrettyBlocks\Formatter\Element\Component\Menu\SimpleMenuFormatter;
use PrestaSafe\PrettyBlocks\Formatter\FieldFormatterInterface;
use PrestaShop\PrestaShop\Adapter\LegacyContext;

class NavigationMenuFormatter implements FieldFormatterInterface
{
    public function __construct(
        protected LegacyContext $context,
        protected SidebarMenuFormatter $sidebarMenuFormatter,
        protected SimpleMenuFormatter $simpleMenuFormatter
    ) {
    }

    public function format(array $fields): array
    {
        $formattedFields = [];
        foreach ($fields as $field) {

            switch ($field['slug']) {
                case 'quick_menu':
                    $formattedFields['quick_menu'] = $this->simpleMenuFormatter->format($field);
                    break;
                case 'menu_button_text':
                    $formattedFields['menu_button_text'] = $field['content']['value'] ?? '';
                    break;
                case 'sidebar_menu':
                    $formattedFields['sidebar_menu'] = $this->sidebarMenuFormatter->format($field);
                    break;
                default:
                    break;
            }

        }

        return $formattedFields;
    }
}
