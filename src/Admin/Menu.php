<?php

namespace DigitalNature\ToolsForKlaviyo\Admin;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

use DigitalNature\ToolsForKlaviyo\Config\Settings\KlaviyoApi\KlaviyoApiSetting;
use DigitalNature\ToolsForKlaviyo\Config\PluginConfig;
use DigitalNature\Utilities\Admin\Menu as DigitalNatureAdminMenu;
use DigitalNature\ToolsForKlaviyo\Common\Users\Capabilities\DigitalNatureToolsForKlaviyoSettingsCapability;
use DigitalNature\WordPressUtilities\Helpers\TemplateHelper;

class Menu
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_admin_menu'], 20);
    }

    /**
     * Adds the menu items
     *
     * @return void
     */
    public function add_admin_menu()
    {
        $klaviyoApiSetting = new KlaviyoApiSetting();

        add_submenu_page(
            DigitalNatureAdminMenu::DIGITAL_NATURE_MENU_SLUG,
            'Digital Nature - Tools for Klaviyo',
            'Tools for Klaviyo',
            DigitalNatureToolsForKlaviyoSettingsCapability::get_capability_name(), // capability
            $klaviyoApiSetting->get_setting_page_slug(), // menu slug
            [ $this, 'dn_tools_for_klaviyo_settings_view' ],
        );
    }

    /**
     * @return void
     */
    public function dn_tools_for_klaviyo_settings_view()
    {
        TemplateHelper::render(
            PluginConfig::get_plugin_name() . '/admin/configure.php',
            [
                'setting' => new KlaviyoApiSetting()
            ],
            trailingslashit(PluginConfig::get_plugin_dir() . '/templates')
        );
    }

}