<?php

namespace DigitalNature\ToolsForKlaviyo\Helpers;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

use DigitalNature\ToolsForKlaviyo\Config\PluginConfig;
use DigitalNature\ToolsForKlaviyo\Config\Settings\KlaviyoApi\Fields\KlaviyoApiPrivateKeyField;
use DigitalNature\ToolsForKlaviyo\Config\Settings\KlaviyoApi\Fields\KlaviyoApiPublicKeyField;
use DigitalNature\ToolsForKlaviyo\Config\Settings\KlaviyoApi\Fields\KlaviyoApiUserAgentSuffixField;
use DigitalNature\ToolsForKlaviyo\Config\Settings\KlaviyoApi\KlaviyoApiSetting;
use DigitalNature\WordPressUtilities\Helpers\LogHelper;
use KlaviyoAPI\KlaviyoAPI;

class KlaviyoApiHelper
{
    /**
     * @return false|mixed|null
     */
    protected static function get_options()
    {
        $settings = new KlaviyoApiSetting();
        return get_option($settings->get_option_name());
    }

    /**
     * @param $options
     * @param $field
     * @return null|mixed
     */
    protected static function get_option_value($options, $field)
    {
        if (empty($options[$field])) {
            return null;
        }

        return $options[$field];
    }

    /**
     * @param string $privateFieldValue
     * @param string $publicFieldValue
     * @return bool
     */
    protected static function api_keys_are_populated(string $privateFieldValue, string $publicFieldValue): bool
    {
        if (empty($privateFieldValue)) {
            LogHelper::write(PluginConfig::get_plugin_friendly_name() . " - Cannot make request, Private API Key not set");
            return false;
        }

        if (empty($publicFieldValue)) {
            LogHelper::write(PluginConfig::get_plugin_friendly_name() . " - Cannot make request, Public API Key not set");
            return false;
        }

        return true;
    }

    /**
     * @return KlaviyoAPI|null
     */
    protected static function get_client(): ?KlaviyoAPI
    {
        $options = self::get_options();
        $privateFieldValue = self::get_option_value($options, KlaviyoApiPrivateKeyField::get_field_name());
        $publicFieldValue = self::get_option_value($options, KlaviyoApiPublicKeyField::get_field_name());
        $userAgentSuffixFieldValue = self::get_option_value($options, KlaviyoApiUserAgentSuffixField::get_field_name());

        if (!self::api_keys_are_populated($privateFieldValue, $publicFieldValue)) {
            return null;
        }

        return new KlaviyoAPI(
            $privateFieldValue,
            3,
            3,
            [
                'verify' => false
            ],
            $userAgentSuffixFieldValue
        );
    }
}