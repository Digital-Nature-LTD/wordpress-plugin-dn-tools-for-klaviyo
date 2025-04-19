<?php

namespace DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyo\Controller\Route;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

use DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyo\Arg\KlaviyoUserEmailArg;
use DigitalNature\Utilities\Wp\RestApi\RestArg;
use DigitalNature\Utilities\Wp\RestApi\RestControllerRoute;
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
        $args = $this->get_submitted_args($request);
        $email = $args['email'];



        $resource = $this->controller->resource;

        return $resource->format_response(['uh' => 'oh']);
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
            new KlaviyoUserEmailArg(true)
        ];
    }
}