<?php
/*
Plugin Name: Custom Brand API Extension
Plugin URI:  https://www.marwarenda.com
Description: Adds YITH product brand information to WooCommerce REST API.
Version:     1.0
Author:      Marwa Renda
Author URI:  https://marwarenda.com
License:     GPLv2 or later
Text Domain: custom-brand-api
*/

// Hook into the REST API initialization
add_action('rest_api_init', 'register_brands_in_api');

// Function to register custom field in WooCommerce REST API
function register_brands_in_api() {
    register_rest_field('product', 'brand', array(
        'get_callback' => 'get_product_brand',
        'schema' => null,
    ));
}

// Callback function to get the brand information for a product
function get_product_brand($object, $field_name, $request) {
    $product_id = $object['id'];
    $brands = wp_get_post_terms($product_id, 'yith_product_brand');
    
    // Prepare an array to hold brand data
    $brand_data = array();
    
    foreach ($brands as $brand) {
        $brand_data[] = array(
            'id' => $brand->term_id,
            'name' => $brand->name,
            'slug' => $brand->slug,
            'description' => $brand->description,
        );
    }
    
    return $brand_data;
}
