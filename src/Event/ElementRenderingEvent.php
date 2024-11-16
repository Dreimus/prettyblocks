<?php

namespace PrestaSafe\PrettyBlocks\Event;

use PrestaSafe\PrettyBlocks\Entity\Block;
use Symfony\Contracts\EventDispatcher\Event;

class ElementRenderingEvent extends Event
{
    public const NAME = 'prettyblocks.element.rendering';
    public const BLOCK_RENDERING_PREFIX = 'prettyblocks.element.rendering.block.';
    public const COMPONENT_RENDERING_PREFIX = 'prettyblocks.element.rendering.component.';

    public function __construct(
        protected Block $block
    ) {
    }

    public function getBlock(): Block
    {
        return $this->block;
    }

    public function setBlock(Block $block): ElementRenderingEvent
    {
        $this->block = $block;
        return $this;
    }
}
