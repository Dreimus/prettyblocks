<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Smarty\Plugin;

use PrestaSafe\PrettyBlocks\Entity\Zone;
use PrestaSafe\PrettyBlocks\Renderer\Zone\ZoneRenderer;
use PrestaShop\PrestaShop\Adapter\SymfonyContainer;

class ZonePlugin
{
    /**
     * @smarty_plugin prettyblocks_zone
     *
     * @param $params
     *
     * @throws \SmartyException
     *
     * @return string
     */
    public static function renderZone($params): string
    {
        $zoneReference = $params['name'];

        if (empty($zoneReference)) {
            throw new \SmartyException('PrettyBlock zone name is required');
        }

        $container = SymfonyContainer::getInstance();

        if (null === $container) {
            throw new \SmartyException('Container not found');
        }

        /** @var Zone $zone */
        $zone = ($container->get('doctrine.orm.entity_manager'))
            ->getRepository(Zone::class)
            ->findOneBy(['reference' => $zoneReference]);

        if (!$zone) {
            return '';
        }

        $zoneRenderer = $container->get(ZoneRenderer::class);

        if (empty($zoneRenderer)) {
            throw new \SmartyException('Zone renderer not found');
        }

        return $zoneRenderer->render($zone);
    }

}
