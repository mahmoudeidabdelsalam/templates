<?php
class Blog extends WP_Widget {

    function __construct() {
        $widget_options = array();
        parent::__construct(false, __('#Premast Blog', 'premast') , $widget_options);
    }

    function form($instance) {
        $defaults = array(
            'title' => __('Blog', 'premast'),
        );
        $instance = wp_parse_args((array) $instance, $defaults);
      ?>

        <p>
          <img src='<?= get_theme_file_uri().'/resources/assets/images/widgets/blog.png'; ?>' style="width:100%;" />
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('title'); ?>">
            <?php _e('Headline:', 'premast'); ?>
          </label>
          <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
        </p>

    <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];

        return $instance;
    }

    function widget($args, $instance) {

        extract($args);
        echo $before_widget;
        global $post;
        $title = $instance['title'];
        $background_image = get_field('background_image_blog', 'widget_' . $widget_id);
        $background_color = get_field('background_color_blog', 'widget_' . $widget_id);

          $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'suppress_filters' => 0,
            'posts_per_page' => 4,
          );
          $posts = get_posts($args);

        ?>
        <div class="blog-column" style="background-image:url('<?= $background_image; ?>'); background-color:<?= $background_color; ?>;">
          <div class="container pt-5 pb-5">
            <div class="row align-items-center">
              
            <h2 class="headline"><?= $title; ?></h2>
            <p class="elementor-text"><?php _e('Check our latest blog articles to learn the best use of powerpoint', 'premast'); ?></p>

             <div class="card-deck">
               <?php 
                if($posts):         
                  foreach ( $posts as $post):
                    setup_postdata($post);

                    $thumbnail = Utilities::global_thumbnails( $post->ID, 'full', false);
                    $link = get_the_permalink($post->ID);
                    $time = get_the_date('F j, Y', $post->ID);
                    $headline = get_the_title($post->ID);
                    $content = wp_trim_words(get_the_content($post->ID), '15', ' ...');
                    $categories = wp_get_post_terms($post->ID, 'category', 'hide_empty=0');
                ?>
                <div class="card wow bounceInUp">
                  <a class="link-img" href="<?= $link; ?>"><img src="<?= $thumbnail; ?>" class="card-img-top" alt="<?= $headline; ?>"></a>
                  <?php 
                  if ($categories): 
                    foreach ($categories as $category): ?>
                    <span class="text-secondary">
                      <?= $category->name; ?>
                    </span>
                  <?php 
                    endforeach;
                  endif; ?>
                  <div class="card-body">
                    <h5 class="card-title"><a class="link-title" href="<?= $link; ?>"><?= $headline; ?></a></h5>
                    <p class="card-text"><?= $content; ?></p>
                    <p><a class="read-more" href="<?= $link; ?>"> <?php _e('Read More »', 'premast'); ?> </a></p>
                    <p class="card-time"><small class="text-muted"><?= $time; ?></small></p>
                  </div>
                </div>
              <?php 
                endforeach;
                  wp_reset_postdata();
              endif;
              ?>

            </div>
          </div>
        </div>

      <?php  

        echo $after_widget;
    }
}

register_widget('Blog');
