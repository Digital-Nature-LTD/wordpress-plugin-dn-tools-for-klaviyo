<?php

namespace DigitalNature\ToolsForKlaviyo\Models;

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

class KlaviyoMetric
{
    /**
     * @var string
     */
    public string $id;

    /**
     * @var string|null
     */
    public $name;

    /**
     * @var string|null
     */
    public $created;

    /**
     * @var string|null
     */
    public $updated;

    /**
     * @var string|null
     */
    public $integration;
}