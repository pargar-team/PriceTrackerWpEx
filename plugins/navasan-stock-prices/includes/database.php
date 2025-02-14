<?php
function nsp_create_database_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'navasan_stock_prices';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        sembol varchar(100) NOT NULL,
        price varchar(100) NOT NULL,
        time_real datetime NOT NULL,
        time_api datetime NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}