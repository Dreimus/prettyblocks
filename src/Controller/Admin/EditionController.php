<?php

declare(strict_types=1);

namespace PrestaSafe\PrettyBlocks\Controller\Admin;

use Configuration;
use Link;
use Module;
use PrestaShop\PrestaShop\Adapter\Shop\Context;
use PrestaShop\PrestaShop\Core\Feature\TokenInUrls;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopBundle\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Tools;

class EditionController extends FrameworkBundleAdminController
{
    public function __construct(
        protected TranslatorInterface $translator,
        protected Context $context
    ) {
        parent::__construct();
    }

    public function editAction(): Response
    {
        $_SERVER[TokenInUrls::ENV_VAR] = TokenInUrls::DISABLED;

        $module = Module::getInstanceByName('prettyblocks');

        $link = new Link();

        $shop_url = $link->getBaseLink();
        $admin_link = $this->get('router')->generate('admin_module_manage');

        $available_language_ids = (\Language::getLanguages(true, $this->context->getContextShopID()));
        $available_language_ids = array_map(static function ($lang) {
            return $lang['id_lang'];
        }, $available_language_ids);

        $variablesForJs = [
            'routes' => [
                'back_office' => $admin_link,
                'front_office' => $shop_url,
                'fields_list' => $this->get('router')->generate('prettyblocks_field_list'),
                'zone_list' => $this->get('router')->generate('prettyblocks_zone_list'),
                'media_upload' => $this->get('router')->generate('prettyblocks_media_upload'),
            ],
        ];

        /**
         * @todo: migrate raw variables to PrettyBlocks inner variables
         */
        return $this->render('@Modules/prettyblocks/templates/admin/edit.html.twig', [
            'prettyblocks' => $variablesForJs,
            'base_url' => $link->getBaseLink(),
            'favicon_url' => Tools::getShopDomainSsl(true) . '/modules/' . $module->name . '/views/images/favicon.ico',
            'module_name' => $module->displayName,
            'shop_name' => $this->context->getShopName(),
            'env' => [
                'vitedev' => filter_var(getenv('PRETTYBLOCKS_VITE_DEV'), FILTER_VALIDATE_BOOLEAN) ?? false,
                'PRETTYBLOCKS_VITE_HOST' => getenv('PRETTYBLOCKS_VITE_HOST') ? getenv('PRETTYBLOCKS_VITE_HOST') : 'http://localhost:3002/',
                'iframe_sandbox' => getenv('PRETTYBLOCKS_IFRAME_SANDBOX') ? getenv('PRETTYBLOCKS_IFRAME_SANDBOX') : 'allow-same-origin allow-scripts allow-forms allow-popups allow-presentation allow-top-navigation allow-pointer-lock allow-popups-to-escape-sandbox allow-modals allow-top-navigation-by-user-activation',
            ],
            'ajax_urls' => [
                'simulate_home' => $this->get('router')->generate('prettyblocks_field_list'),
                'search_by_ref' => $this->get('router')->generate('prettyblocks_field_list'),
                'adminURL' => '',
                // 'update_ajax' => $updateAjax,
                'sf' => $link->getBaseLink(),
                'api' => $link->getBaseLink(),
                'current_domain' => $shop_url,
                'block_url' => $link->getBaseLink(),
                'state' => $link->getBaseLink(),
                'collection' => $link->getBaseLink(),
                //                'block_action_urls' => $blockUrl,
                //                'theme_settings' => $settingsUrls,
                'startup_url' => $link->getBaseLink(),
            ],
            'trans_app' => [
                'current_shop' => $this->translator->trans('Shop in modification', domain: 'Modules.Prettyblocks.Admin'),
                'save' => $this->translator->trans('Save', domain: 'Modules.Prettyblocks.Admin'),
                'add_new_element' => $this->translator->trans('Add new element', domain: 'Modules.Prettyblocks.Admin'),
                'avalaible_elements' => $this->translator->trans('Availables blocks', domain: 'Modules.Prettyblocks.Admin'),
                'close' => $this->translator->trans('Close', domain: 'Modules.Prettyblocks.Admin'),
                'current_zone' => $this->translator->trans('Current zone', domain: 'Modules.Prettyblocks.Admin'),
                'loading' => $this->translator->trans('Loading', domain: 'Modules.Prettyblocks.Admin'),
                'default_settings' => $this->translator->trans('Default settings', domain: 'Modules.Prettyblocks.Admin'),
                'choose_template' => $this->translator->trans('Choose a template', domain: 'Modules.Prettyblocks.Admin'),
                'use_container' => $this->translator->trans('Place the element in a column (container)', domain: 'Modules.Prettyblocks.Admin'),
                'bg_color' => $this->translator->trans('Background color', domain: 'Modules.Prettyblocks.Admin'),
                'ex_color' => $this->translator->trans('Add a color ex: #123456', domain: 'Modules.Prettyblocks.Admin'),
                'theme_settings' => $this->translator->trans('Theme settings', domain: 'Modules.Prettyblocks.Admin'),
                'type_search_here' => $this->translator->trans('Type your search here', domain: 'Modules.Prettyblocks.Admin'),
                'search_blocks' => $this->translator->trans('Search blocks', domain: 'Modules.Prettyblocks.Admin'),
                'is_cached' => $this->translator->trans('Enable cache', domain: 'Modules.Prettyblocks.Admin'),
                'paddings' => $this->translator->trans('Paddings', domain: 'Modules.Prettyblocks.Admin'),
                'top' => $this->translator->trans('Top', domain: 'Modules.Prettyblocks.Admin'),
                'right' => $this->translator->trans('Right', domain: 'Modules.Prettyblocks.Admin'),
                'bottom' => $this->translator->trans('Bottom', domain: 'Modules.Prettyblocks.Admin'),
                'left' => $this->translator->trans('Left', domain: 'Modules.Prettyblocks.Admin'),
                'margins' => $this->translator->trans('Margins', domain: 'Modules.Prettyblocks.Admin'),
                'use_custom_entry' => $this->translator->trans('Use custom entries (px, rem etc..)', domain: 'Modules.Prettyblocks.Admin'),
                'auto_size_section' => $this->translator->trans('Auto sizing', domain: 'Modules.Prettyblocks.Admin'),
                'paddings_section_help' => $this->translator->trans('Padding is the space inside an element, between its content and its boundary', domain: 'Modules.Prettyblocks.Admin'),
                'margins_section_help' => $this->translator->trans('Margin refers to the space outside an element, separating it from other elements', domain: 'Modules.Prettyblocks.Admin'),
                'force_full_width' => $this->translator->trans('Stretch section to 100%', domain: 'Modules.Prettyblocks.Admin'),
                'position_updated' => $this->translator->trans('Position updated successfully', domain: 'Modules.Prettyblocks.Admin'),
                'element_removed' => $this->translator->trans('Element removed successfully', domain: 'Modules.Prettyblocks.Admin'),
                'element_added' => $this->translator->trans('Element added successfully', domain: 'Modules.Prettyblocks.Admin'),
                'error_console' => $this->translator->trans('An error occurred while processing your request', domain: 'Modules.Prettyblocks.Admin'),
                'duplicate_state_error' => $this->translator->trans('An error occurred while duplicating the element', domain: 'Modules.Prettyblocks.Admin'),
                'get_pro' => $this->translator->trans('Get Pro Blocks', domain: 'Modules.Prettyblocks.Admin'),
            ],
            'security_app' => [
                'ajax_token' => Configuration::getGlobalValue('_PRETTYBLOCKS_TOKEN_'),
                'prettyblocks_version' => $module->version,
                'available_language_ids' => $available_language_ids,
                'tinymce_api_key' => 'no-api-key',
            ],
        ]);
    }
}
