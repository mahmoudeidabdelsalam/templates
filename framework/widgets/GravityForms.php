<?php
class GravityForms extends WP_Widget {

    function __construct() {
        $widget_options = array();
        parent::__construct(false, __('#Premast GravityForms', 'premast') , $widget_options);
    }

    function form($instance) {
        $defaults = array(
            'title' => __('GravityForms', 'premast'),
        );
        $instance = wp_parse_args((array) $instance, $defaults);
      ?>

        <p>
          <img src='<?= get_theme_file_uri().'/resources/assets/images/widgets/gravityforms.png'; ?>' style="width:100%;" />
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
        $background_image = get_field('background_image_form', 'widget_' . $widget_id);
        $background_color = get_field('background_color_form', 'widget_' . $widget_id);
        $image_banner = get_field('image_banner_form', 'widget_' . $widget_id);
        $instructions_form = get_field('instructions_froms', 'widget_' . $widget_id);
        $select_from = get_field('select_from', 'widget_' . $widget_id);
        ?>
        <div class="gravity-column" style="background-image:url('<?= $background_image; ?>'); background-color:<?= $background_color; ?>;">
          <div class="container pt-5 pb-5">
            <div class="row align-items-center">
              <div class="col-md-6 col-sm-12 wow bounceInUp">
                <img class="img-fluid img-banner" src="<?= $image_banner; ?>" alt="<?= $title; ?>">
              </div>
              <div class="col-md-6 col-sm-12 wow bounceInUp">
                <h2 class="headline"><?= $title; ?></h2>
                <p class="instructions"><?= $instructions_form; ?></p>
                <?php if($select_from): ?>
                  <?php echo do_shortcode( '[gravityform id="'.$select_from['id'].'" name="false" title="false" description="false" ajax="true" ]' ); ?>
                <?php endif; ?>
              </div>

            </div>
          </div>
        </div>

      <?php  

        echo $after_widget;
    }
}

register_widget('GravityForms');
