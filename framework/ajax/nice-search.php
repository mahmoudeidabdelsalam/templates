<?php 

//get listings for Blogs Refine Search
add_action('wp_ajax_nopriv_get_refineblog_names', 'ajax_refineblog');
add_action('wp_ajax_get_refineblog_names', 'ajax_refineblog');
function ajax_refineblog() {
  global $wpdb; //get access to the WordPress database object variable
  //get names of all businesses
  $name = '%' . $wpdb->esc_like(stripslashes($_POST['name'])) . '%'; //escape for use in LIKE statement
  $sql = "select post_title, post_content, ID
  from $wpdb->posts
  where
    (
    post_title like %s
    )
    and post_status='publish' AND post_type='product'
    LIMIT 10";


    $sql = $wpdb->prepare($sql, $name, $name);
    $results = $wpdb->get_results($sql, OBJECT);
    
    //copy the business titles to a simple array
    $titles = array();

    foreach( $results as $result )
      $tags = wp_get_post_terms( $result->ID, 'product_tag' );
      foreach( $tags as $tag ) {
        $titles[] = ['value' => addslashes( $tag->name )];
      }
    if(count($titles) == 0 ){
      $titles[] = ['value' => __('No results found - Please change keyword ', 'premast')];
    }
    
    $titles = ['suggestions' => $titles];
    echo json_encode($titles); //encode into JSON format and output
    die(); //stop "0" from being output
  }
