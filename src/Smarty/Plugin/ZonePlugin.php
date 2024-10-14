<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Smarty\Plugin;

use Context;

class ZonePlugin
{
    public static function renderZone($params): string
    {
        $zone_name = $params['zone_name'];

        if (empty($zone_name)) {
            return '';
        }

        $context = Context::getContext();
        $id_lang = $context->language->id;
        $id_shop = $context->shop->id;
        //$blocks = PrettyBlocksModel::getInstanceByZone($zone_name, 'front', $id_lang, $id_shop);
        $blocks = [];

        $context->smarty->assign([
            'zone_name' => $zone_name,
            'blocks' => $blocks,
        ]);

        return $context->smarty->fetch('module:prettyblocks/views/templates/front/zone.tpl');
    }

    public static function renderTitle($param): string
    {
        return $param['title'];
    }
}
