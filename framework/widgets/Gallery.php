<?php
class Gallery extends WP_Widget {

    function __construct() {
        $widget_options = array();
        parent::__construct(false, __('#Premast Gallery', 'premast') , $widget_options);
    }

    function form($instance) {
        $defaults = array(
            'title' => __('Gallery', 'premast'),
        );
        $instance = wp_parse_args((array) $instance, $defaults);
      ?>

        <p>
          <img src='<?= get_theme_file_uri().'/resources/assets/images/widgets/gallery.png'; ?>' style="width:100%;" />
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

        $background_image_about = get_field('background_img_gallery', 'widget_' . $widget_id);
        $background_color_about = get_field('background_color_gallery', 'widget_' . $widget_id);

        ?>
        <div class="gallery-column" style="background-image:url('<?= $background_image_about; ?>'); background-color:<?= $background_color_about; ?>;">
          <div class="container pt-4 pb-5">
            <div class="row align-items-center">
              <h2><?= $title; ?></h2>
              <?php 
                $images = get_field('gallery_widget', 'widget_' . $widget_id);
                if( $images ): ?>
                  <ul class="gallery-widgets col-12">
                    <?php foreach( $images as $image ): ?>
                      <li>
                        <img src="<?php echo $image['sizes']['thumbnail']; ?>" alt="<?php echo $image['alt']; ?>" />
                      </li>
                    <?php endforeach; ?>
                  </ul>
              <?php endif; ?>
            </div>
          </div>
        </div>

      <?php  

        echo $after_widget;
    }
}

register_widget('Gallery');
