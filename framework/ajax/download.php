<?php 
add_action( 'wp_ajax_nopriv_counter', 'counter' );
add_action( 'wp_ajax_counter', 'counter' );
function counter() {
	$counter = get_post_meta( $_POST['post_id'], 'counter', true );
	$counter++;
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		update_post_meta( $_POST['post_id'], 'counter', $counter );
		echo $counter;
	}
	die();
}

add_action( 'wp_ajax_nopriv_counterdownload', 'counterdownload' );
add_action( 'wp_ajax_counterdownload', 'counterdownload' );
function counterdownload() {
	$counter_download = get_post_meta( $_POST['post_id'], 'counterdownload', true );
	$counter_download++;
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		update_post_meta( $_POST['post_id'], 'counterdownload', $counter_download );
		echo $counter_download;
	}
	die();
}

add_filter ( 'woocommerce_account_menu_items', 'misha_remove_my_account_links' );
function misha_remove_my_account_links( $menu_links ){
 
	// unset( $menu_links['dashboard'] ); // Remove Dashboard
	unset( $menu_links['payment-methods'] ); // Remove Payment Methods
	unset( $menu_links['edit-account'] ); // Remove Orders
	unset( $menu_links['downloads'] ); // Disable Downloads
	unset( $menu_links['edit-address'] ); // Remove Account details tab
	unset( $menu_links['customer-logout'] ); // Remove Logout link
 
	return $menu_links;
 
}