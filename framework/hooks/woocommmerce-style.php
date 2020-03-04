<?php
function woocommmerce_style() {
   wp_enqueue_style('woocommerce_stylesheet', WP_PLUGIN_URL. '/woocommerce/assets/css/woocommerce.css',false,'1.0',"all");
}
add_action( 'wp_head', 'woocommmerce_style' );


remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );


/**
 * Display "FREE" instead of $0 if the item is free.
 *
 * @param string $price The current price label.
 * @param object $product The product object.
 * @return string
 */
function thenga_price_override( $price, $product ) {
   if ( empty( $product->get_price() ) ) {
      /*
       * Replace the word "Free" with whatever text you would like. Also
       * remember to update the textdomain for translation if required.
      */
      $price = __( 'Free version', 'premast' );
   }
 
   return $price;
}
add_filter( 'woocommerce_get_price_html', 'thenga_price_override', 100, 2 );

function remove_gallery_and_product_images() {
if ( is_product() ) {
    remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
    }
}
add_action('loop_start', 'remove_gallery_and_product_images');

function custom_remove_all_quantity_fields( $return, $product ) {return true;}
add_filter( 'woocommerce_is_sold_individually','custom_remove_all_quantity_fields', 10, 2 );


// add_filter( 'woocommerce_add_to_cart_validation', 'remove_cart_item_before_add_to_cart', 20, 3 );
// function remove_cart_item_before_add_to_cart( $passed, $product_id, $quantity ) {
//     if( ! WC()->cart->is_empty())
//         WC()->cart->empty_cart();
//     return $passed;
// }

add_filter( 'woocommerce_get_breadcrumb', 'ed_change_breadcrumb' );
function ed_change_breadcrumb( $breadcrumb ) {
  if(is_singular()){
		array_pop($breadcrumb);
	}
  return $breadcrumb;
}


add_filter( 'add_to_cart_text', 'woo_custom_single_add_to_cart_text' );                // < 2.1
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_single_add_to_cart_text' );  // 2.1 +
  
function woo_custom_single_add_to_cart_text() {
  
    return __( 'Buy Now', 'woocommerce' );
}

/**
 * Enables the Excerpt meta box in Page edit screen.
 */
function wpcodex_add_excerpt_support_for_pages() {
	add_post_type_support( 'product', 'author' );
}
add_action( 'init', 'wpcodex_add_excerpt_support_for_pages' );


/**
 * Add Cart icon and count to header if WC is active
 */
function my_wc_cart_count() {
 
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
 
        $count = WC()->cart->cart_contents_count;
        ?><a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php
        if ( $count > 0 ) {
            ?>
            <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
            <?php
        }
                ?></a><?php
    }
 
}
add_action( 'your_theme_header_top', 'my_wc_cart_count' );

/**
 * Ensure cart contents update when products are added to the cart via AJAX
 */
function my_header_add_to_cart_fragment( $fragments ) {
 
    ob_start();
    $count = WC()->cart->cart_contents_count;
    ?><a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php
    if ( $count > 0 ) {
        ?>
        <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
        <?php            
    }
        ?></a><?php
 
    $fragments['a.cart-contents'] = ob_get_clean();
     
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'my_header_add_to_cart_fragment' );



// ----- validate password match on the registration page
function registration_errors_validation($reg_errors, $sanitized_user_login, $user_email) {
	global $woocommerce;
	extract( $_POST );
	if ( strcmp( $password, $password2 ) !== 0 ) {
		return new WP_Error( 'registration-error', __( 'Passwords do not match.', 'woocommerce' ) );
	}
	return $reg_errors;
}
add_filter('woocommerce_registration_errors', 'registration_errors_validation', 10,3);

// ----- add a confirm password fields match on the registration page
function wc_register_form_password_repeat() {
	?>
	<p>
		<input type="password" class="input-text" name="password2" id="reg_password2" placeholder="Confirm Password" value="<?php if ( ! empty( $_POST['password2'] ) ) echo esc_attr( $_POST['password2'] ); ?>" />
	</p>
	<?php
}
add_action( 'woocommerce_register_form', 'wc_register_form_password_repeat' );

// ----- Validate confirm password field match to the checkout page
function lit_woocommerce_confirm_password_validation( $posted ) {
    $checkout = WC()->checkout;
    if ( ! is_user_logged_in() && ( $checkout->must_create_account || ! empty( $posted['createaccount'] ) ) ) {
        if ( strcmp( $posted['account_password'], $posted['account_confirm_password'] ) !== 0 ) {
            wc_add_notice( __( 'Passwords do not match.', 'woocommerce' ), 'error' ); 
        }
    }
}
add_action( 'woocommerce_after_checkout_validation', 'lit_woocommerce_confirm_password_validation', 10, 2 );

// ----- Add a confirm password field to the checkout page
function lit_woocommerce_confirm_password_checkout( $checkout ) {
    if ( get_option( 'woocommerce_registration_generate_password' ) == 'no' ) {

        $fields = $checkout->get_checkout_fields();

        $fields['account']['account_confirm_password'] = array(
            'type'              => 'password',
            'label'             => __( 'Confirm password', 'woocommerce' ),
            'required'          => true,
            'placeholder'       => _x( 'Confirm Password', 'placeholder', 'woocommerce' )
        );

        $checkout->__set( 'checkout_fields', $fields );
    }
}
add_action( 'woocommerce_checkout_init', 'lit_woocommerce_confirm_password_checkout', 10, 1 );


add_action( 'template_redirect', 'woo_custom_redirect_after_purchase' );
function woo_custom_redirect_after_purchase() {
  global $wp;
  $like_download = get_field('thanks_page','option');
  
	if ( is_checkout() && !empty( $wp->query_vars['order-received'] ) ) {
		wp_redirect( $like_download );
		exit;
	}
}


if( ! function_exists('custom_ajax_add_to_cart_button') && class_exists('WooCommerce') ) {
    function custom_ajax_add_to_cart_button( $atts ) {
        // Shortcode attributes
        $atts = shortcode_atts( array(
            'id' => '0', // Product ID
            'qty' => '1', // Product quantity
            'text' => '', // Text of the button
            'class' => '', // Additional classes
        ), $atts, 'ajax_add_to_cart' );

        if( esc_attr( $atts['id'] ) == 0 ) return; // Exit when no Product ID

        if( get_post_type( esc_attr( $atts['id'] ) ) != 'product' ) return; // Exit if not a Product

        $product = wc_get_product( esc_attr( $atts['id'] ) );

        if ( ! $product ) return; // Exit when if not a valid Product

        $classes = implode( ' ', array_filter( array(
            'button',
            'product_type_' . $product->get_type(),
            $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
            $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
        ) ) ).' '.$atts['class'];

        $add_to_cart_button = sprintf( '<a rel="nofollow" href="%s" %s %s %s class="%s">%s</a>',
            esc_url( $product->add_to_cart_url() ),
            'data-quantity="' . esc_attr( $atts['qty'] ) .'"',
            'data-product_id="' . esc_attr( $atts['id'] ) .'"',
            'data-product_sku="' . esc_attr( $product->get_sku() ) .'"',
            esc_attr( isset( $classes ) ? $classes : 'button' ),
            esc_html( empty( esc_attr( $atts['text'] ) ) ? $product->add_to_cart_text() : esc_attr( $atts['text'] ) )
        );

        return $add_to_cart_button;
    }
    add_shortcode('ajax_add_to_cart', 'custom_ajax_add_to_cart_button');
}





// WooCommerce Checkout Fields Hook
add_filter( 'woocommerce_checkout_fields' , 'hjs_wc_checkout_fields' );
 
// This example changes the default placeholder text for the state drop downs to "Select A State"
function hjs_wc_checkout_fields( $fields ) {
 
 $fields['billing']['billing_first_name']['placeholder'] = 'Full Name';
 $fields['billing']['billing_last_name']['placeholder'] = 'Last Name';
 $fields['billing']['billing_company']['placeholder'] = 'Company';
 $fields['billing']['billing_address_1']['placeholder'] = 'street address 1';
 $fields['billing']['billing_address_2']['placeholder'] = 'street address 2';
 $fields['billing']['billing_city']['placeholder'] = 'state/city';
 $fields['billing']['billing_postcode']['placeholder'] = 'Postcode';
 $fields['billing']['billing_country']['placeholder'] = 'Country';
 $fields['billing']['billing_state']['placeholder'] = 'State';
 $fields['billing']['billing_email']['placeholder'] = 'Email';
 $fields['billing']['billing_phone']['placeholder'] = 'Phone';

 return $fields;
}



function mwe_get_formatted_shipping_name_and_address($user_id) {

    $address = '<p>';
    $address .= get_user_meta( $user_id, 'billing_first_name', true );
    $address .= "\n";
    $address .= get_user_meta( $user_id, 'billing_last_name', true );
    $address .= '</p>';
    $address .= '<p>';
    $address .= get_user_meta( $user_id, 'billing_address_1', true );
    $address .= "\n";
    $address .= get_user_meta( $user_id, 'billing_country', true );
    $address .= "\n";
    $address .= get_user_meta( $user_id, 'billing_city', true );
    $address .= '</p>';
    $address .= '<p>';
    $address .= get_user_meta( $user_id, 'billing_email', true );
    $address .= '</p>';
    $address .= '<p>';
    $address .= get_user_meta( $user_id, 'billing_phone', true );
    $address .= '</p>';

    return $address;
}

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );


add_filter( 'woocommerce_checkout_fields' , 'custom_remove_woo_checkout_fields' );
 
function custom_remove_woo_checkout_fields( $fields ) {

    // remove billing fields
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_phone']);

   
    // remove shipping fields 
    unset($fields['shipping']['shipping_company']);
    unset($fields['shipping']['shipping_address_1']);
    unset($fields['shipping']['shipping_address_2']);
    unset($fields['shipping']['shipping_city']);
    unset($fields['shipping']['shipping_postcode']);
    unset($fields['shipping']['shipping_state']);
    
    // remove order comment fields
    unset($fields['order']['order_comments']);
    
    return $fields;
}
