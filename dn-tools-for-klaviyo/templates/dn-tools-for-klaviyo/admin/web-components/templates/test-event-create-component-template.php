<?php

use DigitalNature\ToolsForKlaviyo\Config\PluginConfig as TfkPluginConfig;
use DigitalNature\Utilities\Config\PluginConfig as UtilitiesPluginConfig;
?>
<template id="digital-nature-admin-test-event-create-template">
    <div class="digital-nature-admin-wrap">
        <link rel="stylesheet" href="<?= UtilitiesPluginConfig::get_plugin_url(); ?>assets/admin/css/admin.css" media="all">
        <link rel="stylesheet" href="<?= UtilitiesPluginConfig::get_plugin_url(); ?>assets/common/css/common.css" media="all">
        <link rel="stylesheet" href="<?= TfkPluginConfig::get_plugin_url(); ?>assets/admin/css/admin.css" media="all">



        <digital-nature-dismissable-message class="success">
            <span slot="message">Hoop diddy hoop de hoop de hoop</span>
        </digital-nature-dismissable-message>

        <digital-nature-dismissable-message class="error">
            <span slot="message">Hoop diddy hoop de hoop de hoop</span>
        </digital-nature-dismissable-message>

        <digital-nature-dismissable-message class="warning">
            <span slot="message">Hoop diddy hoop de hoop de hoop</span>
        </digital-nature-dismissable-message>

        <digital-nature-dismissable-message class="info">
            <span slot="message">Hoop diddy hoop de hoop de hoop</span>
        </digital-nature-dismissable-message>

        <label for="klaviyo-event-create-test-event-name">Event Name</label>
        <input type="text" name="event-name" value="A test event" id="klaviyo-event-create-test-event-name" />
        <button id="klaviyo-event-create-test-submit" type="submit">Test</button>
    </div>
</template>