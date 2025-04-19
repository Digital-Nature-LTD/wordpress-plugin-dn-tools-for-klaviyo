<?php

namespace DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyo\Controller\Route;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

use DigitalNature\ToolsForKlaviyo\Helpers\KlaviyoEventHelper;
use DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyo\Arg\KlaviyoEventArg;
use DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyo\Arg\KlaviyoEventDataArg;
use DigitalNature\Utilities\Wp\RestApi\RestArg;
use DigitalNature\Utilities\Wp\RestApi\RestControllerRoute;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;

class KlaviyoEventsCreatableRoute extends RestControllerRoute
{
    /**
     * @return array
     */
    public function methods(): array
    {
        return [
            WP_REST_Server::CREATABLE
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

        $args = $this->get_submitted_args($request);
        $event = $args['event'];
        $data = $args['event-data'];

        $responseData = [
            'email' => $user->user_email,
            'event' => $event,
            'data' => $data
        ];

        // create the event
        if (KlaviyoEventHelper::create(
            $event,
            $user->user_email,
            $data
        )) {
            return $this->send_single_record_response($responseData);
        }

        return new WP_Error('TFK0001', 'Could not create event', $responseData);
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
        return [
            new KlaviyoEventArg(true),
            new KlaviyoEventDataArg(false, []),
        ];
    }
}