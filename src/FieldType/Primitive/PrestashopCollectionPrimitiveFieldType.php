<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Primitive;

use ObjectModel;
use PrestaShopCollection;

class PrestashopCollectionPrimitiveFieldType extends SelectPrimitiveFieldType
{
    protected PrestaShopCollection $collection;
    protected string $keyField = 'id';
    protected string $valueField = 'name';

    public function setCollection(PrestaShopCollection $collection): self
    {
        $this->collection = $collection;

        return $this;
    }

    public function getOptions(): array
    {
        if (empty($this->options)) {
            foreach ($this->collection as $item) {
                $this->addOption($this->getKeyField($item), $this->getValueField($item));
            }
        }

        return parent::getOptions();
    }

    private function getKeyField(?ObjectModel $item): mixed
    {
        if (is_array($item->{$this->keyField})) {
            return implode('-', $item->{$this->keyField});
        }

        return $item->{$this->keyField};
    }

    private function getValueField(?ObjectModel $item): string
    {
        if (is_array($item->{$this->valueField})) {
            return implode('-', $item->{$this->valueField});
        }

        return $item->{$this->valueField};
    }

    public function setKeyField(string $keyField): self
    {
        $this->keyField = $keyField;

        return $this;
    }

    public function setValueField(string $valueField): self
    {
        $this->valueField = $valueField;

        return $this;
    }
}
