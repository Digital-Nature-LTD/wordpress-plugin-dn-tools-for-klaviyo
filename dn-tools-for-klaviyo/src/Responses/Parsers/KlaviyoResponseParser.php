<?php

namespace DigitalNature\ToolsForKlaviyo\Responses\Parsers;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

abstract class KlaviyoResponseParser
{
    protected array $response;

    /**
     * Construct and parse the response
     *
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->response = $response;
        $this->parse_api_response();
    }

    /**
     * @return void
     */
    public abstract function parse_api_response(): void;
}