<?php

namespace DigitalNature\ToolsForKlaviyo\Config\Settings\KlaviyoApi\Fields;

use DigitalNature\Utilities\Config\SettingField;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

class KlaviyoApiEventPrefixField extends SettingField
{
    /**
     * @return string
     */
    public static function get_field_title(): string
    {
        return 'Event prefix';
    }

    /**
     * @return string
     */
    public static function get_field_name(): string
    {
        return 'dn_tools_for_klaviyo_plugin_setting_event_prefix';
    }

    /**
     * @return string
     */
    public static function get_field_id(): string
    {
        return 'event_prefix';
    }

    /**
     * @param array $submitted
     * @return bool
     */
    public static function is_valid(array $submitted): bool
    {
        return true;
    }
}