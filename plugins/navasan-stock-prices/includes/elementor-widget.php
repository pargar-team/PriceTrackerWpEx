<?php
function nsp_register_elementor_widget($widgets_manager) {
    require_once plugin_dir_path(__FILE__) . 'elementor-widget-class.php';
    $widgets_manager->register(new \Elementor_Navasan_Stock_Prices_Widget());
}
add_action('elementor/widgets/register', 'nsp_register_elementor_widget');

class Elementor_Navasan_Stock_Prices_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'navasan_stock_prices';
    }

    public function get_title() {
        return __('Navasan Stock Prices', 'navasan-stock-prices');
    }

    public function get_icon() {
        return 'eicon-price-table';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'navasan-stock-prices'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'symbol',
            [
                'label' => __('Symbol', 'navasan-stock-prices'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'harat_naghdi_buy',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $symbol = $settings['symbol'];

        global $wpdb;
        $table_name = $wpdb->prefix . 'navasan_stock_prices';
        $result = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE sembol = %s", $symbol));

        if ($result) {
            echo '<div class="navasan-stock-price">';
            echo '<h3>' . esc_html($symbol) . '</h3>';
            echo '<p>Price: ' . esc_html($result->price) . '</p>';
            echo '<p>Last Updated (Real): ' . esc_html($result->time_real) . '</p>';
            echo '<p>Last Updated (API): ' . esc_html($result->time_api) . '</p>';
            echo '</div>';
        } else {
            echo '<p>No data available for this symbol.</p>';
        }
    }
}