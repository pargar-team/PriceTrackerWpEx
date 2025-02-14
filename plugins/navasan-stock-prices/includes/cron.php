<?php
function nsp_schedule_cron_job() {
    if (!wp_next_scheduled('nsp_hourly_cron_job')) {
        wp_schedule_event(time(), 'hourly', 'nsp_hourly_cron_job');
    }
}

function nsp_remove_cron_job() {
    wp_clear_scheduled_hook('nsp_hourly_cron_job');
}

function nsp_fetch_and_store_data() {
    global $wpdb;
    $api_key = get_option('nsp_api_key');
    $table_name = $wpdb->prefix . 'navasan_stock_prices';

    $symbols = ['harat_naghdi_buy', 'harat_naghdi_sell']; 

    foreach ($symbols as $symbol) {
        $response = wp_remote_get("http://api.navasan.tech/latest/?api_key=$api_key&item=$symbol");
        if (is_wp_error($response)) {
            continue;
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        if (isset($data[$symbol])) {
            $price = $data[$symbol]['value'];
            $time_real = current_time('mysql');
            $time_api = date('Y-m-d H:i:s', $data[$symbol]['timestamp']);

            $existing = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE sembol = %s", $symbol));
            if ($existing) {
                $wpdb->update($table_name, [
                    'price' => $price,
                    'time_real' => $time_real,
                    'time_api' => $time_api
                ], ['id' => $existing->id]);
            } else {
                $wpdb->insert($table_name, [
                    'sembol' => $symbol,
                    'price' => $price,
                    'time_real' => $time_real,
                    'time_api' => $time_api
                ]);
            }
        }
    }
}
add_action('nsp_hourly_cron_job', 'nsp_fetch_and_store_data');