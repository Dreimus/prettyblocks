<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Formatter\Primitive;


use Category;
use CMS;
use CMSCategory;
use Manufacturer;
use PrestaSafe\PrettyBlocks\Formatter\FieldFormatterInterface;
use PrestaShop\PrestaShop\Adapter\LegacyContext;
use Product;
use Supplier;

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

        /** Availables entities :
         * product
         * category
         * cms_page
         * manufacturer
         * cms_category
         * supplier
         */
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
            $link = $this->context->getContext()->link->getCMSLink($cms);
            $label = $cms->meta_title[$this->context->getContext()->language->id];
        } elseif ($entity === 'manufacturer') {
            $manufacturer = new Manufacturer($entityId);
            $link = $manufacturer->getLink();
            $label = $manufacturer->name;
        } elseif ($entity === 'cms_category') {
            $cmsCategory = new CMSCategory($entityId);
            $linkObject = new \Link();
            $link = $linkObject->getCMSCategoryLink($cmsCategory, null, $this->context->getContext()->language->id);
            $label = $cmsCategory->name[$this->context->getContext()->language->id];
        } elseif ($entity === 'supplier') {
            $supplier = new Supplier($entityId);
            $link = $supplier->getLink();
            $label = $supplier->name;
        } elseif ($entity === 'custom_link') {
            $link = $fields['content']['value']['href'];
            $label = $fields['content']['value']['name'];
        }

        $menuItem['link'] = $link;
        $menuItem['label'] = $label;

        return $menuItem;
    }
}
