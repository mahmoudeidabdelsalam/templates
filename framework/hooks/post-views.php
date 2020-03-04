<?php

/**
 * Count post views function using post meta
 * @param int $postID
 */
function c95_set_post_views($postID) {
    $count_key = 'c95_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    $count_update = '_c95_post_views_count_time';
    $time_to_check = 60 * 5; // 5 mins
    if (function_exists('stats_get_csv')) {
      // check if 5 minutes have elapsed since last seen
      if(get_post_meta($postID, $count_update, true) + $time_to_check < time() || empty(get_post_meta($postID, $count_update, true))):
        //var_dump( 'im in becoze '. get_post_meta($postID, $count_update, true) . ' now is ' .time() );
        $args = array(
            'days' => -1,
            'post_id' => $postID,
        );
        $postviews = stats_get_csv('postviews', $args);
        $count = $postviews['0']['views'];
        update_post_meta($postID, $count_key, $count);
        update_post_meta($postID, $count_update, time());
      else:
        //var_dump( 'im out becoze '. get_post_meta($postID, $count_update, true) . 'now is ' .time() );
      endif;

    } else {
        if ($count == '') {
            $count = 0;
            delete_post_meta($postID, $count_key);
            update_post_meta($postID, $count_key, 0);
        } else {
            $count++;
            update_post_meta($postID, $count_key, $count);
        }
    }
}

//To keep the count accurate, lets get rid of prefetching
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function c95_get_post_views($postID) {
    $count_key = 'c95_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        delete_post_meta($postID, $count_key);
        update_post_meta($postID, $count_key, '0');
        return 0;
    }

    return intval($count);
}

function c95_track_post_views($post_id) {
    if (!is_single())
        return;
    if (empty($post_id)) {
        global $post;
        $post_id = $post->ID;
    }
    // will duplicate count in case of active w3tc browser cache
    echo "<!-- mfunc mysecretcode c95_set_post_views($post_id); -->";
    c95_set_post_views(get_the_ID());
    echo "<!-- /mfunc mysecretcode -->";
}

add_action('wp_head', 'c95_track_post_views');

function c95_admin_bar_post_views($wp_admin_bar) {

    if (is_single()) {
        global $post;
        $post_id = $post->ID;

        $args = array(
            'id' => 'premast-views',
            'title' => '<span class="ab-icon dashicons-visibility"></span> ' . c95_get_post_views($post_id) . ' ' . __('Views', 'C95'),
            'href' => get_edit_post_link($post_id),
            'meta' => array(
                'class' => 'c95-views',
            )
        );
        $wp_admin_bar->add_node($args);
    }
}

add_action('admin_bar_menu', 'c95_admin_bar_post_views', 90);
