<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Presenter\FieldType;

use PrestaSafe\PrettyBlocks\Collection\FieldTypeCollection;
use PrestaSafe\PrettyBlocks\FieldType\Element\ElementFieldTypeInterface;
use PrestaSafe\PrettyBlocks\FieldType\Primitive\PrimitiveFieldTypeInterface;
use PrestaShop\PrestaShop\Adapter\Presenter\PresenterInterface;

class FieldTypeApiPresenter implements PresenterInterface
{
    public function present($block): array
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
            $formattedData['fields'] = $this->presentFields($block->getFields());
        }

        return $formattedData;
    }

    private function presentFields(FieldTypeCollection $elementClass): array
    {
        $fields = [];

        foreach ($elementClass as $field) {
            $fields[uniqid('', true)] = $this->present($field);
        }

        return $fields;
    }
}
