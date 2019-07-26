<?php

if ( ! function_exists( 'whpf_get_product_attributes' ) ) {

    /**
     * Return Woocommerce attributes
     */
    function whpf_get_product_attributes()
    {

        $_woocommerce = function_exists('wc') ? wc() : null;
        $attributes = array();
        if (function_exists('wc_get_attribute_taxonomies')) {
            $attribute_taxonomies = wc_get_attribute_taxonomies();
        } else {
            $attribute_taxonomies = $_woocommerce->get_attribute_taxonomies();
        }

        foreach ($attribute_taxonomies as $attribute) {
            $attributes[$attribute->attribute_id] = esc_html__($attribute->attribute_name, 'woo-product-filter');

        }

        return $attributes;

    }
}
?>