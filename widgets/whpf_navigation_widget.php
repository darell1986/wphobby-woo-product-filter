<?php
/**
 * WHPF Navigation Widget class
 *
 * @author  WPHobby
 * @package WooCommerce Product Filter
 * @version 1.0.0
 */

if ( ! class_exists( 'WC_Widget' ) ) {
    return;
}

if ( ! class_exists( 'WHPF_Navigation_Widget' ) ) {

    /**
     * Product Categories Widget.
     *
     */
    class WHPF_Navigation_Widget extends WC_Widget {

        /**
         * Constructor.
         */
        public function __construct() {
            // Get product attributes
            $attributes = whpf_get_product_attributes();

            $this->widget_cssclass    = 'widget widget_product_categories woo-product-filter';
            $this->widget_description = esc_html__( 'A list of product filters.', 'woo-product-filter' );
            $this->widget_id          = 'woo-product-filter';
            $this->widget_name        = esc_html__( 'WPHobby Product Filter', 'woo-product-filter' );
            $this->settings           = array(
                'title'  => array(
                    'type'  => 'text',
                    'std'   => esc_html__( 'Product Filter', 'woo-product-filter' ),
                    'label' => esc_html__( 'Title', 'woo-product-filter' )
                ),
                'attribute'  => array(
                    'type'    => 'select',
                    'std'     => 'color',
                    'options' => $attributes,
                    'label'   => esc_html__( 'Attribute', 'woo-product-filter' )
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

            $this->widget_start( $args, $instance );

            $instance['attribute']  = empty( $instance['attribute'] ) ? '' : $instance['attribute'];

            $attribute = wc_get_attribute( $instance['attribute'] );

            $taxonomy = $attribute->slug;

            $terms = get_terms( array(
                'taxonomy' =>  $taxonomy,
                'hide_empty' => false,
            ) );

            $options = get_option( 'whpf_opts_data' );
            if(isset($options['whpf_field_collapse_filter']) && $options['whpf_field_collapse_filter']){
                // Add Expand/Collapse Button after widget title
                echo '<span class="filter-button"><i class="fa fa-chevron-up"></i></span>';
            }

            echo '<div class="clear"></div>';

            // List display
            echo "<ul class='woo-product-filter-list'>";

            $this->get_list_html($terms, $taxonomy);

            echo "</ul>";

            $this->widget_end( $args );
        }

        /**
         * Display Product Filter Terms.
         */
        public function get_list_html($terms, $taxonomy){
            $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();

            foreach ( $terms as $term ) {
                $current_values = isset( $_chosen_attributes[ $taxonomy ]['terms'] ) ? $_chosen_attributes[ $taxonomy ]['terms'] : array();
                $option_is_set  = in_array( $term->slug, $current_values, true );

                $filter_name = 'filter_' . str_replace( 'pa_', '', $taxonomy );

                if($option_is_set){
                    $link = esc_url(remove_query_arg( $filter_name, $this->get_current_page_url() ));
                }else{
                    $link = esc_url(add_query_arg( $filter_name, $term->slug, $this->get_current_page_url() ));
                }

                echo '<li class="woo-widget-layered-nav-list__item ' . ( $option_is_set ? 'woo-widget-layered-nav-list__item--chosen chosen' : '' ) . '">';
                echo '<a rel="nofollow" href="' . $link . '">' . esc_html( $term->name ) . '</a>';
                echo '</li>';
            }
        }


    }
}