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
	    add_action('admin_enqueue_scripts', [$this, 'enqueue_common_scripts_and_styles'], 20);
	    add_action('wp_enqueue_scripts', [$this, 'enqueue_common_scripts_and_styles'], 20 );

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
	 * @return void
	 */
	public function enqueue_common_scripts_and_styles()
	{
		// enqueue WP API script so we can make REST API calls
		wp_enqueue_script('wp-api');
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
