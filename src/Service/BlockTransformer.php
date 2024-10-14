<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Service;

use PrestaSafe\PrettyBlocks\Model\Block;
use PrestaSafe\PrettyBlocks\Model\Component;
use PrestaSafe\PrettyBlocks\Model\Field;

class BlockTransformer
{
    public function transform(array $data): Block
    {
        $block = new Block();
        $block->setId($data['id']);
        $block->setType($data['type']);
        $block->setLabel($data['label'] ?? '');

        if (isset($data['fields'])) {
            $block->setFields($this->transformFields($data['fields']));
        }

        return $block;
    }

    private function transformFields(array $fieldsData): array
    {
        $fields = [];
        foreach ($fieldsData as $fieldData) {
            if ($fieldData['type'] === 'component') {
                $component = $this->transformComponent($fieldData);
                $fields[] = $component;
            } else {
                $field = $this->transformField($fieldData);
                $fields[] = $field;
            }
        }

        return $fields;
    }

    private function transformComponent(array $data): Component
    {
        $component = new Component();
        $component->setId($data['id']);
        $component->setType($data['type']);
        $component->setLabel($data['label'] ?? '');
        $component->setRepeatable($data['repeatable'] ?? false);

        if (isset($data['fields'])) {
            $component->setFields($this->transformFields($data['fields']));
        }

        return $component;
    }

    private function transformField(array $data): Field
    {
        $field = new Field();
        $field->setId($data['id']);
        $field->setType($data['type']);
        $field->setLabel($data['label'] ?? '');
        $field->setDefault($data['default'] ?? null);

        return $field;
    }
}
