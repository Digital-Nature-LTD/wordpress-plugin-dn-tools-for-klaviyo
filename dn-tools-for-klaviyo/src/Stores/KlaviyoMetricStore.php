<?php

namespace DigitalNature\ToolsForKlaviyo\Stores;

use DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyo\Resource\Model\KlaviyoMetricResourceModel;
use DigitalNature\WordPressUtilities\Stores\InMemoryStore;

class KlaviyoMetricStore extends InMemoryStore
{
    /**
     * This method exists for typing purposes only.
     *
     * @param $id
     * @param bool $purge
     * @return KlaviyoMetricResourceModel|null
     */
    public static function get_record($id, bool $purge = false): ?KlaviyoMetricResourceModel
    {
        return parent::get_record($id, $purge);
    }

    /**
     * @param $id
     * @return null
     */
    protected static function retrieve_record($id)
    {
        return null;
    }
}