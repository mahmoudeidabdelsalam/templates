<?php 
// ajax function change status user membership gift
function membership_gift() {

  $active_id = $_POST['post_id'];                
  $limit = get_field('limit_referral_gift', 'option');

    global $current_user;
    wp_get_current_user();

    $args = array(
      'post_type' => 'wc_user_membership',
      'post_status'   => array('wcm-active'),
      'suppress_filters' => 0,
      'numberposts'   => -1,
      'author' => $current_user->ID
    );
    $posts = get_posts($args);


    $last = array(
      'post_type' => 'wc_user_membership',
      'post_status'   => array('wcm-active'),
      'suppress_filters' => 0,
      'numberposts'   => 1,
      'author' => $current_user->ID
    );
    $last_posts = get_posts($last);

    if($last_posts) {
      $expired = [];

      foreach ($last_posts as  $last_post) {
        $expired = date('Y-m-d H:i:s', strtotime(get_post_meta( $last_post->ID, '_end_date', true )));
      }
    }

    if ($posts && count($posts) == $limit) {
      return false;
    } else {

      
    if ($expired) {
      $start_date = $expired;
      $end_date = date('Y-m-d H:i:s', strtotime($start_date. '+1 months'));
    } else {
      $start_date = date('Y-m-d H:i:s');
      $end_date = date('Y-m-d H:i:s', strtotime('+1 months'));
    }
    
    if($active_id) {
      wp_update_post(array(
        'ID'    =>  $active_id,
        'post_type' => 'wc_user_membership',
        'post_status'   =>  'wcm-active',
      ));
      update_post_meta($active_id, '_end_date', $end_date);
      update_post_meta($active_id, '_start_date', $start_date);
      do_action('wp_update_post', 'wp_update_post');
    }
  }

}
add_action('wp_ajax_get_active', 'membership_gift');
add_action('wp_ajax_nopriv_get_active', 'membership_gift');
