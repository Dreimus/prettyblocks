<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\EventSubscriber;

use Context;
use PrestaSafe\PrettyBlocks\Event\ElementRenderingEvent;
use PrestaSafe\PrettyBlocks\FieldType\Element\Block\NavigationMenu;
use Product;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NavigationMenuBlockRenderingEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        $event = ElementRenderingEvent::BLOCK_RENDERING_PREFIX . (new NavigationMenu())->getSlug();

        return [
            $event => 'formatFields',
        ];
    }

    public function formatFields(ElementRenderingEvent $event): void
    {
        // Here we can modify the block before rendering it
        $block = $event->getBlock();

        $fields = $block->getFields();
        $formattedFields = [];
        $context = Context::getContext();

        foreach ($fields as $field) {
            switch ($field['slug']) {
                case 'quick_menu':
                    $formattedQuickMenu = [];
                    foreach ($field['fields'] as $quickMenuContent) {
                        foreach ($quickMenuContent['sub_elements'] as $quickMenuItem) {
                            $formattedQuickMenuItem = [];
                            foreach ($quickMenuItem['fields'] as $quickMenuItemField) {
                                if ($quickMenuItemField['slug'] === 'link') {
                                    $link = '';
                                    $label = '';
                                    $prestashopEntity = $quickMenuItemField['content']['type'] ?? '';

                                    $prestashopEntityId = $quickMenuItemField['content']['value'] ?? 0;

                                    if ($prestashopEntity === 'product') {
                                        $product = (new Product($prestashopEntityId));
                                        $link = $product->getLink();
                                        $label = $product->name[$context->language->id];
                                    } elseif ($prestashopEntity === 'category') {
                                        $category = new \Category($prestashopEntityId);
                                        $link = $category->getLink();
                                        $label = $category->name[$context->language->id];
                                    } elseif ($prestashopEntity === 'cms') {
                                        $cms = new \CMS($prestashopEntityId);
                                        \Context::getContext()->link->getCMSLink($cms);
                                        $label = $cms->meta_title;
                                    }

                                    // generate link with Prestashop helper
                                    //\Context::getContext()->link->getProductLink($prestashopEntityId);
                                    $formattedQuickMenuItem['link'] = $link;
                                    $formattedQuickMenuItem['label'] = $label;
                                }
                                if ($quickMenuItemField['slug'] === 'highlighted') {
                                    $formattedQuickMenuItem['highlighted'] =
                                        $quickMenuItemField['content']['value'] ??
                                        false;
                                }
                            }
                            if (!empty($formattedQuickMenuItem)) {
                                $formattedQuickMenu[] = $formattedQuickMenuItem;
                            }
                        }
                    }
                    $formattedFields['quick_menu'] = $formattedQuickMenu;
                    break;
            }
        }

        $block->setFields($formattedFields);
    }
}
