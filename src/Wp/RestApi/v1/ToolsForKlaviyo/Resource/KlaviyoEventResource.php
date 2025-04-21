<?php

namespace DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyo\Resource;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

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
                'description'  => esc_html__( 'Unique ID of this event.', PluginConfig::get_plugin_text_domain()),
                'type'         => 'string',
                'readonly'     => true,
            ],
            'email' => [
                'description'  => esc_html__( 'Email address on the profile.', PluginConfig::get_plugin_text_domain()),
                'type'         => 'string',
            ],
            'event' => [
                'description'  => esc_html__( 'The event metric.', PluginConfig::get_plugin_text_domain()),
                'type'         => 'string',
            ],
            'data' => [
                'description'  => esc_html__( 'The data attached to this event.', PluginConfig::get_plugin_text_domain()),
                'type'         => 'array',
            ],
            'timestamp' => [
                'description'  => esc_html__( 'The timestamp when this event occurred.', PluginConfig::get_plugin_text_domain()),
                'type'         => 'int',
            ]
        ];
    }

    /**
     * @param array $data
     * @return array
     */
    public function format_response(array $data): array
    {
        return array_filter([
            'id' => $data['id'] ?? null,
            'email' => $data['email'] ?? null,
            'event' => $data['event'] ?? null,
            'data' => $data['data'] ?? null,
            'timestamp' => $data['timestamp'] ?? null,
        ]);
    }
}