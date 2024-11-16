<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\EventSubscriber;

use PrestaSafe\PrettyBlocks\Event\ElementRenderingEvent;
use PrestaSafe\PrettyBlocks\FieldType\Element\Block\PreHeader;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PreHeaderBlockRenderingEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        $preHeaderFieldType = new PreHeader();
        $preHeaderSlug = $preHeaderFieldType->getSlug();
        $event = ElementRenderingEvent::BLOCK_RENDERING_PREFIX .  $preHeaderSlug;

        return [
            $event => 'formatFields',
        ];
    }

    public function formatFields(ElementRenderingEvent $event): void
    {
        // Here we can modify the block before rendering it
        $preHeaderBlock = $event->getBlock();

        $fields = $preHeaderBlock->getFields();
        $formattedFields = [];

        foreach ($fields as $field) {
            if ($field['slug'] === 'label_all_shops') {
                $formattedFields['shop_menu']['button_label'] = $field['content']['value']?? '';
            }
            if ($field['slug'] === 'shops') {
                foreach ($field['sub_elements'] as $shop) {
                    $formattedShop = [];

                    foreach ($shop['fields'] as $shopField) {
                        if ($shopField['slug'] === 'icon') {
                            $formattedShop['icon'] = $shopField['content']['value']?? '';
                        }
                        if ($shopField['slug'] === 'link') {
                            $formattedShop['link'] = $shopField['content'];
                        }
                    }
                    $formattedFields['shop_menu']['shops'][] = $formattedShop;
                }
            }
            if ($field['slug'] === 'reassurances') {
                foreach ($field['sub_elements'] as $reassurance) {
                    $formattedReassurance = [];

                    foreach ($reassurance['fields'] as $reassuranceField) {
                        if ($reassuranceField['slug'] === 'icon') {
                            $formattedReassurance['icon'] = $reassuranceField['content']['value']?? '';
                        }
                        if ($reassuranceField['slug'] === 'description') {
                            $formattedReassurance['text'] = $reassuranceField['content']['value']?? '';
                        }
                    }
                    $formattedFields['reassurances'][] = $formattedReassurance;
                }
            }

        }

        $preHeaderBlock->setFields($formattedFields);
    }
}
