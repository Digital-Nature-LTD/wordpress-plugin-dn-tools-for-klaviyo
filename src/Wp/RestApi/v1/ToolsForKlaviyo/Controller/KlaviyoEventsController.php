<?php

namespace DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyo\Controller;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

use DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyo\Controller\Route\KlaviyoEventsCreatableRoute;
use DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyo\Controller\Route\KlaviyoEventsReadableRoute;
use DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyo\Resource\KlaviyoEventResource;
use DigitalNature\Utilities\Wp\RestApi\RestController;
use DigitalNature\Utilities\Wp\RestApi\RestControllerRoute;
use DigitalNature\Utilities\Wp\RestApi\RestResource;
use Exception;

class KlaviyoEventsController extends RestController
{
    /**
     * @return string
     */
    public function get_route_url(): string
    {
        return '/events';
    }

    /**
     * @return KlaviyoEventResource
     */
    public function get_resource(): RestResource
    {
        return new KlaviyoEventResource();
    }

    /**
     * @return RestControllerRoute[]
     */
    public function get_routes(): array
    {
        return [
            new KlaviyoEventsReadableRoute(),
            new KlaviyoEventsCreatableRoute(),
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function register_routes()
    {
        register_rest_route(
            $this->namespace,
            $this->build_route_url(),
            $this->build_route_configuration(),
        );
    }
}