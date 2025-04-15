<?php

namespace DigitalNature\ToolsForKlaviyo\Helpers;

use DigitalNature\ToolsForKlaviyo\Config\PluginConfig;
use DigitalNature\ToolsForKlaviyo\Config\Settings\KlaviyoApi\Fields\KlaviyoApiEventPrefixField;
use DigitalNature\ToolsForKlaviyo\Config\Settings\KlaviyoApi\Fields\KlaviyoApiPrivateKeyField;
use DigitalNature\ToolsForKlaviyo\Config\Settings\KlaviyoApi\Fields\KlaviyoApiPublicKeyField;
use DigitalNature\ToolsForKlaviyo\Config\Settings\KlaviyoApi\Fields\KlaviyoApiUserAgentSuffixField;
use DigitalNature\ToolsForKlaviyo\Config\Settings\KlaviyoApi\KlaviyoApiSetting;
use Exception;
use KlaviyoAPI\KlaviyoAPI;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

class KlaviyoEventHelper
{
    /**
     * @param string $event
     * @param string $email
     * @param array $data
     * @return bool
     */
    public static function create(string $event, string $email, array $data): bool
    {
        // allow this to be turned off programmatically
        if (apply_filters('dn_tools_for_klaviyo_is_sandbox', false, $event)) {
            return false;
        }

        $options = self::get_options();
        $privateFieldValue = self::get_option_value($options, KlaviyoApiPrivateKeyField::get_field_id());
        $publicFieldValue = self::get_option_value($options, KlaviyoApiPublicKeyField::get_field_id());
        $userAgentSuffixFieldValue = self::get_option_value($options, KlaviyoApiUserAgentSuffixField::get_field_id());
        $eventPrefixFieldValue = self::get_option_value($options, KlaviyoApiEventPrefixField::get_field_id());


        if (empty($privateFieldValue)) {
            error_log(PluginConfig::get_plugin_friendly_name() . " - Cannot make request, Private API Key not set");
            return false;
        }

        if (empty($publicFieldValue)) {
            error_log(PluginConfig::get_plugin_friendly_name() . " - Cannot make request, Public API Key not set");
            return false;
        }

        try {
            $client = new KlaviyoAPI(
                $privateFieldValue,
                3,
                3,
                [
                    'verify' => false
                ],
                $userAgentSuffixFieldValue
            );

            $client->Events->createEvent(
                [
                    'data' => [
                        'type' => 'event',
                        'attributes' => [
                            'properties' => $data,
                            'metric' => [
                                'data' => [
                                    'type' => 'metric',
                                    'attributes' => [
                                        'name' => ((empty($eventPrefixFieldValue) ? '' : "$eventPrefixFieldValue ") . $event)
                                    ],
                                ]
                            ],
                            'profile' => [
                                'data' => [
                                    'type' => 'profile',
                                    'attributes' => [
                                        'email' => $email
                                    ]
                                ]
                            ],
                        ],
                    ],
                ],
            );
        } catch (Exception $e) {
            error_log(PluginConfig::get_plugin_friendly_name() . " - Error when tracking, data: " . json_encode($data) . ' with error: ' . $e->getCode() . ' ' . $e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * @return false|mixed|null
     */
    private static function get_options()
    {
        $settings = new KlaviyoApiSetting();
        return get_option($settings->get_option_name());
    }

    /**
     * @param $options
     * @param $field
     * @return null|mixed
     */
    private static function get_option_value($options, $field)
    {
        if (empty($options[$field])) {
            return null;
        }

        return $options[$field];
    }
}