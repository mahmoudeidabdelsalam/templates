<?php 
add_filter('woocommerce_shortcode_products_query', 'wh_woocommerce_shortcode_products_orderby');

function wh_woocommerce_shortcode_products_orderby($args)
{

    $standard_array = ['menu_order', 'title', 'date', 'rand', 'id'];
//  print_r($args['orderby']);
    if (isset($args['orderby']) && !in_array($args['orderby'], $standard_array))
    {
        $args['meta_key'] = '_featured';
        $args['orderby'] = 'meta_value_num';
    }
//  print_r($args);
    return $args;
}