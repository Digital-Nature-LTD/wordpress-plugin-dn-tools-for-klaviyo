<?php

namespace DigitalNature\ToolsForKlaviyo\Helpers;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

class KlaviyoIncludesHelper
{
    const TYPE_METRIC = 'metric';

    public static function get_metrics_from_includes(array $includes): array
    {
        $metrics = [];

        $metricIncludes = array_filter($includes, function(array $include) {
            return $include['type'] === self::TYPE_METRIC;
        });

        array_map(
            function(array $metric) use (&$metrics) {
                $metrics[$metric['id']] = KlaviyoMetricHelper::create($metric);
            },
            $metricIncludes
        );

        return $metrics;
    }
}