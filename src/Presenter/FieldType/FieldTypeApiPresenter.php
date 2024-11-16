<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Presenter\FieldType;

use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\FieldType\Element\Component\ComponentFieldTypeInterface;
use PrestaSafe\PrettyBlocks\FieldType\Element\ElementFieldTypeInterface;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\PrimitiveFieldTypeInterface;
use PrestaShop\PrestaShop\Adapter\Presenter\PresenterInterface;

class FieldTypeApiPresenter implements PresenterInterface
{
    public function present($block, int $depth = 0, $parent = null): array
    {
        $formattedData = [
            'id' => $block->getId(),
            'type' => $block->getType(),
            'label' => $block->getLabel(),
            'slug' => $block->getSlug(),
        ];


        if ($block instanceof PrimitiveFieldTypeInterface) {
            $formattedData['default'] = $block->getDefault();

            if (method_exists($block, 'getExtraData')) {
                $formattedData['extraData'] = $block->getExtraData();
            }
        }

        if ($block instanceof ElementFieldTypeInterface) {
            $formattedData['repeatable'] = $block->isRepeatable();
            $formattedData['template'] = $block->getTemplate();

            if ($block instanceof ComponentFieldTypeInterface && $parent && $parent::class === $block::class) {
                $depth++;

                if ($depth > $block->getDepth()) {
                    return $formattedData;
                }
            }

            $formattedData['fields'] = $this->presentFields($block->getFields(), $depth, $block);
        }

        return $formattedData;
    }

    private function presentFields(FieldTypeCollection $elementClass, $depth = 0, $parent = null): array
    {
        $fields = [];

        foreach ($elementClass as $field) {
            $fields[uniqid('', true)] = $this->present($field, $depth, $parent);
        }

        return $fields;
    }
}
