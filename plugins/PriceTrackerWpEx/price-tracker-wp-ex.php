<?php
/*
Plugin Name:  Price Tracker
Description: A plugin to track and display  prices using an external API.
Version: 1.0
Author: Your Name
*/

if (!defined('ABSPATH')) {
    exit;
}

function price_tracker_add_admin_menu() {
    add_menu_page(
        'Price Tracker Settings',
        'Price Tracker Wp Ex',
        'manage_options',
        'price-tracker',
        'price_tracker_settings_page',
        'dashicons-chart-line',
        100
    );
}
add_action('admin_menu', 'price_tracker_add_admin_menu');

function price_tracker_settings_page() {
    ?>
    <div class="wrap">
        <h1> Price Tracker Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('price_tracker_options_group'); 
            do_settings_sections('-price-tracker');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function price_tracker_register_settings() {
    register_setting(
        'price_tracker_options_group',
        'price_tracker_api_key',
        'sanitize_text_field'
    );

    add_settings_section(
        'price_tracker_main_section',
        'API Settings',
        null,
        '-price-tracker'
    );

    add_settings_field(
        'price_tracker_api_key',
        'API Key',
        'price_tracker_api_key_callback',
        '-price-tracker',
        'price_tracker_main_section'
    );
}
add_action('admin_init', 'price_tracker_register_settings');

function price_tracker_api_key_callback() {
    $api_key = get_option('price_tracker_api_key', '');
    echo '<input type="text" name="price_tracker_api_key" value="' . esc_attr($api_key) . '" class="regular-text">';
}
