<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Factory;

use InvalidArgumentException;
use PrestaSafe\PrettyBlocks\Entity\Block\BlockInterface;
use PrestaSafe\PrettyBlocks\FieldType\Element\Block\BlockFieldTypeInterface;
use PrestaSafe\PrettyBlocks\FieldType\Registry\FieldTypeElementRegistry;
use PrestaSafe\PrettyBlocks\FieldType\Resolver\FieldTypeResolver;

class EntityFactory
{
    public function __construct(
        private readonly FieldTypeElementRegistry $registry,
        private readonly FieldTypeResolver $resolver
    ) {
    }

    public function createBlock(array $data): BlockInterface
    {
        $fieldTypeClassName = $this->resolver->idToClass($data['block_id']);

        if (!$fieldTypeClassName || !class_exists($fieldTypeClassName)) {
            throw new InvalidArgumentException("Block type not registered: {$data['type']}");
        }

        /** @var BlockFieldTypeInterface $fieldType */
        $fieldType = new $fieldTypeClassName();

        if (null !== $fieldType->getDataClass()) {
            $dataClass = $fieldType->getDataClass();

            /** @var BlockInterface $block */
            $block = new $dataClass($data['id'], $data['label'], $data['type']);
            $block->setBlockId($data['block_id']);
            $block->setBlockType($data['block_type']);
            $block->setBlockData($data['block_data']);

            return $block;
        } else {
            return new $fieldTypeClassName($data['id'], $data['label'], $data['type']);
        }
    }

    public function createComponent(array $data): BlockInterface
    {
        $className = $this->registry->getComponentClass($data['type']);

        if (!$className || !class_exists($className)) {
            throw new InvalidArgumentException("Component type not registered: {$data['type']}");
        }

        // Hydrate fields if necessary
        return new $className($data['id'], $data['label'], $data['type']);
    }

    public function createField(array $data): mixed
    {
        // @todo: Implement field creation
//        $className = $this->registry->getFieldClass($data['type']);
//
//        if (!$className || !class_exists($className)) {
//            throw new InvalidArgumentException("Field type not registered: {$data['type']}");
//        }
//
//        $field = new $className($data['id'], $data['label']);
//        $field->setValue($data['content']['value']);
//
//        return $field;
    }
}
