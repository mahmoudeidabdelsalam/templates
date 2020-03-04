{{--
  Template Name: Checkout Template
--}}

@extends('layouts.app')

@section('content')

@php
  $order_pay   = isset($_GET['key']) ? $_GET['key'] : '0';
  if($order_pay):
@endphp


@while(have_posts()) @php the_post() @endphp
  <div class="custom-header pb-0">
    <div class="elementor-background-overlay" style="background-image:url('{{ the_field('header_section_image', 'option') }}')"></div>
      @include('partials.page-header')
      <div class="header-checkout mt-5">
        <div class="container-fluid">
          <div class="row m-0">
            <img class="img-fluid" src="{{ get_theme_file_uri().'/dist/images/header-checkout.png' }}" alt="{{ _e('2 checkout', 'premast') }}" title="{{ _e('2 checkout', 'premast') }}"/>
          </div>
        </div>
      </div>            
  </div>

  <div class="container mt-5 mb-5">
    <div class="row">
      <?php echo do_shortcode( '[woocommerce_checkout]' ); ?>
    </div>            
  </div>
@endwhile

@php
  else:

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }
  $checkout = WC()->checkout;

  global $current_user;
  wp_get_current_user();
  $user = wp_get_current_user();
@endphp

@while(have_posts()) @php the_post() @endphp
  <div class="custom-header pb-0">
    <div class="elementor-background-overlay" style="background-image:url('{{ the_field('header_section_image', 'option') }}')"></div>
      @include('partials.page-header')
      <div class="header-checkout mt-5">
        <div class="container-fluid">
          <div class="row m-0">
            <img class="img-fluid" src="{{ get_theme_file_uri().'/dist/images/header-checkout.png' }}" alt="{{ _e('2 checkout', 'premast') }}" title="{{ _e('2 checkout', 'premast') }}"/>
          </div>
        </div>
      </div>            
  </div>

  

    <div class="container-fluid mt-5 mb-5">
      <div class="row">
        

        <div class="col-md-7 col-12 billing-custom">
          <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
            <!-- Custom billing -->
            <div class="woocommerce-billing-custom">
              <div class="woocommerce-billing-fields">
              <?php if ( ! is_user_logged_in()) : ?>
                <?php if ( wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>
                  <h3><?php esc_html_e( 'Billing &amp; Shipping', 'woocommerce' ); ?> <span class="login-checkout"><?php _e('Already Have account', 'premast'); ?> <a class="mt-2 login text-primary" href="#" data-toggle="modal" data-target="#LoginUser">sign in/a></span></h3>
                <?php else : ?>
                  <h3><?php esc_html_e( 'Billing details', 'woocommerce' ); ?> <span class="login-checkout"><?php _e('Already Have account', 'premast'); ?> <a class="mt-2 login text-primary" href="#" data-toggle="modal" data-target="#LoginUser">sign in</a></span></h3>
                <?php endif; ?>
              <?php else : ?>
                <?php if ( wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>
                  <h3><?php esc_html_e( 'Billing &amp; Shipping', 'woocommerce' ); ?> </h3>
                <?php else : ?>
                  <h3><?php esc_html_e( 'Billing details', 'woocommerce' ); ?></h3>
                <?php endif; ?>
              <?php endif; ?>
              <?php if ( ! is_user_logged_in()) : ?>
                <?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>
                <div class="woocommerce-billing-fields__field-wrapper">
                  <?php
                  $fields = $checkout->get_checkout_fields( 'billing' );
                  foreach ( $fields as $key => $field ) {
                    woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
                  }
                  ?>
                </div>
                <?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
                <?php else: ?>
                  <div class="save-data">
                    <?php echo mwe_get_formatted_shipping_name_and_address($current_user->ID); ?>
                  </div>
                  <a class="btn-edit" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <?php _e('edit billing details', 'premast'); ?>
                  </a>  
                  <div class="collapse <?= (get_user_meta( $current_user->ID, 'billing_first_name', true ) == 0)? 'show':''; ?>" id="collapseExample">
                    <?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>
                    <div class="woocommerce-billing-fields__field-wrapper">
                      <?php
                      $fields = $checkout->get_checkout_fields( 'billing' );
                      foreach ( $fields as $key => $field ) {
                        woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
                      }
                      ?>
                    </div>
                    <?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
                  </div>
                <?php endif; ?>
              </div>
              <?php if ( ! is_user_logged_in()) : ?>
                <div class="woocommerce-account-fields">
                  <?php if ( ! $checkout->is_registration_required() ) : ?>
                    <p class="form-row form-row-wide create-account">
                      <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                        <input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ); ?> type="checkbox" name="createaccount" value="1" /> <span><?php esc_html_e( 'Create an account?', 'woocommerce' ); ?></span>
                      </label>
                    </p>
                  <?php endif; ?>
                  <?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>
                  <?php if ( $checkout->get_checkout_fields( 'account' ) ) : ?>
                    <div class="create-account">
                      <h4><?php _e('Account password', 'premast'); ?></h4>
                      <?php foreach ( $checkout->get_checkout_fields( 'account' ) as $key => $field ) : ?>
                        <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
                      <?php endforeach; ?>
                      <div class="clear"></div>
                    </div>
                  <?php endif; ?>

                  <?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>
                </div>
                <a class="btn-next hidden" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                  <?php _e('next', 'premast'); ?>
                </a>  
              <?php endif; ?>
            </div>
            <!-- Custom Pay -->
            <div class="custom-pay">
              <?php if ( ! is_user_logged_in()) : ?>
                <div class="collapse" id="collapseExample">
                  <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
                  <div id="order_review" class="woocommerce-checkout-review-order">
                    <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                  </div>
                  <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
                </div>
              <?php else: ?>     
                <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
                <div id="order_review" class="woocommerce-checkout-review-order mt-0">
                  <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                </div>
                <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
              <?php endif; ?>
            </div>
          </form>
        </div>

        

        <div class="col-md-5">
          <!-- Custom coupons -->
          <div class="custom-coupons">
            <?php
              defined( 'ABSPATH' ) || exit;
              if ( ! wc_coupons_enabled() ) { // @codingStandardsIgnoreLine.
                return;
              }
            ?>
            <div class="woocommerce-form-coupon-toggle">
              <?php wc_print_notice( apply_filters( 'woocommerce_checkout_coupon_message', ' <a href="#" class="showcoupon">' . esc_html__( 'Click here to enter your code', 'woocommerce' ) . '</a>' ), 'notice' ); ?>
            </div>
            <form class="checkout_coupon woocommerce-form-coupon" method="post" style="display:block">
              <p><?php esc_html_e( 'If you have a coupon code, please apply it below.', 'woocommerce' ); ?></p>
              <p class="form-row d-flex">
                <input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" id="coupon_code" value="" />
                <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply', 'woocommerce' ); ?></button>
              </p>                
            </form>
          </div>

          @if(get_field('donation_text', 'option') || get_field('donation_link', 'option'))
            <div class="col-12 custom-banner" style="background-image:url('{{ the_field('donation_background_image', 'option') }}'); background-color:{{ the_field('donation_background_color', 'option') }};">
              <div class="media">
                <img src="{{ the_field('donation_icon', 'option') }}" class="mr-3" alt="{{ the_field('donation_text', 'option') }}">
                <div class="media-body">
                  <p>{{ the_field('donation_text', 'option') }}</p>
                  <a href="{{ the_field('donation_link', 'option') }}" class="overlay-link"></a>
                </div>
              </div>
            </div>
          @endif

          <!-- Custom summary -->
          <div class="col-12 summary-custom">
            <h3><?php _e('order summary', 'premast'); ?></h3>
            <table class="shop_table woocommerce-checkout-review-order-table">
              <thead>
                <tr>
                  <th class="product-name"><?php esc_html_e( 'item', 'woocommerce' ); ?></th>
                  <th class="product-total"><?php esc_html_e( 'price', 'woocommerce' ); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php
                do_action( 'woocommerce_review_order_before_cart_contents' );
                foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                  $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                  if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                    $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                    ?>
                    <tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
                      <td class="product-name">
                        <?php
                          $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
                          if ( ! $product_permalink ) {
                            echo $thumbnail; // PHPCS: XSS ok.
                          } else {
                            printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
                          }
                        ?>
                        <?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        <?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times; %s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        <?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                      </td>
                      <td class="product-total">
                        <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                      </td>
                    </tr>
                    <?php
                  }
                }
                do_action( 'woocommerce_review_order_after_cart_contents' );
                ?>
              </tbody>
              <tfoot>
                <tr class="cart-subtotal">
                  <th><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
                  <td><?php wc_cart_totals_subtotal_html(); ?></td>
                </tr>
                <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
                  <tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                    <th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
                    <td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
                  </tr>
                <?php endforeach; ?>
                <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
                  <?php do_action( 'woocommerce_review_order_before_shipping' ); ?>
                  <?php wc_cart_totals_shipping_html(); ?>
                  <?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
                <?php endif; ?>
                <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
                  <tr class="fee">
                    <th><?php echo esc_html( $fee->name ); ?></th>
                    <td><?php wc_cart_totals_fee_html( $fee ); ?></td>
                  </tr>
                <?php endforeach; ?>
                <?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
                  <?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
                    <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited ?>
                      <tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                        <th><?php echo esc_html( $tax->label ); ?></th>
                        <td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <tr class="tax-total">
                      <th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
                      <td><?php wc_cart_totals_taxes_total_html(); ?></td>
                    </tr>
                  <?php endif; ?>
                <?php endif; ?>
                <?php do_action( 'woocommerce_review_order_before_order_total' ); ?>
                <tr class="order-total">
                  <th><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
                  <td><?php wc_cart_totals_order_total_html(); ?></td>
                </tr>
                <?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
              </tfoot>
            </table>
          </div>
          <img class="img-fluid mr-auto ml-auto mt-5 d-block" src="{{ get_theme_file_uri().'/dist/images/header-checkout.png' }}" alt="{{ _e('2 checkout', 'premast') }}" title="{{ _e('2 checkout', 'premast') }}"/>
        </div>
      </div>
    </div>
 


  <script type = "text/javascript">
    jQuery(function($) {
      if($('#billing_first_name').val() === "" || $('#billing_last_name').val() === "" || $('#select2-billing_country-container').val() === "" || $('#billing_address_1').val() === "" || $('#billing_city').val() === "" || $('#billing_email').val() === "" || $('#account_password').val() === ""  ){ 
        $('.btn-next').addClass('hidden');
      } else {
        $('.btn-next').removeClass('hidden');
      }
      $(".woocommerce-billing-custom .form-row input").blur(function() { 
        if($(this).val() == ''){ 
          $('.btn-next').addClass('hidden');
        } else {
          $('.btn-next').removeClass('hidden');
        }
      });
    });
  </script>

  

  @endwhile
  <?php endif; ?>
@endsection
