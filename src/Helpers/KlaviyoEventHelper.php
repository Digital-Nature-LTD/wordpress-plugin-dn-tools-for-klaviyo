<?php

namespace DigitalNature\ToolsForKlaviyo\Helpers;

use DigitalNature\ToolsForKlaviyo\Config\Settings;
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
        if (!apply_filters('klaviyo_custom_events_and_tracking_do_send', true, $event)) {
            return false;
        }

        $options = get_option(Settings::API_SETTINGS_OPTIONS_NAME);

        if (!isset($options['api_key_private']) || !$options['api_key_private']) {
            error_log(KLAVIYO_CUSTOM_EVENTS_AND_TRACKING_FRIENDLY_NAME . " - Cannot track, Private API Key not set");
            return false;
        }

        if (!isset($options['api_key_public']) || !$options['api_key_public']) {
            error_log(KLAVIYO_CUSTOM_EVENTS_AND_TRACKING_FRIENDLY_NAME . " - Cannot track, Public API Key not set");
            return false;
        }

        $eventPrefix = apply_filters('klaviyo_custom_events_and_tracking_event_prefix', '');

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
            error_log(KLAVIYO_CUSTOM_EVENTS_AND_TRACKING_FRIENDLY_NAME . " - Error when tracking, data: " . json_encode($data) . ' with error: ' . $e->getCode() . ' ' . $e->getMessage());
            return false;
        }

        return true;
    }
}