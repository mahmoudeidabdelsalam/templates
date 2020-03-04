<?php
function get_post_child_list( $taxonomy = '', $post_id = '' )
{

  if ($post_id) {
    $current_post = $post_id;
  } else {
    $current_post = get_queried_object_id();
  }
  
  $terms = wp_get_post_terms( $current_post, $taxonomy );

  /*
    * Check if $taxonomy has a value, also check for WP_Error or empty $terms. If any of these conditions
    * are met, halt execution and return false
    */
  if ( !$taxonomy || is_wp_error( $terms ) || empty( $terms ) )
      return false;

  /*
    * We have made it to here safely, now iterate over the terms
    */


  $parent = [];

  foreach ($terms as $term) {
    if ( $term->parent == 0)

    $parent[] = $term->term_id;
  }  


  $child_of_parent = get_term_children($parent[0], $taxonomy);

  // dd($child_of_parent);

  foreach ( $terms as $term ) {

      if ( $term->parent == 0)
          continue;

      $child_of_parent = get_term_children($term->term_id, $taxonomy);

      if ($child_of_parent) {
        $term_id[] = $term->term_id;
      }
  }

  if (!isset( $term_id ) && $terms) {
    foreach ( $terms as $term ) {

      if ( $term->parent == 0)
          continue;

      $term_id[] = $term->term_id;
    }
  }
  // dd($term_id);
  /*
    * Build our string of names
    */
    if ( !isset( $term_id ) )
        return false;

    // $string = implode( ', ', $term_names );

  return $term_id;
}



function get_post_childrdn( $taxonomy = '', $parent = '', $post_id = '' ) {
  if ($post_id) {
    $current_post = $post_id;
  } else {
    $current_post = get_queried_object_id();
  }
  
  $terms = wp_get_post_terms( $current_post, $taxonomy );
  $child_of_parent = get_term_children($parent[0], $taxonomy);

    foreach ( $terms as $term ) {

      if ( $term->parent == 0)
          continue;
      if (in_array($term->term_id, $child_of_parent))
      $term_id[] = $term->term_id;
    }

  if ( !isset( $term_id ) )
    return false;

  return $term_id;
}