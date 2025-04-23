<?php

namespace DigitalNature\ToolsForKlaviyo\Helpers;

// Exit if accessed directly.
use DigitalNature\ToolsForKlaviyo\Models\KlaviyoMetric;

if (!defined('ABSPATH')) exit;

class KlaviyoMetricHelper
{
    /**
     * @param array $data
     * @return KlaviyoMetric
     */
    public static function create(array $data): KlaviyoMetric
    {
        $metric = new KlaviyoMetric();

        $metric->id = $data['id'] ?? null;
        $metric->name = $data['attributes']['name'] ?? null;
        $metric->created = $data['attributes']['created'] ?? null;
        $metric->updated = $data['attributes']['updated'] ?? null;
        $metric->integration = $data['attributes']['integration'] ?? null;

        return $metric;
    }

    /**
     * @param array $event
     * @param KlaviyoMetric[] $metrics
     * @return KlaviyoMetric|null
     */
    public static function get_metric_for_event(array $event, array $metrics): ?KlaviyoMetric
    {
        if (empty($event['relationships']) || empty($event['relationships']['metric'])) {
            return null;
        }

        $metricId = $event['relationships']['metric']['data']['id'];

        if (!array_key_exists($metricId, $metrics)) {
            return null;
        }

        return $metrics[$metricId];
    }
}