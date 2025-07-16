<?php

namespace DigitalNature\ToolsForKlaviyo\Common\Users\Capabilities;

use DigitalNature\WordPressUtilities\Common\Users\Capabilities\BaseCapability;

class DigitalNatureToolsForKlaviyoSettingsCapability extends BaseCapability
{
	/**
	 * @return string
	 */
	public static function get_capability_name(): string
	{
		return 'digital_nature_tools_for_klaviyo_settings';
	}
}