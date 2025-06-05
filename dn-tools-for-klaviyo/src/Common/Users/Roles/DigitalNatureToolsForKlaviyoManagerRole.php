<?php

namespace DigitalNature\ToolsForKlaviyo\Common\Users\Roles;

use DigitalNature\ToolsForKlaviyo\Common\Users\Capabilities\DigitalNatureToolsForKlaviyoSettingsCapability;
use DigitalNature\Utilities\Common\Users\Capabilities\ReadCapability;
use DigitalNature\WordPressUtilities\Common\Users\Roles\BaseRole;

class DigitalNatureToolsForKlaviyoManagerRole extends BaseRole
{
	/**
	 * @return string
	 */
	public static function get_role_slug(): string
	{
		return 'digital_nature_tools_for_klaviyo_manager';
	}

	/**
	 * @return string
	 */
	public static function get_role_name(): string
	{
		return 'Digital Nature - Tools for Klaviyo Manager';
	}

	/**
	 * @return string[]
	 */
	public static function get_capabilities(): array
	{
		return [
            DigitalNatureToolsForKlaviyoSettingsCapability::get_capability_name(),
            ReadCapability::get_capability_name(),
		];
	}
}