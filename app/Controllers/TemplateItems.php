<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class TemplateItems extends Controller
{

  /**
    * Function Name: Welcome Home()
    * This Function is used to return background, Headline, Subtitle and link For Welcome Section
    * @return array | the value of url image, text and link ACF
    * This function is called in home/section-welcome file
  */
  public function loopItems() {

  $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
  $Name   = isset($_GET['refine']) ? $_GET['refine'] : '0';
  $sort   = isset($_GET['sort']) ? $_GET['sort'] : '0';
  
  if ( $sort == 'date' ):
    $orderby = 'date';
    $order = 'DESC';
    $meta_key = '';
  elseif( $sort == 'view') :
    $orderby = 'meta_value_num';
    $order = 'DESC';
    $meta_key = 'c95_post_views_count';
  elseif( $sort == 'download') :
    $orderby = 'meta_value_num';
    $order = 'DESC';
    $meta_key = 'counterdownload';
  else :
    $orderby = 'date';
    $order = 'DESC';
    $meta_key = '';
  endif;



    if ($sort != '0') {
      // second query
      $second_ids = get_posts( array(
        'post_type' => 'product',
        'posts_per_page' => 20,
        'fields'         => 'ids',
        'paged' => $paged,
        'meta_key' => $meta_key,
        'orderby' => $orderby,
        'order' => $order,
      ));

      $per_page = 20 - count($second_ids);
    } else {
      $second_ids = [];
      $per_page = 20;
    }

    $orders = array(
      'post_type' => 'product',
      'posts_per_page' => 20,
      'paged' => $paged,
      'meta_key' => $meta_key,
      'orderby' => $orderby,
      'order' => $order,
    );

    $args = array(
      'post_type' => 'product',
      'posts_per_page' => $per_page,
      'paged' => $paged,
      'post__not_in' => $second_ids,
    );

    if($Name != '0') {
      $args['s'] = $Name;
    }
    
    if( $sort == 'featured') {
      $orders['tax_query'] = array(
        array(
          'taxonomy' => 'product_visibility',
          'field'    => 'name',
          'terms'    => 'featured',
        ),
      );
      $second_ids['tax_query'] = array(
        array(
          'taxonomy' => 'product_visibility',
          'field'    => 'name',
          'terms'    => 'featured',
        ),
      );
    }

    $my_query = new \WP_Query( $args );
      
    if ($sort != '0') {
      $more_query = new \WP_Query( $orders ); 
      $my_query->posts = array_merge( $more_query->posts, $my_query->posts);
    }

    return  $my_query;
  }

}
