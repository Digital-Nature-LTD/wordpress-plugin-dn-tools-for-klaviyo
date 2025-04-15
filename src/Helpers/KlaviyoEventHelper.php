<?php

namespace DigitalNature\ToolsForKlaviyo\Helpers;

use DigitalNature\ToolsForKlaviyo\Config\PluginConfig;
use DigitalNature\ToolsForKlaviyo\Config\Settings\KlaviyoApi\KlaviyoApiSetting;
use Exception;
use KlaviyoAPI\KlaviyoAPI;

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

        if (!isset($options['api_key_private']) || !$options['api_key_private']) {
            error_log(PluginConfig::get_plugin_friendly_name() . " - Cannot track, Private API Key not set");
            return false;
        }

        if (!isset($options['api_key_public']) || !$options['api_key_public']) {
            error_log(PluginConfig::get_plugin_friendly_name() . " - Cannot track, Public API Key not set");
            return false;
        }

        $eventPrefix = apply_filters('dn_tools_for_klaviyo_event_prefix', '');

        try {
            $client = new KlaviyoAPI(
                $options['api_key_private'],
                3,
                3,
                [
                    'verify' => false
                ],
                "/KLIRA"
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
                                        'name' => ((empty($eventPrefix) ? '' : "$eventPrefix ") . $event)
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
}