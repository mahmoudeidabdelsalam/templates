<?php 
add_shortcode( 'products-counter', 'products_counter' );
function products_counter( $atts ) {
    $atts = shortcode_atts( [
        'category' => '',
    ], $atts );

    $taxonomy = 'product_cat';
    if ( is_numeric( $atts['category'] ) ) {
        $cat = get_term( $atts['category'], $taxonomy );
    } else {
        $cat = get_term_by( 'slug', $atts['category'], $taxonomy );
    }

    if ( $cat && ! is_wp_error( $cat ) ) {
        return $cat->count;
    }
    return '';
}


// [product_count] shortcode
function product_count_shortcode( ) {
	$count_posts = wp_count_posts( 'product' );
	return $count_posts->publish;
}
add_shortcode( 'product_count', 'product_count_shortcode' );