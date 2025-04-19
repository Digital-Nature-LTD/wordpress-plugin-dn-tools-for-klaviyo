<?php

namespace DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

use DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyo\Controller\KlaviyoEventsController;
use DigitalNature\Utilities\Wp\RestApi\RestNamespace;
use DigitalNature\Utilities\Wp\RestApi\RestController;
use Exception;

class ToolsForKlaviyoApiNamespace extends RestNamespace
{
    /**
     * @return string
     */
    public function get_name(): string
    {
        return 'tools-for-klaviyo';
    }

    /**
     * @return string
     */
    public function get_version(): string
    {
        return 'v1';
    }

    /**
     * @return RestController[]
     * @throws Exception
     */
    public function get_controllers(): array
    {
        return [
            new KlaviyoEventsController($this)
        ];
    }
}