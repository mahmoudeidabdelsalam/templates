<?php

  /**
  * Function Name: reset Format Post and unset def &$post global - formatPost();
  * @return ( remove def &$post global )
  */
  function formatPost(&$post){
    unset($post->post_title, $post->post_author, $post->post_date, $post->post_modified, $post->post_date_gmt, $post->post_content, $post->comment_status, $post->ping_status, $post->post_password, $post->to_ping, $post->pinged, $post->post_modified_gmt, $post->post_content_filtered, $post->post_parent, $post->guid, $post->post_mime_type);
    unset($post->comment_count, $post->comment_count, $post->filter, $post->menu_order, $post->post_status);

}
