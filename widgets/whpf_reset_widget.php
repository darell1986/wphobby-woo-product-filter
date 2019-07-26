<?php
/**
 * WHPF Reset Widget class
 *
 * @author  WPHobby
 * @package WooCommerce Product Filter
 * @version 1.0.0
 */


if ( ! class_exists( 'WC_Widget' ) ) {
    return;
}

if ( ! class_exists( 'WHPF_Rest_Widget' ) ) {

    /**
     * WHPF Rest Widget.
     *
     */
    class WHPF_Rest_Widget extends WC_Widget {

        /**
         * Constructor.
         */
        public function __construct() {
            $this->widget_cssclass    = 'widget widget_product_filter woo-product-filter';
            $this->widget_description = esc_html__( 'Reset product filters.', 'woo-product-filter' );
            $this->widget_id          = 'woo-reset-product-filter';
            $this->widget_name        = esc_html__( 'WPHobby Reset Product Filter', 'woo-product-filter' );
            $this->settings           = array(
                'title'  => array(
                    'type'  => 'text',
                    'std'   => esc_html__( 'Reset', 'woo-product-filter' ),
                    'label' => esc_html__( 'Title', 'woo-product-filter' )
                ),
                'reset_button_text'  => array(
                    'type'  => 'text',
                    'std'   => esc_html__( 'Reset All Filters', 'woo-product-filter' ),
                    'label' => esc_html__( 'Title', 'woo-product-filter' )
                ),

            );

            parent::__construct();
        }

        /**
         * Output widget.
         *
         * @see WP_Widget
         *
         * @param array $args
         * @param array $instance
         */
        public function widget( $args, $instance ) {
            if ( ! is_shop() && ! is_product_taxonomy() ) {
                return;
            }

            $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();

            if(count($_chosen_attributes) == 0) {
                return;
            }


            $this->widget_start( $args, $instance );

            $instance['reset_button_text']  = empty( $instance['reset_button_text'] ) ? '' : $instance['reset_button_text'];

            $reset_button_text = $instance['reset_button_text'];

            $reset_link = strtok($this->get_current_page_url(),'?');

            ?>
                <div class="clear"></div>
                <div class="woo-reset-wrapper">
                    <a class="woo-reset-filter button" href="<?php echo esc_url($reset_link); ?>">
                        <?php echo esc_html($reset_button_text); ?>
                    </a>
                </div>
            <?php

            $this->widget_end( $args );
        }
    }
}