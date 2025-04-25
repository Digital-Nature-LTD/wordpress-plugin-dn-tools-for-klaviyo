<?php

namespace DigitalNature\ToolsForKlaviyo\Admin\Hooks;

// Exit if accessed directly.
use DigitalNature\ToolsForKlaviyo\Config\PluginConfig;
use DigitalNature\ToolsForKlaviyo\Helpers\KlaviyoApiHelper;
use DigitalNature\WordPressUtilities\Helpers\TemplateHelper;

if ( ! defined( 'ABSPATH' ) ) exit;

class Options
{
    public function __construct()
    {
        add_action('dn_tools_for_klaviyo_plugin_options_configuration_panel_body_after_form', [$this, 'dn_tools_for_klaviyo_plugin_options_configuration_panel_body_after_form']);
    }

    /**
     * Add the test form for the Klaviyo API on the configuration page
     *
     * @return void
     */
    public function dn_tools_for_klaviyo_plugin_options_configuration_panel_body_after_form(): void
    {
        if (!KlaviyoApiHelper::is_configured()) {
            return;
        }

        TemplateHelper::render(
            PluginConfig::get_plugin_name() . '/admin/api/test-event.php',
            [
            ],
            trailingslashit(PluginConfig::get_plugin_dir() . '/templates')
        );
    }
}