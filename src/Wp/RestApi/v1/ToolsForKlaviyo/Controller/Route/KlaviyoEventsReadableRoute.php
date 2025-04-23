<?php

namespace DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyo\Controller\Route;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

use DigitalNature\ToolsForKlaviyo\Helpers\KlaviyoEventHelper;
use DigitalNature\ToolsForKlaviyo\Helpers\KlaviyoIncludesHelper;
use DigitalNature\ToolsForKlaviyo\Helpers\KlaviyoMetricHelper;
use DigitalNature\ToolsForKlaviyo\Helpers\UserHelper;
use DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyo\Arg\KlaviyoUserEmailArg;
use DigitalNature\Utilities\Wp\RestApi\RestArg;
use DigitalNature\Utilities\Wp\RestApi\RestControllerRoute;
use Exception;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;

class KlaviyoEventsReadableRoute extends RestControllerRoute
{
    /**
     * @return array
     */
    public function methods(): array
    {
        return [
            WP_REST_Server::READABLE
        ];
    }

    /**
     * Gets the item(s)
     *
     * @param WP_REST_Request $request
     * @return WP_Error|WP_REST_Response
     */
    public function callback(WP_REST_Request $request)
    {
        $user = wp_get_current_user();

        // get the Klaviyo profile ID, error if we don't have one
        try {
            $profileId = UserHelper::get_klaviyo_profile_id($user);
        } catch (Exception $e) {
            return $this->send_error_response($e->getMessage(), 'get_klaviyo_profile_id');
        }

        // get the events
        $response = KlaviyoEventHelper::get_for_profile(
            $profileId,
            null,
            ['name'],
            null,
            ['metric']
        );

        // no events, send empty response
        if (empty($response)) {
            return $this->send_empty_response();
        }

        $included = $response['included'];

        $metrics = KlaviyoIncludesHelper::get_metrics_from_includes($included);

        // add each event to the response
        foreach ($response['data'] as $event) {
            $metric = KlaviyoMetricHelper::get_metric_for_event($event, $metrics);

            $this->add_response_data([
                'id' => $event['id'] ?? null,
                'data' => $event['attributes']['event_properties'] ?? null,
                'timestamp' => $event['attributes']['timestamp'] ?? null,
                'metric' => $metric ?? null,
            ]);
        }

        return $this->send_response();
    }

    /**
     * @param WP_REST_Request $request
     * @return bool|WP_Error
     */
    public function permission_callback(WP_REST_Request $request)
    {
        if (current_user_can('administrator')) {
            return true;
        }

        return false;
    }

    /**
     * @return RestArg[]
     */
    public function set_args(): array
    {
        return [];
    }
}