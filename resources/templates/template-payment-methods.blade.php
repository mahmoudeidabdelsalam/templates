{{--
  Template Name: User Payment Methods
--}}

@extends('layouts.app')

@section('content')

@if(!is_user_logged_in())
  <div class="container">
    <div class="row justify-content-center m-0">
      <div class="user-not-login">
        <h2>{{ _e('Join us and enjoy with this benefits', 'premast') }}</h2>
        <p>{{ _e('Join Premast today.', 'premast') }}</p>
        <a class="mt-2 login btn btn-blue" href="#" data-toggle="modal" data-target="#LoginUser">{{ _e('Log In', 'premast') }}</a>
      </div>
    </div>
  </div>
@else
  <section class="template-users">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3 col-12 side-menu-user">
          <h2 class="headline text-primary">{{ _e('My Account', 'premast') }}</h2>
          @if (has_nav_menu('user_navigation'))
            {!! wp_nav_menu(['theme_location' => 'user_navigation', 'container' => false, 'menu_class' => 'nav nav-pills flex-column flex-sm-row col-12', 'walker' => new NavWalker()]) !!}
          @endif
        </div>
        <div class="col-md-9 col-12 p-5 mb-5">
          <?php
          if ( ! defined( 'ABSPATH' ) ) {
            exit;
          }
          $saved_methods = wc_get_customer_saved_methods_list( get_current_user_id() );
          $has_methods   = (bool) $saved_methods;
          $types         = wc_get_account_payment_methods_types();
          do_action( 'woocommerce_before_account_payment_methods', $has_methods ); ?>

          <?php if ( $has_methods ) : ?>

            <table class="woocommerce-MyAccount-paymentMethods shop_table shop_table_responsive account-payment-methods-table">
              <thead>
                <tr>
                  <?php foreach ( wc_get_account_payment_methods_columns() as $column_id => $column_name ) : ?>
                    <th class="woocommerce-PaymentMethod woocommerce-PaymentMethod--<?php echo esc_attr( $column_id ); ?> payment-method-<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
                  <?php endforeach; ?>
                </tr>
              </thead>
              <?php foreach ( $saved_methods as $type => $methods ) : ?>
                <?php foreach ( $methods as $method ) : ?>
                  <tr class="payment-method<?php echo ! empty( $method['is_default'] ) ? ' default-payment-method' : ''; ?>">
                    <?php foreach ( wc_get_account_payment_methods_columns() as $column_id => $column_name ) : ?>
                      <td class="woocommerce-PaymentMethod woocommerce-PaymentMethod--<?php echo esc_attr( $column_id ); ?> payment-method-<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
                        <?php
                        if ( has_action( 'woocommerce_account_payment_methods_column_' . $column_id ) ) {
                          do_action( 'woocommerce_account_payment_methods_column_' . $column_id, $method );
                        } elseif ( 'method' === $column_id ) {
                          if ( ! empty( $method['method']['last4'] ) ) {
                            /* translators: 1: credit card type 2: last 4 digits */
                            echo sprintf( __( '%1$s ending in %2$s', 'woocommerce' ), esc_html( wc_get_credit_card_type_label( $method['method']['brand'] ) ), esc_html( $method['method']['last4'] ) );
                          } else {
                            echo esc_html( wc_get_credit_card_type_label( $method['method']['brand'] ) );
                          }
                        } elseif ( 'expires' === $column_id ) {
                          echo esc_html( $method['expires'] );
                        } elseif ( 'actions' === $column_id ) {
                          foreach ( $method['actions'] as $key => $action ) {
                            echo '<a href="' . esc_url( $action['url'] ) . '" class="button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>&nbsp;';
                          }
                        }
                        ?>
                      </td>
                    <?php endforeach; ?>
                  </tr>
                <?php endforeach; ?>
              <?php endforeach; ?>
            </table>
          <?php else : ?>
            <p class="woocommerce-Message woocommerce-Message--info woocommerce-info"><?php esc_html_e( 'No saved methods found.', 'woocommerce' ); ?></p>
          <?php endif; ?>

          <?php do_action( 'woocommerce_after_account_payment_methods', $has_methods ); ?>

        <?php if ( WC()->payment_gateways->get_available_payment_gateways() ) : ?>
          <?php
          defined( 'ABSPATH' ) || exit;
          $available_gateways = WC()->payment_gateways->get_available_payment_gateways();
          if ( $available_gateways ) : ?>
            <form id="add_payment_method" method="post">
              <div id="payment" class="woocommerce-Payment">
                <ul class="woocommerce-PaymentMethods payment_methods methods">
                  <?php
                  // Chosen Method.
                  if ( count( $available_gateways ) ) {
                    current( $available_gateways )->set_current();
                  }
                  foreach ( $available_gateways as $gateway ) {
                    ?>
                    <li class="woocommerce-PaymentMethod woocommerce-PaymentMethod--<?php echo esc_attr( $gateway->id ); ?> payment_method_<?php echo esc_attr( $gateway->id ); ?>">
                      <input id="payment_method_<?php echo esc_attr( $gateway->id ); ?>" type="radio" class="input-radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> />
                      <label for="payment_method_<?php echo esc_attr( $gateway->id ); ?>"><?php echo wp_kses_post( $gateway->get_title() ); ?> <?php echo wp_kses_post( $gateway->get_icon() ); ?></label>
                      <?php
                      if ( $gateway->has_fields() || $gateway->get_description() ) {
                        echo '<div class="woocommerce-PaymentBox woocommerce-PaymentBox--' . esc_attr( $gateway->id ) . ' payment_box payment_method_' . esc_attr( $gateway->id ) . '" style="display: none;">';
                        $gateway->payment_fields();
                        echo '</div>';
                      }
                      ?>
                    </li>
                    <?php
                  }
                  ?>
                </ul>

                <div class="form-row">
                  <?php wp_nonce_field( 'woocommerce-add-payment-method', 'woocommerce-add-payment-method-nonce' ); ?>
                  <button type="submit" class="woocommerce-Button woocommerce-Button--alt button alt" id="place_order" value="<?php esc_attr_e( 'Add payment method', 'woocommerce' ); ?>"><?php esc_html_e( 'Add payment method', 'woocommerce' ); ?></button>
                  <input type="hidden" name="woocommerce_add_payment_method" id="woocommerce_add_payment_method" value="1" />
                </div>
              </div>
            </form>
          <?php else : ?>
            <p class="woocommerce-notice woocommerce-notice--info woocommerce-info"><?php esc_html_e( 'New payment methods can only be added during checkout. Please contact us if you require assistance.', 'woocommerce' ); ?></p>
          <?php endif; ?>

        <?php endif; ?>
        </div>
      </div>
    </div>
  </section>

  @endif
@endsection