<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Presenter\Zone;

use PrestaSafe\PrettyBlocks\Entity\Zone\Zone;
use PrestaSafe\PrettyBlocks\Presenter\FieldType\ElementContentApiCollectionPresenter;
use PrestaShop\PrestaShop\Adapter\Presenter\PresenterInterface;
use PrestaShop\PrestaShop\Core\Exception\TypeException;

class ZonePresenter implements PresenterInterface
{
    public function present($block): array
    {
        if (!$block instanceof Zone) {
            throw new TypeException('Expected Zone');
        }

        $formattedData = [
            'id' => $block->getId(),
            'label' => $block->getLabel(),
        ];

        $formattedData['content'] = (new ElementContentApiCollectionPresenter())->present($block->getElements());

        return $formattedData;
    }
}
