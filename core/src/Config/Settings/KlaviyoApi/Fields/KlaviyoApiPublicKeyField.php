<?php

namespace DigitalNature\ToolsForKlaviyo\Config\Settings\KlaviyoApi\Fields;

use DigitalNature\Utilities\Config\Setting;
use DigitalNature\Utilities\Config\SettingField;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

class KlaviyoApiPublicKeyField extends SettingField
{
    /**
     * @return string
     */
    public static function get_field_title(): string
    {
        return 'API Key - Public';
    }

    /**
     * @return string
     */
    public static function get_field_name(): string
    {
        return 'dn_tools_for_klaviyo_plugin_setting_api_key_public';
    }

    /**
     * @return string
     */
    public static function get_field_id(): string
    {
        return 'api_key_public';
    }

    /**
     * Validates that the public API key is a 6 char alphanumeric string
     *
     * @param array $submitted
     * @param Setting $setting
     * @return bool
     */
    public static function is_valid(array $submitted, Setting $setting): bool
    {
        if (!preg_match( '/^[a-z0-9]{6}$/i', $submitted[static::get_field_name()])) {
            $setting->add_field_error(self::get_field_title() . ' must be a 6 character alphanumeric string');
            return false;
        }

        return true;
    }
}