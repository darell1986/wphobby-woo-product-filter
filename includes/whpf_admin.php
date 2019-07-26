<?php
/**
 * WHPF Admin class
 *
 * @author  WPHobby
 * @package WooCommerce Product Filter
 * @version 1.0.0
 */
if( ! class_exists( 'WHPF_Admin' ) ) {
    class WHPF_Admin {
        // =============================================================================
        // Construct
        // =============================================================================
        public function __construct() {
            add_action( 'admin_init', array( $this, 'whpf_register_settings' ) );
            add_action( 'admin_menu', array( $this, 'whpf_register_menu' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'whpf_admin_styles_scripts' ) );
        }

        /**
         * Load welcome admin css and js
         * @return void
         * @since  1.0.0
         */
        public function whpf_admin_styles_scripts() {
            if ( is_admin() ) {
                wp_enqueue_style('font-awesome', WHPF_URL . 'assets/css/font-awesome.min.css', false, WHPF_VERSION );
                wp_enqueue_style( 'whpf-admin-style', WHPF_URL . 'assets/css/admin.css', false, WHPF_VERSION );

            }
        }

        /*
         * Display admin messages
         */
        public function whpf_display_message(){
            if ( isset( $_GET['settings-updated'] ) ) {
                echo "<div class='updated'><p>".__( 'Settings updated successfully.', 'woo-product-filter' )."</p></div>";
            }
        }

        /**
         * Register admin menus
         * @return void
         * @since  1.0.0
         */
        public function whpf_register_menu(){
            add_menu_page( 'WPHobby WooCommerce Product Filter', 'Filters', 'manage_options', 'whpf-panel', array( $this, 'whpf_panel_general' ), WHPF_URL . '/assets/images/icon.svg', '2');
        }

        /**
         * The admin panel content
         * @since 1.0.0
         */
        public function whpf_panel_general() {
            $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general';
        ?>
            <div class="whpf-panel">
                <div class="wrap">
                    <?php require_once( WHPF_DIR . '/includes/admin/sections/top.php' ); ?>
                    <?php $this->whpf_display_message(); ?>
                    <?php
                    if( $active_tab == 'general' ){
                        require_once( WHPF_DIR . '/includes/admin/sections/tab-general.php' );
                    }
                    ?>
                </div>
            </div>
        <?php
        }

        /**
         * Register Settings
         * @since 1.0.0
         */
        public function whpf_register_settings() {
            register_setting(
                'whpf_general', // A settings group name. Must exist prior to the register_setting call. This must match the group name in settings_fields()
                'whpf_general_data'
            );


            add_settings_section( 'whpf_section_general', '', array( $this, 'whpf_section_general_output' ), 'whpf_panel_general' );
            add_settings_field( 'whpf_field_off_canvas_position', esc_html__("Off-Canvas Filter Position", "woo-product-filter"), array( $this, 'whpf_off_canvas_position_output' ), 'whpf_panel_general', 'whpf_section_general' );
            add_settings_field( 'whpf_field_off_canvas_style', esc_html__("Off Canvas Filters Style", "woo-product-filter"), array( $this, 'whpf_off_canvas_filter_style_output' ), 'whpf_panel_general', 'whpf_section_general' );
            add_settings_field( 'whpf_field_off_canvas_filter', esc_html__("Enable Off Canvas Filters", "woo-product-filter"), array( $this, 'whpf_off_canvas_filter_output' ), 'whpf_panel_general', 'whpf_section_general' );
            add_settings_field( 'whpf_field_collapse_filterr', esc_html__("Enable Collapse Filters", "woo-product-filter"), array( $this, 'whpf_collapse_filter_output' ), 'whpf_panel_general', 'whpf_section_general' );
            add_settings_field( 'whpf_field_back_to_top', esc_html__("Enable Back To Top", "woo-product-filter"), array( $this, 'whpf_back_to_top_output' ), 'whpf_panel_general', 'whpf_section_general' );

        }

        public function whpf_section_general_output() {
           echo esc_html__( 'This is where general display settings.', 'woo-product-filter' );
        }

        public function whpf_off_canvas_position_output() {
            $options = get_option( 'whpf_general_data' );
            ?>
            <select name='whpf_general_data[whpf_field_off_canvas_position]'> 
                <option value='left' <?php if(isset($options['whpf_field_off_canvas_position'])){selected( $options['whpf_field_off_canvas_position'], 'left' );} ?>>Left</option> 
                <option value='right' <?php if(isset($options['whpf_field_off_canvas_position'])){selected( $options['whpf_field_off_canvas_position'], 'right' );} ?>>Right</option> 
            </select>
        <?php
        }

        public function whpf_off_canvas_filter_output() {
            $options = get_option( 'whpf_general_data' );
            $value = 1;
            $checked = $options['whpf_field_off_canvas_filter']== '1' ? 'checked' : '';
            ?>
            <label class="switch">
                <input type="checkbox" value='<?php echo esc_attr($value); ?>' name='whpf_general_data[whpf_field_off_canvas_filter]' <?php echo esc_attr($checked); ?> />
                <span class="slider round"></span>
            </label>
            <?php
        }

        public function whpf_off_canvas_filter_style_output() {
            $options = get_option( 'whpf_general_data' );
            ?>
            <select name='whpf_general_data[whpf_field_off_canvas_style]'> 
                <option value='light' <?php if(isset($options['whpf_field_off_canvas_style'])){selected( $options['whpf_field_off_canvas_style'], 'light' );} ?>>Light</option> 
                <option value='dark' <?php if(isset($options['whpf_field_off_canvas_style'])){selected( $options['whpf_field_off_canvas_style'], 'dark' );} ?>>Dark</option> 
            </select>
            <?php
        }

        public function whpf_collapse_filter_output(){
            $options = get_option( 'whpf_general_data' );
            $value = 1;
            $checked = $options['whpf_field_collapse_filter']== '1' ? 'checked' : '';
            ?>
            <label class="switch">
                <input type="checkbox" value='<?php echo esc_attr($value); ?>' name='whpf_general_data[whpf_field_collapse_filter]' <?php echo esc_attr($checked); ?> />
                <span class="slider round"></span>
            </label>
            <?php

        }

        public function whpf_back_to_top_output() {
            $options = get_option( 'whpf_general_data' );
            $value = 1;
            $checked = $options['whpf_field_back_to_top']== '1' ? 'checked' : '';
            ?>
            <label class="switch">
                <input type="checkbox" value='<?php echo esc_attr($value); ?>' name='whpf_general_data[whpf_field_back_to_top]' <?php echo esc_attr($checked); ?> />
                <span class="slider round"></span>
            </label>
            <?php
        }


    }

    new WHPF_Admin;
}