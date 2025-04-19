<?php

namespace DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyo\Resource;

use DigitalNature\ToolsForKlaviyo\Config\PluginConfig;
use DigitalNature\Utilities\Wp\RestApi\RestResource;

class KlaviyoEventResource extends RestResource
{
    /**
     * @return string
     */
    public function get_schema_title(): string
    {
        return 'klaviyo-event';
    }

    /**
     * @return string
     */
    public function get_schema_type(): string
    {
        return 'object';
    }

    /**
     * @return array
     */
    public function get_schema_properties(): array
    {
        return [
            'id' => [
                'description'  => esc_html__( 'Unique identifier for the event.', PluginConfig::get_plugin_text_domain()),
                'type'         => 'string',
                'readonly'     => true,
            ],
        ];
    }
}