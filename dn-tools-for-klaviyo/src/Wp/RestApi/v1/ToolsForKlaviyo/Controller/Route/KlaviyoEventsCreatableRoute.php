<?php

namespace DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyo\Controller\Route;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

use DigitalNature\ToolsForKlaviyo\Helpers\KlaviyoEventHelper;
use DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyo\Arg\KlaviyoEventArg;
use DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyo\Arg\KlaviyoEventDataArg;
use DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyo\Resource\Model\KlaviyoEventResourceModel;
use DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyo\Resource\Model\KlaviyoMetricResourceModel;
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

        // manually format the data into the resource model
        $model = new KlaviyoEventResourceModel([
            'attributes' => [
                'event_properties' => $data,
                'timestamp' => time(),
            ],
            'metric' => new KlaviyoMetricResourceModel(['attributes' => ['name' => KlaviyoEventHelper::get_prefixed_event_name($event)]]),
        ]);

        // create the event
        if (KlaviyoEventHelper::create(
            $event,
            $user->user_email,
            $data
        )) {
            $this->add_response_data($model);
            return $this->send_response();
        }

        return new WP_Error('TFK0001', 'Could not create event', [$event, $data]);
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