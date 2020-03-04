<?php
class SwitchTabs extends WP_Widget {

    function __construct() {
        $widget_options = array();
        parent::__construct(false, __('#Premast Switch Tabs', 'premast') , $widget_options);
    }

    function form($instance) {
        $defaults = array(
            'title' => __('Switch Tabs', 'premast'),
        );
        $instance = wp_parse_args((array) $instance, $defaults);
      ?>

        <p>
          <img src='<?= get_theme_file_uri().'/resources/assets/images/widgets/switch-tabs.png'; ?>' style="width:100%;" />
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

        $templates_instructions = get_field('tab_templates_instructions', 'widget_' . $widget_id);
        $templates_link = get_field('tab_templates_link', 'widget_' . $widget_id);
        $templates_video = get_field('tab_templates_video', 'widget_' . $widget_id);

        $studio_instructions = get_field('tab_studio_instructions', 'widget_' . $widget_id);
        $studio_link = get_field('tab_studio_link', 'widget_' . $widget_id);
        $studio_after = get_field('tab_studio_after', 'widget_' . $widget_id);
        $studio_before = get_field('tab_studio_before', 'widget_' . $widget_id);

        ?>
          <div class="services-home">
            <h3 class="sr-only"><?=  _e('I need someone help me', 'premast') ?></h3>
            <h3 class="sr-only"><?=  _e('I need to create it by myself', 'premast') ?></h3>
            <div class="container">
              <div class="tab-slider--nav">
                <div class="tab-slider-container">
                  <p class="mb-0"><?=  _e('I need someone help me', 'premast') ?></p>
                    <ul class="tab-slider--tabs">
                      <li class="tab-slider--trigger active" rel="tab1"></li>
                      <li class="tab-slider--trigger" rel="tab2"></li>      
                    </ul>
                  <p class="mb-0"><?=  _e('I need to create it by myself', 'premast') ?></p>
                </div>
              </div>

              <div class="tab-slider--container mt-5">

                <div id="tab1" class="tab-slider--body pt-5">
                  <div class="container">
                    <div class="row align-items-center col-12">
                      <div class="col-md-5 col-sm-12 wow bounceInUp">
                        <img class="mb-5" src="<?=  get_theme_file_uri().'/dist/images/premast-studio.png' ?>" alt="Premast studio">
                        <p class="text-gray-dark text-medium"><?= $studio_instructions; ?></p>
                        <a class="btn btn-primary text-small mt-5" href="<?= $studio_link; ?>"><?=  _e('Get started', 'premast') ?> <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
                      </div>
                      <div class="col-md-7 col-sm-12 wow bounceInUp">
                        <figure class="cd-image-container">
                          <img src="<?= $studio_before; ?>" alt="Original Image">
                          <span class="cd-image-label" data-type="original"><?php _e('Before', 'premast'); ?></span>
                          
                          <div class="cd-resize-img"> <!-- the resizable image on top -->
                              <img src="<?= $studio_after; ?>" alt="Modified Image">
                              <span class="cd-image-label" data-type="modified"><?php _e('After', 'premast'); ?></span>
                          </div>
                          
                          <span class="cd-handle"></span> <!-- slider handle -->
                        </figure> <!-- cd-image-container -->
                      </div>
                    </div>
                  </div>
                </div>
                
                <div id="tab2" class="tab-slider--body pt-5">
                  <div class="container">
                    <div class="row align-items-center col-12">
                      <div class="col-md-6 col-sm-12 wow bounceInUp">
                        <img class="mb-5" src="<?=  get_theme_file_uri().'/dist/images/premast-templates.png' ?>" alt="Premast studio">
                        <p class="text-gray-dark text-medium"><?= $templates_instructions; ?></p>
                        <a class="btn btn-primary text-small mt-5" href="<?= $templates_link; ?>"><?=  _e('View our templates', 'premast') ?> <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
                      </div>
                      <div class="col-md-6 col-sm-12 wow bounceInUp">
                        <div class="card">
                          <div class="embed-responsive embed-responsive-4by3">
                            <?= $templates_video; ?>
                            <!-- <iframe class="jet-video-iframe embed-responsive-item" allowfullscreen="" data-lazy-load="https://www.youtube.com/embed/vvuAtCBFMKA?feature=oembed&amp;playlist=vvuAtCBFMKA&amp;wmode=opaque&amp;autoplay=1&amp;loop=1&amp;controls=0&amp;mute=1&amp;rel=0&amp;modestbranding=0" allow="autoplay;encrypted-media" src="https://www.youtube.com/embed/vvuAtCBFMKA?feature=oembed&amp;playlist=vvuAtCBFMKA&amp;wmode=opaque&amp;autoplay=1&amp;loop=1&amp;controls=0&amp;mute=1&amp;rel=0&amp;modestbranding=0"></iframe> -->
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

            </div>
          </div>

      <?php  

        echo $after_widget;
    }
}

register_widget('SwitchTabs');
