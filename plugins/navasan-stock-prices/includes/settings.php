<?php
function nsp_add_settings_page() {
    add_options_page('Navasan Stock Prices Settings', 'Navasan Stock Prices', 'manage_options', 'nsp-settings', 'nsp_render_settings_page');
}
add_action('admin_menu', 'nsp_add_settings_page');

function nsp_render_settings_page() {
    ?>
    <div class="wrap">
        <h2>Navasan Stock Prices Settings</h2>
        <form method="post" action="options.php">
            <?php
            settings_fields('nsp_options_group');
            do_settings_sections('nsp-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function nsp_register_settings() {
    register_setting('nsp_options_group', 'nsp_api_key');
    add_settings_section('nsp_main_section', 'Main Settings', null, 'nsp-settings');
    add_settings_field('nsp_api_key', 'API Key', 'nsp_api_key_callback', 'nsp-settings', 'nsp_main_section');
}
add_action('admin_init', 'nsp_register_settings');

function nsp_api_key_callback() {
    $api_key = get_option('nsp_api_key');
    echo '<input type="text" name="nsp_api_key" value="' . esc_attr($api_key) . '" class="regular-text">';
}