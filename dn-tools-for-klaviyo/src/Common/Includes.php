<?php

namespace DigitalNature\ToolsForKlaviyo\Common;

use DigitalNature\ToolsForKlaviyo\Common\Users\Roles\DigitalNatureToolsForKlaviyoManagerRole;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

class Includes
{

    /**
     * Here, create 'new' instances of all classes that create hooks/shortcodes/filters/api etc.
     *
     * constructor
     */
    function __construct()
    {
        // Add role(s)
        DigitalNatureToolsForKlaviyoManagerRole::add_role();

        // CRON
        // new \DigitalNature\ToolsForKlaviyo\Cron\YourClass();

        // HOOKS
        // new \DigitalNature\ToolsForKlaviyo\Hooks\YourClass();

        // Late loading
        add_action('init', [$this, 'create_instances_late_loading']);
        add_action('admin_init', [$this, 'create_instances_late_loading']);
    }

    /**
     * Here, create 'new' instances of all config classes that require other classes (e.g. the
     * hooks/shortcodes/filters/api etc. initialised in the constructor) before they can be initialised
     *
     * @return void
     */
    public function create_instances_late_loading(): void
    {
        // REST API
        new \DigitalNature\ToolsForKlaviyo\Wp\RestApi\v1\ToolsForKlaviyoApiNamespace();
    }
}
