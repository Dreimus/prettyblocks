<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Presenter\Block;

use PrestaSafe\PrettyBlocks\Collection\BlockCollection;
use PrestaSafe\PrettyBlocks\Model\Block;
use PrestaShop\PrestaShop\Adapter\Presenter\PresenterInterface;

class BlockApiPresenter implements PresenterInterface
{
    public function present(mixed $block): array
    {
        if (!$block instanceof Block) {
            throw new \InvalidArgumentException('Expected Block');
        }

        return [
            'id' => $block->getId(),
            'type' => $block->getType(),
            'label' => $block->getLabel(),
            'repeatable' => $block->isRepeatable(),
            'fields' => $block->getFields(),
        ];
    }
}
