<?php

namespace DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyo\Arg;

use DigitalNature\Utilities\Wp\RestApi\RestArg;

class KlaviyoEventArg extends RestArg
{
    /**
     * @return string
     */
    public function get_name(): string
    {
        return 'event';
    }
}