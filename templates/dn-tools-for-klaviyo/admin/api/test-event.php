<?php
use DigitalNature\Utilities\Config\PluginConfig;

?>
<div class="tools-for-klaviyo-test-event">
    <h2>Connection Test</h2>

    <p>Fill in your event name below and click send - this will create a Klaviyo event on your profile</p>

    <tools-for-klaviyo-test-event-create
        data-stylesheet="<?= PluginConfig::get_plugin_url(); ?>assets/admin/css/dn-utilities-admin.css">
    </tools-for-klaviyo-test-event-create>
</div>