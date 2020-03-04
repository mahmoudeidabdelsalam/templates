<?php
class BannerRight extends WP_Widget {

    function __construct() {
        $widget_options = array();
        parent::__construct(false, __('#Premast Banner Right', 'premast') , $widget_options);
    }

    function form($instance) {
        $defaults = array(
            'title' => __('Banner Right', 'premast'),
        );
        $instance = wp_parse_args((array) $instance, $defaults);
      ?>

        <p>
          <img src='<?= get_theme_file_uri().'/resources/assets/images/widgets/banner-right.png'; ?>' style="width:100%;" />
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

        $background_image_about = get_field('background_image_about', 'widget_' . $widget_id);
        $background_color_about = get_field('background_color_about', 'widget_' . $widget_id);
        $headline_about = get_field('headline_about', 'widget_' . $widget_id);

        $instructions_about = get_field('instructions_about', 'widget_' . $widget_id);
        $link_about = get_field('link_about', 'widget_' . $widget_id);
        $image_banner_about = get_field('image_banner_about', 'widget_' . $widget_id);

        ?>
        <div class="about-tow-column" style="background-image:url('<?= $background_image_about; ?>');background-color:<?= $background_color_about; ?>;">
          <div class="container pt-5 pb-5">
            <div class="row align-items-center">
              <div class="col-md-6 col-sm-12 wow bounceInUp">
                <h2 class="text-gray-dark font-weight-300"><?= $headline_about; ?></h2>
                <p class="text-gray-light text-medium"><?= $instructions_about; ?></p>
                <?php if($link_about): ?>
                  <a class="btn btn-primary text-small mt-5" href="<?= $link_about; ?>"><?=  _e('Get started', 'premast') ?> <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
                <?php endif; ?>
              </div>
              <div class="col-md-6 col-sm-12 wow bounceInUp">
                <img class="img-fluid" src="<?= $image_banner_about; ?>" alt="<?= $headline_about; ?>">
              </div>
            </div>
          </div>
        </div>

      <?php  

        echo $after_widget;
    }
}

register_widget('BannerRight');
