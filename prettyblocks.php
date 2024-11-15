<?php

declare(strict_types=1);
/**
 * Copyright (c) Since 2020 PrestaSafe and contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@prestasafe.com so we can send you a copy immediately.
 *
 * @author    PrestaSafe <contact@prestasafe.com>
 * @copyright Since 2020 PrestaSafe and contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaSafe
 */

use PrestaSafe\PrettyBlocks\Controller\Admin\EditionController;
use PrestaSafe\PrettyBlocks\Exception\PrettyBlocksException;
use PrestaSafe\PrettyBlocks\Install\Installer;
use PrestaSafe\PrettyBlocks\Smarty\Plugin\ZonePlugin;
use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

if (!defined('_PS_VERSION_')) {
    exit;
}
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

class PrettyBlocks extends Module
{
    public $js_path;
    public $css_path;
    public $tabs = [
        [
            'name' => 'Pretty Blocks', // One name for all langs
            'class_name' => EditionController::class,
            'visible' => true,
            'route_name' => 'prettyblocks_admin_edit',
            'parent_class_name' => 'AdminParentThemes',
        ],
    ];

    public function __construct()
    {
        $this->name = 'prettyblocks';
        $this->tab = 'administration';
        $this->version = '4.0.0';
        $this->author = 'PrestaSafe';
        $this->need_instance = 1;

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->trans('Pretty Blocks', [], 'Modules.Prettyblocks.Admin');
        $this->description = $this->trans('Configure your design easily', [], 'Modules.Prettyblocks.Admin');
        $this->controllers = ['ajax'];

        $this->ps_versions_compliancy = ['min' => '8.1.0', 'max' => _PS_VERSION_];
    }

    public function isUsingNewTranslationSystem()
    {
        return true;
    }

    public function getContent()
    {
        /** @var \Symfony\Component\Routing\RouterInterface $router */
        $router = $this->get('router');
        $route = $router->generate('prettyblocks_admin_edit', []);
        Tools::redirectAdmin($route);
    }

    private function loadDefault()
    {
        return Configuration::updateGlobalValue('_PRETTYBLOCKS_TOKEN_', Tools::passwdGen(25));
    }

    public function install(): bool
    {
        if (!(parent::install())) {
            return false;
        }

        /** @var \Doctrine\DBAL\Connection $dbalConnection */
        $dbalConnection = $this->get('doctrine.dbal.default_connection');

        /** @var Installer $installer */
        $installer = (new Installer($this->getTranslator(), $dbalConnection, $this));

        try {
            return $installer->install($this);
        } catch (PrettyBlocksException $e) {
            $this->_errors[] = $e->getMessage();
            $installer->uninstall($this);
            parent::uninstall();

            return false;
        }
    }

    /**
     * @throws Exception
     *
     * @return bool
     */
    public function uninstall(): bool
    {
        /** @var \Doctrine\DBAL\Connection $dbalConnection */
        $dbalConnection = $this->get('doctrine.dbal.default_connection');

        /** @var Installer $installer */
        $installer = (new Installer($this->getTranslator(), $dbalConnection, $this));

        try {
            return ($installer)->uninstall($this) && parent::uninstall();
        } catch (Exception $e) {
            $this->_errors[] = $e->getMessage();

            return false;
        }
    }

    public function hookActionDispatcher()
    {
        $this->context->smarty->registerPlugin('function', 'prettyblocks_zone', [ZonePlugin::class, 'renderZone']);
    }

//
//    /**
//     * Return la view
//     */
//    public function renderWidget($hookName = null, array $configuration = [])
//    {
//        // @todo: delete widget
//        return;
//        $vars = $this->getWidgetVariables($hookName, $configuration);
//        $this->smarty->assign($vars);
//        if (isset($configuration['zone_name'])) {
//            return $this->renderZone(['zone_name' => pSQL($configuration['zone_name'])]);
//        }
//        if (isset($configuration['action']) && $configuration['action'] == 'GetBlockRender') {
//            $block = $configuration['data'];
//            $vars = [
//                'id_prettyblocks' => $block['id_prettyblocks'],
//                'instance_id' => $block['instance_id'],
//                'state' => $block['repeater_db'],
//                'block' => $block,
//                'test' => Hook::exec('beforeRenderingBlock', ['state' => $configuration['data']], null, true),
//            ];
//            $this->smarty->assign($vars);
//            $template = $block['templates'][$block['templateSelected']] ?? 'module:prettyblocks/views/templates/blocks/welcome.tpl';
//
//            return $this->fetch($template);
//        }
//        if ($vars['hookName'] !== null) {
//            return ZonePlugin::renderZone(['zone_name' => $vars['hookName']]);
//        }
//    }

}
