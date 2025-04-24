<?php

namespace DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyo\Resource;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

use DigitalNature\ToolsForKlaviyo\Config\PluginConfig;
use DigitalNature\Utilities\Wp\RestApi\RestResource;

class KlaviyoMetricResource extends RestResource
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
                'description'  => esc_html__( 'Unique ID of this metric.', PluginConfig::get_plugin_text_domain()),
                'type'         => 'string',
                'readonly'     => true,
            ],
            'name' => [
                'description'  => esc_html__( 'Name of this metric.', PluginConfig::get_plugin_text_domain()),
                'type'         => 'string',
            ],
            'created' => [
                'description'  => esc_html__( 'Created date, e.g. "2025-04-19T21:11:11+00:00".', PluginConfig::get_plugin_text_domain()),
                'type'         => 'string',
            ],
            'updated' => [
                'description'  => esc_html__( 'Updated date, e.g. "2025-04-19T21:11:11+00:00"', PluginConfig::get_plugin_text_domain()),
                'type'         => 'string',
            ],
            'integration' => [
                'description'  => esc_html__( 'The integration details on how the event was added.', PluginConfig::get_plugin_text_domain()),
                'type'         => 'array',
            ],
        ];
    }
}