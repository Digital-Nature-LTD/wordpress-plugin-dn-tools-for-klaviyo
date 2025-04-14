<?php

namespace DigitalNature\ToolsForKlaviyo\Config\Settings\KlaviyoApi;

use DigitalNature\ToolsForKlaviyo\Config\Settings\KlaviyoApi\Fields\KlaviyoApiPrivateKeyField;
use DigitalNature\ToolsForKlaviyo\Config\Settings\KlaviyoApi\Fields\KlaviyoApiPublicKeyField;
use DigitalNature\Utilities\Config\Setting;
use DigitalNature\Utilities\Config\SettingField;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

class KlaviyoApiSetting extends Setting
{
    /**
     * @return string
     */
    public function get_setting_page(): string
    {
        return 'dn_tools_for_klaviyo';
    }

    /**
     * @return string
     */
    public function get_setting_page_title(): string
    {
        return 'Digital Nature - Tools for Klaviyo Configuration';
    }

    /**
     * @return string
     */
    public function get_option_name(): string
    {
        return 'dn_tools_for_klaviyo_plugin_options';
    }

    /**
     * @return string
     */
    public function get_option_group(): string
    {
        return 'dn_tools_for_klaviyo_plugin_option_group';
    }

    /**
     * @return SettingField[]
     */
    protected function get_fields(): array
    {
        return [
            new KlaviyoApiPrivateKeyField($this),
            new KlaviyoApiPublicKeyField($this),
        ];
    }

    /**
     * @return string
     */
    protected function get_section_id(): string
    {
        return 'dn_tools_for_klaviyo_api_settings';
    }

    /**
     * @return string
     */
    protected function get_section_title(): string
    {
        return 'API Settings';
    }

    /**
     * @return string
     */
    protected function get_section_content(): string
    {
        return '<p>Please fill in your API credentials below, you can <a target="_blank" href="https://www.klaviyo.com/account#api-keys-tab">find the details in your Klaviyo account</a></p>';
    }
}