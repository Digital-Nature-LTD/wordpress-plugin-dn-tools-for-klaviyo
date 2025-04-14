<?php

namespace DigitalNature\ToolsForKlaviyo\Admin;

// Exit if accessed directly.
use DigitalNature\ToolsForKlaviyo\Config\Settings\KlaviyoApi\KlaviyoApiSetting;
use DigitalNature\ToolsForKlaviyo\Config\PluginConfig;

if ( ! defined( 'ABSPATH' ) ) exit;

class Includes {

    /**
     * constructor
     */
    function __construct(){
        add_action('admin_enqueue_scripts', [$this, 'enqueue_backend_scripts_and_styles'], 20);
        add_action('admin_init', [$this, 'register_settings'], 10);

        // construct any admin classes here
         new \DigitalNature\ToolsForKlaviyo\Admin\Menu();

        // SHORTCODES
        // new \DigitalNature\ToolsForKlaviyo\Shortcodes\YourClass();
    }

    /**
     * Enqueue the backend related scripts and styles for this plugin.
     * All of the added scripts and styles will be available on every page within the backend.
     *
     * @access	public
     * @since	1.0.0
     *
     * @return	void
     */
    public function enqueue_backend_scripts_and_styles() {
        wp_enqueue_style( 'dn-tools-for-klaviyo-admin-styles', PluginConfig::get_plugin_url() . 'assets/admin/css/dn-tools-for-klaviyo-admin.css', [], DIGITAL_NATURE_TOOLS_FOR_KLAVIYO_VERSION, 'all' );
        wp_enqueue_script( 'dn-tools-for-klaviyo-admin-script', PluginConfig::get_plugin_url() . 'assets/admin/js/dn-tools-for-klaviyo-admin.js', [], DIGITAL_NATURE_TOOLS_FOR_KLAVIYO_VERSION, 'all' );
    }

    /**
     * @return void
     */
    public function register_settings(): void
    {
        $klaviyoApiSetting = new KlaviyoApiSetting();
        $klaviyoApiSetting->register();
    }
}
