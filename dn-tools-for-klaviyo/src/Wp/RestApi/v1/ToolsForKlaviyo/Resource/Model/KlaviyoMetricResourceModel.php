<?php

namespace DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyo\Resource\Model;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

use DigitalNature\ToolsForKlaviyo\Helpers\KlaviyoMetricHelper;
use DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyo\Resource\KlaviyoMetricResource;
use DigitalNature\Utilities\Wp\RestApi\RestResourceModel;

class KlaviyoMetricResourceModel extends RestResourceModel
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
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->attributes = $data['attributes'] ?? null;
        $this->relationships = $data['relationships'] ?? null;
        $this->links = $data['links'] ?? null;
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
            'name' => $this->attributes['name'] ?? null,
            'created' => $this->attributes['created'] ?? null,
            'updated' => $this->attributes['updated'] ?? null,
            'integration' => $this->attributes['integration'] ?? null,
        ]);
    }
}