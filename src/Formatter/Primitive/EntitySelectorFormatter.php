<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Formatter\Primitive;


use Category;
use CMS;
use PrestaSafe\PrettyBlocks\Formatter\FieldFormatterInterface;
use PrestaShop\PrestaShop\Adapter\LegacyContext;
use Product;

class EntitySelectorFormatter implements FieldFormatterInterface
{
    public function __construct(
        protected LegacyContext $context
    ) {
    }

    public function format(array $fields): array
    {
        $link = '';
        $label = '';
        $entity = $fields['content']['type'] ?? '';

        $entityId = $fields['content']['value'] ?? 0;

        if ($entity === 'product') {
            $product = (new Product($entityId));
            $link = $product->getLink();
            if (is_array($product->name)) {
                $label = $product->name[$this->context->getContext()->language->id];
            } else {
                $label = $product->name;
            }
        } elseif ($entity === 'category') {
            $category = new Category($entityId);
            $link = $category->getLink();
            $label = $category->name[$this->context->getContext()->language->id];
        } elseif ($entity === 'cms_page') {
            $cms = new CMS($entityId);
            $this->context->getContext()->link->getCMSLink($cms);
            $label = $cms->meta_title[$this->context->getContext()->language->id];
        } elseif ($entity === 'custom_link') {
            $link = $fields['content']['value']['href'];
            $label = $fields['content']['value']['name'];
        }

        $menuItem['link'] = $link;
        $menuItem['label'] = $label;

        return $menuItem;
    }
}
