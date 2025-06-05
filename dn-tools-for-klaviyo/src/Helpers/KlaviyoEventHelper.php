<?php

namespace DigitalNature\ToolsForKlaviyo\Helpers;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

use DigitalNature\ToolsForKlaviyo\Config\PluginConfig;
use DigitalNature\ToolsForKlaviyo\Config\Settings\KlaviyoApi\Fields\KlaviyoApiEventPrefixField;
use DigitalNature\WordPressUtilities\Helpers\LogHelper;
use Exception;
use KlaviyoAPI\ApiException;

class KlaviyoEventHelper extends KlaviyoApiHelper
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

        try {
            $client = self::get_client();

            if (!$client) {
                return false;
            }

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
                                        'name' => self::get_prefixed_event_name($event),
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
            LogHelper::write(PluginConfig::get_plugin_friendly_name() . " - Error when tracking, data: " . json_encode($data) . ' with error: ' . $e->getCode() . ' ' . $e->getMessage());
            return false;
        }

        return true;
    }


    /**
     * @param string $profileId
     * @param array|null $events
     * @param array|null $metrics
     * @param array|null $profiles
     * @param array|null $include
     * @return array|null
     */
    public static function get_for_profile(string $profileId, array $events = null, array $metrics = null, array $profiles = null, array $include = null): ?array
    {
        // allow this to be turned off programmatically
        if (apply_filters('dn_tools_for_klaviyo_is_sandbox', false, serialize($events))) {
            return null;
        }

        try {
            $client = self::get_client();

            if (!$client) {
                return null;
            }

            $eventsResponse = $client->Events->getEvents(
                $events,
                $metrics,
                $profiles,
                "equals(profile_id,\"$profileId\")",
                $include,
            );

            if (empty($eventsResponse)) {
                return null;
            }
        } catch (ApiException $e) {
            LogHelper::write(PluginConfig::get_plugin_friendly_name() . " - Error when getting events, with error: {$e->getCode()} {$e->getMessage()} {$e->getResponseBody()}");
            return null;
        }

        return $eventsResponse;
    }

    /**
     * @param string $eventId
     * @param array $eventMetrics
     * @return string|null
     */
    public static function get_metric_for_event(string $eventId, array &$eventMetrics = []): ?string
    {
        // if we already have it then return it
        if (array_key_exists($eventId, $eventMetrics)) {
            return $eventMetrics[$eventId];
        }

        $client = self::get_client();

        if (!$client) {
            return null;
        }

        // look up event using Klaviyo API
        $eventResponse = $client->Events->getMetricForEvent($eventId);

        var_dump($eventResponse);
        exit;
    }

    /**
     * @param string $event
     * @return string
     */
    public static function get_prefixed_event_name(string $event): string
    {
        $options = self::get_options();
        $eventPrefixFieldValue = self::get_option_value($options, KlaviyoApiEventPrefixField::get_field_name());

        return ((empty($eventPrefixFieldValue) ? '' : "$eventPrefixFieldValue ") . $event);
    }
}