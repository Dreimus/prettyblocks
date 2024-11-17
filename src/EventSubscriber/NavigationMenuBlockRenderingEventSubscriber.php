<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\EventSubscriber;

use PrestaSafe\PrettyBlocks\Event\ElementRenderingEvent;
use PrestaSafe\PrettyBlocks\FieldType\Element\Block\NavigationMenu;
use PrestaSafe\PrettyBlocks\Formatter\Element\Block\NavigationMenuFormatter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NavigationMenuBlockRenderingEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        protected NavigationMenuFormatter $navigationMenuFormatter,
    ) {
    }

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
        $formattedFields = $this->navigationMenuFormatter->format($fields);

        $block->setFields($formattedFields);
    }
}
