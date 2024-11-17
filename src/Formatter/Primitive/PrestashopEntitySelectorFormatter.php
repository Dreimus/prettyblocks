<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Formatter\Primitive;


use Category;
use CMS;
use PrestaSafe\PrettyBlocks\Formatter\FieldFormatterInterface;
use PrestaShop\PrestaShop\Adapter\LegacyContext;
use Product;

class PrestashopEntitySelectorFormatter implements FieldFormatterInterface
{
    public function __construct(
        protected LegacyContext $context
    ) {
    }

    public function format(array $fields): array
    {
        $link = '';
        $label = '';
        $prestashopEntity = $fields['content']['type'] ?? '';

        $prestashopEntityId = $fields['content']['value'] ?? 0;

        if ($prestashopEntity === 'product') {
            $product = (new Product($prestashopEntityId));
            $link = $product->getLink();
            if (is_array($product->name)) {
                $label = $product->name[$this->context->getContext()->language->id];
            } else {
                $label = $product->name;
            }
        } elseif ($prestashopEntity === 'category') {
            $category = new Category($prestashopEntityId);
            $link = $category->getLink();
            $label = $category->name[$this->context->getContext()->language->id];
        } elseif ($prestashopEntity === 'cms_page') {
            $cms = new CMS($prestashopEntityId);
            $this->context->getContext()->link->getCMSLink($cms);
            $label = $cms->meta_title[$this->context->getContext()->language->id];
        }

        $menuItem['link'] = $link;
        $menuItem['label'] = $label;

        return $menuItem;
    }
}
