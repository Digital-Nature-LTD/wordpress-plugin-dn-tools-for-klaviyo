# Digital Nature - Tools for Klaviyo
Tools for Klaviyo, send events and send & sync attributes with Klaviyo profiles

## Requirements
Requires the [Digital Nature Utilities](https://github.com/Digital-Nature-LTD/wordpress-plugin-utilities) plugin


## Helpers


## Filters
### dn_tools_for_klaviyo_is_sandbox
Allows you to define conditions under which this site will be treated as a sandbox.

A sandbox site will not send any data to Klaviyo.

#### Params:
- `bool $isSandbox` - Defines whether this is a sandbox, default is `false`

### dn_tools_for_klaviyo_event_prefix
Allows a prefix to be added to Klaviyo events

#### Params:
- `string $prefix` - The prefix, default is `''`

