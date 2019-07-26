<?php
/**
 * WHobby WooCommerce Product Filter Panel
 */
?>
<h2 class="nav-tab-wrapper">
    <?php
    $url = admin_url().'admin.php?page=whpf-panel';
    $premium_url = 'https://codecanyon.net/item/advanced-woocommerce-product-filter/24153628';
    ?>
    <a href="<?php echo esc_url($url); ?>" class="nav-tab <?php echo ($_GET[ 'page' ] == 'whpf-panel' && !isset($_GET[ 'tab' ]) )? 'nav-tab-active' : ''; ?>"><?php _e('General', 'whpf-admin' ); ?></a>
    <a href="<?php echo esc_url($premium_url); ?>" target="_blank" class="nav-tab <?php echo $_GET[ 'tab' ] == 'premium' ? 'nav-tab-active' : ''; ?>"><?php _e('Premium Version', 'whpf-admin' ); ?></a>
</h2>