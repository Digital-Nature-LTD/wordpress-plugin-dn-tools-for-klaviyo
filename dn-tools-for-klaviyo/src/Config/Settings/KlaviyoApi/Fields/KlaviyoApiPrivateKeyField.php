<?php

namespace DigitalNature\ToolsForKlaviyo\Config\Settings\KlaviyoApi\Fields;

use DigitalNature\Utilities\Config\Setting;
use DigitalNature\Utilities\Config\SettingField;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

class KlaviyoApiPrivateKeyField extends SettingField
{
    /**
     * @return string
     */
    public static function get_field_title(): string
    {
        return 'API Key - Private';
    }

    /**
     * @return string
     */
    public static function get_field_name(): string
    {
        return 'dn_tools_for_klaviyo_plugin_setting_api_key_private';
    }

    /**
     * @return string
     */
    public static function get_field_id(): string
    {
        return 'api_key_private';
    }

    /**
     * Validates that the private API key is a 37 char string starting pk_
     *
     * @param array $submitted
     * @param Setting $setting
     * @return bool
     */
    public static function is_valid(array $submitted, Setting $setting): bool
    {
        if (!preg_match( '/^pk_[a-z0-9]{34}$/i', $submitted[static::get_field_name()])) {
            $setting->add_field_error(self::get_field_title() . ' must be a 37 character string starting pk_');
            return false;
        }

        return true;
    }
}