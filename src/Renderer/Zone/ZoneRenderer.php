<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Renderer\Zone;

use PrestaSafe\PrettyBlocks\Entity\Block;
use PrestaSafe\PrettyBlocks\Entity\Zone;
use PrestaShop\PrestaShop\Adapter\LegacyContext;

class ZoneRenderer
{
    protected \Smarty $smarty;
    public function __construct(
        protected LegacyContext $context
    ) {
        $this->smarty = $context->getSmarty();
    }

    public function render(Zone $zone): string
    {
        $blocks = $zone->getBlocks();
        $output = '';
        /** @var Block $block */
        foreach ($blocks as $block) {
            $output .= $this->renderBlock($block);
        }

        return $output;
    }

    private function renderBlock(Block $block): string
    {
        return "";
        $scope = $this->smarty->createData(
            $this->smarty
        );

        $fields = $block->getFields();
        $formattedFields = $this->formatBlockFields($block->getBlockId(), $fields);

        $scope->assign('block_fields', $formattedFields);

        $tpl = $this->smarty->createTemplate(
            "module:prettyblocks/templates/blocks/{$block->getBlockId()}.tpl",
            $scope
        );

        return $tpl->fetch();
    }

    private function formatBlockFields(string $blockId, array $fields)
    {
        return match ($blockId) {
            "prestasafe_prettyblocks_fieldtype_element_block_preheader" => $this->formatPreheaderFields($fields),
            default => [],
        };
    }

    private function formatPreheaderFields(array $fields): array
    {
        $formattedFields = [];

        $shopDropdown = [];
        $shopDropdown['label'] = $fields[0]['content']['value'];
        $shopDropdown['shops'] = [];

        foreach ($fields[1]['sub_elements'] as $shopField) {
            $shopFields = $shopField['fields'];
            $shopDropdown['shops'][] = [
                'icon' => $shopFields[0]['content']['value'],
                'desc' => $shopFields[1]['content']['label'],
                'url' => $shopFields[1]['content']['href'],
            ];
        }
        $formattedFields['shop_dropdown'] = $shopDropdown;
        $reassurance = [];

        foreach ($fields[2]['sub_elements'] as $reassuranceField) {
            $reassuranceFields = $reassuranceField['fields'];
            $reassurance[] = [
                'icon' => $reassuranceFields[0]['content']['value'],
                'desc' => $reassuranceFields[1]['content']['value'],
            ];
        }
        $formattedFields['reassurance'] = $reassurance;

        return $formattedFields;
    }
}
