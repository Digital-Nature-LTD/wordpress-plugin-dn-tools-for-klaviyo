<?php

namespace DigitalNature\ToolsForKlaviyo\Admin;

use DigitalNature\ToolsForKlaviyo\Config\PluginConfig;
use DigitalNature\ToolsForKlaviyo\Config\Settings\KlaviyoApi\KlaviyoApiSetting;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

class PluginActionLinks
{
    public function __construct()
    {
        add_action('plugin_action_links_' . PluginConfig::get_plugin_base(), [$this, 'add_plugin_action_link'], 20);
    }

    /**
     * Adds action links to the plugin list table
     *
     * @param array $links
     * @return array
     */
    public function add_plugin_action_link(array $links): array
    {
        $klaviyoApiSetting = new KlaviyoApiSetting();

        $links['configure'] = sprintf( '<a href="%s" title="Configure">%s</a>', '/wp-admin/admin.php?page=' . $klaviyoApiSetting->get_setting_page(), __( 'Configure', PluginConfig::get_plugin_name() ) );

        return $links;
    }
}