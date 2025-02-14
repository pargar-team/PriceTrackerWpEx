<?php
/*
Plugin Name: Navasan Stock Prices
Description: A plugin to fetch and display stock prices from Navasan API.
Version: 1.0
*/

if (!defined('ABSPATH')) {
    exit; 
}

require_once plugin_dir_path(__FILE__) . 'includes/database.php';
require_once plugin_dir_path(__FILE__) . 'includes/settings.php';
require_once plugin_dir_path(__FILE__) . 'includes/cron.php';
require_once plugin_dir_path(__FILE__) . 'includes/elementor-widget.php';

register_activation_hook(__FILE__, 'nsp_activate');
register_deactivation_hook(__FILE__, 'nsp_deactivate');

function nsp_activate() {
    nsp_create_database_table();
    nsp_schedule_cron_job();
}

function nsp_deactivate() {
    nsp_remove_cron_job();
}