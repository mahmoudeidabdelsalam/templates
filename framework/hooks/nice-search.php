<?php 

function redirect() {
  global $wp_rewrite;
  if (!isset($wp_rewrite) || !is_object($wp_rewrite) || !$wp_rewrite->using_permalinks()) {
    return;
  }

  $search_base = $wp_rewrite->search_base;
  if (is_search() && !is_admin() && strpos($_SERVER['REQUEST_URI'], "/{$search_base}/") === false) {
    wp_redirect(get_field('link_page_items', 'option'). '/?refine=' . urlencode(get_query_var('s')));
    exit();
  }
}
add_action('template_redirect', 'redirect');
