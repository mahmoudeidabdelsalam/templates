<?php
// register forntend Ajax
add_action('wp_ajax_graphics_add_front_end', 'graphics_add_front_end', 0);
add_action('wp_ajax_nopriv_graphics_add_front_end', 'graphics_add_front_end');
function graphics_add_front_end() {

 
      global $current_user;
      wp_get_current_user();
      $user = wp_get_current_user();

      $thumbnail = $_POST["thumbnail"];
      $file_url = $_POST["file_url"];
      $title = $_POST['title'];
      $main_scat = $_POST["main_scat"];

      $tags = $_POST['tags'];
      $tags = array_map( 'intval', $tags );
      $tags = array_unique( $tags );

      $graphics = wp_insert_post(array (
        'post_type' => 'graphics',
        'post_title' => $title,
        'post_status' => 'publish',
        'post_author' => $current_user->ID,
        'tax_input' => array( 'graphics-category' => array($main_scat))
      ));


      if ($graphics) {
        update_field( 'field_5d43723a031b2', $file_url, $graphics );
        wp_set_object_terms($graphics, $tags, 'graphics-tag');
        set_post_thumbnail( $graphics, $thumbnail );
      }


    // alert errors & success
	  	if (!is_wp_error($graphics)) {
        $post   = get_post($graphics);
        $term_name = wp_get_post_terms($post->ID, 'graphics-category', array("fields" => "names"));
        $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), "full");
        $output .=  '<div class="media" id="'.$post->ID.'">';
        $output .=    '<div class="card">';
        $output .=      '<div class="img-top-item">';
        $output .=        '<img src="'.$thumbnail[0].'" class="card-img-top" alt="'. $post->post_title .'">';
        $output .=      '</div>';
        $output .=      '<div class="card-body">';
        $output .=        '<h5 class="card-title"> '. $post->post_title .' </h5>';
        $output .=        '<h5 class="card-term"> '. $term_name["0"] .' </h5>';
        $output .=        '<div class="card-event"> <a herf="#" class="item-deleted item-event" data-deleted="'.$post->ID.'" data-nonce="'.wp_create_nonce("testdel").'"><i class="fa fa-trash-o" aria-hidden="true"></i></a> </div>';
        $output .=      '</div>';
        $output .=     '</div>';
        $output .=   '</div>';
        echo $output;
	  	} else {
	    	if (isset($user_id->errors['empty_user_login'])) {
	          $notice_key = '<span class="user-errors alert alert-danger">User Name and Email are mandatory</span>';
	          echo $notice_key;
	      	} elseif (isset($user_id->errors['existing_user_login'])) {
	          echo'<span class="user-errors alert alert-danger">User Email already exixts.</span>';
	      	} else {
	          echo'<span class="user-errors alert alert-danger">Error Occured please fill up the sign up form carefully.</span>';
	      	}
      }

	die;
}


add_action('wp_ajax_ajaxtestdel', 'ajaxtestdel', 0);
add_action('wp_ajax_nopriv_ajaxtestdel', 'ajaxtestdel');

function ajaxtestdel() {
  $postid = isset($_POST['postid']) ? $_POST['postid'] : '';
  $nonce = isset($_POST['ajaxsecurity']) ? $_POST['ajaxsecurity'] : '';
  if ( $postid && $nonce ) {
    wp_delete_post($postid);
    $status = 'success';
  } else {
     $status = 'error';
  }
  die($status);
}


