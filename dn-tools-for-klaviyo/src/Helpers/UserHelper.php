<?php

namespace DigitalNature\ToolsForKlaviyo\Helpers;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

use DigitalNature\ToolsForKlaviyo\Exceptions\ToolsForKlaviyoProfileNotFoundException;
use WP_User;

class UserHelper
{
    const USER_METADATA_KEY_KLAVIYO_PROFILE_ID = 'tools_for_klaviyo_profile_id';

    /**
     * @param WP_User $user
     * @return string
     * @throws ToolsForKlaviyoProfileNotFoundException
     */
    public static function get_klaviyo_profile_id(WP_User $user): string
    {
        // look up profile ID metadata
        $metadataProfileId = get_user_meta($user->ID, self::USER_METADATA_KEY_KLAVIYO_PROFILE_ID, true);

        if (!empty($metadataProfileId)) {
            return $metadataProfileId;
        }

        // metadata not found, look up profile by email
        $profile = KlaviyoProfileHelper::get_profile_by_email($user->user_email);

        if (empty($profile) || empty($profile['id'])) {
            throw new ToolsForKlaviyoProfileNotFoundException("Could not find Klaviyo Profile for {$user->user_email}");
        }

        // set the metadata on the profile
        update_user_meta($user->ID, self::USER_METADATA_KEY_KLAVIYO_PROFILE_ID, $profile['id']);

        return $profile['id'];
    }
}