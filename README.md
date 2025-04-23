# Digital Nature - Tools for Klaviyo
Tools for Klaviyo, send events and send & sync attributes with Klaviyo profiles

## Requirements
Requires the [Digital Nature Utilities](https://github.com/Digital-Nature-LTD/wordpress-plugin-utilities) plugin


## Configuration
In order to use the Klaviyo integration you must fill in your API credentials, you can do this in the "Digital Nature > Tools for Klaviyo" admin area.

Your permissions must include full access to "Events, Metrics, Profiles, Webhooks"

### Event prefix
Events can be automatically prefixed with a string of your choice.

> Example: You set a prefix of "Yo!" and trigger an event "My event name" - the event will be tracked in Klaviyo as "Yo! My event name".
> 
> A space will be automatically added between your prefix and the event name. 

## Helpers
### KlaviyoEventHelper
Sends [events](https://developers.klaviyo.com/en/reference/create_event) to Klaviyo

#### Usage
Simply call the static `create` method on the helper to log an event to the user's Klaviyo profile.

```php
/** @var WP_User $user */

use DigitalNature\ToolsForKlaviyo\Helpers\KlaviyoEventHelper;

KlaviyoEventHelper::create(
    "My event name",
    $user->user_email,
    [
        'a_parameter' => $myParameter,
        'another_parameter' => $anotherParameter,
    ]
);
```

### KlaviyoProfileHelper
[Creates or updates](https://developers.klaviyo.com/en/reference/create_or_update_profile) Klaviyo profiles.

#### Usage

##### Retrieving a profile
The simplest way to retrieve a profile is by email using `get_profile_by_email`.

```php
/** @var WP_User $user */

use DigitalNature\ToolsForKlaviyo\Helpers\KlaviyoProfileHelper;

/** @var array $profile */
$profile = KlaviyoProfileHelper::get_profile_by_email(
    $user->user_email
);
```

We also have a `get_profile` method that allows you to specify your own filters (see Klaviyo API docs for more information).

##### Creating or updating profile attributes
You can use the `create_or_update` method to add or update the value of attributes on the profile.

```php
/** @var WP_User $user */

use DigitalNature\ToolsForKlaviyo\Helpers\KlaviyoProfileHelper;

/** @var bool $success */
$success = KlaviyoProfileHelper::create_or_update(
    $user->user_email,
    [
        'a_profile_attribute' => $aValue,
        'another_profile_attribute' => $anotherValue,
    ]
);
```

##### Marketing opt in / out
Additional methods are provided to opt in or out of marketing, and to check current and historic statuses.

```php
/** @var WP_User $user */

use DigitalNature\ToolsForKlaviyo\Helpers\KlaviyoProfileHelper;

/** @var array|null $profile */
$profile = KlaviyoProfileHelper::get_profile_by_email($user->user_email);

/** @var bool $neverSubscribed */
$neverSubscribed = KlaviyoProfileHelper::has_never_subscribed_to_email_marketing($profile);
/** @var bool $hasOptedIn */
$hasOptedIn = KlaviyoProfileHelper::has_opted_in_to_email_marketing($profile);
/** @var bool $hasOptedOut */
$hasOptedOut = KlaviyoProfileHelper::has_opted_out_of_email_marketing($profile);
/** @var bool $optedIn */
$optedIn = KlaviyoProfileHelper::opt_in($profile);
/** @var bool $optedOut */
$optedOut = KlaviyoProfileHelper::opt_out($profile);
```



## Filters
### dn_tools_for_klaviyo_is_sandbox
Allows you to define conditions under which this site will be treated as a sandbox.

A sandbox site will not send any data to Klaviyo.

#### Params:
- `bool $isSandbox` - Defines whether this is a sandbox, default is `false`
