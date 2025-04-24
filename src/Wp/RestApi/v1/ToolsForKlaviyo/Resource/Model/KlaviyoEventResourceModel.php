<?php

namespace DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyo\Resource\Model;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

use DigitalNature\ToolsForKlaviyo\Helpers\KlaviyoMetricHelper;
use DigitalNature\Utilities\Wp\RestApi\RestResourceModel;

class KlaviyoEventResourceModel extends RestResourceModel
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var array
     */
    public $attributes;

    /**
     * @var array
     */
    public $relationships;

    /**
     * @var array
     */
    public $links;

    /**
     * @var KlaviyoMetricResourceModel|null
     */
    public ?KlaviyoMetricResourceModel $metric;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->attributes = $data['attributes'] ?? null;
        $this->relationships = $data['relationships'] ?? null;
        $this->links = $data['links'] ?? null;
        $this->metric = $data['metric'] ?? $this->get_metric();
    }

    /**
     * Get the associated metric for this event
     *
     * @return KlaviyoMetricResourceModel|null
     */
    public function get_metric(): ?KlaviyoMetricResourceModel
    {
        return KlaviyoMetricHelper::get_metric_for_event($this);
    }

    /**
     * Return response, this should match the schema for the associated resource
     *
     * @return array
     */
    public function format_response(): array
    {
        return array_filter([
            'id' => $this->id ?? null,
            'data' => $this->attributes['event_properties'] ?? null,
            'timestamp' => $this->attributes['timestamp'] ?? null,
            'metric' => $this->metric ? $this->metric->format_response() : null,
        ]);
    }
}