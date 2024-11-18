<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Formatter\Element\Block;

use PrestaSafe\PrettyBlocks\Formatter\FieldFormatterInterface;

class FooterFormatter implements FieldFormatterInterface
{
    public function format(array $fields): array
    {
        $formattedFields = [];
        foreach ($fields as $field) {
            switch ($field['slug']) {
                case 'reassurance_component':
                    $formattedFields['reassurance'] = $this->formatReassurance($field);
                    break;
                case 'seo_description':
                    $formattedFields['seo_description'] = $field['content']['value'];
                    break;
                case 'raviday_plus_title':
                    $formattedFields['raviday_plus']['title'] = $field['content']['value'];
                    break;
                case 'raviday_plus_content':
                    $formattedFields['raviday_plus']['content'] = $field['content']['value'];
                    break;
                case 'shops':
                    foreach ($field['sub_elements'] as $shop) {
                        $formattedShop = [];

                        foreach ($shop['fields'] as $shopField) {
                            if ($shopField['slug'] === 'icon') {
                                $formattedShop['icon'] = $shopField['content']['value'] ?? '';
                            }
                            if ($shopField['slug'] === 'link') {
                                $formattedShop['link'] = $shopField['content'];
                            }
                        }
                        $formattedFields['shop_menu']['shops'][] = $formattedShop;
                    }
                    break;
                default:
                    break;
            }
        }

        return $formattedFields;
    }

    protected function formatReassurance(array $field): array
    {
        $reassurance = [];
        foreach ($field['sub_elements'] as $reassuranceItem) {
            $reassuranceItemContent = [];
            foreach ($reassuranceItem['fields'] as $reassuranceItemFields) {
                if ($reassuranceItemFields['slug'] === 'icon') {
                    $reassuranceItemContent['icon'] = $reassuranceItemFields['content']['value'];
                }
                if ($reassuranceItemFields['slug'] === 'title') {
                    $reassuranceItemContent['title'] = $reassuranceItemFields['content']['value'];
                }
                if ($reassuranceItemFields['slug'] === 'description') {
                    $reassuranceItemContent['description'] = $reassuranceItemFields['content']['value'];
                }
            }
            if (!empty($reassuranceItemContent)) {
                $reassurance[] = $reassuranceItemContent;
            }
        }

        return $reassurance;
    }
}
