<footer class="content-info bg-gray-dark">
  <div class="container-fluid p-0">
    <div class="row">
      <div class="col-md-8 col-sm-12 col-12">
        <div class="navbar-footer">
          <h3 class="sr-only">{{ _e('Footer navigation', 'premast') }}</h3>
          @if (has_nav_menu('footer_navigation'))
            {!! wp_nav_menu(['theme_location' => 'footer_navigation', 'container' => false, 'menu_class' => 'navbar', 'walker' => new NavWalker()]) !!}
          @endif
        </div>
      </div>
      <div class="col-md-3 col-sm-12 col-12 pl-md-5 pr-md-5 pt-5">
        @php dynamic_sidebar('sidebar-footer') @endphp
      </div>
    </div>
  </div>
</footer>

<section class="copyright">
  <h3 class="sr-only">{{ _e('Copyright © 2018 Premast-powerpoint design solutions. All rights reserved.', 'premast') }}</h3>
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-md-6 text-left">
        {{ _e('Copyright © 2018 Premast-powerpoint design solutions. All rights reserved.', 'premast') }}
      </div>
      <div class="col-md-6 text-right">
        <span class="footer-secure-payment">{{ _e('Secure Payment by', 'permast') }}</span> <img src="{{ get_theme_file_uri().'/dist/images/2checkout-2.png' }}" alt="2Checkout">
      </div>
    </div>
  </div>
</section>

@if ( !is_user_logged_in() && !is_page_template( 'templates/template-signup.blade.php' ) && !is_page_template( 'templates/template-signin.blade.php' ) )

  <!-- Modal Login -->
  <div class="modal fade" id="LoginUser" tabindex="-1" role="dialog" aria-labelledby="LoginUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="row m-0">
          <div class="col-md-5 col-12 row m-0 align-items-center"  style="background-image: linear-gradient(150deg, #56ecf2 0%, #4242e3 100%);">
            <div class="elementor-background-overlay" style="background-image: url('{{ the_field('header_section_image', 'option') }}');"></div>
            <div class="col-12 description">
              <h4 class="text-white title-description">{{ _e('Welcome Back to premast', 'premast') }}</h4>
              <p class="text-white text-description">{{ _e('Download your preferred design from huge collection of professionally, creative designed powerpoint templates for all your needs.', 'premast') }}</p>
            </div>
          </div>
          <div class="col-md-7 col-12">
            <div class="modal-header">
              <a class="navbar-brand" href="{{ home_url('/') }}" title="{{ get_bloginfo('name') }}">
                <img class="img-fluid" src="@if(get_field('website_logo', 'option')) {{ the_field('website_logo','option') }} @else {{ get_theme_file_uri().'/dist/images/logo-en.png' }} @endif" alt="{{ get_bloginfo('name', 'display') }}" title="{{ get_bloginfo('name') }}"/>
                <span class="sr-only"> {{ get_bloginfo('name') }} </span>
              </a>
              <h5 class="modal-title" id="LoginUserLabel">{{ _e('Sign Into Your Account', 'premast') }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="tab-content">
                <div class="tab-pane fade show active" id="WP_login">
                  <span id="login-loader" style="display:none;"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></span>

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
    
                  <span class="switch-link switch-to-lost position-relative" data-tab="lost_password" style=" bottom: 0; margin: 24px auto; display: block; text-align: center; width: 100%; right: 0; ">{{ _e('Lost your password?', 'premast') }}</span>

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
              </div>
            </div>

            <div class="modal-footer">
              {{ _e('Dont have an account?', 'premast') }} <a class="signup" href="#" data-dismiss="modal" aria-label="Close" data-toggle="modal" data-target="#SignupUser">{{ _e('Sign Up', 'premast') }}</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="SignupUser" tabindex="-1" role="dialog" aria-labelledby="SignupUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="row m-0">
          <div class="col-md-5 col-12 row m-0 align-items-center"  style="background-image: linear-gradient(150deg, #56ecf2 0%, #4242e3 100%);">
            <div class="elementor-background-overlay" style="background-image: url('{{ the_field('header_section_image', 'option') }}');"></div>
            <div class="col-12 description">
              <h4 class="text-white title-description">{{ _e('Welcome to premast', 'premast') }}</h4>
              <p class="text-white text-description mb-3">{{ _e('Join us and enjoy with this benefits', 'premast') }}</p> 
              <p class="text-white min-description">{{ _e('* Recieve a 20% off discount in your E-mail', 'premast') }}</p>
              <p class="text-white min-description">{{ _e('* Downloads hunderds of powerpoint slides and graphics for free', 'premast') }}</p>
              <p class="text-white min-description">{{ _e('* Discover amazing new products daily', 'premast') }}</p>
            </div>
          </div>
          <div class="col-md-7 col-12">
            <div class="modal-header">
              <a class="navbar-brand" href="{{ home_url('/') }}" title="{{ get_bloginfo('name') }}">
                <img class="img-fluid" src="@if(get_field('website_logo', 'option')) {{ the_field('website_logo','option') }} @else {{ get_theme_file_uri().'/dist/images/logo-en.png' }} @endif" alt="{{ get_bloginfo('name', 'display') }}" title="{{ get_bloginfo('name') }}"/>
                <span class="sr-only"> {{ get_bloginfo('name') }} </span>
              </a>
              <h5 class="modal-title" id="SignupUserLabel">{{ _e('Create a New Premast Account', 'premast') }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p class="register-message m-0" style="display:none"></p>
              <form action="#" method="POST" name="register-form" class="register-form register-user">
                <p class="form-row form-row-first">
                  <input class="form-control" type="text"  name="first_name" placeholder="First Name" id="firstname">
                </p>
                <p class="form-row form-row-last">
                  <input type="text" name="last_name" placeholder="Last Name" id="lastname">
                </p>
                <p>
                  <input type="email" name="user_email" placeholder="Email" id="useremail">
                </p>
                <p>
                  <input type="password" name="user_password" placeholder="Password" id="password">
                </p>
                <p>
                  <input type="password" name="re-pwd" placeholder="Confirm Password" id="confirm_password">
                  <span id="message"></span>
                </p>  
                <p class="Conditions">
                  <input type="checkbox" id="Conditions"> <label class="d-inline-block mb-0 label-Conditions" for="Conditions">{{ _e('Accept our Terms&Conditions', 'premast') }}</label>
                </p>
                <button type="submit" id="register-button" class="woocommerce-Button button" name="register" value="Register">{{ _e('Register', 'premast') }}</button>
                <span id="register-loader" style="display:none;"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></span>
              </form> 
              

              <script type="text/javascript">
                jQuery(function($) {
                  $('#password, #confirm_password').on('keyup', function () {
                    if ($('#password').val() == $('#confirm_password').val()) {
                      $('#message').html('Matching').css('color', 'green');
                    } else 
                      $('#message').html('Not Matching').css('color', 'red');
                  });
                  $('#register-button').on('click',function(e){
                    e.preventDefault();
                    var firstname = $('#firstname').val();
                    var useremail = $('#useremail').val();
                    var password = $('#password').val();
                    var lastname = $('#lastname').val();
                    $.ajax({
                      type:"POST",
                      url:"<?php echo admin_url('admin-ajax.php'); ?>",
                      data: {
                        action: "register_user_front_end",
                        first_name : firstname,
                        last_name : lastname,
                        user_email : useremail,
                        user_password : password
                      },
                      beforeSend: function(results) {
                        $('#register-loader').show();
                      },                   
                      success: function(results){
                        $('.register-message').html(results).show();
                        $('#register-loader').hide();
                      },
                      error: function(results) {
                        $('.register-message').html('plz try again later').show();
                        $('#register-loader').hide();
                      }
                    });
                  });

                  $('#wp-submit').on('click',function(e){
                    $('#login-loader').show();
                  });

                });
              </script>

              <?php // echo do_shortcode('[wc_reg_form_bbloomer]') ?>
              <div class="galogin">
                {!! do_shortcode( '[nextend_social_login provider="google"]' ) !!}
              </div>
            </div>
            <div class="modal-footer">
              {{ _e('You have an account?', 'premast') }} <a class="login" href="#" data-dismiss="modal" aria-label="Close" data-toggle="modal" data-target="#LoginUser">{{ _e('Sign in', 'premast') }}</a>
            </div>
          </div>
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
