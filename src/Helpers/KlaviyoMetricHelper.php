<?php

namespace DigitalNature\ToolsForKlaviyo\Helpers;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

use DigitalNature\ToolsForKlaviyo\Stores\KlaviyoMetricStore;
use DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyo\Resource\Model\KlaviyoEventResourceModel;
use DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyo\Resource\Model\KlaviyoMetricResourceModel;

class KlaviyoMetricHelper
{
    /**
     * @param KlaviyoEventResourceModel $event
     * @return KlaviyoMetricResourceModel|null
     */
    public static function get_metric_for_event(KlaviyoEventResourceModel $event): ?KlaviyoMetricResourceModel
    {
        if (empty($event->relationships) || empty($event->relationships['metric'])) {
            return null;
        }

        $metricId = $event->relationships['metric']['data']['id'];

        return KlaviyoMetricStore::get_record($metricId);
    }
}