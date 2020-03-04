{{--
  Template Name: Sign in
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    <section class="section-template position-relative" style="background-image: linear-gradient(150deg, {{ the_field('gradient_color_one','option') }} 0%, {{ the_field('gradient_color_two','option') }} 100%);">
      <div class="elementor-background-overlay" style="background-image: url('{{ the_field('banner_background_overlay','option') }}');"></div>
      <div class="container">
        <div class="row justify-content-center">
        @if ( !is_user_logged_in() )
          <div class="col-md-7 col-12 modal-show">
            <div class="show-header text-center">
              <a class="navbar-brand" href="{{ home_url('/') }}" title="{{ get_bloginfo('name') }}">
                <img class="img-fluid" src="@if(get_field('website_logo', 'option')) {{ the_field('website_logo','option') }} @else {{ get_theme_file_uri().'/dist/images/logo-en.png' }} @endif" alt="{{ get_bloginfo('name', 'display') }}" title="{{ get_bloginfo('name') }}"/>
                <span class="sr-only"> {{ get_bloginfo('name') }} </span>
              </a>
              <br>
              <h5 class="modal-title" id="LoginUserLabel">{{ _e('One account for all our services', 'premast') }}</h5>

              <img class="img-fluid" src="{{ get_theme_file_uri().'/dist/images/logos.png' }}" alt="{{ get_bloginfo('name', 'display') }}" title="{{ get_bloginfo('name') }}"/>
            </div>
            <div class="modal-body">
              <div class="tab-content">
                <div class="tab-pane fade show active" id="WP_login">
                  @php 
                    $args = array(
                      'echo'           => true,
                      'remember'       => true,
                      'redirect'       => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
                      'form_id'        => 'loginform',
                      'id_username'    => 'user_login',
                      'id_password'    => 'user_pass',
                      'id_submit'      => 'wp-submit',
                      'label_username' => __( 'Email' ),
                      'label_password' => __( 'Password' ),
                      'label_log_in'   => __( 'Sign in' ),
                      'value_username' => '',
                      'value_remember' => false
                    ); 
                  @endphp
                  
                  {{ wp_login_form($args) }}
                  <span class="switch-link switch-to-lost" data-tab="lost_password">{{ _e('Lost your password?', 'premast') }}</span>
                </div>

                <div class="tab-pane fade" id="lost_password">
                  <?php
                    defined( 'ABSPATH' ) || exit;
                    do_action( 'woocommerce_before_lost_password_form' );
                    ?>
                    <form method="post" class="woocommerce-ResetPassword lost_reset_password">
                      <p><?php echo apply_filters( 'woocommerce_lost_password_message', esc_html__( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'woocommerce' ) ); ?></p><?php // @codingStandardsIgnoreLine ?>
                      <p class="woocommerce-form-row woocommerce-form-row--first form-row">
                        <label for="user_login"><?php esc_html_e( 'Username or email', 'woocommerce' ); ?></label>
                        <input class="woocommerce-Input woocommerce-Input--text input-text" type="text" name="user_login" id="user_login" autocomplete="username" />
                      </p>
                      <div class="clear"></div>
                      <?php do_action( 'woocommerce_lostpassword_form' ); ?>
                      <p class="woocommerce-form-row form-row">
                        <input type="hidden" name="wc_reset_password" value="true" />
                        <button type="submit" class="woocommerce-Button button" value="<?php esc_attr_e( 'Reset password', 'woocommerce' ); ?>"><?php esc_html_e( 'Reset password', 'woocommerce' ); ?></button>
                      </p>
                      <?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>
                    </form>
                    <?php do_action( 'woocommerce_after_lost_password_form' ); ?>
                    
                    <span class="switch-link switch-to-login" data-tab="WP_login">{{ _e('Sign in', 'premast') }}</span>
                </div>
                <div class="text-center">
                  {{ _e('Dont have an account?', 'premast') }} <a class="signup text-primary" href="{{ the_field('link_signup', 'option') }}">{{ _e('Sign Up', 'premast') }}</a>
                </div>
              </div>
            </div>
          </div>

          <script>
            jQuery(function($) {
              // placeholder Login
              $('input#user_login').attr('placeholder', 'Email');
              $('input#user_pass').attr('placeholder', 'Password');

              // Tabs Custom
              $('.switch-link').click(function(){
                var tab_id = $(this).attr('data-tab');
                $('.tab-content .tab-pane').removeClass('show');
                $('.tab-content .tab-pane').removeClass('active');
                $("#"+tab_id).addClass('active');
                $("#"+tab_id).addClass('show');
              });

            });
          </script>
        @endif
        </div>
      </div>
    </section>
  @endwhile
@endsection


<style>
.modal-show {
    background: #EFF6FA;
    box-shadow: 0px 3px 2px rgba(0, 0, 0, 0.269107);
    border-radius: 14px;
    padding: 60px 100px 20px !important;
}
.modal-show .login-username label, .modal-show .login-password label {
    display: none !important;
}
.modal-show h5.modal-title {
    font-weight: normal;
    font-size: 20px;
    line-height: 23px;
    text-align: center;
    letter-spacing: 0.0438698px;
    color: #3D4552;
    mix-blend-mode: normal;
    opacity: 0.82;
    margin-bottom: 40px;
    margin-top: 10px;
}
.modal-show  input[type="text"], input[type="password"] {
    background: #FFFFFF;
    border: 1px solid rgba(0, 0, 0, 0.15);
    box-sizing: border-box;
    border-radius: 8px !important;
    height: 40px !important;
}
.modal-show .modal-body {
    padding: 40px 0;
}
.modal-show  p.login-submit {
    text-align: center;
}
.modal-show span.switch-to-lost {
    position: absolute;
    bottom: 146px;
    width: auto !important;
    right: 0;
}
section.section-template span.switch-link {
  text-align: center !important;
}
.modal-show  p.woocommerce-form-row.form-row {
    align-items: center;
}
</style>