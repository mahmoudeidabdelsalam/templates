<?php
/**
* Function Name: Wrap Embed With Div - wrap_embed_with_div();
* This Function can  Automatically wrap div to oembeds
* @param ($html, $url, $attr)
* @return (type $newhtml)
*/
function wrap_embed_with_div($html, $url, $attr) {
  $newhtml=preg_replace('/class="embed"/', '/class="oembed-container embed text-center"/', $html);
  if($newhtml == $html):
    $return = '<div class="oembed-container embed text-center">' . $html . '</div>';
  else:
    $return = $newhtml;
  endif;
  return $return;
}
add_filter('embed_oembed_html', 'wrap_embed_with_div', 10, 3);
/**
* Function Name: Embed Url Lookup - embed_url_lookup();
* This Function can  Automatically wrap div to oembeds
* @param ()
* @return ()
*/
function embed_url_lookup() {
  $reg = preg_match('|^\s*(https?://[^\s"]+)\s*$|im', get_the_content(), $matches);
  if (!$reg)
  return false;

  return trim($matches[0]);
}

function load_oembed_ajax(){
  if (isset($_POST['oembed_url'])):
    $url = $_POST['oembed_url'];
    echo wp_oembed_get($url);
  endif;
  die(); // this is required to terminate immediately and return a proper response
}
add_action('wp_ajax_nopriv_load_oembed_ajax', 'load_oembed_ajax');
add_action('wp_ajax_load_oembed_ajax', 'load_oembed_ajax');
/**
* Function Name: C95 Facebook Oembed - c95_facebook_oembed();
* This Function can Add Facebook oEmbed to Oembed provider
* @param ()
* @return ()
* @link https://core.trac.wordpress.org/ticket/34737
*/
function c95_facebook_oembed() {
  $endpoints = array(
    '#https?://www\.facebook\.com/video.php.*#i' => 'https://www.facebook.com/plugins/video/oembed.json/',
    '#https?://www\.facebook\.com/.*/videos/.*#i' => 'https://www.facebook.com/plugins/video/oembed.json/',
    '#https?://www\.facebook\.com/.*/posts/.*#i' => 'https://www.facebook.com/plugins/post/oembed.json/',
    '#https?://www\.facebook\.com/.*/activity/.*#i' => 'https://www.facebook.com/plugins/post/oembed.json/',
    '#https?://www\.facebook\.com/photo.php.*#i' => 'https://www.facebook.com/plugins/post/oembed.json/',
    '#https?://www\.facebook\.com/.*/photos/.*#i' => 'https://www.facebook.com/plugins/post/oembed.json/',
    '#https?://www\.facebook\.com/permalink.php.*#i' => 'https://www.facebook.com/plugins/post/oembed.json/',
    '#https?://www\.facebook\.com/media/.*#i' => 'https://www.facebook.com/plugins/post/oembed.json/',
    '#https?://www\.facebook\.com/questions/.*#i' => 'https://www.facebook.com/plugins/post/oembed.json/',
    '#https?://www\.facebook\.com/notes/.*#i' => 'https://www.facebook.com/plugins/post/oembed.json/'
  );
  foreach ($endpoints as $pattern => $endpoint) {
    wp_oembed_add_provider($pattern, $endpoint, true);
  }
}
add_action('init', 'c95_facebook_oembed');
/**
* Function Name: filter wpseo opengraph image - filter_wpseo_opengraph_image();
* This Function can Generates a Photon URL instead of default one
* @param  (type $img)
* @return (type)
*/
function filter_wpseo_opengraph_image($img) {
  // Generates a Photon URL instead of default one...
  // http://jetpack.wp-a2z.org/oik_api/jetpack_photon_url/
  if (function_exists('jetpack_photon_url')) {
    $img = jetpack_photon_url($img);
  }
  return $img;
}
// define the wpseo_opengraph_image callback
add_filter('wpseo_opengraph_image', 'filter_wpseo_opengraph_image', 10, 1 );
