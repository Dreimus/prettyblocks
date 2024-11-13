<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\FieldType\Primitive;

use Context;
use PrestaShopCollection;

class PrestashopLinkSelectPrimitiveFieldType extends SelectPrimitiveFieldType
{
    protected array $prestashopClasses = [
        \Product::class,
        \Category::class,
        \CMS::class,
    ];

    public function getOptions(): array
    {
        $options = [];
        $context = Context::getContext();
        $idLang = $context->language->id;

        foreach ($this->prestashopClasses as $class) {
            $collection = new PrestaShopCollection($class, $idLang);
            $results = $collection->getResults();

            foreach ($results as $result) {
                if ($class === \Product::class) {
                    $options[] = [
                        'value' => $class . '-' . $result->id,
                        'label' => '( ' . $class . ' ) - ' . $result->name,
                    ];
                } elseif ($class === \Category::class) {
                    $options[] = [
                        'value' => $class . '-' . $result->id,
                        'label' => '( ' . $class . ' ) - ' . $result->name,
                    ];
                } elseif ($class === \CMS::class) {
                    $options[] = [
                        'value' => $class . '-' . $result->id,
                        'label' => '( ' . $class . ' ) - ' . $result->meta_title,
                    ];
                }
            }
        }

        return $options;
    }

    public function getPrestashopClasses(): array
    {
        return $this->prestashopClasses;
    }

    /**
     * Allowing to set the prestashop classes that will be used to fetch the links
     *
     * @param array $prestashopClasses
     *
     * @return $this
     */
    public function setPrestashopClasses(array $prestashopClasses): PrestashopLinkSelectPrimitiveFieldType
    {
        $this->prestashopClasses = $prestashopClasses;

        return $this;
    }
}
