<?php
/**
 * WHPF class
 *
 * @author  WPHobby
 * @package WooCommerce Product Filter
 * @version 1.0.0
 */
class WHPF {

    public $options;

    /**
     * @var bool Check WooCommerce Version
     * @since 1.0.0
     */
    public $current_wc_version  = false;
    public $is_wc_older_2_1     = false;
    public $is_wc_older_2_6     = false;

    public function __construct() {
        $this->options = get_option(WHPF_OPTIONS);

        /**
         * WooCommerce Version Check
         */
        $this->current_wc_version = WC()->version;
        $this->is_wc_older_2_1    = version_compare( $this->current_wc_version, '2.1', '<' );
        $this->is_wc_older_2_6    = version_compare( $this->current_wc_version, '2.6', '<' );

        /* Register Sidebar and Widget */
        add_action( 'widgets_init', array( $this, 'register_widgets' ) );
        /* Enqueue Style and Scripts */
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles_scripts' ) );
        $options = $this->options;
        if(isset($options['whpf_field_off_canvas_filter']) && $options['whpf_field_off_canvas_filter']){
            /* Add Off-Canvas Filter Button on Shop Page */
            add_action( 'woocommerce_before_shop_loop', array( $this, 'woocommerce_off_canvas_filter' ), 10 );
        }
        /* Add Filter HTML Elements after footer */
        add_action( 'wp_footer', array( $this, 'elements_after_footer' ) );

    }

    public function activate(){
        //plugin default opts
        $init_opts = array(
            'version' => WHPF_VERSION
        );

        if(!empty($this->options)){
            // update existed options
            update_option(WHPF_OPTIONS, $init_opts);
        }else{
            // add the init options
            add_option(WHPF_OPTIONS, $init_opts);
        }
    }

    public function initialize(){
    }

    public function deactivate(){
    }

    /**
     * Register widgets
     *
     * @access public
     * @since  1.0.0
     */
    public function register_widgets() {

        unregister_widget( 'WC_Widget_Layered_Nav' );


        $widgets = apply_filters( 'whpf_widgets', array(
                'WHPF_Navigation_Widget',
                'WHPF_Rest_Widget',
            )
        );

        foreach( $widgets as $widget ){
            register_widget( $widget );
        }



        // OffCanvas Filter Sidebar
        register_sidebar( array(
            'name'          => esc_html__( 'OffCanvas Filter', 'woo-product-filter' ),
            'id'            => 'off-canvas-filter',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );
    }

    /**
     * Enqueue Styles and Scripts
     */
    public function enqueue_styles_scripts() {
        wp_enqueue_style('bootstrap', WHPF_URL . 'assets/css/bootstrap.min.css', false, WHPF_VERSION );
        wp_enqueue_style('font-awesome', WHPF_URL . 'assets/css/font-awesome.min.css', false, WHPF_VERSION );
        wp_enqueue_style( 'whpf-frontend-style', WHPF_URL . 'assets/css/frontend.css', false, WHPF_VERSION );
        wp_enqueue_style( 'whpf-responsive-style', WHPF_URL . 'assets/css/responsive.css', false, WHPF_VERSION );
        wp_enqueue_script( 'whpf-frontend-script', WHPF_URL . 'assets/js/frontend.js', array( 'jquery' ), WHPF_VERSION, true );

    }

    /**
     * Add Off-Canvas Filter Button on Shop Page
     */
    public function woocommerce_off_canvas_filter(){
    ?>
        <div id="canvas-filter-section">
            <a class="canvas-filter-open" href="javascript:void(0)">
                <?php echo esc_html_e('Filter', 'woo-product-filter'); ?>
            </a>
        </div>
    <?php
    }

    /**
     * Add Filter HTML Elements after footer
     */
    public function elements_after_footer()
    {
        $canvas_class = 'canvas-filter-left';
        $options = $this->options;
        if ($options['whpf_field_off_canvas_position'] == 'left') {
            $canvas_class = 'canvas-filter-left';
        } else if ($options['whpf_field_off_canvas_position'] == 'right') {
            $canvas_class = 'canvas-filter-right';
        }

        if ($options['whpf_field_off_canvas_style'] == 'light') {
            $canvas_class .= ' canvas-filter-light';
        } else if ($options['whpf_field_off_canvas_style'] == 'dark') {
            $canvas_class .= ' canvas-filter-dark';
        }

        ?>
            <div class="canvas-filter-wrapper">
                <div class="<?php echo esc_attr($canvas_class); ?>">
                    <?php
                    $sidebar = 'off-canvas-filter';
                    if (is_active_sidebar($sidebar)) {
                        dynamic_sidebar($sidebar);
                    }else{
                    ?>
                        <p><?php echo esc_html__("Please Add your filters widget Here.", "woo-product-filter");?></p>
                    <?php
                    }
                    ?>
                </div>
                <div class="filter-overlay"></div>
            </div>
        <?php
        if ($options['whpf_field_back_to_top']) {
        ?>
        <a href="#" class="back-to-top" style="display: inline-block;">
           <i class="fa fa-angle-up" aria-hidden="true"></i>
        </a>
        <?php
        }
    }
}
?>