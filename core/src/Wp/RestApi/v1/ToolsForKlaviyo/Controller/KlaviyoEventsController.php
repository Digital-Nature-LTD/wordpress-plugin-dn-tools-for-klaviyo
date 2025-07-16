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

class KlaviyoEventsController extends RestController
{
    /**
     * Full controller path: /wp-json/tools-for-klaviyo/v1/events
     *
     * @return string
     */
    public function get_route_url(): string
    {
        return '/events';
    }

    /**
     * @return KlaviyoEventResource
     */
    protected function get_resource(): RestResource
    {
        return new KlaviyoEventResource();
    }

    /**
     * @return RestControllerRoute[]
     */
    protected function get_routes(): array
    {
        return [
            new KlaviyoEventsReadableRoute($this),
            new KlaviyoEventsCreatableRoute($this),
        ];
    }
}