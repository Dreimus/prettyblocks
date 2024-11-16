<?php

namespace PrestaSafe\PrettyBlocks\EventSubscriber;

use PrestaSafe\PrettyBlocks\Event\ElementRenderingEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BlockRenderingEventSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [
            ElementRenderingEvent::NAME => 'onElementRendering',
        ];
    }

    public function onElementRendering(ElementRenderingEvent $event): void
    {
        // Here we can modify the block before rendering it
    }
}
