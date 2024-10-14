<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Controller\Api;

use PrestaSafe\PrettyBlocks\FieldType\Registry\FieldTypeElementRegistry;
use PrestaSafe\PrettyBlocks\Presenter\FieldType\FieldTypeApiPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class FieldController extends AbstractController implements EventSubscriberInterface
{
    public function __construct(
        protected FieldTypeElementRegistry $fieldTypeRegistry,
        protected FieldTypeApiPresenter $fieldTypeApiPresenter
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

    public function getAction(string $idZone): JsonResponse
    {
        return new JsonResponse([]);
    }

    public static function getSubscribedEvents()
    {
        return [];
    }
}
