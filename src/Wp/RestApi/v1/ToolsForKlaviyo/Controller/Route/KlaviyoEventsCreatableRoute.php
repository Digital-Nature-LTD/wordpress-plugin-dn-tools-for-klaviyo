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
        // Add a custom status code to the WP_REST_Response, if needed. I'm assuming default code is 200
        //$response->set_status( 201 );

        return new WP_REST_Response([
            'data' => 'goes here'
        ]);
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
    public function args(): array
    {
        return [
            new KlaviyoUserEmailArg(true)
        ];
    }
}