<?php
class Testimonials extends WP_Widget {

    function __construct() {
        $widget_options = array();
        parent::__construct(false, __('#Premast Testimonials', 'premast') , $widget_options);
    }

    function form($instance) {
        $defaults = array(
            'title' => __('Testimonials', 'premast'),
        );
        $instance = wp_parse_args((array) $instance, $defaults);
      ?>

        <p>
          <img src='<?= get_theme_file_uri().'/resources/assets/images/widgets/testimonials.png'; ?>' style="width:100%;" />
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

        $background_image_about = get_field('background_img_testimonials', 'widget_' . $widget_id);
        $background_color_about = get_field('background_color_testimonials', 'widget_' . $widget_id);
        $headline_about = get_field('headline_about', 'widget_' . $widget_id);

        $instructions_about = get_field('instructions_about', 'widget_' . $widget_id);
        $link_about = get_field('link_about', 'widget_' . $widget_id);
        $image_banner_about = get_field('image_banner_about', 'widget_' . $widget_id);

        ?>
        <div class="testimonials-column" style="background-image:url('<?= $background_image_about; ?>'); background-color:<?= $background_color_about; ?>;">
          <div class="container pt-4 pb-5">
            <div class="row align-items-center">
              <h2><?= $title; ?></h2>
              
              <div class="single-item col-12">
              <?php
                // check if the repeater field has rows of data
                if( have_rows('testimonials', 'widget_' . $widget_id) ):
                  // loop through the rows of data
                    while ( have_rows('testimonials', 'widget_' . $widget_id) ) : the_row(); ?>
                    
                    <div class="testimonials-item-inner">
                      <div class="testimonials-content">
                        <div class="testimonials-icon">
                          <div class="testimonials-icon-inner">
                            <i class="fa fa-quote-left"></i>
                          </div>
                        </div>
                        <p class="testimonials-comment">
                          <span><?= the_sub_field('testimonials_comment'); ?></span>
                        </p>
                        <div class="testimonials-name">
                          <span><?= the_sub_field('name_testimonials'); ?></span>
                        </div>
                        <div class="testimonials-position">
                          <span><?= the_sub_field('position_testimonials'); ?></span>
                        </div>
                      </div>
                    </div>

                  <?php 
                    endwhile;
                  else :
                    // no rows found
                endif;
              ?>
              </div>
            </div>
          </div>
        </div>

      <?php  

        echo $after_widget;
    }
}

register_widget('Testimonials');
