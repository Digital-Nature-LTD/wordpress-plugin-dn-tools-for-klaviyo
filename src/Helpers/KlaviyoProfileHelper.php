<?php

namespace DigitalNature\ToolsForKlaviyo\Helpers;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

use DigitalNature\ToolsForKlaviyo\Config\PluginConfig;
use DigitalNature\WordPressUtilities\Helpers\LogHelper;
use Exception;

class KlaviyoProfileHelper extends KlaviyoApiHelper
{
    const CONSENT_NEVER_SUBSCRIBED = 'NEVER_SUBSCRIBED';
    const CONSENT_SUBSCRIBED = 'SUBSCRIBED';
    const CONSENT_UNSUBSCRIBED = 'UNSUBSCRIBED';

    /**
     * Creates or updates a profile
     *
     * @param string $email
     * @param array $data
     * @return bool
     */
    public static function create_or_update(string $email, array $data): bool
    {
        // allow this to be turned off programmatically
        if (apply_filters('dn_tools_for_klaviyo_is_sandbox', false)) {
            return false;
        }

        try {
            $client = self::get_client();

            if (!$client) {
                return false;
            }

            $client->Profiles->createOrUpdateProfile(
                [
                    'data' => [
                        'type' => 'profile',
                        'attributes' => [
                            'email' => $email,
                            'properties' => $data,
                        ],
                    ],
                ],
            );
        } catch (Exception $e) {
            LogHelper::write(PluginConfig::get_plugin_friendly_name() . " - Error when identify, data: " . json_encode($data) . ' with error: ' . $e->getCode() . ' ' . $e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * @param array $additionalFields
     * @param array $fields
     * @param string $filter
     * @param bool $returnPaginationMetadata
     * @return array|bool
     */
    public static function get_profile(array $additionalFields = [], array $fields = [], string $filter = '', bool $returnPaginationMetadata = false): ?array
    {
        try {
            $client = self::get_client();

            if (!$client) {
                return null;
            }

            # $additional_fields_profile | string[]
            # $fields_profile | string[]
            # $filter | string
            # $page_cursor | string
            # $page_size | int
            # $sort | string
            $profiles = $client->Profiles->getProfiles(
                $additionalFields,
                $fields,
                $filter
            );

            // The last record contains details of next/previous page links, we can cut that out here
            if (!$returnPaginationMetadata) {
                $profiles = array_slice($profiles, 0, count($profiles) - 1);
            }

        } catch (Exception $e) {
            LogHelper::write(PluginConfig::get_plugin_friendly_name() . " - Error when getting profile with error: {$e->getCode()} {$e->getMessage()}");
            return null;
        }

        return $profiles;
    }

    /**
     * @param string $email
     * @param array $additionalFields
     * @param array $fields
     * @return array|null
     */
    public static function get_profile_by_email(string $email, array $additionalFields = [], array $fields = []): ?array
    {
        $profiles = self::get_profile($additionalFields, $fields, "equals(email,\"$email\")", true);

        if (empty($profiles)) {
            return null;
        }

        $profiles = $profiles['data'];

        // return the first result only
        return array_shift($profiles);
    }

    /**
     * Returns true if this profile has never subscribed to email marketing, false otherwise.
     * Will throw an exception if the profile is invalid.
     *
     * @param array $profile
     * @return bool
     * @throws Exception
     */
    public static function has_never_subscribed_to_email_marketing(array $profile): bool
    {
        self::validate_profile_with_subscriptions($profile);

        return $profile['attributes']['subscriptions']['email']['marketing']['consent'] === self::CONSENT_NEVER_SUBSCRIBED;
    }

    /**
     * @param array $profile
     * @return bool
     * @throws Exception
     */
    public static function has_opted_in_to_email_marketing(array $profile): bool
    {
        self::validate_profile_with_subscriptions($profile);

        return $profile['attributes']['subscriptions']['email']['marketing']['consent'] === self::CONSENT_SUBSCRIBED;
    }

    /**
     * @param array $profile
     * @return bool
     * @throws Exception
     */
    public static function has_opted_out_of_email_marketing(array $profile): bool
    {
        self::validate_profile_with_subscriptions($profile);

        return $profile['attributes']['subscriptions']['email']['marketing']['consent'] === self::CONSENT_UNSUBSCRIBED;
    }

    /**
     * @param array $profile
     * @return void
     * @throws Exception
     */
    private static function validate_profile_with_subscriptions(array $profile): void
    {
        $attributes = $profile['attributes'] ?? null;

        if (empty($attributes)) {
            throw new Exception("Profile is missing attributes");
        }

        $subscriptions = $attributes['subscriptions'] ?? null;

        if (empty($subscriptions)) {
            throw new Exception("Profile is missing subscriptions attribute");
        }
    }

    /**
     * Opts in to email marketing
     *
     * @param string $email
     * @return bool
     */
    public static function opt_in(string $email): bool
    {
        // allow this to be turned off programmatically
        if (apply_filters('dn_tools_for_klaviyo_is_sandbox', false)) {
            return false;
        }

        try {
            $client = self::get_client();

            if (!$client) {
                return false;
            }

            $client->Profiles->subscribeProfiles(
                [
                    'data' => [
                        "type" => "profile-subscription-bulk-create-job",
                        "attributes" => [
                            "profiles" => [
                                'data' => [
                                    [
                                        'type' => 'profile',
                                        'attributes' => [
                                            'email' => "$email",
                                            "subscriptions" => [
                                                "email" => [
                                                    "marketing" => [
                                                        "consent" => self::CONSENT_SUBSCRIBED
                                                    ]
                                                ],
                                            ],
                                        ]
                                    ]
                                ]
                            ],
                        ],
                    ],
                ],
            );
        } catch (Exception $e) {
            LogHelper::write(PluginConfig::get_plugin_friendly_name() . " - Error when subscribing profile '{$email}' with error: {$e->getCode()} {$e->getMessage()}");
            return false;
        }

        return true;
    }


    /**
     * Opts out of email marketing
     *
     * @param string $email
     * @return bool
     */
    public static function opt_out(string $email): bool
    {
        // allow this to be turned off programmatically
        if (apply_filters('dn_tools_for_klaviyo_is_sandbox', false)) {
            return false;
        }

        try {
            $client = self::get_client();

            if (!$client) {
                return false;
            }

            $client->Profiles->unsubscribeProfiles(
                [
                    'data' => [
                        "type" => "profile-subscription-bulk-delete-job",
                        "attributes" => [
                            "profiles" => [
                                'data' => [
                                    [
                                        'type' => 'profile',
                                        'attributes' => [
                                            'email' => "$email",
                                            "subscriptions" => [
                                                "email" => [
                                                    "marketing" => [
                                                        "consent" => self::CONSENT_UNSUBSCRIBED
                                                    ]
                                                ],
                                            ],
                                        ]
                                    ]
                                ]
                            ],
                        ],
                    ],
                ],
            );
        } catch (Exception $e) {
            LogHelper::write(PluginConfig::get_plugin_friendly_name() . " - Error when unsubscribing profile '{$email}' with error: {$e->getCode()} {$e->getMessage()}");
            return false;
        }

        return true;
    }
}