<?php
/** @var Setting $setting */

use DigitalNature\Utilities\Config\Setting;

?>

<h2><?= $setting->get_setting_page_title(); ?></h2>
<form action="options.php" method="post">

    <?php
    settings_fields($setting->get_option_name());
    do_settings_sections($setting->get_setting_page());
    ?>

    <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Save' ); ?>" />
</form>