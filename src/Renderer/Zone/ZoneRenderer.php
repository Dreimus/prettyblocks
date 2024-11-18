<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Renderer\Zone;

use PrestaSafe\PrettyBlocks\Entity\Block;
use PrestaSafe\PrettyBlocks\Entity\Zone;
use PrestaSafe\PrettyBlocks\Event\ElementRenderingEvent;
use PrestaShop\PrestaShop\Adapter\LegacyContext;
use PrestaShop\PrestaShop\Core\Exception\TypeException;
use Smarty;
use Smarty_Data;
use Smarty_Internal_TemplateBase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ZoneRenderer
{
    protected Smarty $smarty;

    public function __construct(
        protected LegacyContext $context,
        protected EventDispatcherInterface $eventDispatcher
    ) {
        $this->smarty = $context->getSmarty();
    }

    /**
     * Handles rendering of a zone
     *
     * @param Zone $zone
     *
     * @throws \PrestaShop\PrestaShop\Core\Exception\TypeException
     *
     * @return string
     */
    public function render(Zone $zone): string
    {
        if (Zone::GENERIC_ZONE_REFERENCE === $zone->getReference()) {
            $this->renderGenericZone($zone);
        } else {
            $blocks = $zone->getBlocks();
            $output = '';
            /** @var Block $block */
            foreach ($blocks as $block) {
                $output .= $this->renderBlock($block);
            }

            return $output;
        }
    }

    /**
     * Handles rendering of a block, it will create a scope for the block
     * and render the block template with the scope as string
     *
     * @param Block $block
     *
     * @throws \SmartyException
     *
     * @return string
     */
    private function renderBlock(Block $block): string
    {
        $scope = $this->smarty->createData(
            $this->smarty
        );

        $formattedBlock = $this->formatBlock($block, $scope);

        $scope->assign('block', $formattedBlock);

        $tpl = $this->smarty->createTemplate(
            $block->getTemplate(),
            $scope
        );

        return $tpl->fetch();
    }

    /**
     * Format block data for rendering
     * For block rendering, events will be triggered to allow
     * modules to modify the block data before rendering.
     * If you want to modify the block data before rendering, you can listen to the ElementRenderingEvent::NAME
     * and ElementRenderingEvent::BLOCK_RENDERING_PREFIX . $block->getSlug() events
     *
     * @see ElementRenderingEvent     *
     *
     * @param Block $block
     * @param Smarty_Data $scope
     *
     * @return array
     */
    protected function formatBlock(Block $block, Smarty_Data $scope)
    {
        $renderingEvent = new ElementRenderingEvent(
            $block,
            $scope
        );

        // we will trigger two events here, one for generic block rendering and one for the specific block
        $this->eventDispatcher->dispatch($renderingEvent, ElementRenderingEvent::NAME);

        $specificBlockRenderingEventSlug = ElementRenderingEvent::BLOCK_RENDERING_PREFIX . $block->getSlug();
        $this->eventDispatcher->dispatch($renderingEvent, $specificBlockRenderingEventSlug);

        $block = $renderingEvent->getBlock();

        return [
            'id' => $block->getId(),
            'slug' => $block->getSlug(),
            'block_id' => $block->getBlockId(),
            'fields' => $block->getFields(),
        ];
    }

    /**
     * In the case of the generic zone, no block will be rendered
     * The blocks contents will be assigned to smarty variables in global scope
     * You can reach the block contents in your templates using
     * 'prettyblocks_generic_zone_block_{$block->getSlug()}' variable.
     *
     * @param Zone $zone
     *
     * @throws TypeException
     */
    protected function renderGenericZone(Zone $zone): void
    {
        $scope = $this->smarty->createData(
            $this->smarty
        );
        $blocks = $zone->getBlocks();
        /** @var Block $block */
        foreach ($blocks as $block) {
            $formattedBlock = $this->formatBlock($block, $scope);

            $scope->assign('prettyblocks_generic_zone_block_' . $block->getSlug(), $formattedBlock);
        }
    }
}
