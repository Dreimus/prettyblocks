<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Controller\Api;

use PrestaSafe\PrettyBlocks\Service\ZoneService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MediaController extends AbstractController
{
    public function upload(Request $request, ZoneService $zoneService): JsonResponse
    {
        $zone = $request->get('zone');
        $file = $request->files->get('file');

        if (!$zone || !$file) {
            return new JsonResponse(['error' => 'Invalid request'], 400);
        }

        $zoneService->upload($zone, $file);

        return new JsonResponse(['success' => true]);
    }
}
