<?php
class ButtonCart extends WP_Widget {

    function __construct() {
        $widget_options = array();
        parent::__construct(false, __('#Premast Add Cart', 'premast') , $widget_options);
    }

    function form($instance) {
        $defaults = array(
            'title' => __('Id Product', 'premast'),
        );
        $instance = wp_parse_args((array) $instance, $defaults);
      ?>

        <p>
          <label for="<?php echo $this->get_field_id('title'); ?>">
            <?php _e('ID Product:', 'premast'); ?>
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
        global $product;
        $product_id = (int) $instance['title'];

        $in_cart = false;
        
        foreach( WC()->cart->get_cart() as $cart_item ) {
          $product_in_cart = $cart_item['product_id'];

          if ( $product_in_cart === $product_id ) {
            $in_cart = true;
          }
        }
        $link = wc_get_checkout_url();
        ?>
        <?php if ($in_cart) : ?>
          <div class="elementor-element elementor-element-302a45d elementor-widget elementor-widget-jet-button" data-id="302a45d" data-element_type="widget" data-widget_type="jet-button.default">
            <div class="elementor-widget-container">
              <div class="elementor-jet-button jet-elements">
                <div class="jet-button__container">
                  <a class="jet-button__instance jet-button__instance--icon- hover-effect-1" href="<?= $link; ?>">
                    <div class="jet-button__plane jet-button__plane-normal"></div>
                    <div class="jet-button__plane jet-button__plane-hover"></div>
                    <div class="jet-button__state jet-button__state-normal">
                    <span class="jet-button__label">I Want This</span> </div>
                    <div class="jet-button__state jet-button__state-hover">
                    <span class="jet-button__label">I Want This</span> </div>
                  </a>
              </div>
              </div> 
            </div>
          </div>                  
        <?php else: ?>
          <div class="elementor-element elementor-element-302a45d elementor-widget elementor-widget-jet-button" data-id="302a45d" data-element_type="widget" data-widget_type="jet-button.default">
            <div class="elementor-widget-container">
              <div class="elementor-jet-button jet-elements">
                <div class="jet-button__container">
                  <a class="jet-button__instance jet-button__instance--icon- hover-effect-1" href="<?= $link; ?>?add-to-cart=<?= $product_id; ?>">
                    <div class="jet-button__plane jet-button__plane-normal"></div>
                    <div class="jet-button__plane jet-button__plane-hover"></div>
                    <div class="jet-button__state jet-button__state-normal">
                    <span class="jet-button__label">I Want This</span> </div>
                    <div class="jet-button__state jet-button__state-hover">
                    <span class="jet-button__label">I Want This</span> </div>
                  </a>
                </div>
              </div> 
            </div>
          </div>
          

          <style>
          
          </style>
        <?php endif; ?>
      <?php  
    }
}

register_widget('ButtonCart');
