<?php

namespace DigitalNature\ToolsForKlaviyo;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

class Includes {

    /**
     * Here, create 'new' instances of all classes that create hooks/shortcodes/filters/api etc.
     *
     * constructor
     */
    function __construct()
    {
        // CRON
        // new \DigitalNature\ToolsForKlaviyo\Cron\YourClass();

        // HOOKS
        // new \DigitalNature\ToolsForKlaviyo\Hooks\YourClass();

        // REST
        new \DigitalNature\ToolsForKlaviyo\Wp\Api\WPRest();

        // Late loading
        add_action('plugins_loaded', [$this, 'create_instances_after_all_plugins_loaded']);
    }

    /**
     * Here, create 'new' instances of all config classes that require other classes (e.g. the
     * hooks/shortcodes/filters/api etc. initialised in the constructor) before they can be initialised
     *
     * @return void
     */
    public function create_instances_after_all_plugins_loaded()
    {
        // CONFIG
        new \DigitalNature\ToolsForKlaviyo\Config\Settings();
    }
}
