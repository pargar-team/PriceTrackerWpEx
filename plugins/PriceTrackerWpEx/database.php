<?php
if (!defined('ABSPATH')) {
    exit;
}

function price_tracker_create_database_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'price_tracker';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        price decimal(10,2) NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'price_tracker_create_database_table');

function price_tracker_save_to_database($price) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'price_tracker';

    $wpdb->insert(
        $table_name,
        array(
            'price' => $price,
        )
    );
}
