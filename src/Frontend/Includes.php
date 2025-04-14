<?php

namespace DigitalNature\ToolsForKlaviyo\Frontend;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

class Includes {

    /**
     * constructor
     */
    function __construct(){
        add_action( 'wp_enqueue_scripts', [$this, 'enqueue_frontend_scripts_and_styles'], 20 );

        // construct any frontend classes here
        // new \DigitalNature\ToolsForKlaviyo\Frontend\YourClass();

        // SHORTCODES
        // new \DigitalNature\ToolsForKlaviyo\Shortcodes\YourClass();
    }

    /**
     * Enqueue the frontend related scripts and styles for this plugin.
     * All of the added scripts and styles will be available on every page within the frontend.
     *
     * @access	public
     * @since	1.0.0
     *
     * @return	void
     */
    public function enqueue_frontend_scripts_and_styles() {
        wp_enqueue_style( 'klaviyo-custom-events-and-tracking-frontend-styles', KLAVIYO_CUSTOM_EVENTS_AND_TRACKING_PLUGIN_URL . 'assets/frontend/css/frontend-styles.css', [], KLAVIYO_CUSTOM_EVENTS_AND_TRACKING_VERSION, 'all' );
        wp_enqueue_script( 'klaviyo-custom-events-and-tracking-frontend-script', KLAVIYO_CUSTOM_EVENTS_AND_TRACKING_PLUGIN_URL . 'assets/frontend/js/frontend-script.js', [], KLAVIYO_CUSTOM_EVENTS_AND_TRACKING_VERSION, 'all' );
    }
}
