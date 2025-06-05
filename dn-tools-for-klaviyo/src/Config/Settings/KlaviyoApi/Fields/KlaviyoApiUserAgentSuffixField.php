<?php

namespace DigitalNature\ToolsForKlaviyo\Config\Settings\KlaviyoApi\Fields;

use DigitalNature\Utilities\Config\Setting;
use DigitalNature\Utilities\Config\SettingField;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

class KlaviyoApiUserAgentSuffixField extends SettingField
{
    /**
     * @return string
     */
    public static function get_field_title(): string
    {
        return 'User agent suffix';
    }

    /**
     * @return string
     */
    public static function get_field_name(): string
    {
        return 'dn_tools_for_klaviyo_plugin_setting_user_agent_suffix';
    }

    /**
     * @return string
     */
    public static function get_field_id(): string
    {
        return 'user_agent_suffix';
    }

    /**
     * Validates that the suffix is provided, starts with a slash and has at least one character
     *
     * @param array $submitted
     * @param Setting $setting
     * @return bool
     */
    public static function is_valid(array $submitted, Setting $setting): bool
    {
        if (!preg_match( '/^\/[a-zA-Z0-9]+$/i', $submitted[static::get_field_name()])) {
            $setting->add_field_error(self::get_field_title() . ' must be an alphanumeric string starting with a "/"');
            return false;
        }

        return true;
    }
}