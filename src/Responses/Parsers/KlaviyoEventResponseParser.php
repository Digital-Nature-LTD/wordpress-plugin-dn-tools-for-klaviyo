<?php

namespace DigitalNature\ToolsForKlaviyo\Responses\Parsers;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

use DigitalNature\ToolsForKlaviyo\Helpers\KlaviyoIncludesHelper;
use DigitalNature\ToolsForKlaviyo\Stores\KlaviyoMetricStore;
use DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyo\Resource\Model\KlaviyoEventResourceModel;
use DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyo\Resource\Model\KlaviyoMetricResourceModel;

class KlaviyoEventResponseParser extends KlaviyoResponseParser
{
    /**
     * Parses the API response and extracts the separate parts - metrics etc.
     *
     * @return void
     */
    public function parse_api_response(): void
    {
        $included = $this->response['included'] ?? null;

        if (!empty($included)) {
            $this->extract_metrics_from_includes($included);
        }
    }

    /**
     * Extracts metrics from the includes portion of an API Response
     *
     * @param array $includes
     * @return void
     */
    public function extract_metrics_from_includes(array $includes): void
    {
        $metricIncludes = array_filter($includes, function(array $include) {
            return $include['type'] === KlaviyoIncludesHelper::TYPE_METRIC;
        });

        array_map(
            function(array $metric) use (&$metrics) {
                $resource = new KlaviyoMetricResourceModel($metric);
                KlaviyoMetricStore::add_record($resource, $resource->id);
            },
            $metricIncludes
        );
    }

    /**
     * @return KlaviyoEventResourceModel[]|null
     */
    public function get_events(): ?array
    {
        if (empty($this->response['data'])) {
            return null;
        }

        return array_map(
            function(array $event) {
                return new KlaviyoEventResourceModel($event);
            },
            $this->response['data']
        );
    }
}