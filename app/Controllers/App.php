<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class App extends Controller
{
    public function siteName()
    {
        return get_bloginfo('name');
    }

      /**
        * Function Name: post_loop();
        * This Function takes 4 arguments $post_type & $posts_per_page & image size and no. of pages
        * It returns the arguments for general post type loop
      */
      static function post_loop($type= 'post', $postCount = 3, $imgSize, $paged = 1 , $wordsCount = 15) {

        $array = array();

        $args = array(
            'post_type' => $type,
            'post_status' => 'publish',
            'suppress_filters' => 0,
            'posts_per_page' => $postCount,
            'paged' => $paged,
        );

        $posts = get_posts($args);

        foreach ( $posts as $post):
            setup_postdata($post);
            $array[] = [
                'id'      => $post->ID,
                'url'     => get_the_permalink($post->ID),
                'image'   => \Utilities::global_thumbnails( $post->ID, $imgSize, false),
                'date'    => get_the_date('d M, Y', $post->ID),
                'title'   => get_the_title($post->ID),
                'excerpt' => wp_trim_words(get_the_content($post->ID), $wordsCount , ' ...')
            ];
        endforeach;
        wp_reset_postdata();

        return $array;
      }


    public function RelatedPost () 
    {
      $category = wp_get_post_terms( get_queried_object_id(), 'category', ['fields' => 'ids'] );
      $args = [
        'post_type' => 'post',
        'post__not_in'        => array( get_queried_object_id() ),
        'posts_per_page'      => 3,
        'ignore_sticky_posts' => 1,
        'orderby'             => 'rand',
        'tax_query' => [
          [
            'taxonomy' => 'category',
            'terms'    => $category
          ]
        ]
      ];

      return new \WP_Query($args);
    }


    /**
    * Function Name: Welcome Home()
    * This Function is used to return background, Headline, Subtitle and link For Welcome Section
    * @return array | the value of url image, text and link ACF
    * This function is called in home/section-welcome file
    */
    public function WelcomeHome() {
      $welcome_res = array(
        'image'          => get_field('image_welcome_banner', 'option'),
        'background'     => get_field('image_welcome_background', 'option'),
        'headline'       => get_field('headline_welcome_banner', 'option'),
        'description'    => get_field('sub_headline_welcome_banner', 'option'),
        'link'           => get_field('link_welcome_banner', 'option'),
      );
      return  $welcome_res;
    }

    public static function title()
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }
            return __('Latest Posts', 'sage');
        }
        if (is_archive()) {
            return get_the_archive_title();
        }
        if (is_search()) {
            return sprintf(__('Search Results for %s', 'sage'), get_search_query());
        }
        if (is_404()) {
            return __('Not Found', 'sage');
        }
        return get_the_title();
    }
}
