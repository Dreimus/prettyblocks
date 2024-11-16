<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Renderer\Zone;

use PrestaSafe\PrettyBlocks\Entity\Block;
use PrestaSafe\PrettyBlocks\Entity\Zone;
use PrestaSafe\PrettyBlocks\Event\ElementRenderingEvent;
use PrestaShop\PrestaShop\Adapter\LegacyContext;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ZoneRenderer
{
    protected \Smarty $smarty;

    public function __construct(
        protected LegacyContext            $context,
        protected EventDispatcherInterface $eventDispatcher
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
        $scope = $this->smarty->createData(
            $this->smarty
        );

        $renderingEvent = new ElementRenderingEvent(
            $block
        );

        // we will trigger two events here, one for generic block rendering and one for the specific block
        $this->eventDispatcher->dispatch($renderingEvent, ElementRenderingEvent::NAME);

        $specificBlockRenderingEventSlug = ElementRenderingEvent::BLOCK_RENDERING_PREFIX . $block->getSlug();
        $this->eventDispatcher->dispatch($renderingEvent, $specificBlockRenderingEventSlug);

        $block = $renderingEvent->getBlock();

        $formattedBlock = [
            'id' => $block->getId(),
            'slug' => $block->getSlug(),
            'block_id' => $block->getBlockId(),
            'fields' => $block->getFields(),
        ];

        $scope->assign('block', $formattedBlock);

        $tpl = $this->smarty->createTemplate(
            $block->getTemplate(),
            $scope
        );

        return $tpl->fetch();
    }

}
