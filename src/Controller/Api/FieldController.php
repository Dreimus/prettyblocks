<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Controller\Api;

use Category;
use CMS;
use CMSCategory;
use Manufacturer;
use PrestaSafe\PrettyBlocks\FieldType\Registry\FieldTypeElementRegistry;
use PrestaSafe\PrettyBlocks\Presenter\FieldType\FieldTypeApiPresenter;
use PrestaShop\PrestaShop\Adapter\LegacyContext;
use PrestaShopCollection;
use Product;
use Supplier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class FieldController extends AbstractController implements EventSubscriberInterface
{
    public function __construct(
        protected FieldTypeElementRegistry $fieldTypeRegistry,
        protected FieldTypeApiPresenter $fieldTypeApiPresenter,
        protected LegacyContext $context
    ) {
    }

    /**
     * Endpoint to list all available blocks
     */
    public function listAction(): JsonResponse
    {
        $data = [];

        foreach ($this->fieldTypeRegistry->getRegisteredFieldTypes() as $fieldType) {
            $data[] = $this->fieldTypeApiPresenter->present($fieldType);
        }

        return new JsonResponse($data);
    }

    public function searchEntitiesAction(): JsonResponse
    {
        $data = [
            [
                'slug' => 'product',
                'label' => 'Product',
                'getValuesUrl' => $this->generateUrl('prettyblocks_field_entities_get', ['entity' => 'product']),
            ],
            [
                'slug' => 'category',
                'label' => 'Category',
                'getValuesUrl' => $this->generateUrl('prettyblocks_field_entities_get', ['entity' => 'category']),
            ],
            [
                'slug' => 'cms_page',
                'label' => 'CMS Page',
                'getValuesUrl' => $this->generateUrl('prettyblocks_field_entities_get', ['entity' => 'cms_page']),
            ],
            [
                'slug' => 'manufacturer',
                'label' => 'Manufacturer',
                'getValuesUrl' => $this->generateUrl('prettyblocks_field_entities_get', ['entity' => 'manufacturer']),
            ],
            [
                'slug' => 'cms_category',
                'label' => 'CMS Category',
                'getValuesUrl' => $this->generateUrl('prettyblocks_field_entities_get', ['entity' => 'cms_category']),
            ],
            [
                'slug' => 'supplier',
                'label' => 'Supplier',
                'getValuesUrl' => $this->generateUrl('prettyblocks_field_entities_get', ['entity' => 'supplier']),
            ]
        ];

        return new JsonResponse($data);
    }

    public function getAction(string $idZone): JsonResponse
    {
        return new JsonResponse([]);
    }

    public function getEntityAction(string $entity): JsonResponse
    {
        $entityClass = null;

        switch ($entity) {
            case 'product':
                $entityClass = Product::class;
                break;
            case 'category':
                $entityClass = Category::class;
                break;
            case 'cms_page':
                $entityClass = CMS::class;
                break;
            case 'manufacturer':
                $entityClass = Manufacturer::class;
                break;
            case 'cms_category':
                $entityClass = CMSCategory::class;
                break;
            case 'supplier':
                $entityClass = Supplier::class;
                break;
        }

        if (null === $entityClass) {
            return new JsonResponse(['error' => 'Entity not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = [];
        $collection = new PrestaShopCollection($entityClass, $this->context->getContext()->language->id);

        foreach ($collection as $objectModel) {
            if ($objectModel instanceof CMS) {
                $data[] = [
                    'id' => $objectModel->id,
                    'name' => $objectModel->meta_title,
                ];
            } else {
                $data[] = [
                    'id' => $objectModel->id,
                    'name' => $objectModel->name,
                ];
            }
        }

        return new JsonResponse($data);
    }

    public static function getSubscribedEvents(): array
    {
        return [];
    }

    public function searchIconsAction(): JsonResponse
    {
        return new JsonResponse([
            'tag' => 'Tag',
            'charcoal_barbecue' => 'Barbecue',
            'gas_barbecue' => 'Gas barbecue',
            'plancha' => 'Plancha',
            'outdoor_kitchen' => 'Outdoor kitchen',
            'pizza_oven' => 'Pizza oven',
            'pellets_barbecue' => 'Pellets barbecue',
            'electric_barbecue' => 'Electric barbecue',
            'brasero' => 'Brasero',
            'smoker' => 'Smoker',
            'accessories' => 'Accessories',
            'spare_parts' => 'Spare parts',
            'flag' => 'Flag',
            'size' => 'Size',
        ]);
    }
}
