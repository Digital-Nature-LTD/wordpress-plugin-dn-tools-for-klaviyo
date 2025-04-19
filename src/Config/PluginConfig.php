<?php

namespace DigitalNature\ToolsForKlaviyo\Config;

use DigitalNature\WordPressUtilities\Config\PluginConfiguration;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

class PluginConfig extends PluginConfiguration
{
    /**
     * @return string
     */
    public static function get_prefix(): string
    {
        return 'DIGITAL_NATURE_TOOLS_FOR_KLAVIYO';
    }

    /**
     * @return string
     */
    public static function get_plugin_name(): string
    {
        return 'dn-tools-for-klaviyo';
    }

    /**
     * @return string
     */
    public static function get_plugin_friendly_name(): string
    {
        return 'Digital Nature - Tools for Klaviyo';
    }

    /**
     * @return string
     */
    public static function get_plugin_text_domain(): string
    {
        return 'dn-tools-for-klaviyo';
    }
}