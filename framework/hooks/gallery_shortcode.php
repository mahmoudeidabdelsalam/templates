<?php

remove_shortcode('gallery', 'gallery_shortcode'); // removes the original shortcode
add_shortcode('gallery', 'my_awesome_gallery_shortcode'); // add your own shortcode

function my_awesome_gallery_shortcode($attr, $output) {
  $post = get_post();

  static $instance = 0;
  $instance++;

  if (!empty($attr['ids'])) {
    // 'ids' is explicitly ordered, unless you specify otherwise.
    if (empty($attr['orderby'])) {
      $attr['orderby'] = 'post__in';
    }
    $attr['include'] = $attr['ids'];
  }

  // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
  if (isset($attr['orderby'])) {
    $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
    if (!$attr['orderby']) {
      unset($attr['orderby']);
    }
  }

  $html5 = current_theme_supports('html5', 'gallery');
  $atts = shortcode_atts(array(
    'order' => 'ASC',
    'orderby' => 'menu_order ID',
    'id' => $post ? $post->ID : 0,
    'itemtag' => $html5 ? 'figure' : 'dl',
    'icontag' => $html5 ? 'div' : 'dt',
    'captiontag' => $html5 ? 'figcaption' : 'dd',
    'columns' => 3,
    'size' => 'thumbnail',
    'include' => '',
    'exclude' => '',
    'link' => ''
  ), $attr, 'gallery');

  $id = intval($atts['id']);
  if ('RAND' == $atts['order']) {
    $atts['orderby'] = 'none';
  }



  if (!empty($atts['include'])) {
    $_attachments = get_posts(array('include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby']));

    $attachments = array();
    foreach ($_attachments as $key => $val) {
      $attachments[$val->ID] = $_attachments[$key];
    }
  } elseif (!empty($atts['exclude'])) {
    $attachments = get_children(array('post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby']));
  } else {
    $attachments = get_children(array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby']));
  }

  if (empty($attachments)) {
    return '';
  }

  // Here is the view for the feed

  if (is_feed()) {
    $output = "\n";
    foreach ($attachments as $att_id => $attachment) {
      $output .= wp_get_attachment_link($att_id, $atts['size'], true) . "\n";
    }
    return $output;
  }

  $itemtag = tag_escape($atts['itemtag']);
  $captiontag = tag_escape($atts['captiontag']);
  $icontag = tag_escape($atts['icontag']);
  $valid_tags = wp_kses_allowed_html('post');
  if (!isset($valid_tags[$itemtag])) {
    $itemtag = 'dl';
  }
  if (!isset($valid_tags[$captiontag])) {
    $captiontag = 'dd';
  }
  if (!isset($valid_tags[$icontag])) {
    $icontag = 'dt';
  }

  $columns = intval($atts['columns']);
  $itemwidth = $columns > 0 ? floor(100 / $columns) : 100;
  $float = is_rtl() ? 'right' : 'left';

  $selector = "gallery-{$instance}";

  $gallery_style = '';

  $size_class = sanitize_html_class($atts['size']);
  $gallery_div = "<div class='fixed-height-200 relative bg-black gallery-shortcode-container'><ul rel='lightSliderGallery'  id='$selector' class='cS-hidden gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class} list-unstyled'>";

  /**
  * Filter the default gallery shortcode CSS styles.
  *
  * @since 2.5.0
  *
  * @param string $gallery_style Default gallery shortcode CSS styles.
  * @param string $gallery_div   Opening HTML div container for the gallery shortcode output.
  */
  $output = apply_filters('gallery_style', $gallery_style . $gallery_div);
  //echo "<ul rel='lightSlider' id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class} list-unstyled'>";

  $i = 0;
  foreach ($attachments as $id => $attachment) {
    //var_dump($attachment);
    $thumb = wp_get_attachment_image_src($id, 'tiny');
    $large = wp_get_attachment_image_src($id, 'gallery-full');
    $attachment_image = wp_get_attachment_image_src($id, 'featured', array('class' => '', 'style' => 'height:auto;'))[0];
    ?>

    <?php

    $output .= "<li data-thumb='" . $thumb['0'] . "' data-src='" . $large['0'] . "' >";
    //$output .= '<a href="#" class="img-responsive">';
    $output .= '<img src="' . $attachment_image . '" class="center-block img-responsive" style="height:auto;" >';
    //$output .= '</a>';
    $output .= '</li>';
  }
  $output .= "</ul>";
  $output .= '<div class="gallery-actions hidden-xs">
      <span id="goToPrevSlide">
        <i class="fa fa-fw fa-lg fa-chevron-right"></i>
      </span>
      <span id="maximizeSlide">
        <i class="fa fa-fw fa-lg fa-expand"></i>
      </span>
      <span id="shareSlide">
        <i class="fa fa-fw fa-lg fa-share-alt"></i>
      </span>
      <span id="goToNextSlide">
        <i class="fa fa-fw fa-lg fa-chevron-left"></i>
      </span>
    </div>';
  $output .= "</div><div class='clearfix'></div><br>"
  ?>


  <?php

  return $output;
}
