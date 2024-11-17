<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Formatter\Element\Component\Menu;

use PrestaSafe\PrettyBlocks\Formatter\FieldFormatterInterface;
use PrestaShop\PrestaShop\Adapter\LegacyContext;

class SidebarMenuFormatter implements FieldFormatterInterface
{
    public function __construct(
        protected LegacyContext $context,
        protected SimpleMenuFormatter $simpleMenuFormatter,
        protected ExpandableMenuFormatter $expandableMenuFormatter
    ) {
    }

    public function format(array $fields): array
    {
        $formattedSidebarMenu = [];
        foreach ($fields['fields'] as $sidebarMenuContent) {
            match ($sidebarMenuContent['slug']) {
                'expandable_menu' => $formattedSidebarMenu['expandable_menu'] = $this->expandableMenuFormatter->format($sidebarMenuContent),
                'sidebar_footer_menu' => $formattedSidebarMenu['sidebar_footer_menu'] = $this->simpleMenuFormatter->format($sidebarMenuContent),
            };
        }

        return $formattedSidebarMenu;
    }
}
