<?php

namespace DigitalNature\ToolsForKlaviyo\Admin;

use DigitalNature\ToolsForKlaviyo\Config\Settings\KlaviyoApi\KlaviyoApiSetting;
use DigitalNature\ToolsForKlaviyo\Config\PluginConfig;
use DigitalNature\WordPressUtilities\Helpers\TemplateHelper;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

class Includes {

    /**
     * constructor
     */
    function __construct() {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_backend_scripts_and_styles'], 20);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_web_component_scripts'], 20);
        add_action('admin_footer', [$this, 'enqueue_web_component_templates'], 20);
        add_action('admin_init', [$this, 'register_settings'], 10);

        // construct any admin classes here
        new \DigitalNature\ToolsForKlaviyo\Admin\Menu();
        new \DigitalNature\ToolsForKlaviyo\Admin\PluginActionLinks();
        new \DigitalNature\ToolsForKlaviyo\Admin\Hooks\Options();

        // SHORTCODES
        // new \DigitalNature\ToolsForKlaviyo\Shortcodes\YourClass();
    }

    /**
     * Enqueue the backend related scripts and styles for this plugin.
     * All the added scripts and styles will be available on every page within the backend.
     *
     * @access	public
     * @since	1.0.0
     *
     * @return	void
     */
    public function enqueue_backend_scripts_and_styles()
    {
        wp_enqueue_style( 'dn-tools-for-klaviyo-admin-styles', PluginConfig::get_plugin_url() . 'assets/admin/css/admin.css', [], PluginConfig::get_plugin_version(), 'all' );
    }

    /**
     * Enqueue the backend web component scripts and styles for this plugin.
     * All the added scripts and styles will be available on every page within the backend.
     *
     * @access	public
     * @since	1.0.0
     *
     * @return	void
     */
    public function enqueue_web_component_scripts()
    {
        // web components
	    wp_enqueue_script_module(
            'dn-tools-for-klaviyo-component-test-event-create',
            PluginConfig::get_plugin_url() . 'assets/admin/js/admin.js',
            [
                'wp-api-request'
            ],
            PluginConfig::get_plugin_version(),
            'all'
        );
    }

    /**
     * @return void
     */
    public function enqueue_web_component_templates()
    {
        TemplateHelper::render(
            PluginConfig::get_plugin_name() . '/admin/web-components/templates/test-event-create-component-template.php',
            [],
            trailingslashit(PluginConfig::get_plugin_dir() . '/templates')
        );
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
