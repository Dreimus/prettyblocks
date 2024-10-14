<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Presenter\Block;

use PrestaSafe\PrettyBlocks\Collection\BlockCollection;
use PrestaShop\PrestaShop\Adapter\Presenter\PresenterInterface;

class BlockCollectionApiPresenter implements PresenterInterface
{
    public function present(mixed $block): array
    {
        if (!$block instanceof BlockCollection) {
            throw new \InvalidArgumentException('Expected BlockCollection');
        }

        $presentedCollection = [];
        foreach ($block as $element) {
            $presentedCollection[] = (new BlockApiPresenter())->present($element);
        }

        return $presentedCollection;
    }
}
