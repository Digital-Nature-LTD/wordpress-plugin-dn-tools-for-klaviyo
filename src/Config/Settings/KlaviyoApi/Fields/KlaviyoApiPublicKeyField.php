<?php

namespace DigitalNature\ToolsForKlaviyo\Config\Settings\KlaviyoApi\Fields;

use DigitalNature\ToolsForKlaviyo\Config\Settings\KlaviyoApi\KlaviyoApiSetting;
use DigitalNature\Utilities\Config\SettingField;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

class KlaviyoApiPublicKeyField extends SettingField
{
    /**
     * @return string
     */
    public function get_field_title(): string
    {
        return 'API Key - Public';
    }

    /**
     * @return string
     */
    public function get_field_name(): string
    {
        return 'dn_tools_for_klaviyo_plugin_setting_api_key_public';
    }

    /**
     * @return string
     */
    public function get_field_id(): string
    {
        return 'api_key_public';
    }

    /**
     * @return string
     */
    public function get_setting_class(): string
    {
        return KlaviyoApiSetting::class;
    }

    /**
     * Validates that the public API key is a 6 char alphanumeric string
     *
     * @param array $submitted
     * @return bool
     */
    public function is_valid(array $submitted): bool
    {
        if (!preg_match( '/^[a-z0-9]{6}$/i', $submitted[$this->get_field_id()])) {
            return false;
        }

        return true;
    }
}