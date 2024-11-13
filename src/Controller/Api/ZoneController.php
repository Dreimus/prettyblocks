<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Controller\Api;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use JsonException;
use PrestaSafe\PrettyBlocks\Entity\Block;
use PrestaSafe\PrettyBlocks\Entity\Zone;
use PrestaSafe\PrettyBlocks\FieldType\Element\Block\Footer;
use PrestaSafe\PrettyBlocks\FieldType\Element\Block\NavigationMenu;
use PrestaSafe\PrettyBlocks\FieldType\Element\Block\PreHeader;
use PrestaSafe\PrettyBlocks\FieldType\Element\Block\PromotionSlider;
use PrestaSafe\PrettyBlocks\FieldType\Registry\FieldTypeElementRegistry;
use PrestaSafe\PrettyBlocks\Presenter\FieldType\FieldTypeApiPresenter;
use PrestaSafe\PrettyBlocks\Service\BlockTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ZoneController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected BlockTransformer $blockTransformer,
        protected FieldTypeElementRegistry $fieldTypeRegistry,
        protected FieldTypeApiPresenter $fieldTypeApiPresenter
    ) {
    }

    /**
     * Return the list of all available zones
     */
    public function listZones(): JsonResponse
    {
        $zones = $this->entityManager->getRepository(Zone::class)->findAll();
        $data = [];

        foreach ($zones as $zone) {
            $data[] = [
                'id' => $zone->getId(),
                'label' => $zone->getLabel(),
                'getUrl' => $this->generateUrl('prettyblocks_zone_get', ['id' => $zone->getId()]),
                'updateUrl' => $this->generateUrl('prettyblocks_zone_update', ['id' => $zone->getId()]),
                'blockAvailableUrl' => $this->generateUrl('prettyblocks_zone_fields', ['id' => $zone->getId()]),
            ];
        }

        return new JsonResponse($data);
    }

    /**
     * Return a specific zone by its ID
     */
    public function getZone(string $id): JsonResponse
    {
        $zone = $this->entityManager->getRepository(Zone::class)->find($id);

        if (null === $zone) {
            return new JsonResponse(['error' => 'Zone not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        try {
            $data = [
                'id' => $zone->getId(),
                'label' => $zone->getLabel(),
            ];

            $content = [];

            foreach ($zone->getBlocks() as $block) {
                $content[$block->getPosition()] =
                    [
                        'id' => $block->getId(),
                        'block_id' => $block->getBlockId(),
                        'type' => $block->getType(),
                        'label' => $block->getLabel(),
                        'fields' => $block->getFields(),
                    ];
            }

            $data['content'] = $content;
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse($data);
    }

    public function getZoneFields(string $id): JsonResponse
    {
        switch ($id) {
            case '1': // sur entête
                $this->fieldTypeRegistry->add(PreHeader::class);
                break;
            case '2': // entête
                $this->fieldTypeRegistry->add(NavigationMenu::class);
                $this->fieldTypeRegistry->add(PromotionSlider::class);
                break;
            case '3': // pied de page
                $this->fieldTypeRegistry->add(Footer::class);
                break;
            default: // default
                $this->fieldTypeRegistry->registerNativeElements();
        }

        $data = [];

        foreach ($this->fieldTypeRegistry->getRegisteredFieldTypes() as $fieldType) {
            $data[] = $this->fieldTypeApiPresenter->present($fieldType);
        }

        return new JsonResponse($data);
    }

    /**
     * Update a specific zone by its ID with edited elements
     *
     * @throws JsonException
     */
    public function updateZone(Request $request, string $id): JsonResponse
    {
        $zone = $this->entityManager->getRepository(Zone::class)->find($id);

        if (null === $zone) {
            return new JsonResponse(['error' => 'Zone not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        try {
            $elements = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return new JsonResponse(['error' => 'Invalid JSON'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $newBlockIds = [];

        foreach ($elements as $position => $element) {
            $blockId = $element['block_id'];
            $newBlockIds[] = $blockId;

            $existingBlock = null;
            foreach ($zone->getBlocks() as $block) {
                if ($block->getBlockId() === $blockId) {
                    $existingBlock = $block;
                    break;
                }
            }

            if ($existingBlock) {
                $existingBlock
                    ->setLabel($element['label'] ?? '')
                    ->setFields($element['fields'] ?? [])
                    ->setPosition($position);
            } else {
                $block = new Block($element['label'] ?? '');
                $block
                    ->setBlockId($blockId)
                    ->setFields($element['fields'] ?? [])
                    ->setPosition($position)
                    ->setZone($zone);

                $zone->addBlock($block, $position);
                $this->entityManager->persist($block);
            }
        }

        foreach ($zone->getBlocks()->toArray() as $existingBlock) {
            if (!in_array($existingBlock->getBlockId(), $newBlockIds, true)) {
                $zone->removeBlock($existingBlock);
                $this->entityManager->remove($existingBlock);
            }
        }

        try {
            // Persistance de la zone
            $this->entityManager->persist($zone);
            $this->entityManager->flush();
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse(['status' => 'Zone updated successfully']);
    }
}
